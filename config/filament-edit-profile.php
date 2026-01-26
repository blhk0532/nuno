<?php

return [
    'locales' => [
        'pt_BR' => '🇧🇷 Português',
        'en' => '🇺🇸 Inglês',
        'es' => '🇪🇸 Espanhol',
    ],
    'locale_column' => 'locale',
    'theme_color_column' => 'theme_color',
    'avatar_column' => 'avatar_url',
    'disk' => 'public',
    'visibility' => 'public', // or replace by filesystem disk visibility with fallback value
    'show_custom_fields' => true,
    'custom_fields' => [
        'name_first' => [
            'type' => 'text',
            'label' => 'First Name',
            'placeholder' => 'Enter your first name',
        ],
        'name_last' => [
            'type' => 'text',
            'label' => 'Last Name',
            'placeholder' => 'Enter your last name',
        ],
        'phone' => [
            'type' => 'text',
            'label' => 'Phone',
            'placeholder' => 'Enter your phone number',
        ],
        'address' => [
            'type' => 'text',
            'label' => 'Address',
            'placeholder' => 'Enter your address',
        ],
    ],
];
