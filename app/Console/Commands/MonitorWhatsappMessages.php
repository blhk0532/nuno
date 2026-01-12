<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use WallaceMartinss\FilamentEvolution\Enums\MessageDirectionEnum;
use WallaceMartinss\FilamentEvolution\Enums\MessageStatusEnum;
use WallaceMartinss\FilamentEvolution\Enums\MessageTypeEnum;
use WallaceMartinss\FilamentEvolution\Models\WhatsappInstance;
use WallaceMartinss\FilamentEvolution\Models\WhatsappMessage;

class MonitorWhatsappMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:monitor-messages
                            {instance? : The instance name to monitor}
                            {--conversation= : Monitor only this conversation (remoteJid)}
                            {--all : Monitor all instances}
                            {--since= : Check messages since this many minutes ago (default: 5)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitor for new WhatsApp messages and sync them';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $instanceName = $this->argument('instance');
        $conversationId = $this->option('conversation');
        $monitorAll = $this->option('all');
        $sinceMinutes = (int) $this->option('since', 5);

        if ($monitorAll) {
            $instances = WhatsappInstance::where('sync_full_history', true)->get();
        } elseif ($instanceName) {
            $instances = WhatsappInstance::where('name', $instanceName)->get();
        } else {
            $this->error('Please specify an instance name or use --all flag');

            return Command::FAILURE;
        }

        if ($instances->isEmpty()) {
            $this->error('No instances found');

            return Command::FAILURE;
        }

        $since = now()->subMinutes($sinceMinutes);

        foreach ($instances as $instance) {
            $this->info("🔍 Monitoring messages for instance: {$instance->name} (since {$since->format('H:i:s')})");
            if ($conversationId) {
                $this->info("📱 Monitoring only conversation: {$conversationId}");
            }

            $newMessagesCount = $this->checkForNewMessages($instance, $conversationId, $since);

            if ($newMessagesCount > 0) {
                $this->info("✅ Found and synced {$newMessagesCount} new messages");
            } else {
                $this->info('⏸️  No new messages found');
            }
        }

        return Command::SUCCESS;
    }

    private function checkForNewMessages(WhatsappInstance $instance, ?string $conversationId, $since): int
    {
        $apiKey = config('filament-evolution.api.api_key');
        $baseUrl = config('filament-evolution.api.base_url');

        if (! $apiKey || ! $baseUrl) {
            $this->error('Evolution API configuration missing');

            return 0;
        }

        $url = "{$baseUrl}/chat/findMessages/{$instance->instance_id}";

        try {
            $payload = [
                'limit' => 100, // Check recent messages
            ];

            // Add conversation filter if specified
            if ($conversationId) {
                $payload['where'] = [
                    'key' => [
                        'remoteJid' => $conversationId,
                    ],
                ];
            }

            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withHeaders([
                'apikey' => $apiKey,
                'Content-Type' => 'application/json',
            ])->post($url, $payload);

            $status = $response->status();
            if ($status < 200 || $status >= 300) {
                $this->error("Failed to fetch messages: HTTP {$status} - ".$response->body());

                return 0;
            }

            $data = $response->json();

            if (! isset($data['messages']['records'])) {
                $this->error('No records key in response');

                return 0;
            }

            $messages = $data['messages']['records'];

            if (empty($messages)) {
                return 0;
            }

            // Filter messages newer than our since timestamp
            $newMessages = array_filter($messages, function ($message) use ($since) {
                $messageTimestamp = isset($message['messageTimestamp'])
                    ? \Carbon\Carbon::createFromTimestamp($message['messageTimestamp'])
                    : null;

                return $messageTimestamp && $messageTimestamp->greaterThan($since);
            });

            if (empty($newMessages)) {
                return 0;
            }

            // Check which ones we don't already have
            $existingMessageIds = WhatsappMessage::where('instance_id', $instance->id)
                ->whereIn('message_id', array_column($newMessages, 'id'))
                ->pluck('message_id')
                ->toArray();

            $messagesToProcess = array_filter($newMessages, function ($message) use ($existingMessageIds) {
                return ! in_array($message['id'], $existingMessageIds);
            });

            if (empty($messagesToProcess)) {
                return 0;
            }

            // Process and save new messages
            $savedCount = 0;
            foreach ($messagesToProcess as $message) {
                try {
                    $transformedMessage = $this->transformMessage($message, $instance);

                    WhatsappMessage::create([
                        'instance_id' => $instance->id,
                        'message_id' => $transformedMessage['message_id'],
                        'remote_jid' => $transformedMessage['remote_jid'],
                        'phone' => $transformedMessage['phone'],
                        'direction' => $transformedMessage['direction'],
                        'type' => $transformedMessage['type'],
                        'content' => json_encode($transformedMessage['content']),
                        'media' => $transformedMessage['media'] ? json_encode($transformedMessage['media']) : null,
                        'status' => $transformedMessage['status'],
                        'raw_payload' => json_encode($transformedMessage['raw_payload']),
                    ]);

                    $savedCount++;
                } catch (\Exception $e) {
                    $this->error("Error processing message {$message['id']}: ".$e->getMessage());
                }
            }

            return $savedCount;

        } catch (\Exception $e) {
            $this->error('Error checking for new messages: '.$e->getMessage());

            return 0;
        }
    }

    private function transformMessage(array $message, WhatsappInstance $instance): array
    {
        // Extract key information
        $key = $message['key'] ?? [];
        $messageData = $message['message'] ?? [];

        // Determine message direction
        $fromMe = $key['fromMe'] ?? false;
        $direction = $fromMe ? MessageDirectionEnum::OUTGOING : MessageDirectionEnum::INCOMING;

        // Extract phone number
        $remoteJid = $key['remoteJid'] ?? '';
        $phone = str_replace(['@s.whatsapp.net', '@g.us'], '', $remoteJid);

        // Determine message type and extract content
        $messageType = $this->determineMessageType($messageData);
        $content = $this->extractContent($messageData, $messageType);
        $media = $this->extractMedia($messageData, $messageType);

        return [
            'message_id' => $key['id'] ?? '',
            'remote_jid' => $remoteJid,
            'phone' => $phone,
            'direction' => $direction,
            'type' => $messageType,
            'content' => $content,
            'media' => $media,
            'status' => MessageStatusEnum::SENT,
            'raw_payload' => $message,
        ];
    }

    private function determineMessageType(array $messageData): MessageTypeEnum
    {
        if (isset($messageData['conversation'])) {
            return MessageTypeEnum::TEXT;
        }

        if (isset($messageData['imageMessage'])) {
            return MessageTypeEnum::IMAGE;
        }

        if (isset($messageData['videoMessage'])) {
            return MessageTypeEnum::VIDEO;
        }

        if (isset($messageData['audioMessage'])) {
            return MessageTypeEnum::AUDIO;
        }

        if (isset($messageData['documentMessage'])) {
            return MessageTypeEnum::DOCUMENT;
        }

        if (isset($messageData['locationMessage'])) {
            return MessageTypeEnum::LOCATION;
        }

        if (isset($messageData['contactMessage'])) {
            return MessageTypeEnum::CONTACT;
        }

        // Fallback: use UNKNOWN if the enum defines it, otherwise fall back to TEXT
        if (defined(MessageTypeEnum::class.'::UNKNOWN')) {
            return MessageTypeEnum::TEXT;
        }

        return MessageTypeEnum::TEXT;
    }

    private function extractContent(array $messageData, MessageTypeEnum $type): array
    {
        $content = [];

        switch ($type) {
            case MessageTypeEnum::TEXT:
                $content['text'] = $messageData['conversation'] ?? '';
                break;

            case MessageTypeEnum::IMAGE:
                $content['caption'] = $messageData['imageMessage']['caption'] ?? null;
                break;

            case MessageTypeEnum::VIDEO:
                $content['caption'] = $messageData['videoMessage']['caption'] ?? null;
                break;

            case MessageTypeEnum::DOCUMENT:
                $content['fileName'] = $messageData['documentMessage']['fileName'] ?? null;
                $content['caption'] = $messageData['documentMessage']['caption'] ?? null;
                break;

            case MessageTypeEnum::LOCATION:
                $content['latitude'] = $messageData['locationMessage']['degreesLatitude'] ?? null;
                $content['longitude'] = $messageData['locationMessage']['degreesLongitude'] ?? null;
                $content['name'] = $messageData['locationMessage']['name'] ?? null;
                $content['address'] = $messageData['locationMessage']['address'] ?? null;
                break;

            case MessageTypeEnum::CONTACT:
                $content['contactName'] = $messageData['contactMessage']['displayName'] ?? null;
                $content['contactNumber'] = $messageData['contactMessage']['vcard'] ?? null;
                break;
        }

        return $content;
    }

    private function extractMedia(array $messageData, MessageTypeEnum $type): ?array
    {
        switch ($type) {
            case MessageTypeEnum::IMAGE:
                return [
                    'url' => $messageData['imageMessage']['url'] ?? null,
                    'mimetype' => $messageData['imageMessage']['mimetype'] ?? null,
                    'fileLength' => $messageData['imageMessage']['fileLength'] ?? null,
                ];

            case MessageTypeEnum::VIDEO:
                return [
                    'url' => $messageData['videoMessage']['url'] ?? null,
                    'mimetype' => $messageData['videoMessage']['mimetype'] ?? null,
                    'fileLength' => $messageData['videoMessage']['fileLength'] ?? null,
                ];

            case MessageTypeEnum::AUDIO:
                return [
                    'url' => $messageData['audioMessage']['url'] ?? null,
                    'mimetype' => $messageData['audioMessage']['mimetype'] ?? null,
                    'fileLength' => $messageData['audioMessage']['fileLength'] ?? null,
                ];

            case MessageTypeEnum::DOCUMENT:
                return [
                    'url' => $messageData['documentMessage']['url'] ?? null,
                    'mimetype' => $messageData['documentMessage']['mimetype'] ?? null,
                    'fileLength' => $messageData['documentMessage']['fileLength'] ?? null,
                    'fileName' => $messageData['documentMessage']['fileName'] ?? null,
                ];
        }

        return null;
    }
}
