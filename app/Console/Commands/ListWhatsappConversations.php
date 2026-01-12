<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use WallaceMartinss\FilamentEvolution\Models\WhatsappMessage;

class ListWhatsappConversations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:list-conversations
                            {instance? : Filter by instance name}
                            {--limit=50 : Number of conversations to show}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List available WhatsApp conversations with message counts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $instanceName = $this->argument('instance');
        $limit = (int) $this->option('limit');

        $query = WhatsappMessage::select([
            'remote_jid',
            'instance_id',
            DB::raw('COUNT(*) as message_count'),
            DB::raw('MAX(created_at) as last_message_at'),
            DB::raw('MAX(content->"$.text") as last_message_text'),
        ])
            ->groupBy('remote_jid', 'instance_id')
            ->orderBy('last_message_at', 'desc')
            ->limit($limit);

        if ($instanceName) {
            $query->whereHas('instance', function ($q) use ($instanceName) {
                $q->where('name', $instanceName);
            });
        }

        $conversations = $query->with('instance')->get();

        if ($conversations->isEmpty()) {
            $this->warn('No conversations found.');

            return Command::SUCCESS;
        }

        $this->info('📱 WhatsApp Conversations:');
        $this->table(
            ['Remote JID', 'Instance', 'Messages', 'Last Message'],
            $conversations->map(function ($conversation) {
                return [
                    $conversation->remote_jid,
                    $conversation->instance->name ?? 'Unknown',
                    $conversation->message_count,
                    $conversation->last_message_at?->diffForHumans() ?? 'Unknown',
                ];
            })
        );

        $this->info("\n💡 To sync a specific conversation, use:");
        $this->info('   php artisan whatsapp:sync-messages {instance} --conversation={remote_jid}');

        return Command::SUCCESS;
    }
}
