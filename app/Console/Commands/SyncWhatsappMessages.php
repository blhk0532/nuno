<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use WallaceMartinss\FilamentEvolution\Enums\MessageDirectionEnum;
use WallaceMartinss\FilamentEvolution\Enums\MessageStatusEnum;
use WallaceMartinss\FilamentEvolution\Enums\MessageTypeEnum;
use WallaceMartinss\FilamentEvolution\Models\WhatsappInstance;
use WallaceMartinss\FilamentEvolution\Models\WhatsappMessage;

class SyncWhatsappMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:sync-messages
                            {instance? : The instance name to sync messages for}
                            {--conversation= : Sync only messages from this conversation (remoteJid)}
                            {--limit=1000 : Number of messages to fetch per request}
                            {--all : Sync messages for all instances}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync historical messages from Evolution API to database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $instanceName = $this->argument('instance');
        $conversationId = $this->option('conversation');
        $limit = (int) $this->option('limit');
        $syncAll = $this->option('all');

        if ($syncAll) {
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

        foreach ($instances as $instance) {
            $this->info("🔄 Syncing messages for instance: {$instance->name}");
            if ($conversationId) {
                $this->info("📱 Syncing only conversation: {$conversationId}");
            }
            $this->syncInstanceMessages($instance, $limit, $conversationId);
        }

        return Command::SUCCESS;
    }

    private function syncInstanceMessages(WhatsappInstance $instance, int $limit, ?string $conversationId = null): void
    {
        $apiKey = config('filament-evolution.api.api_key');
        $baseUrl = config('filament-evolution.api.base_url');

        if (! $apiKey || ! $baseUrl) {
            $this->error('Evolution API configuration missing');

            return;
        }

        $url = "{$baseUrl}/chat/findMessages/{$instance->instance_id}";
        $existingMessageIds = WhatsappMessage::where('instance_id', $instance->id)
            ->when($conversationId, fn ($query) => $query->where('remote_jid', $conversationId))
            ->pluck('message_id')
            ->toArray();

        $this->info('📊 Found '.count($existingMessageIds).' existing messages'.($conversationId ? " for conversation {$conversationId}" : ''));

        $offset = 0;
        $totalSynced = 0;

        do {
            try {
                $payload = [
                    'limit' => $limit,
                    'offset' => $offset,
                ];

                // Add conversation filter if specified
                if ($conversationId) {
                    $payload['where'] = [
                        'key' => [
                            'remoteJid' => $conversationId,
                        ],
                    ];
                }

                /** @var Response $response */
                $response = Http::withHeaders([
                    'apikey' => $apiKey,
                    'Content-Type' => 'application/json',
                ])->post($url, $payload);

                $status = $response->status();
                if ($status < 200 || $status >= 300) {
                    $this->error("Failed to fetch messages (HTTP {$status}): ".$response->body());
                    break;
                }

                $data = json_decode($response->body(), true);
                $this->info('Response structure: '.json_encode(array_keys($data)));

                if (! isset($data['messages']['records'])) {
                    $this->error('No records key in response: '.json_encode($data));
                    break;
                }

                $messages = $data['messages']['records'];
                $this->info('Messages type: '.gettype($messages).', count: '.(is_array($messages) ? count($messages) : 'N/A'));

                if (empty($messages)) {
                    $this->info('✅ No more messages to sync');
                    break;
                }

                $newMessages = [];
                foreach ($messages as $index => $message) {
                    try {
                        $newMessages[] = $this->transformMessage($message, $instance);
                    } catch (\Exception $e) {
                        $this->error("Error transforming message {$index}: ".$e->getMessage());
                        $this->error('Message data: '.json_encode($message));

                        continue;
                    }
                }

                if (! empty($newMessages)) {
                    // Convert array fields to JSON strings for bulk insert
                    $messagesToInsert = array_map(function ($message) {
                        return [
                            ...$message,
                            'content' => json_encode($message['content']),
                            'media' => $message['media'] ? json_encode($message['media']) : null,
                            'raw_payload' => json_encode($message['raw_payload']),
                        ];
                    }, $newMessages);

                    WhatsappMessage::insert($messagesToInsert);
                    $totalSynced += count($newMessages);
                    $this->info('✅ Synced '.count($newMessages)." new messages (offset: {$offset})");
                } else {
                    $this->info("⏭️  No new messages in this batch (offset: {$offset})");
                }

                $offset += count($messages);

                // Safety check to prevent infinite loops
                if ($offset > 50000) {
                    $this->warn('⚠️  Reached maximum offset limit (50,000). Stopping sync.');
                    break;
                }

            } catch (\Exception $e) {
                $this->error('Error syncing messages: '.$e->getMessage());
                break;
            }

        } while (! empty($messages));

        $this->info("🎉 Total messages synced for {$instance->name}: {$totalSynced}");
    }

    private function transformMessage(array $message, WhatsappInstance $instance): array
    {
        $direction = $message['key']['fromMe'] ? MessageDirectionEnum::OUTGOING : MessageDirectionEnum::INCOMING;
        $messageType = $this->determineMessageType($message);
        $content = $this->extractContent($message);
        $media = $this->extractMedia($message);

        return [
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'instance_id' => $instance->id,
            'message_id' => $message['id'],
            'remote_jid' => $message['key']['remoteJid'],
            'phone' => $this->extractPhone($message['key']['remoteJid']),
            'direction' => $direction,
            'type' => $messageType,
            'content' => $content,
            'media' => $media,
            'status' => MessageStatusEnum::SENT, // Assume sent for historical messages
            'raw_payload' => $message,
            'sent_at' => now()->createFromTimestamp($message['messageTimestamp']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    private function determineMessageType(array $message): MessageTypeEnum
    {
        $messageType = $message['messageType'] ?? 'conversation';

        return match ($messageType) {
            'conversation' => MessageTypeEnum::TEXT,
            'imageMessage' => MessageTypeEnum::IMAGE,
            'audioMessage' => MessageTypeEnum::AUDIO,
            'videoMessage' => MessageTypeEnum::VIDEO,
            'documentMessage' => MessageTypeEnum::DOCUMENT,
            'locationMessage' => MessageTypeEnum::LOCATION,
            'contactMessage' => MessageTypeEnum::CONTACT,
            'stickerMessage' => MessageTypeEnum::STICKER,
            default => MessageTypeEnum::TEXT,
        };
    }

    private function extractContent(array $message): array
    {
        $content = [];

        if (isset($message['message']['conversation'])) {
            $content['text'] = $message['message']['conversation'];
        }

        // Add other content types as needed
        if (isset($message['message']['imageMessage'])) {
            $content['caption'] = $message['message']['imageMessage']['caption'] ?? null;
        }

        return $content;
    }

    private function extractMedia(array $message): ?array
    {
        // Extract media information if present
        if (isset($message['message']['imageMessage'])) {
            return [
                'url' => $message['message']['imageMessage']['url'] ?? null,
                'mimetype' => $message['message']['imageMessage']['mimetype'] ?? null,
                'fileLength' => $message['message']['imageMessage']['fileLength'] ?? null,
            ];
        }

        return null;
    }

    private function extractPhone(string $remoteJid): ?string
    {
        // Extract phone number from remoteJid (e.g., "1234567890@s.whatsapp.net" -> "1234567890")
        if (str_contains($remoteJid, '@')) {
            return explode('@', $remoteJid)[0];
        }

        return $remoteJid;
    }
}
