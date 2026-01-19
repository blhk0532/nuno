<?php

declare(strict_types=1);

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Services\TelavoxSmsService;

Artisan::command('inspire', function (): void {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('telavox:sms {to : Destination number} {message : Message text} {--debug : Show request details}', function (string $to, string $message, TelavoxSmsService $sms): int {
    $debug = (bool) $this->option('debug');
    
    try {
        $result = $sms->send($to, $message, $debug);
    } catch (\Throwable $e) {
        $this->error('Failed: ' . $e->getMessage());
        return 1;
    }

    if ($debug) {
        $this->info('Debug mode - request details:');
        $this->line(json_encode($result, JSON_PRETTY_PRINT));
        return 0;
    }

    if ($result['success']) {
        $this->info('SMS sent successfully.');
        return 0;
    }

    $status = $result['status'];
    $msg = $result['message'] ?? 'Unknown error';
    $this->error("Failed (status {$status}): {$msg}");
    
    if (isset($result['body'])) {
        $this->line('Response: ' . json_encode($result['body'], JSON_PRETTY_PRINT));
    }
    
    return 1;
})->purpose('Send an SMS via Telavox');

Artisan::command('telavox:test', function (): int {
    $token = config('telavox.token');
    $baseUrl = config('telavox.base_url');
    
    if (empty($token)) {
        $this->error('TELAVOX_TOKEN not configured');
        return 1;
    }
    
    $this->info('Testing Telavox API connection...');
    $this->line('Base URL: ' . $baseUrl);
    $this->line('Token: ' . substr($token, 0, 20) . '...');
    
    // Try a simple endpoint to verify token works
    $response = \Illuminate\Support\Facades\Http::withToken($token)
        ->acceptJson()
        ->get($baseUrl . '/user');
    
    $this->line('Status: ' . $response->status());
    $this->line('Response: ' . json_encode($response->json(), JSON_PRETTY_PRINT));
    
    return $response->successful() ? 0 : 1;
})->purpose('Test Telavox API connection');
