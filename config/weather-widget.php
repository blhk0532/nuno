<?php

return [

    /**
     * API Key for Current Weather Data
     * You can get your API key from OpenWeatherMap:
     * https://openweathermap.org/price
     */
    'api_key' => env('OPENWEATHER_API_KEY', 'db3e9b8b2507f9f0893579962f326d28'),


    /**
     * Default city for weather data
     */
    'city' => 'Stockholm',


    /**
     * Units for temperature and other measurements
     * Options: 'metric', 'imperial', 'standard'
     * 'metric' - Celsius (°C), 'imperial' - Fahrenheit (°F), 'standard' - Kelvin (°K)
     * Default is 'metric'
     */
    'units' => 'metric',


    /**
     * Refresh (Poll) interval in minutes
     * This determines how often the weather data will be refreshed.
     * This also factors into the cache duration.
     */
    'refresh_minutes' => 100,

    /**
     * Icon settings
     * You can customize the icon set and variant used in the widget.
     * 'icon_set' can be 'fill', 'line', or 'monochrome'.
     */
    'icon_set' => 'fill',

    /**
     * Icon variant
     * Options: 'static', 'animated' (only for fill/line icons)
     */
    'icon_variant' => 'animated',

    /**
     * Language for weather data.
     * If not specified, then `app()->getLocale()` will be used.
     * Full list of supported languages here: https://openweathermap.org/forecast5#multi
     */
    'locale' => null,
];
