<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\TelavoxSmsService;
use Illuminate\Console\Command;

class SendTelavoxSms extends Command
{
    /** @var string */
    protected $signature = 'telavox:sms {to : Destination number (e.g. 00467081234567 or 0701234567)} {message : Message text}';

    /** @var string */
    protected $description = 'Send an SMS using the Telavox API';

    public function handle(TelavoxSmsService $sms): int
    {
        $to = (string) $this->argument('to');
        $message = (string) $this->argument('message');

        try {
            $result = $sms->send($to, $message);
        } catch (\Throwable $e) {
            $this->error('Failed: ' . $e->getMessage());
            return self::FAILURE;
        }

        if ($result['success']) {
            $this->info('SMS sent successfully.');
            return self::SUCCESS;
        }

        $status = $result['status'];
        $msg = $result['message'] ?? 'Unknown error';
        $this->error("Failed (status {$status}): {$msg}");
        return self::FAILURE;
    }
}
