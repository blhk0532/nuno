<?php

declare(strict_types=1);

return [
    // Telavox Flow/Home API base URL
    'base_url' => env('TELAVOX_BASE_URL', 'https://api.telavox.se'),

    // Personal JWT token for the authenticated Telavox user
    // Store securely in .env as TELAVOX_TOKEN
    'token' => env('TELAVOX_TOKEN'),
];
