<?php return array (
  'view' => 
  array (
    'paths' => 
    array (
      0 => '/home/baba/zzz/nuno/resources/views',
    ),
    'compiled' => '/home/baba/zzz/nuno/storage/framework/views',
  ),
  'broadcasting' => 
  array (
    'default' => 'log',
    'connections' => 
    array (
      'reverb' => 
      array (
        'driver' => 'reverb',
        'key' => 'drig5c2s9nghayizb5k9',
        'secret' => 'dqrgkvrhiawaddqsdopa',
        'app_id' => '870081',
        'options' => 
        array (
          'host' => 'localhost',
          'port' => '8080',
          'scheme' => 'http',
          'useTLS' => false,
        ),
        'client_options' => 
        array (
        ),
      ),
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => '0b76c5efc0fcde78df27',
        'secret' => '555afee778361155a2c7',
        'app_id' => '147973',
        'options' => 
        array (
          'cluster' => 'mt1',
          'host' => 'api-mt1.pusher.com',
          'port' => 443,
          'scheme' => 'https',
          'encrypted' => true,
          'useTLS' => true,
        ),
        'client_options' => 
        array (
        ),
      ),
      'ably' => 
      array (
        'driver' => 'ably',
        'key' => NULL,
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'concurrency' => 
  array (
    'default' => 'process',
  ),
  'hashing' => 
  array (
    'driver' => 'bcrypt',
    'bcrypt' => 
    array (
      'rounds' => '12',
      'verify' => true,
      'limit' => NULL,
    ),
    'argon' => 
    array (
      'memory' => 65536,
      'threads' => 1,
      'time' => 4,
      'verify' => true,
    ),
    'rehash_on_login' => true,
  ),
  'actionable-column' => 
  array (
    'placeholder' => 'N/A',
    'custom_css_path' => NULL,
  ),
  'activitylog' => 
  array (
    'enabled' => true,
    'delete_records_older_than_days' => 365,
    'default_log_name' => 'default',
    'default_auth_driver' => NULL,
    'subject_returns_soft_deleted_models' => false,
    'activity_model' => 'Spatie\\Activitylog\\Models\\Activity',
    'table_name' => 'activity_log',
    'database_connection' => NULL,
  ),
  'app' => 
  array (
    'name' => 'Nordic Digital Solutions',
    'env' => 'local',
    'debug' => false,
    'url' => 'http://localhost:8000',
    'frontend_url' => 'http://localhost:3000',
    'asset_url' => NULL,
    'timezone' => 'Europe/Stockholm',
    'locale' => 'en',
    'fallback_locale' => 'en',
    'faker_locale' => 'en_US',
    'cipher' => 'AES-256-CBC',
    'key' => 'base64:5lF7oeMK0qX/0POp6hgsshT4etq0/ryjVnJ/4sICZCc=',
    'previous_keys' => 
    array (
    ),
    'maintenance' => 
    array (
      'driver' => 'file',
      'store' => 'database',
    ),
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Concurrency\\ConcurrencyServiceProvider',
      6 => 'Illuminate\\Cookie\\CookieServiceProvider',
      7 => 'Illuminate\\Database\\DatabaseServiceProvider',
      8 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      9 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      10 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      11 => 'Illuminate\\Hashing\\HashServiceProvider',
      12 => 'Illuminate\\Mail\\MailServiceProvider',
      13 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      14 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      15 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      16 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      17 => 'Illuminate\\Queue\\QueueServiceProvider',
      18 => 'Illuminate\\Redis\\RedisServiceProvider',
      19 => 'Illuminate\\Session\\SessionServiceProvider',
      20 => 'Illuminate\\Translation\\TranslationServiceProvider',
      21 => 'Illuminate\\Validation\\ValidationServiceProvider',
      22 => 'Illuminate\\View\\ViewServiceProvider',
      23 => 'App\\Providers\\Adultdate\\ChatsPanelProvider',
      24 => 'App\\Providers\\AppServiceProvider',
      25 => 'App\\Providers\\Filament\\AdminPanelProvider',
      26 => 'App\\Providers\\Filament\\AppPanelProvider',
      27 => 'App\\Providers\\Filament\\BookingPanelProvider',
      28 => 'App\\Providers\\Filament\\CalendarPanelProvider',
      29 => 'App\\Providers\\Filament\\ChatPanelProvider',
      30 => 'App\\Providers\\Filament\\ClientsPanelProvider',
      31 => 'App\\Providers\\Filament\\ContentPanelProvider',
      32 => 'App\\Providers\\Filament\\DataPanelProvider',
      33 => 'App\\Providers\\Filament\\DevPanelProvider',
      34 => 'App\\Providers\\Filament\\DialerPanelProvider',
      35 => 'App\\Providers\\Filament\\EmailPanelProvider',
      36 => 'App\\Providers\\Filament\\FilesPanelProvider',
      37 => 'App\\Providers\\Filament\\FinancePanelProvider',
      38 => 'App\\Providers\\Filament\\LocalePanelProvider',
      39 => 'App\\Providers\\Filament\\ManagerPanelProvider',
      40 => 'App\\Providers\\Filament\\NotifyPanelProvider',
      41 => 'App\\Providers\\Filament\\OauthPanelProvider',
      42 => 'App\\Providers\\Filament\\PartnerPanelProvider',
      43 => 'App\\Providers\\Filament\\PluginsPanelProvider',
      44 => 'App\\Providers\\Filament\\PrivatePanelProvider',
      45 => 'App\\Providers\\Filament\\ProductPanelProvider',
      46 => 'App\\Providers\\Filament\\QueuePanelProvider',
      47 => 'App\\Providers\\Filament\\ScriptPanelProvider',
      48 => 'App\\Providers\\Filament\\ServerPanelProvider',
      49 => 'App\\Providers\\Filament\\ServicePanelProvider',
      50 => 'App\\Providers\\Filament\\SheetsPanelProvider',
      51 => 'App\\Providers\\Filament\\StatsPanelProvider',
      52 => 'App\\Providers\\Filament\\StoragePanelProvider',
      53 => 'App\\Providers\\Filament\\SuperPanelProvider',
      54 => 'App\\Providers\\Filament\\SystemPanelProvider',
      55 => 'App\\Providers\\Filament\\ToolsPanelProvider',
      56 => 'App\\Providers\\Filament\\UserPanelProvider',
      57 => 'App\\Providers\\FolioServiceProvider',
      58 => 'App\\Providers\\FortifyServiceProvider',
      59 => 'App\\Providers\\HorizonServiceProvider',
      60 => 'App\\Providers\\VoltServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Arr' => 'Illuminate\\Support\\Arr',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Benchmark' => 'Illuminate\\Support\\Benchmark',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Concurrency' => 'Illuminate\\Support\\Facades\\Concurrency',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Context' => 'Illuminate\\Support\\Facades\\Context',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'Date' => 'Illuminate\\Support\\Facades\\Date',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Http' => 'Illuminate\\Support\\Facades\\Http',
      'Js' => 'Illuminate\\Support\\Js',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Number' => 'Illuminate\\Support\\Number',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Process' => 'Illuminate\\Support\\Facades\\Process',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'RateLimiter' => 'Illuminate\\Support\\Facades\\RateLimiter',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schedule' => 'Illuminate\\Support\\Facades\\Schedule',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'Str' => 'Illuminate\\Support\\Str',
      'Uri' => 'Illuminate\\Support\\Uri',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Vite' => 'Illuminate\\Support\\Facades\\Vite',
    ),
  ),
  'app-modules' => 
  array (
    'modules_namespace' => 'Modules',
    'modules_vendor' => NULL,
    'modules_directory' => 'app-modules',
    'tests_base' => 'Tests\\TestCase',
    'stubs' => NULL,
    'should_discover_events' => NULL,
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'admin' => 
      array (
        'driver' => 'session',
        'provider' => 'admins',
      ),
      'service' => 
      array (
        'driver' => 'session',
        'provider' => 'services',
      ),
      'partner' => 
      array (
        'driver' => 'session',
        'provider' => 'partners',
      ),
      'super' => 
      array (
        'driver' => 'session',
        'provider' => 'supers',
      ),
      'sanctum' => 
      array (
        'driver' => 'sanctum',
        'provider' => NULL,
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\User',
      ),
      'admins' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\User',
      ),
      'services' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\Service',
      ),
      'partners' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\Partner',
      ),
      'supers' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\Super',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
      ),
      'admins' => 
      array (
        'provider' => 'admins',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
      ),
      'services' => 
      array (
        'provider' => 'services',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
      ),
      'partners' => 
      array (
        'provider' => 'partners',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
      ),
      'supers' => 
      array (
        'provider' => 'supers',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
      ),
    ),
    'password_timeout' => 10800,
  ),
  'auth-designer' => 
  array (
  ),
  'backup' => 
  array (
    'backup' => 
    array (
      'name' => 'Nordic Digital Solutions',
      'source' => 
      array (
        'files' => 
        array (
          'include' => 
          array (
            0 => '/home/baba/zzz/nuno',
          ),
          'exclude' => 
          array (
            0 => '/home/baba/zzz/nuno/vendor',
            1 => '/home/baba/zzz/nuno/node_modules',
          ),
          'follow_links' => false,
          'ignore_unreadable_directories' => false,
          'relative_path' => NULL,
        ),
        'databases' => 
        array (
          0 => 'mysql',
        ),
      ),
      'database_dump_compressor' => NULL,
      'database_dump_file_timestamp_format' => NULL,
      'database_dump_filename_base' => 'database',
      'database_dump_file_extension' => '',
      'destination' => 
      array (
        'compression_method' => -1,
        'compression_level' => 9,
        'filename_prefix' => '',
        'disks' => 
        array (
          0 => 'local',
        ),
      ),
      'temporary_directory' => '/home/baba/zzz/nuno/storage/app/backup-temp',
      'password' => NULL,
      'encryption' => 'default',
      'tries' => 1,
      'retry_delay' => 0,
    ),
    'notifications' => 
    array (
      'notifications' => 
      array (
        'Spatie\\Backup\\Notifications\\Notifications\\BackupHasFailedNotification' => 
        array (
          0 => 'mail',
        ),
        'Spatie\\Backup\\Notifications\\Notifications\\UnhealthyBackupWasFoundNotification' => 
        array (
          0 => 'mail',
        ),
        'Spatie\\Backup\\Notifications\\Notifications\\CleanupHasFailedNotification' => 
        array (
          0 => 'mail',
        ),
        'Spatie\\Backup\\Notifications\\Notifications\\BackupWasSuccessfulNotification' => 
        array (
          0 => 'mail',
        ),
        'Spatie\\Backup\\Notifications\\Notifications\\HealthyBackupWasFoundNotification' => 
        array (
          0 => 'mail',
        ),
        'Spatie\\Backup\\Notifications\\Notifications\\CleanupWasSuccessfulNotification' => 
        array (
          0 => 'mail',
        ),
      ),
      'notifiable' => 'Spatie\\Backup\\Notifications\\Notifiable',
      'mail' => 
      array (
        'to' => 'your@example.com',
        'from' => 
        array (
          'address' => 'noreply@example.com',
          'name' => 'Your App',
        ),
      ),
      'slack' => 
      array (
        'webhook_url' => '',
        'channel' => NULL,
        'username' => NULL,
        'icon' => NULL,
      ),
      'discord' => 
      array (
        'webhook_url' => '',
        'username' => '',
        'avatar_url' => '',
      ),
    ),
    'monitor_backups' => 
    array (
      0 => 
      array (
        'name' => 'Nordic Digital Solutions',
        'disks' => 
        array (
          0 => 'local',
        ),
        'health_checks' => 
        array (
          'Spatie\\Backup\\Tasks\\Monitor\\HealthChecks\\MaximumAgeInDays' => 1,
          'Spatie\\Backup\\Tasks\\Monitor\\HealthChecks\\MaximumStorageInMegabytes' => 5000,
        ),
      ),
    ),
    'cleanup' => 
    array (
      'strategy' => 'Spatie\\Backup\\Tasks\\Cleanup\\Strategies\\DefaultStrategy',
      'default_strategy' => 
      array (
        'keep_all_backups_for_days' => 7,
        'keep_daily_backups_for_days' => 16,
        'keep_weekly_backups_for_weeks' => 8,
        'keep_monthly_backups_for_months' => 4,
        'keep_yearly_backups_for_years' => 2,
        'delete_oldest_backups_when_using_more_megabytes_than' => 5000,
      ),
      'tries' => 1,
      'retry_delay' => 0,
    ),
  ),
  'blade-flags' => 
  array (
    'prefix' => 'flag',
    'fallback' => 'country-xx',
    'class' => '',
    'attributes' => 
    array (
    ),
  ),
  'blade-fontawesome' => 
  array (
    'brands' => 
    array (
      'prefix' => 'fab',
      'fallback' => '',
      'class' => '',
      'attributes' => 
      array (
      ),
    ),
    'regular' => 
    array (
      'prefix' => 'far',
      'fallback' => '',
      'class' => '',
      'attributes' => 
      array (
      ),
    ),
    'solid' => 
    array (
      'prefix' => 'fas',
      'fallback' => '',
      'class' => '',
      'attributes' => 
      array (
      ),
    ),
    'duotone' => 
    array (
      'prefix' => 'fad',
      'fallback' => '',
      'class' => '',
      'attributes' => 
      array (
      ),
    ),
    'light' => 
    array (
      'prefix' => 'fal',
      'fallback' => '',
      'class' => '',
      'attributes' => 
      array (
      ),
    ),
    'thin' => 
    array (
      'prefix' => 'fat',
      'fallback' => '',
      'class' => '',
      'attributes' => 
      array (
      ),
    ),
    'sharp-light' => 
    array (
      'prefix' => 'fal:sharp',
      'fallback' => '',
      'class' => '',
      'attributes' => 
      array (
      ),
    ),
    'sharp-regular' => 
    array (
      'prefix' => 'far:sharp',
      'fallback' => '',
      'class' => '',
      'attributes' => 
      array (
      ),
    ),
    'sharp-solid' => 
    array (
      'prefix' => 'fas:sharp',
      'fallback' => '',
      'class' => '',
      'attributes' => 
      array (
      ),
    ),
    'sharp-duotone-solid' => 
    array (
      'prefix' => 'fad:sharp',
      'fallback' => '',
      'class' => '',
      'attributes' => 
      array (
      ),
    ),
    'sharp-thin' => 
    array (
      'prefix' => 'fat:sharp',
      'fallback' => '',
      'class' => '',
      'attributes' => 
      array (
      ),
    ),
    'custom-icons' => 
    array (
      'prefix' => 'fak',
      'fallback' => '',
      'class' => '',
      'attributes' => 
      array (
      ),
    ),
  ),
  'blade-heroicons' => 
  array (
    'prefix' => 'heroicon',
    'fallback' => '',
    'class' => '',
    'attributes' => 
    array (
    ),
  ),
  'blade-icons' => 
  array (
    'sets' => 
    array (
    ),
    'class' => '',
    'attributes' => 
    array (
    ),
    'fallback' => '',
    'components' => 
    array (
      'disabled' => false,
      'default' => 'icon',
    ),
  ),
  'blade-lucide-icons' => 
  array (
    'prefix' => 'lucide',
    'fallback' => '',
    'class' => '',
    'attributes' => 
    array (
    ),
  ),
  'blade-tabler-icons' => 
  array (
    'prefix' => 'tabler',
    'fallback' => 'section',
    'class' => '',
    'attributes' => 
    array (
    ),
  ),
  'boost' => 
  array (
    'enabled' => true,
    'browser_logs_watcher' => true,
  ),
  'cache' => 
  array (
    'default' => 'redis',
    'stores' => 
    array (
      'array' => 
      array (
        'driver' => 'array',
        'serialize' => false,
      ),
      'session' => 
      array (
        'driver' => 'session',
        'key' => '_cache',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'connection' => NULL,
        'table' => 'cache',
        'lock_connection' => NULL,
        'lock_table' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => '/home/baba/zzz/nuno/storage/framework/cache/data',
        'lock_path' => '/home/baba/zzz/nuno/storage/framework/cache/data',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'cache',
        'lock_connection' => 'default',
      ),
      'dynamodb' => 
      array (
        'driver' => 'dynamodb',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ),
      'octane' => 
      array (
        'driver' => 'octane',
      ),
      'failover' => 
      array (
        'driver' => 'failover',
        'stores' => 
        array (
          0 => 'database',
          1 => 'array',
        ),
      ),
    ),
    'prefix' => 'nordic_digital_solutions_cache_',
  ),
  'command-runner' => 
  array (
    'table_name' => 'command_runs',
  ),
  'commentions' => 
  array (
    'tables' => 
    array (
      'comments' => 'comments',
      'comment_reactions' => 'comment_reactions',
      'comment_subscriptions' => 'comment_subscriptions',
    ),
    'commenter' => 
    array (
      'model' => 'App\\Models\\User',
    ),
    'comment' => 
    array (
      'model' => 'Kirschbaum\\Commentions\\Comment',
      'policy' => 'Kirschbaum\\Commentions\\Policies\\CommentPolicy',
    ),
    'reactions' => 
    array (
      'allowed' => 
      array (
        0 => '👍',
        1 => '❤️',
        2 => '😂',
        3 => '😮',
        4 => '😢',
        5 => '🤔',
      ),
    ),
    'subscriptions' => 
    array (
      'dispatch_as_mention' => false,
      'show_subscribers' => true,
      'auto_subscribe_on_comment' => true,
      'auto_subscribe_on_mention' => true,
    ),
    'notifications' => 
    array (
      'mentions' => 
      array (
        'enabled' => false,
        'channels' => 
        array (
          0 => 'mail',
        ),
        'listener' => 'Kirschbaum\\Commentions\\Listeners\\SendUserMentionedNotification',
        'notification' => 'Kirschbaum\\Commentions\\Notifications\\UserMentionedInComment',
        'mail' => 
        array (
          'subject' => 'You were mentioned in a comment',
        ),
      ),
    ),
  ),
  'cors' => 
  array (
    'paths' => 
    array (
      0 => 'api/*',
      1 => 'sanctum/csrf-cookie',
      2 => 'calendar/*',
    ),
    'allowed_methods' => 
    array (
      0 => '*',
    ),
    'allowed_origins' => 
    array (
      0 => 'http://localhost:5173',
      1 => 'https://ndsth.com',
    ),
    'allowed_origins_patterns' => 
    array (
    ),
    'allowed_headers' => 
    array (
      0 => '*',
    ),
    'exposed_headers' => 
    array (
    ),
    'max_age' => 0,
    'supports_credentials' => true,
  ),
  'creators-ticketing' => 
  array (
    'navigation_group' => 'Creators Ticketing',
    'user_model' => 'App\\Models\\User',
    'user_name_column' => 'name',
    'navigation_visibility' => 
    array (
      'field' => 'role',
      'allowed' => 
      array (
        0 => 'super',
        1 => 'admin',
      ),
    ),
    'ticket_assign_scope' => 'any_user',
    'max_open_tickets_per_user' => 5,
    'ticket_limit_message' => 'You have reached the maximum number of open tickets. Please wait for an existing ticket to be resolved before creating a new one.',
    'ticket_prefix' => 'TKT',
    'table_prefix' => 'ct_',
    'ticket_format' => '{PREFIX}-{DATE}-{RAND}',
    'ticket_date_format' => 'ymd',
    'ticket_random_length' => 4,
  ),
  'dash-arrange' => 
  array (
    'user_model' => 'App\\Models\\User',
    'user_id_resolver' => NULL,
    'permission_check' => NULL,
    'default_grid_columns' => 
    array (
      'md' => 2,
      'xl' => 12,
    ),
    'sortable_options' => 
    array (
      'animation' => 150,
      'handle' => '[x-sortable-handle]',
    ),
    'customize_dashboard_title' => 'Customize',
    'customize_dashboard_button_color' => 'primary',
  ),
  'data' => 
  array (
    'date_format' => 'Y-m-d\\TH:i:sP',
    'date_timezone' => NULL,
    'features' => 
    array (
      'cast_and_transform_iterables' => false,
      'ignore_exception_when_trying_to_set_computed_property_value' => false,
    ),
    'transformers' => 
    array (
      'DateTimeInterface' => 'Spatie\\LaravelData\\Transformers\\DateTimeInterfaceTransformer',
      'Illuminate\\Contracts\\Support\\Arrayable' => 'Spatie\\LaravelData\\Transformers\\ArrayableTransformer',
      'BackedEnum' => 'Spatie\\LaravelData\\Transformers\\EnumTransformer',
    ),
    'casts' => 
    array (
      'DateTimeInterface' => 'Spatie\\LaravelData\\Casts\\DateTimeInterfaceCast',
      'BackedEnum' => 'Spatie\\LaravelData\\Casts\\EnumCast',
    ),
    'rule_inferrers' => 
    array (
      0 => 'Spatie\\LaravelData\\RuleInferrers\\SometimesRuleInferrer',
      1 => 'Spatie\\LaravelData\\RuleInferrers\\NullableRuleInferrer',
      2 => 'Spatie\\LaravelData\\RuleInferrers\\RequiredRuleInferrer',
      3 => 'Spatie\\LaravelData\\RuleInferrers\\BuiltInTypesRuleInferrer',
      4 => 'Spatie\\LaravelData\\RuleInferrers\\AttributesRuleInferrer',
    ),
    'normalizers' => 
    array (
      0 => 'Spatie\\LaravelData\\Normalizers\\ModelNormalizer',
      1 => 'Spatie\\LaravelData\\Normalizers\\ArrayableNormalizer',
      2 => 'Spatie\\LaravelData\\Normalizers\\ObjectNormalizer',
      3 => 'Spatie\\LaravelData\\Normalizers\\ArrayNormalizer',
      4 => 'Spatie\\LaravelData\\Normalizers\\JsonNormalizer',
    ),
    'wrap' => NULL,
    'var_dumper_caster_mode' => 'development',
    'structure_caching' => 
    array (
      'enabled' => true,
      'directories' => 
      array (
        0 => '/home/baba/zzz/nuno/app/Data',
      ),
      'cache' => 
      array (
        'store' => 'redis',
        'prefix' => 'laravel-data',
        'duration' => NULL,
      ),
      'reflection_discovery' => 
      array (
        'enabled' => true,
        'base_path' => '/home/baba/zzz/nuno',
        'root_namespace' => NULL,
      ),
    ),
    'validation_strategy' => 'only_requests',
    'name_mapping_strategy' => 
    array (
      'input' => NULL,
      'output' => NULL,
    ),
    'ignore_invalid_partials' => false,
    'max_transformation_depth' => NULL,
    'throw_when_max_transformation_depth_reached' => true,
    'commands' => 
    array (
      'make' => 
      array (
        'namespace' => 'Data',
        'suffix' => 'Data',
      ),
    ),
    'livewire' => 
    array (
      'enable_synths' => false,
    ),
  ),
  'database' => 
  array (
    'default' => 'mysql',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'url' => NULL,
        'database' => 'nuno',
        'prefix' => '',
        'foreign_key_constraints' => true,
        'busy_timeout' => NULL,
        'journal_mode' => NULL,
        'synchronous' => NULL,
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'nuno',
        'username' => 'root',
        'password' => 'bkkbkk',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'mariadb' => 
      array (
        'driver' => 'mariadb',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'nuno',
        'username' => 'root',
        'password' => 'bkkbkk',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'nuno',
        'username' => 'root',
        'password' => 'bkkbkk',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'search_path' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'nuno',
        'username' => 'root',
        'password' => 'bkkbkk',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ),
    ),
    'migrations' => 
    array (
      'table' => 'migrations',
      'update_date_on_publish' => true,
    ),
    'redis' => 
    array (
      'client' => 'phpredis',
      'options' => 
      array (
        'cluster' => 'redis',
        'prefix' => 'nordic_digital_solutions_database_',
        'persistent' => false,
      ),
      'default' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '0',
        'max_retries' => 3,
        'backoff_algorithm' => 'decorrelated_jitter',
        'backoff_base' => 100,
        'backoff_cap' => 1000,
      ),
      'cache' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '1',
        'max_retries' => 3,
        'backoff_algorithm' => 'decorrelated_jitter',
        'backoff_base' => 100,
        'backoff_cap' => 1000,
      ),
      'horizon' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '0',
        'max_retries' => 3,
        'backoff_algorithm' => 'decorrelated_jitter',
        'backoff_base' => 100,
        'backoff_cap' => 1000,
        'options' => 
        array (
          'prefix' => 'nordic_digital_solutions_horizon:',
        ),
      ),
    ),
  ),
  'debugbar' => 
  array (
    'enabled' => false,
    'hide_empty_tabs' => true,
    'except' => 
    array (
      0 => 'telescope*',
      1 => 'horizon*',
      2 => '_boost/browser-logs',
    ),
    'storage' => 
    array (
      'enabled' => true,
      'open' => NULL,
      'driver' => 'file',
      'path' => '/home/baba/zzz/nuno/storage/debugbar',
      'connection' => NULL,
      'provider' => '',
      'hostname' => '127.0.0.1',
      'port' => 2304,
    ),
    'editor' => 'phpstorm',
    'remote_sites_path' => NULL,
    'local_sites_path' => NULL,
    'include_vendors' => true,
    'capture_ajax' => true,
    'add_ajax_timing' => false,
    'ajax_handler_auto_show' => true,
    'ajax_handler_enable_tab' => true,
    'defer_datasets' => false,
    'error_handler' => false,
    'error_level' => 30719,
    'clockwork' => false,
    'collectors' => 
    array (
      'phpinfo' => false,
      'messages' => true,
      'time' => true,
      'memory' => true,
      'exceptions' => true,
      'log' => true,
      'db' => true,
      'views' => true,
      'route' => false,
      'auth' => false,
      'gate' => true,
      'session' => false,
      'symfony_request' => true,
      'mail' => true,
      'laravel' => true,
      'events' => false,
      'default_request' => false,
      'logs' => false,
      'files' => false,
      'config' => false,
      'cache' => false,
      'models' => true,
      'livewire' => true,
      'jobs' => false,
      'pennant' => false,
    ),
    'options' => 
    array (
      'time' => 
      array (
        'memory_usage' => false,
      ),
      'messages' => 
      array (
        'trace' => true,
        'capture_dumps' => false,
      ),
      'memory' => 
      array (
        'reset_peak' => false,
        'with_baseline' => false,
        'precision' => 0,
      ),
      'auth' => 
      array (
        'show_name' => true,
        'show_guards' => true,
      ),
      'gate' => 
      array (
        'trace' => false,
      ),
      'db' => 
      array (
        'with_params' => true,
        'exclude_paths' => 
        array (
        ),
        'backtrace' => true,
        'backtrace_exclude_paths' => 
        array (
        ),
        'timeline' => false,
        'duration_background' => true,
        'explain' => 
        array (
          'enabled' => false,
        ),
        'hints' => false,
        'show_copy' => true,
        'only_slow_queries' => true,
        'slow_threshold' => false,
        'memory_usage' => false,
        'soft_limit' => 100,
        'hard_limit' => 500,
      ),
      'mail' => 
      array (
        'timeline' => true,
        'show_body' => true,
      ),
      'views' => 
      array (
        'timeline' => true,
        'data' => false,
        'group' => 50,
        'inertia_pages' => 'js/Pages',
        'exclude_paths' => 
        array (
          0 => 'vendor/filament',
        ),
      ),
      'route' => 
      array (
        'label' => true,
      ),
      'session' => 
      array (
        'hiddens' => 
        array (
        ),
      ),
      'symfony_request' => 
      array (
        'label' => true,
        'hiddens' => 
        array (
        ),
      ),
      'events' => 
      array (
        'data' => false,
        'excluded' => 
        array (
        ),
      ),
      'logs' => 
      array (
        'file' => NULL,
      ),
      'cache' => 
      array (
        'values' => true,
      ),
    ),
    'inject' => true,
    'route_prefix' => '_debugbar',
    'route_middleware' => 
    array (
    ),
    'route_domain' => NULL,
    'theme' => 'auto',
    'debug_backtrace_limit' => 50,
  ),
  'eloquent-sortable' => 
  array (
    'order_column_name' => 'order_column',
    'sort_when_creating' => true,
    'ignore_timestamps' => false,
  ),
  'essentials' => 
  array (
    'NunoMaduro\\Essentials\\Configurables\\AggressivePrefetching' => true,
    'NunoMaduro\\Essentials\\Configurables\\AutomaticallyEagerLoadRelationships' => true,
    'NunoMaduro\\Essentials\\Configurables\\FakeSleep' => true,
    'NunoMaduro\\Essentials\\Configurables\\ForceScheme' => true,
    'environments' => 
    array (
      'NunoMaduro\\Essentials\\Configurables\\ForceScheme' => 
      array (
        0 => 'production',
      ),
    ),
    'NunoMaduro\\Essentials\\Configurables\\ImmutableDates' => true,
    'NunoMaduro\\Essentials\\Configurables\\PreventStrayRequests' => true,
    'NunoMaduro\\Essentials\\Configurables\\ProhibitDestructiveCommands' => true,
    'NunoMaduro\\Essentials\\Configurables\\SetDefaultPassword' => true,
    'NunoMaduro\\Essentials\\Configurables\\ShouldBeStrict' => true,
    'NunoMaduro\\Essentials\\Configurables\\Unguard' => false,
  ),
  'excel' => 
  array (
    'exports' => 
    array (
      'chunk_size' => 1000,
      'pre_calculate_formulas' => false,
      'strict_null_comparison' => false,
      'csv' => 
      array (
        'delimiter' => ',',
        'enclosure' => '"',
        'line_ending' => '
',
        'use_bom' => false,
        'include_separator_line' => false,
        'excel_compatibility' => false,
        'output_encoding' => '',
        'test_auto_detect' => true,
      ),
      'properties' => 
      array (
        'creator' => '',
        'lastModifiedBy' => '',
        'title' => '',
        'description' => '',
        'subject' => '',
        'keywords' => '',
        'category' => '',
        'manager' => '',
        'company' => '',
      ),
    ),
    'imports' => 
    array (
      'read_only' => true,
      'ignore_empty' => false,
      'heading_row' => 
      array (
        'formatter' => 'slug',
      ),
      'csv' => 
      array (
        'delimiter' => NULL,
        'enclosure' => '"',
        'escape_character' => '\\',
        'contiguous' => false,
        'input_encoding' => 'guess',
      ),
      'properties' => 
      array (
        'creator' => '',
        'lastModifiedBy' => '',
        'title' => '',
        'description' => '',
        'subject' => '',
        'keywords' => '',
        'category' => '',
        'manager' => '',
        'company' => '',
      ),
      'cells' => 
      array (
        'middleware' => 
        array (
        ),
      ),
    ),
    'extension_detector' => 
    array (
      'xlsx' => 'Xlsx',
      'xlsm' => 'Xlsx',
      'xltx' => 'Xlsx',
      'xltm' => 'Xlsx',
      'xls' => 'Xls',
      'xlt' => 'Xls',
      'ods' => 'Ods',
      'ots' => 'Ods',
      'slk' => 'Slk',
      'xml' => 'Xml',
      'gnumeric' => 'Gnumeric',
      'htm' => 'Html',
      'html' => 'Html',
      'csv' => 'Csv',
      'tsv' => 'Csv',
      'pdf' => 'Dompdf',
    ),
    'value_binder' => 
    array (
      'default' => 'Maatwebsite\\Excel\\DefaultValueBinder',
    ),
    'cache' => 
    array (
      'driver' => 'memory',
      'batch' => 
      array (
        'memory_limit' => 60000,
      ),
      'illuminate' => 
      array (
        'store' => NULL,
      ),
      'default_ttl' => 10800,
    ),
    'transactions' => 
    array (
      'handler' => 'db',
      'db' => 
      array (
        'connection' => NULL,
      ),
    ),
    'temporary_files' => 
    array (
      'local_path' => '/home/baba/zzz/nuno/storage/framework/cache/laravel-excel',
      'local_permissions' => 
      array (
      ),
      'remote_disk' => NULL,
      'remote_prefix' => NULL,
      'force_resync_remote' => NULL,
    ),
  ),
  'excel-import' => 
  array (
    'upload_disk' => NULL,
    'load_stylesheet' => false,
  ),
  'filament' => 
  array (
    'broadcasting' => 
    array (
      'echo' => 
      array (
        'broadcaster' => 'pusher',
        'key' => 'drig5c2s9nghayizb5k9',
        'host' => 'localhost',
        'port' => '8080',
        'scheme' => 'http',
        'useTLS' => false,
        'authEndpoint' => '/broadcasting/auth',
        'disableStats' => true,
        'encrypted' => true,
        'forceTLS' => false,
      ),
    ),
    'default_filesystem_disk' => 'local',
    'assets_path' => NULL,
    'cache_path' => '/home/baba/zzz/nuno/bootstrap/cache/filament',
    'livewire_loading_delay' => 'default',
    'file_generation' => 
    array (
      'flags' => 
      array (
      ),
    ),
    'system_route_prefix' => 'filament',
  ),
  'filament-ace-editor-field' => 
  array (
    'base_url' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7',
    'file' => 'ace.js',
    'editor_config' => 
    array (
      'useWorker' => false,
    ),
    'editor_options' => 
    array (
      'mode' => 'ace/mode/php',
      'theme' => 'ace/theme/eclipse',
      'enableBasicAutocompletion' => true,
      'enableLiveAutocompletion' => true,
      'liveAutocompletionDelay' => 0,
      'liveAutocompletionThreshold' => 0,
      'enableSnippets' => true,
      'enableInlineAutocompletion' => true,
      'showPrintMargin' => false,
      'wrap' => 'free',
    ),
    'dark_mode' => 
    array (
      'enable' => true,
      'theme' => 'ace/theme/dracula',
    ),
    'enabled_extensions' => 
    array (
      0 => 'beautify',
      1 => 'language_tools',
      2 => 'inline_autocomplete',
    ),
    'extensions' => 
    array (
      'beautify' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-beautify.min.js',
      'code_lens' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-code_lens.min.js',
      'command_bar' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-command_bar.min.js',
      'elastic_tabstops_lite' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-elastic_tabstops_lite.min.js',
      'emmet' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-emmet.min.js',
      'error_marker' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-error_marker.min.js',
      'hardwrap' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-hardwrap.min.js',
      'inline_autocomplete' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-inline_autocomplete.min.js',
      'keybinding_menu' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-keybinding_menu.min.js',
      'language_tools' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-language_tools.min.js',
      'linking' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-linking.min.js',
      'modelist' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-modelist.min.js',
      'options' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-options.min.js',
      'prompt' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-prompt.min.js',
      'rtl' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-rtl.min.js',
      'searchbox' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-searchbox.min.js',
      'settings_menu' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-settings_menu.min.js',
      'simple_tokenizer' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-simple_tokenizer.min.js',
      'spellcheck' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-spellcheck.min.js',
      'split' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-split.min.js',
      'static_highlight' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-static_highlight.min.js',
      'statusbar' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-statusbar.min.js',
      'textarea' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-textarea.min.js',
      'themelist' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-themelist.min.js',
      'whitespace' => 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.7/ext-whitespace.min.js',
    ),
  ),
  'filament-activity-log' => 
  array (
    'resource' => 
    array (
      'class' => 'AlizHarb\\ActivityLog\\Resources\\ActivityLogs\\ActivityLogResource',
      'group' => NULL,
      'sort' => NULL,
      'default_sort_column' => 'created_at',
      'default_sort_direction' => 'desc',
      'navigation_count_badge' => false,
      'navigation_icon' => 'heroicon-o-rectangle-stack',
      'global_search' => 
      array (
        'enabled' => true,
        'attributes' => 
        array (
          0 => 'log_name',
          1 => 'description',
          2 => 'subject_type',
          3 => 'event',
        ),
      ),
      'pagination' => 
      array (
        'options' => 
        array (
          0 => 10,
          1 => 25,
          2 => 50,
          3 => 100,
        ),
        'default' => 50,
      ),
    ),
    'events' => 
    array (
      'created' => 
      array (
        'icon' => 'heroicon-m-plus',
        'color' => 'success',
      ),
      'updated' => 
      array (
        'icon' => 'heroicon-m-pencil',
        'color' => 'warning',
      ),
      'deleted' => 
      array (
        'icon' => 'heroicon-m-trash',
        'color' => 'danger',
      ),
      'restored' => 
      array (
        'icon' => 'heroicon-m-arrow-uturn-left',
        'color' => 'gray',
      ),
    ),
    'datetime_format' => 'M d, Y H:i:s',
    'table' => 
    array (
      'columns' => 
      array (
        'log_name' => 
        array (
          'visible' => true,
          'searchable' => true,
          'sortable' => true,
        ),
        'event' => 
        array (
          'visible' => true,
          'searchable' => true,
          'sortable' => true,
        ),
        'subject_type' => 
        array (
          'visible' => true,
          'searchable' => true,
          'sortable' => true,
        ),
        'causer' => 
        array (
          'visible' => true,
          'searchable' => true,
          'sortable' => true,
        ),
        'description' => 
        array (
          'visible' => true,
          'searchable' => true,
          'limit' => 50,
        ),
        'created_at' => 
        array (
          'visible' => true,
          'searchable' => true,
          'sortable' => true,
        ),
        'ip_address' => 
        array (
          'visible' => true,
          'searchable' => true,
        ),
        'user_agent' => 
        array (
          'visible' => true,
          'searchable' => true,
        ),
      ),
      'filters' => 
      array (
        'log_name' => true,
        'event' => true,
        'created_at' => true,
        'causer' => true,
        'subject_type' => true,
      ),
      'actions' => 
      array (
        'timeline' => true,
        'view' => true,
        'revert' => true,
        'delete' => true,
        'export' => true,
      ),
      'bulk_actions' => 
      array (
        'delete' => true,
      ),
    ),
    'infolist' => 
    array (
      'tabs' => 
      array (
        'overview' => true,
        'changes' => true,
        'raw_data' => true,
      ),
      'entries' => 
      array (
        'log_name' => true,
        'event' => true,
        'created_at' => true,
        'causer' => true,
        'subject' => true,
        'description' => true,
        'properties_attributes' => true,
        'properties_old' => true,
        'properties_raw' => true,
        'ip_address' => true,
        'user_agent' => true,
      ),
    ),
    'timeline' => 
    array (
      'show_action' => true,
      'icon' => 'heroicon-m-clock',
    ),
    'permissions' => 
    array (
      'enabled' => false,
      'custom_authorization' => NULL,
      'view_any' => 'view_any_activity',
      'view' => 'view_activity',
      'create' => 'create_activity',
      'update' => 'update_activity',
      'delete' => 'delete_activity',
      'restore' => 'restore_activity',
      'force_delete' => 'force_delete_activity',
    ),
    'widgets' => 
    array (
      'enabled' => true,
      'dashboard' => true,
      'widgets' => 
      array (
        0 => 'AlizHarb\\ActivityLog\\Widgets\\LatestActivityWidget',
      ),
      'activity_chart' => 
      array (
        'enabled' => true,
        'heading' => 'Activity Over Time',
        'sort' => 1,
        'max_height' => '300px',
        'polling_interval' => NULL,
        'days' => 30,
        'type' => 'line',
        'label' => 'Activities',
        'fill' => true,
        'tension' => 0.3,
        'border_color' => '#10b981',
        'fill_color' => 'rgba(16, 185, 129, 0.1)',
        'date_format' => 'M d',
        'options' => 
        array (
          'plugins' => 
          array (
            'legend' => 
            array (
              'display' => false,
            ),
          ),
          'scales' => 
          array (
            'y' => 
            array (
              'beginAtZero' => true,
              'ticks' => 
              array (
                'precision' => 0,
              ),
            ),
          ),
        ),
      ),
      'latest_activity' => 
      array (
        'enabled' => true,
        'heading' => NULL,
        'sort' => 2,
        'polling_interval' => NULL,
        'limit' => 10,
        'paginated' => false,
        'columns' => 
        array (
          'event' => true,
          'causer' => true,
          'causer_limit' => 30,
          'subject_type' => true,
          'subject_type_limit' => 30,
          'description' => true,
          'description_limit' => 50,
          'created_at' => true,
        ),
      ),
    ),
  ),
  'filament-apex-charts' => 
  array (
    'chart_options' => 
    array (
      0 => 'Empty',
      1 => 'Area',
      2 => 'Bar',
      3 => 'Boxplot',
      4 => 'Bubble',
      5 => 'Candlestick',
      6 => 'Column',
      7 => 'Donut',
      8 => 'Heatmap',
      9 => 'Line',
      10 => 'Mixed-LineAndColumn',
      11 => 'Pie',
      12 => 'PolarArea',
      13 => 'Radar',
      14 => 'Radialbar',
      15 => 'RangeArea',
      16 => 'Scatter',
      17 => 'TimelineRangeBars',
      18 => 'Treemap',
      19 => 'Funnel',
    ),
  ),
  'filament-booking' => 
  array (
    'currency' => 'SEK',
    'locale' => 'en',
    'product_images_disk' => 'product-images',
    'features' => 
    array (
      'booking_brands' => true,
      'booking_categories' => true,
      'booking_customers' => true,
      'booking_orders' => true,
      'booking_products' => true,
    ),
  ),
  'filament-easy-footer' => 
  array (
    'app_name' => NULL,
    'github' => 
    array (
      'repository' => NULL,
      'token' => NULL,
      'cache_ttl' => 3600,
    ),
  ),
  'filament-edit-profile' => 
  array (
    'locale_column' => 'locale',
    'theme_color_column' => 'theme_color',
    'avatar_column' => 'avatar_url',
    'disk' => 'public',
    'visibility' => 'public',
    'locales' => 
    array (
      'pt_BR' => '🇧🇷 Português',
      'en' => '🇺🇸 Inglês',
      'es' => '🇪🇸 Espanhol',
    ),
    'show_custom_fields' => true,
    'custom_fields' => 
    array (
      'name_first' => 
      array (
        'type' => 'text',
        'label' => 'First Name',
        'placeholder' => 'Enter your first name',
      ),
      'name_last' => 
      array (
        'type' => 'text',
        'label' => 'Last Name',
        'placeholder' => 'Enter your last name',
      ),
      'phone' => 
      array (
        'type' => 'text',
        'label' => 'Phone',
        'placeholder' => 'Enter your phone number',
      ),
      'address' => 
      array (
        'type' => 'text',
        'label' => 'Address',
        'placeholder' => 'Enter your address',
      ),
    ),
  ),
  'filament-email' => 
  array (
    'resource' => 
    array (
      'class' => 'RickDBCN\\FilamentEmail\\Filament\\Resources\\EmailResource',
      'model' => 'RickDBCN\\FilamentEmail\\Models\\Email',
      'cluster' => NULL,
      'group' => NULL,
      'sort' => NULL,
      'icon' => NULL,
      'default_sort_column' => 'created_at',
      'default_sort_direction' => 'desc',
      'datetime_format' => 'Y-m-d H:i:s',
      'table_search_fields' => 
      array (
        0 => 'subject',
        1 => 'from',
        2 => 'to',
        3 => 'cc',
        4 => 'bcc',
      ),
      'has_title_case_model_label' => false,
    ),
    'keep_email_for_days' => 60,
    'label' => NULL,
    'prune_enabled' => true,
    'prune_crontab' => '0 0 * * *',
    'can_access' => 
    array (
      'role' => 
      array (
      ),
    ),
    'pagination_page_options' => 
    array (
      0 => 10,
      1 => 25,
      2 => 50,
      3 => 'all',
    ),
    'attachments_disk' => 'local',
    'store_attachments' => true,
  ),
  'filament-evolution' => 
  array (
    'api' => 
    array (
      'base_url' => 'http://localhost:8080',
      'api_key' => 'c7a0c7ec9f7ebad60dddb9e95b275a86d0d844dba3bd98a5eb5606aee4a8aa31',
      'timeout' => 30,
      'retry' => 
      array (
        'times' => 3,
        'sleep' => 100,
      ),
    ),
    'webhook' => 
    array (
      'url' => 'http://localhost:8000/api/webhooks/evolution',
      'secret' => 'my-secret-key',
      'path' => 'api/evolution/webhook',
      'events' => 
      array (
        0 => 'APPLICATION_STARTUP',
        1 => 'QRCODE_UPDATED',
        2 => 'CONNECTION_UPDATE',
        3 => 'NEW_TOKEN',
        4 => 'SEND_MESSAGE',
        5 => 'PRESENCE_UPDATE',
        6 => 'MESSAGES_UPSERT',
        7 => 'MESSAGES_UPDATE',
      ),
    ),
    'instance' => 
    array (
      'integration' => 'WHATSAPP-BAILEYS',
      'qrcode_expires_in' => 30,
      'reject_call' => false,
      'msg_call' => '',
      'groups_ignore' => false,
      'always_online' => false,
      'read_messages' => false,
      'read_status' => false,
      'sync_full_history' => true,
    ),
    'queue' => 
    array (
      'enabled' => true,
      'connection' => NULL,
      'name' => 'default',
    ),
    'storage' => 
    array (
      'webhooks' => true,
      'messages' => true,
    ),
    'cleanup' => 
    array (
      'webhooks_days' => 30,
      'messages_days' => 90,
    ),
    'media' => 
    array (
      'disk' => 'public',
      'directory' => 'whatsapp-media',
      'max_size' => 16384,
    ),
    'default_instance' => 'BK',
    'filament' => 
    array (
      'navigation_sort' => 100,
    ),
    'cache' => 
    array (
      'enabled' => true,
      'ttl' => 60,
      'prefix' => 'evolution_',
    ),
    'logging' => 
    array (
      'enabled' => true,
      'channel' => NULL,
      'webhook_events' => false,
      'webhook_errors' => true,
      'log_payloads' => false,
    ),
    'tenancy' => 
    array (
      'enabled' => false,
      'column' => 'team_id',
      'table' => 'teams',
      'model' => 'App\\Models\\Team',
      'column_type' => 'uuid',
    ),
  ),
  'filament-general-settings' => 
  array (
    'show_application_tab' => true,
    'show_logo_and_favicon' => false,
    'show_analytics_tab' => true,
    'show_seo_tab' => true,
    'show_email_tab' => true,
    'show_social_networks_tab' => true,
    'expiration_cache_config_time' => 60,
  ),
  'filament-icon-picker' => 
  array (
    'allowed_sets' => 
    array (
      0 => 'fontawesome-solid',
      1 => 'fontawesome-regular',
      2 => 'fontawesome-brands',
      3 => 'phosphor-icons',
      4 => 'google-material-design-icons',
      5 => 'tabler',
      6 => 'lucide',
      7 => 'bootstrap-icons',
      8 => 'remix',
    ),
    'icons_per_page' => 100,
    'columns' => 
    array (
      'default' => 6,
      'sm' => 8,
      'md' => 10,
      'lg' => 12,
    ),
    'modal_size' => '4xl',
    'cache_icons' => false,
    'cache_duration' => 86400,
  ),
  'filament-impersonate' => 
  array (
    'guard' => 'web',
    'redirect_to' => '/',
    'leave_middleware' => 'web',
    'route_prefix' => NULL,
    'allow_soft_deleted' => false,
    'banner' => 
    array (
      'render_hook' => 'panels::body.start',
      'style' => 'dark',
      'fixed' => true,
      'position' => 'top',
      'styles' => 
      array (
        'light' => 
        array (
          'text' => '#1f2937',
          'background' => '#f3f4f6',
          'border' => '#e8eaec',
        ),
        'dark' => 
        array (
          'text' => '#f3f4f6',
          'background' => '#1f2937',
          'border' => '#374151',
        ),
      ),
    ),
  ),
  'filament-log-viewer' => 
  array (
    'max_log_file_size' => 2048,
    'enable_delete' => true,
  ),
  'filament-maillog' => 
  array (
    'amazon-ses' => 
    array (
      'configuration-set' => NULL,
    ),
    'resources' => 
    array (
      'MaiLogResource' => 'Tapp\\FilamentMailLog\\Resources\\MailLogResource',
    ),
    'navigation' => 
    array (
      'maillog' => 
      array (
        'register' => true,
        'sort' => 1,
        'icon' => 'heroicon-o-rectangle-stack',
      ),
    ),
    'sort' => 
    array (
      'column' => 'created_at',
      'direction' => 'desc',
    ),
  ),
  'filament-pinpoint' => 
  array (
    'api_key' => 'AIzaSyDRTB78Vhlmr0hzgKPMgtAYJVTbZp14P4c',
    'default' => 
    array (
      'lat' => NULL,
      'lng' => NULL,
      'zoom' => '18',
      'height' => '500',
    ),
  ),
  'filament-sanctum' => 
  array (
    'navigation' => 
    array (
      'slug' => 'sanctum',
      'icon' => 'heroicon-o-finger-print',
      'sidebar_menu' => 
      array (
        'enabled' => false,
        'sort' => -1,
        'group' => NULL,
      ),
      'user_menu' => 
      array (
        'enabled' => true,
      ),
    ),
    'abilities' => 
    array (
      'columns' => 4,
      'list' => 
      array (
        'users:read' => 'Read User',
        'users:create' => 'Create User',
        'users:update' => 'Update User',
        'users:delete' => 'Delete User',
        'blog:read' => 'Read Blog',
        'blog:create' => 'Create Blog',
        'blog:update' => 'Update Blog',
        'blog:delete' => 'Delete Blog',
      ),
    ),
  ),
  'filament-shield' => 
  array (
    'shield_resource' => 
    array (
      'slug' => 'shield/roles',
      'show_model_path' => true,
      'cluster' => NULL,
      'tabs' => 
      array (
        'pages' => true,
        'widgets' => true,
        'resources' => true,
        'custom_permissions' => false,
      ),
    ),
    'tenant_model' => NULL,
    'auth_provider_model' => 'App\\Models\\User',
    'super_admin' => 
    array (
      'enabled' => true,
      'name' => 'super_admin',
      'define_via_gate' => false,
      'intercept_gate' => 'before',
    ),
    'panel_user' => 
    array (
      'enabled' => true,
      'name' => 'panel_user',
    ),
    'permissions' => 
    array (
      'separator' => ':',
      'case' => 'pascal',
      'generate' => true,
    ),
    'policies' => 
    array (
      'path' => '/home/baba/zzz/nuno/app/Policies',
      'merge' => true,
      'generate' => true,
      'methods' => 
      array (
        0 => 'viewAny',
        1 => 'view',
        2 => 'create',
        3 => 'update',
        4 => 'delete',
        5 => 'restore',
        6 => 'forceDelete',
        7 => 'forceDeleteAny',
        8 => 'restoreAny',
        9 => 'replicate',
        10 => 'reorder',
      ),
      'single_parameter_methods' => 
      array (
        0 => 'viewAny',
        1 => 'create',
        2 => 'deleteAny',
        3 => 'forceDeleteAny',
        4 => 'restoreAny',
        5 => 'reorder',
      ),
    ),
    'localization' => 
    array (
      'enabled' => false,
      'key' => 'filament-shield::filament-shield.resource_permission_prefixes_labels',
    ),
    'resources' => 
    array (
      'subject' => 'model',
      'manage' => 
      array (
        'BezhanSalleh\\FilamentShield\\Resources\\Roles\\RoleResource' => 
        array (
          0 => 'viewAny',
          1 => 'view',
          2 => 'create',
          3 => 'update',
          4 => 'delete',
        ),
      ),
      'exclude' => 
      array (
      ),
    ),
    'pages' => 
    array (
      'subject' => 'class',
      'prefix' => 'view',
      'exclude' => 
      array (
        0 => 'Filament\\Pages\\Dashboard',
      ),
    ),
    'widgets' => 
    array (
      'subject' => 'class',
      'prefix' => 'view',
      'exclude' => 
      array (
        0 => 'Filament\\Widgets\\AccountWidget',
        1 => 'Filament\\Widgets\\FilamentInfoWidget',
      ),
    ),
    'custom_permissions' => 
    array (
    ),
    'discovery' => 
    array (
      'discover_all_resources' => false,
      'discover_all_widgets' => false,
      'discover_all_pages' => false,
    ),
    'register_role_policy' => true,
  ),
  'filament-translation-manager' => 
  array (
    'locales' => 
    array (
    ),
    'gate' => NULL,
    'ignore_groups' => 
    array (
    ),
    'navigation_sort' => NULL,
    'navigation_group' => 'filament-translation-manager::messages.navigation_group',
    'widget' => 
    array (
      'enabled' => false,
      'gate' => NULL,
      'sort' => NULL,
    ),
    'navigation_icon' => 
    \Filament\Support\Icons\Heroicon::OutlinedLanguage,
  ),
  'filament-whatsapp-widget' => 
  array (
    'whatsapp_agent_resource' => 
    array (
      'cluster' => NULL,
      'model' => 'JeffersonGoncalves\\WhatsappWidget\\Models\\WhatsappAgent',
      'should_register_navigation' => true,
      'navigation_group' => true,
      'navigation_badge' => true,
      'navigation_sort' => -1,
      'navigation_icon' => 'heroicon-s-chat-bubble-left',
      'slug' => 'whatsapp/whatsapp-agent',
    ),
  ),
  'filament-wirechat' => 
  array (
    'uses_uuid_for_conversations' => true,
    'table_prefix' => 'wirechat_',
    'storage' => 
    array (
      'disk' => 'public',
      'visibility' => 'public',
      'directories' => 
      array (
        'attachments' => 'attachments',
      ),
    ),
    'broadcasting' => 
    array (
      'enabled' => true,
      'driver' => 'pusher',
      'messages_queue' => 'default',
      'notifications_queue' => 'default',
    ),
    'queue' => 
    array (
      'connection' => 'redis',
    ),
    'notifications' => 
    array (
      'enabled' => true,
      'database' => true,
    ),
    'theme' => 
    array (
      'brand_primary' => NULL,
      'light_primary' => NULL,
      'light_secondary' => NULL,
      'light_accent' => NULL,
      'light_border' => NULL,
      'dark_primary' => NULL,
      'dark_secondary' => NULL,
      'dark_accent' => NULL,
      'dark_border' => NULL,
    ),
    'show_new_group_modal_button' => false,
    'show_new_chat_modal_button' => false,
    'max_group_members' => 1000,
    'attachments' => 
    array (
      'storage_disk' => 'public',
      'disk_visibility' => 'public',
      'storage_folder' => 'attachments',
      'media_mimes' => 
      array (
        0 => 'jpg',
        1 => 'jpeg',
        2 => 'png',
        3 => 'gif',
        4 => 'webp',
        5 => 'svg',
      ),
      'file_mimes' => 
      array (
        0 => 'pdf',
        1 => 'doc',
        2 => 'docx',
        3 => 'xls',
        4 => 'xlsx',
        5 => 'txt',
        6 => 'csv',
        7 => 'zip',
        8 => 'rar',
        9 => '7z',
        10 => 'ppt',
        11 => 'pptx',
        12 => 'odt',
        13 => 'ods',
        14 => 'rtf',
      ),
      'max_uploads' => 10,
      'file_max_upload_size' => 12288,
      'media_max_upload_size' => 12288,
    ),
    'searchable_attributes' => 
    array (
      0 => 'name',
      1 => 'email',
    ),
    'user_model' => NULL,
    'dashboard_route' => 'default',
    'color' => '#3b82f6',
    'uuids' => false,
  ),
  'filemanager' => 
  array (
    'mode' => 'database',
    'storage_mode' => 
    array (
      'disk' => 'local',
      'root' => '',
      'show_hidden' => false,
      'url_expiration' => 60,
    ),
    'streaming' => 
    array (
      'url_strategy' => 'auto',
      'url_expiration' => 60,
      'route_prefix' => 'filemanager',
      'middleware' => 
      array (
        0 => 'web',
      ),
      'force_signed_disks' => 
      array (
      ),
      'public_disks' => 
      array (
        0 => 'public',
      ),
      'public_access_disks' => 
      array (
      ),
    ),
    'model' => 'MWGuerra\\FileManager\\Models\\FileSystemItem',
    'file_manager' => 
    array (
      'enabled' => true,
      'navigation' => 
      array (
        'icon' => 'heroicon-o-folder',
        'label' => 'File Manager',
        'sort' => 1,
        'group' => 'FileManager',
      ),
    ),
    'file_system' => 
    array (
      'enabled' => true,
      'navigation' => 
      array (
        'icon' => 'heroicon-o-server-stack',
        'label' => 'File System',
        'sort' => 2,
        'group' => 'FileManager',
      ),
    ),
    'schema_example' => 
    array (
      'enabled' => true,
    ),
    'upload' => 
    array (
      'disk' => 'local',
      'directory' => 'uploads',
      'max_file_size' => 102400,
      'allowed_mimes' => 
      array (
        0 => 'video/mp4',
        1 => 'video/webm',
        2 => 'video/ogg',
        3 => 'video/quicktime',
        4 => 'video/x-msvideo',
        5 => 'image/jpeg',
        6 => 'image/png',
        7 => 'image/gif',
        8 => 'image/webp',
        9 => 'application/pdf',
        10 => 'application/msword',
        11 => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        12 => 'application/vnd.ms-excel',
        13 => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        14 => 'application/vnd.ms-powerpoint',
        15 => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        16 => 'text/plain',
        17 => 'audio/mpeg',
        18 => 'audio/wav',
        19 => 'audio/ogg',
        20 => 'audio/webm',
        21 => 'audio/flac',
        22 => 'application/zip',
        23 => 'application/x-rar-compressed',
        24 => 'application/x-7z-compressed',
      ),
    ),
    'security' => 
    array (
      'blocked_extensions' => 
      array (
        0 => 'php',
        1 => 'php3',
        2 => 'php4',
        3 => 'php5',
        4 => 'php7',
        5 => 'php8',
        6 => 'phtml',
        7 => 'phar',
        8 => 'pl',
        9 => 'py',
        10 => 'pyc',
        11 => 'pyo',
        12 => 'rb',
        13 => 'sh',
        14 => 'bash',
        15 => 'zsh',
        16 => 'cgi',
        17 => 'asp',
        18 => 'aspx',
        19 => 'jsp',
        20 => 'jspx',
        21 => 'cfm',
        22 => 'cfc',
        23 => 'exe',
        24 => 'msi',
        25 => 'dll',
        26 => 'com',
        27 => 'bat',
        28 => 'cmd',
        29 => 'vbs',
        30 => 'vbe',
        31 => 'js',
        32 => 'jse',
        33 => 'ws',
        34 => 'wsf',
        35 => 'wsc',
        36 => 'wsh',
        37 => 'ps1',
        38 => 'psm1',
        39 => 'htaccess',
        40 => 'htpasswd',
        41 => 'ini',
        42 => 'log',
        43 => 'sql',
        44 => 'env',
        45 => 'pem',
        46 => 'key',
        47 => 'crt',
        48 => 'cer',
      ),
      'sanitize_extensions' => 
      array (
        0 => 'svg',
        1 => 'html',
        2 => 'htm',
        3 => 'xml',
      ),
      'validate_mime' => true,
      'rename_uploads' => false,
      'sanitize_filenames' => true,
      'max_filename_length' => 255,
      'blocked_filename_patterns' => 
      array (
        0 => '/\\.{2,}/',
        1 => '/^\\./',
        2 => '/[\\x00-\\x1f]/',
        3 => '/[<>:"|?*]/',
      ),
    ),
    'authorization' => 
    array (
      'enabled' => true,
      'permissions' => 
      array (
        'view_any' => NULL,
        'view' => NULL,
        'create' => NULL,
        'update' => NULL,
        'delete' => NULL,
        'delete_any' => NULL,
        'download' => NULL,
      ),
      'policy' => 'MWGuerra\\FileManager\\Policies\\FileSystemItemPolicy',
    ),
    'sidebar' => 
    array (
      'enabled' => true,
      'root_label' => 'Root',
      'heading' => 'Folders',
      'show_in_file_manager' => true,
    ),
    'file_types' => 
    array (
      'video' => true,
      'image' => true,
      'audio' => true,
      'pdf' => true,
      'text' => true,
      'document' => true,
      'archive' => true,
      'custom' => 
      array (
      ),
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'local',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => '/home/baba/zzz/nuno/storage/app/private',
        'serve' => true,
        'throw' => false,
        'report' => false,
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => '/home/baba/zzz/nuno/storage/app/public',
        'url' => 'http://localhost:8000/storage',
        'visibility' => 'public',
        'throw' => false,
        'report' => false,
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'bucket' => '',
        'url' => NULL,
        'endpoint' => NULL,
        'use_path_style_endpoint' => false,
        'throw' => false,
        'report' => false,
      ),
      'filament-excel' => 
      array (
        'driver' => 'local',
        'root' => '/home/baba/zzz/nuno/storage/app/filament-excel',
        'url' => 'http://localhost:8000/filament-excel',
      ),
      'private' => 
      array (
        'driver' => 'local',
        'root' => '/home/baba/zzz/nuno/storage/app/private',
        'visibility' => 'private',
        'throw' => false,
      ),
    ),
    'links' => 
    array (
      '/home/baba/zzz/nuno/public/storage' => '/home/baba/zzz/nuno/storage/app/public',
    ),
  ),
  'flowforge' => 
  array (
    'columns' => 
    array (
      'default_limit' => 10,
    ),
    'kanban' => 
    array (
      'initial_cards_count' => 20,
      'cards_increment' => 10,
      'max_cards_per_column' => 100,
    ),
    'ui' => 
    array (
      'show_item_counts' => true,
      'show_board_title' => true,
      'show_refresh_button' => true,
    ),
    'animations' => 
    array (
      'enable_drag_animations' => true,
    ),
  ),
  'fortify-options' => 
  array (
    'two-factor-authentication' => 
    array (
      'confirm' => true,
      'confirmPassword' => true,
    ),
  ),
  'fortify' => 
  array (
    'guard' => 'web',
    'middleware' => 
    array (
      0 => 'web',
    ),
    'auth_middleware' => 'auth',
    'passwords' => 'users',
    'username' => 'email',
    'email' => 'email',
    'views' => true,
    'home' => '/nds/app',
    'prefix' => '',
    'domain' => NULL,
    'lowercase_usernames' => true,
    'limiters' => 
    array (
      'login' => 'login',
      'two-factor' => 'two-factor',
    ),
    'paths' => 
    array (
      'login' => NULL,
      'logout' => NULL,
      'password' => 
      array (
        'request' => NULL,
        'reset' => NULL,
        'email' => NULL,
        'update' => NULL,
        'confirm' => NULL,
        'confirmation' => NULL,
      ),
      'register' => NULL,
      'verification' => 
      array (
        'notice' => NULL,
        'verify' => NULL,
        'send' => NULL,
      ),
      'user-profile-information' => 
      array (
        'update' => NULL,
      ),
      'user-password' => 
      array (
        'update' => NULL,
      ),
      'two-factor' => 
      array (
        'login' => NULL,
        'enable' => NULL,
        'confirm' => NULL,
        'disable' => NULL,
        'qr-code' => NULL,
        'secret-key' => NULL,
        'recovery-codes' => NULL,
      ),
    ),
    'redirects' => 
    array (
      'login' => NULL,
      'logout' => NULL,
      'password-confirmation' => NULL,
      'register' => NULL,
      'email-verification' => NULL,
      'password-reset' => NULL,
    ),
    'features' => 
    array (
      0 => 'two-factor-authentication',
    ),
  ),
  'google-calendar' => 
  array (
    'default_auth_profile' => 'service_account',
    'auth_profiles' => 
    array (
      'service_account' => 
      array (
        'credentials_json' => '/home/baba/zzz/nuno/storage/app/google-calendar/service-account-credentials.json',
      ),
      'oauth' => 
      array (
        'credentials_json' => '/home/baba/zzz/nuno/storage/app/google-calendar/oauth-credentials.json',
        'token_json' => '/home/baba/zzz/nuno/storage/app/google-calendar/oauth-token.json',
      ),
    ),
    'calendar_id' => NULL,
    'user_to_impersonate' => NULL,
  ),
  'horizon' => 
  array (
    'name' => 'Nordic Digital Solutions',
    'domain' => NULL,
    'path' => 'horizon',
    'use' => 'default',
    'prefix' => 'nordic_digital_solutions_horizon:',
    'middleware' => 
    array (
      0 => 'web',
    ),
    'waits' => 
    array (
      'redis:default' => 60,
    ),
    'trim' => 
    array (
      'recent' => 60,
      'pending' => 60,
      'completed' => 60,
      'recent_failed' => 10080,
      'failed' => 10080,
      'monitored' => 10080,
    ),
    'silenced' => 
    array (
    ),
    'silenced_tags' => 
    array (
    ),
    'metrics' => 
    array (
      'trim_snapshots' => 
      array (
        'job' => 24,
        'queue' => 24,
      ),
    ),
    'fast_termination' => false,
    'memory_limit' => 64,
    'defaults' => 
    array (
      'supervisor-1' => 
      array (
        'connection' => 'redis',
        'queue' => 
        array (
          0 => 'scrape',
          1 => 'default',
          2 => 'hitta-counts',
          3 => 'ratsit-counts',
          4 => 'hitta-postort',
          5 => 'hitta-personer',
          6 => 'ratsit-personer',
          7 => 'merinfo-queue',
          8 => 'merinfo-count',
        ),
        'balance' => 'auto',
        'autoScalingStrategy' => 'time',
        'maxProcesses' => 5,
        'maxTime' => 0,
        'maxJobs' => 0,
        'memory' => 128,
        'tries' => 1,
        'timeout' => 600,
        'nice' => 0,
      ),
    ),
    'environments' => 
    array (
      'production' => 
      array (
        'supervisor-1' => 
        array (
          'maxProcesses' => 10,
          'balanceMaxShift' => 1,
          'balanceCooldown' => 3,
        ),
      ),
      'local' => 
      array (
        'supervisor-1' => 
        array (
          'maxProcesses' => 3,
        ),
      ),
    ),
    'watch' => 
    array (
      0 => 'app',
      1 => 'bootstrap',
      2 => 'config/**/*.php',
      3 => 'database/**/*.php',
      4 => 'public/**/*.php',
      5 => 'resources/**/*.php',
      6 => 'routes',
      7 => 'composer.lock',
      8 => 'composer.json',
      9 => '.env',
    ),
  ),
  'ide-helper' => 
  array (
    'filename' => '_ide_helper.php',
    'models_filename' => '_ide_helper_models.php',
    'meta_filename' => '.phpstorm.meta.php',
    'include_fluent' => false,
    'include_factory_builders' => false,
    'write_model_magic_where' => true,
    'write_model_external_builder_methods' => true,
    'write_model_relation_count_properties' => true,
    'write_model_relation_exists_properties' => false,
    'write_eloquent_model_mixins' => false,
    'include_helpers' => false,
    'helper_files' => 
    array (
      0 => '/home/baba/zzz/nuno/vendor/laravel/framework/src/Illuminate/Support/helpers.php',
      1 => '/home/baba/zzz/nuno/vendor/laravel/framework/src/Illuminate/Foundation/helpers.php',
    ),
    'model_locations' => 
    array (
      0 => 'app',
    ),
    'ignored_models' => 
    array (
    ),
    'model_hooks' => 
    array (
    ),
    'extra' => 
    array (
      'Eloquent' => 
      array (
        0 => 'Illuminate\\Database\\Eloquent\\Builder',
        1 => 'Illuminate\\Database\\Query\\Builder',
      ),
      'Session' => 
      array (
        0 => 'Illuminate\\Session\\Store',
      ),
    ),
    'magic' => 
    array (
    ),
    'interfaces' => 
    array (
    ),
    'model_camel_case_properties' => false,
    'type_overrides' => 
    array (
      'integer' => 'int',
      'boolean' => 'bool',
    ),
    'include_class_docblocks' => false,
    'force_fqn' => false,
    'use_generics_annotations' => true,
    'macro_default_return_types' => 
    array (
      'Illuminate\\Http\\Client\\Factory' => 'Illuminate\\Http\\Client\\PendingRequest',
    ),
    'additional_relation_types' => 
    array (
    ),
    'additional_relation_return_types' => 
    array (
    ),
    'enforce_nullable_relationships' => true,
    'post_migrate' => 
    array (
    ),
  ),
  'inertia' => 
  array (
    'ssr' => 
    array (
      'enabled' => false,
      'url' => 'http://127.0.0.1:13714',
    ),
    'ensure_pages_exist' => false,
    'page_paths' => 
    array (
      0 => '/home/baba/zzz/nuno/resources/js/Pages',
    ),
    'page_extensions' => 
    array (
      0 => 'js',
      1 => 'jsx',
      2 => 'svelte',
      3 => 'ts',
      4 => 'tsx',
      5 => 'vue',
    ),
    'use_script_element_for_initial_page' => true,
    'testing' => 
    array (
      'ensure_pages_exist' => true,
      'page_paths' => 
      array (
        0 => '/home/baba/zzz/nuno/resources/js/pages',
      ),
      'page_extensions' => 
      array (
        0 => 'js',
        1 => 'jsx',
        2 => 'svelte',
        3 => 'ts',
        4 => 'tsx',
        5 => 'vue',
      ),
    ),
    'history' => 
    array (
      'encrypt' => false,
    ),
  ),
  'laradumps' => 
  array (
    'queries' => 
    array (
      'ignore_sql_patterns' => 
      array (
        0 => '',
      ),
      'ignore_routes_patterns' => 
      array (
        0 => 'horizon/*',
        1 => 'telescope/*',
      ),
    ),
  ),
  'laravel-chained-translator' => 
  array (
    'custom_lang_directory_name' => 'lang-custom',
    'add_gitignore_to_custom_lang_directory' => true,
    'group_keys_in_array' => false,
    'json_group' => 'json-file',
  ),
  'laravel-impersonate' => 
  array (
    'session_key' => 'impersonated_by',
    'session_guard' => 'impersonator_guard',
    'session_guard_using' => 'impersonator_guard_using',
    'default_impersonator_guard' => 'web',
    'take_redirect_to' => '/',
    'leave_redirect_to' => '/',
  ),
  'livewire' => 
  array (
    'class_namespace' => 'App\\Livewire',
    'view_path' => '/home/baba/zzz/nuno/resources/views/livewire',
    'layout' => 'components.layouts.app',
    'lazy_placeholder' => NULL,
    'temporary_file_upload' => 
    array (
      'disk' => NULL,
      'rules' => NULL,
      'directory' => NULL,
      'middleware' => NULL,
      'preview_mimes' => 
      array (
        0 => 'png',
        1 => 'gif',
        2 => 'bmp',
        3 => 'svg',
        4 => 'wav',
        5 => 'mp4',
        6 => 'mov',
        7 => 'avi',
        8 => 'wmv',
        9 => 'mp3',
        10 => 'm4a',
        11 => 'jpg',
        12 => 'jpeg',
        13 => 'mpga',
        14 => 'webp',
        15 => 'wma',
      ),
      'max_upload_time' => 5,
      'cleanup' => true,
    ),
    'render_on_redirect' => false,
    'legacy_model_binding' => false,
    'inject_assets' => true,
    'navigate' => 
    array (
      'show_progress_bar' => true,
      'progress_bar_color' => '#2299dd',
    ),
    'inject_morph_markers' => true,
    'smart_wire_keys' => false,
    'pagination_theme' => 'tailwind',
    'release_token' => 'a',
  ),
  'livewire-ui-spotlight' => 
  array (
    'shortcuts' => 
    array (
      0 => 'k',
      1 => 'slash',
    ),
    'commands' => 
    array (
    ),
    'include_css' => false,
    'include_js' => true,
    'show_results_without_input' => false,
  ),
  'logging' => 
  array (
    'default' => 'stack',
    'deprecations' => 
    array (
      'channel' => NULL,
      'trace' => false,
    ),
    'channels' => 
    array (
      'stack' => 
      array (
        'driver' => 'stack',
        'channels' => 
        array (
          0 => 'single',
        ),
        'ignore_exceptions' => false,
      ),
      'single' => 
      array (
        'driver' => 'single',
        'path' => '/home/baba/zzz/nuno/storage/logs/laravel.log',
        'level' => 'debug',
        'replace_placeholders' => true,
      ),
      'daily' => 
      array (
        'driver' => 'daily',
        'path' => '/home/baba/zzz/nuno/storage/logs/laravel.log',
        'level' => 'debug',
        'days' => 14,
        'replace_placeholders' => true,
      ),
      'slack' => 
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'debug',
        'replace_placeholders' => true,
      ),
      'papertrail' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' => 
        array (
          'host' => NULL,
          'port' => NULL,
          'connectionString' => 'tls://:',
        ),
        'processors' => 
        array (
          0 => 'Monolog\\Processor\\PsrLogMessageProcessor',
        ),
      ),
      'stderr' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'formatter' => NULL,
        'with' => 
        array (
          'stream' => 'php://stderr',
        ),
        'processors' => 
        array (
          0 => 'Monolog\\Processor\\PsrLogMessageProcessor',
        ),
      ),
      'syslog' => 
      array (
        'driver' => 'syslog',
        'level' => 'debug',
        'facility' => 8,
        'replace_placeholders' => true,
      ),
      'errorlog' => 
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
        'replace_placeholders' => true,
      ),
      'null' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\NullHandler',
      ),
      'emergency' => 
      array (
        'path' => '/home/baba/zzz/nuno/storage/logs/laravel.log',
      ),
      'browser' => 
      array (
        'driver' => 'single',
        'path' => '/home/baba/zzz/nuno/storage/logs/browser.log',
        'level' => 'debug',
        'days' => 14,
      ),
    ),
  ),
  'mail' => 
  array (
    'default' => 'smtp',
    'mailers' => 
    array (
      'smtp' => 
      array (
        'transport' => 'smtp',
        'scheme' => NULL,
        'url' => NULL,
        'host' => 'smtp.mailtrap.io',
        'port' => '2525',
        'username' => 'your_username',
        'password' => 'your_password',
        'timeout' => NULL,
        'local_domain' => 'localhost',
      ),
      'ses' => 
      array (
        'transport' => 'ses',
      ),
      'postmark' => 
      array (
        'transport' => 'postmark',
      ),
      'resend' => 
      array (
        'transport' => 'resend',
      ),
      'sendmail' => 
      array (
        'transport' => 'sendmail',
        'path' => '/usr/sbin/sendmail -bs -i',
      ),
      'log' => 
      array (
        'transport' => 'log',
        'channel' => NULL,
      ),
      'array' => 
      array (
        'transport' => 'array',
      ),
      'failover' => 
      array (
        'transport' => 'failover',
        'mailers' => 
        array (
          0 => 'smtp',
          1 => 'log',
        ),
      ),
      'roundrobin' => 
      array (
        'transport' => 'roundrobin',
        'mailers' => 
        array (
          0 => 'ses',
          1 => 'postmark',
        ),
      ),
    ),
    'from' => 
    array (
      'address' => 'noreply@example.com',
      'name' => 'Your App',
    ),
    'markdown' => 
    array (
      'theme' => 'default',
      'paths' => 
      array (
        0 => '/home/baba/zzz/nuno/resources/views/vendor/mail',
      ),
    ),
  ),
  'mcp' => 
  array (
    'redirect_domains' => 
    array (
      0 => '*',
    ),
  ),
  'media-library' => 
  array (
    'disk_name' => 'public',
    'max_file_size' => 10485760,
    'queue_connection_name' => 'redis',
    'queue_name' => '',
    'queue_conversions_by_default' => true,
    'queue_conversions_after_database_commit' => true,
    'media_model' => 'Spatie\\MediaLibrary\\MediaCollections\\Models\\Media',
    'media_observer' => 'Spatie\\MediaLibrary\\MediaCollections\\Models\\Observers\\MediaObserver',
    'use_default_collection_serialization' => false,
    'temporary_upload_model' => 'Spatie\\MediaLibraryPro\\Models\\TemporaryUpload',
    'enable_temporary_uploads_session_affinity' => true,
    'generate_thumbnails_for_temporary_uploads' => true,
    'file_namer' => 'Spatie\\MediaLibrary\\Support\\FileNamer\\DefaultFileNamer',
    'path_generator' => 'Spatie\\MediaLibrary\\Support\\PathGenerator\\DefaultPathGenerator',
    'file_remover_class' => 'Spatie\\MediaLibrary\\Support\\FileRemover\\DefaultFileRemover',
    'custom_path_generators' => 
    array (
    ),
    'url_generator' => 'Spatie\\MediaLibrary\\Support\\UrlGenerator\\DefaultUrlGenerator',
    'moves_media_on_update' => false,
    'version_urls' => false,
    'image_optimizers' => 
    array (
      'Spatie\\ImageOptimizer\\Optimizers\\Jpegoptim' => 
      array (
        0 => '-m85',
        1 => '--force',
        2 => '--strip-all',
        3 => '--all-progressive',
      ),
      'Spatie\\ImageOptimizer\\Optimizers\\Pngquant' => 
      array (
        0 => '--force',
      ),
      'Spatie\\ImageOptimizer\\Optimizers\\Optipng' => 
      array (
        0 => '-i0',
        1 => '-o2',
        2 => '-quiet',
      ),
      'Spatie\\ImageOptimizer\\Optimizers\\Svgo' => 
      array (
        0 => '--disable=cleanupIDs',
      ),
      'Spatie\\ImageOptimizer\\Optimizers\\Gifsicle' => 
      array (
        0 => '-b',
        1 => '-O3',
      ),
      'Spatie\\ImageOptimizer\\Optimizers\\Cwebp' => 
      array (
        0 => '-m 6',
        1 => '-pass 10',
        2 => '-mt',
        3 => '-q 90',
      ),
      'Spatie\\ImageOptimizer\\Optimizers\\Avifenc' => 
      array (
        0 => '-a cq-level=23',
        1 => '-j all',
        2 => '--min 0',
        3 => '--max 63',
        4 => '--minalpha 0',
        5 => '--maxalpha 63',
        6 => '-a end-usage=q',
        7 => '-a tune=ssim',
      ),
    ),
    'image_generators' => 
    array (
      0 => 'Spatie\\MediaLibrary\\Conversions\\ImageGenerators\\Image',
      1 => 'Spatie\\MediaLibrary\\Conversions\\ImageGenerators\\Webp',
      2 => 'Spatie\\MediaLibrary\\Conversions\\ImageGenerators\\Avif',
      3 => 'Spatie\\MediaLibrary\\Conversions\\ImageGenerators\\Pdf',
      4 => 'Spatie\\MediaLibrary\\Conversions\\ImageGenerators\\Svg',
      5 => 'Spatie\\MediaLibrary\\Conversions\\ImageGenerators\\Video',
    ),
    'temporary_directory_path' => NULL,
    'image_driver' => 'gd',
    'ffmpeg_path' => '/usr/bin/ffmpeg',
    'ffprobe_path' => '/usr/bin/ffprobe',
    'ffmpeg_timeout' => 900,
    'ffmpeg_threads' => 0,
    'jobs' => 
    array (
      'perform_conversions' => 'Spatie\\MediaLibrary\\Conversions\\Jobs\\PerformConversionsJob',
      'generate_responsive_images' => 'Spatie\\MediaLibrary\\ResponsiveImages\\Jobs\\GenerateResponsiveImagesJob',
    ),
    'media_downloader' => 'Spatie\\MediaLibrary\\Downloaders\\DefaultDownloader',
    'media_downloader_ssl' => true,
    'temporary_url_default_lifetime' => 5,
    'remote' => 
    array (
      'extra_headers' => 
      array (
        'CacheControl' => 'max-age=604800',
      ),
    ),
    'responsive_images' => 
    array (
      'width_calculator' => 'Spatie\\MediaLibrary\\ResponsiveImages\\WidthCalculator\\FileSizeOptimizedWidthCalculator',
      'use_tiny_placeholders' => true,
      'tiny_placeholder_generator' => 'Spatie\\MediaLibrary\\ResponsiveImages\\TinyPlaceholderGenerator\\Blurred',
    ),
    'enable_vapor_uploads' => false,
    'default_loading_attribute_value' => NULL,
    'prefix' => '',
    'force_lazy_loading' => true,
  ),
  'model-states' => 
  array (
    'default_transition' => 'Spatie\\ModelStates\\DefaultTransition',
  ),
  'money' => 
  array (
    'defaults' => 
    array (
      'currency' => 'USD',
      'convert' => false,
    ),
    'currencies' => 
    array (
      'AED' => 
      array (
        'name' => 'UAE Dirham',
        'code' => 784,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'د.إ',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'AFN' => 
      array (
        'name' => 'Afghani',
        'code' => 971,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '؋',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'ALL' => 
      array (
        'name' => 'Lek',
        'code' => 8,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'L',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'AMD' => 
      array (
        'name' => 'Armenian Dram',
        'code' => 51,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'դր.',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'ANG' => 
      array (
        'name' => 'Netherlands Antillean Guilder',
        'code' => 532,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'ƒ',
        'symbol_first' => true,
        'decimal_mark' => ',',
        'thousands_separator' => '.',
      ),
      'AOA' => 
      array (
        'name' => 'Kwanza',
        'code' => 973,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'Kz',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'ARS' => 
      array (
        'name' => 'Argentine Peso',
        'code' => 32,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => true,
        'decimal_mark' => ',',
        'thousands_separator' => '.',
      ),
      'AUD' => 
      array (
        'name' => 'Australian Dollar',
        'code' => 36,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ' ',
      ),
      'AWG' => 
      array (
        'name' => 'Aruban Florin',
        'code' => 533,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'ƒ',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'AZN' => 
      array (
        'name' => 'Azerbaijanian Manat',
        'code' => 944,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '₼',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'BAM' => 
      array (
        'name' => 'Convertible Mark',
        'code' => 977,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'КМ',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'BBD' => 
      array (
        'name' => 'Barbados Dollar',
        'code' => 52,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'BDT' => 
      array (
        'name' => 'Taka',
        'code' => 50,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '৳',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'BGN' => 
      array (
        'name' => 'Bulgarian Lev',
        'code' => 975,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'лв',
        'symbol_first' => false,
        'decimal_mark' => ',',
        'thousands_separator' => ' ',
      ),
      'BHD' => 
      array (
        'name' => 'Bahraini Dinar',
        'code' => 48,
        'precision' => 3,
        'subunit' => 1000,
        'symbol' => 'ب.د',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'BIF' => 
      array (
        'name' => 'Burundi Franc',
        'code' => 108,
        'precision' => 0,
        'subunit' => 1,
        'symbol' => 'Fr',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'BMD' => 
      array (
        'name' => 'Bermudian Dollar',
        'code' => 60,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'BND' => 
      array (
        'name' => 'Brunei Dollar',
        'code' => 96,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'BOB' => 
      array (
        'name' => 'Boliviano',
        'code' => 68,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'Bs.',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'BOV' => 
      array (
        'name' => 'Mvdol',
        'code' => 984,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'Bs.',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'BRL' => 
      array (
        'name' => 'Brazilian Real',
        'code' => 986,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'R$',
        'symbol_first' => true,
        'decimal_mark' => ',',
        'thousands_separator' => '.',
      ),
      'BSD' => 
      array (
        'name' => 'Bahamian Dollar',
        'code' => 44,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'BTN' => 
      array (
        'name' => 'Ngultrum',
        'code' => 64,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'Nu.',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'BWP' => 
      array (
        'name' => 'Pula',
        'code' => 72,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'P',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'BYN' => 
      array (
        'name' => 'Belarussian Ruble',
        'code' => 974,
        'precision' => 0,
        'subunit' => 1,
        'symbol' => 'Br',
        'symbol_first' => false,
        'decimal_mark' => ',',
        'thousands_separator' => ' ',
      ),
      'BZD' => 
      array (
        'name' => 'Belize Dollar',
        'code' => 84,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'CAD' => 
      array (
        'name' => 'Canadian Dollar',
        'code' => 124,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'CDF' => 
      array (
        'name' => 'Congolese Franc',
        'code' => 976,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'Fr',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'CHF' => 
      array (
        'name' => 'Swiss Franc',
        'code' => 756,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'CHF',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'CLF' => 
      array (
        'name' => 'Unidades de fomento',
        'code' => 990,
        'precision' => 0,
        'subunit' => 1,
        'symbol' => 'UF',
        'symbol_first' => true,
        'decimal_mark' => ',',
        'thousands_separator' => '.',
      ),
      'CLP' => 
      array (
        'name' => 'Chilean Peso',
        'code' => 152,
        'precision' => 0,
        'subunit' => 1,
        'symbol' => '$',
        'symbol_first' => true,
        'decimal_mark' => ',',
        'thousands_separator' => '.',
      ),
      'CNY' => 
      array (
        'name' => 'Yuan Renminbi',
        'code' => 156,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '¥',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'COP' => 
      array (
        'name' => 'Colombian Peso',
        'code' => 170,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => true,
        'decimal_mark' => ',',
        'thousands_separator' => '.',
      ),
      'CRC' => 
      array (
        'name' => 'Costa Rican Colon',
        'code' => 188,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '₡',
        'symbol_first' => true,
        'decimal_mark' => ',',
        'thousands_separator' => '.',
      ),
      'CUC' => 
      array (
        'name' => 'Peso Convertible',
        'code' => 931,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'CUP' => 
      array (
        'name' => 'Cuban Peso',
        'code' => 192,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'CVE' => 
      array (
        'name' => 'Cape Verde Escudo',
        'code' => 132,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'CZK' => 
      array (
        'name' => 'Czech Koruna',
        'code' => 203,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'Kč',
        'symbol_first' => false,
        'decimal_mark' => ',',
        'thousands_separator' => '.',
      ),
      'DJF' => 
      array (
        'name' => 'Djibouti Franc',
        'code' => 262,
        'precision' => 0,
        'subunit' => 1,
        'symbol' => 'Fdj',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'DKK' => 
      array (
        'name' => 'Danish Krone',
        'code' => 208,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'kr',
        'symbol_first' => false,
        'decimal_mark' => ',',
        'thousands_separator' => '.',
      ),
      'DOP' => 
      array (
        'name' => 'Dominican Peso',
        'code' => 214,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'DZD' => 
      array (
        'name' => 'Algerian Dinar',
        'code' => 12,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'د.ج',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'EGP' => 
      array (
        'name' => 'Egyptian Pound',
        'code' => 818,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'ج.م',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'ERN' => 
      array (
        'name' => 'Nakfa',
        'code' => 232,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'Nfk',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'ETB' => 
      array (
        'name' => 'Ethiopian Birr',
        'code' => 230,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'Br',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'EUR' => 
      array (
        'name' => 'Euro',
        'code' => 978,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '€',
        'symbol_first' => true,
        'decimal_mark' => ',',
        'thousands_separator' => '.',
      ),
      'FJD' => 
      array (
        'name' => 'Fiji Dollar',
        'code' => 242,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'FKP' => 
      array (
        'name' => 'Falkland Islands Pound',
        'code' => 238,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '£',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'GBP' => 
      array (
        'name' => 'Pound Sterling',
        'code' => 826,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '£',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'GEL' => 
      array (
        'name' => 'Lari',
        'code' => 981,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '₾',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'GHS' => 
      array (
        'name' => 'Ghana Cedi',
        'code' => 936,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '₵',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'GIP' => 
      array (
        'name' => 'Gibraltar Pound',
        'code' => 292,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '£',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'GMD' => 
      array (
        'name' => 'Dalasi',
        'code' => 270,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'D',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'GNF' => 
      array (
        'name' => 'Guinea Franc',
        'code' => 324,
        'precision' => 0,
        'subunit' => 1,
        'symbol' => 'Fr',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'GTQ' => 
      array (
        'name' => 'Quetzal',
        'code' => 320,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'Q',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'GYD' => 
      array (
        'name' => 'Guyana Dollar',
        'code' => 328,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'HKD' => 
      array (
        'name' => 'Hong Kong Dollar',
        'code' => 344,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'HNL' => 
      array (
        'name' => 'Lempira',
        'code' => 340,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'L',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'HRK' => 
      array (
        'name' => 'Croatian Kuna',
        'code' => 191,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'kn',
        'symbol_first' => false,
        'decimal_mark' => ',',
        'thousands_separator' => '.',
      ),
      'HTG' => 
      array (
        'name' => 'Gourde',
        'code' => 332,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'G',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'HUF' => 
      array (
        'name' => 'Forint',
        'code' => 348,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'Ft',
        'symbol_first' => false,
        'decimal_mark' => ',',
        'thousands_separator' => '.',
      ),
      'IDR' => 
      array (
        'name' => 'Rupiah',
        'code' => 360,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'Rp',
        'symbol_first' => true,
        'decimal_mark' => ',',
        'thousands_separator' => '.',
      ),
      'ILS' => 
      array (
        'name' => 'New Israeli Sheqel',
        'code' => 376,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '₪',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'INR' => 
      array (
        'name' => 'Indian Rupee',
        'code' => 356,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '₹',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'IQD' => 
      array (
        'name' => 'Iraqi Dinar',
        'code' => 368,
        'precision' => 3,
        'subunit' => 1000,
        'symbol' => 'ع.د',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'IRR' => 
      array (
        'name' => 'Iranian Rial',
        'code' => 364,
        'precision' => 0,
        'subunit' => 100,
        'symbol' => '﷼',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'ISK' => 
      array (
        'name' => 'Iceland Krona',
        'code' => 352,
        'precision' => 0,
        'subunit' => 1,
        'symbol' => 'kr',
        'symbol_first' => true,
        'decimal_mark' => ',',
        'thousands_separator' => '.',
      ),
      'JMD' => 
      array (
        'name' => 'Jamaican Dollar',
        'code' => 388,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'JOD' => 
      array (
        'name' => 'Jordanian Dinar',
        'code' => 400,
        'precision' => 3,
        'subunit' => 100,
        'symbol' => 'د.ا',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'JPY' => 
      array (
        'name' => 'Yen',
        'code' => 392,
        'precision' => 0,
        'subunit' => 1,
        'symbol' => '¥',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'KES' => 
      array (
        'name' => 'Kenyan Shilling',
        'code' => 404,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'KSh',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'KGS' => 
      array (
        'name' => 'Som',
        'code' => 417,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'som',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'KHR' => 
      array (
        'name' => 'Riel',
        'code' => 116,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '៛',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'KMF' => 
      array (
        'name' => 'Comoro Franc',
        'code' => 174,
        'precision' => 0,
        'subunit' => 1,
        'symbol' => 'Fr',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'KPW' => 
      array (
        'name' => 'North Korean Won',
        'code' => 408,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '₩',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'KRW' => 
      array (
        'name' => 'Won',
        'code' => 410,
        'precision' => 0,
        'subunit' => 1,
        'symbol' => '₩',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'KWD' => 
      array (
        'name' => 'Kuwaiti Dinar',
        'code' => 414,
        'precision' => 3,
        'subunit' => 1000,
        'symbol' => 'د.ك',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'KYD' => 
      array (
        'name' => 'Cayman Islands Dollar',
        'code' => 136,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'KZT' => 
      array (
        'name' => 'Tenge',
        'code' => 398,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '〒',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'LAK' => 
      array (
        'name' => 'Kip',
        'code' => 418,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '₭',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'LBP' => 
      array (
        'name' => 'Lebanese Pound',
        'code' => 422,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'ل.ل',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'LKR' => 
      array (
        'name' => 'Sri Lanka Rupee',
        'code' => 144,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '₨',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'LRD' => 
      array (
        'name' => 'Liberian Dollar',
        'code' => 430,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'LSL' => 
      array (
        'name' => 'Loti',
        'code' => 426,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'L',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'LTL' => 
      array (
        'name' => 'Lithuanian Litas',
        'code' => 440,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'Lt',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'LVL' => 
      array (
        'name' => 'Latvian Lats',
        'code' => 428,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'Ls',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'LYD' => 
      array (
        'name' => 'Libyan Dinar',
        'code' => 434,
        'precision' => 3,
        'subunit' => 1000,
        'symbol' => 'ل.د',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'MAD' => 
      array (
        'name' => 'Moroccan Dirham',
        'code' => 504,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'د.م.',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'MDL' => 
      array (
        'name' => 'Moldovan Leu',
        'code' => 498,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'L',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'MGA' => 
      array (
        'name' => 'Malagasy Ariary',
        'code' => 969,
        'precision' => 2,
        'subunit' => 5,
        'symbol' => 'Ar',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'MKD' => 
      array (
        'name' => 'Denar',
        'code' => 807,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'ден',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'MMK' => 
      array (
        'name' => 'Kyat',
        'code' => 104,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'K',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'MNT' => 
      array (
        'name' => 'Tugrik',
        'code' => 496,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '₮',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'MOP' => 
      array (
        'name' => 'Pataca',
        'code' => 446,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'P',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'MRO' => 
      array (
        'name' => 'Ouguiya',
        'code' => 478,
        'precision' => 2,
        'subunit' => 5,
        'symbol' => 'UM',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'MUR' => 
      array (
        'name' => 'Mauritius Rupee',
        'code' => 480,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '₨',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'MVR' => 
      array (
        'name' => 'Rufiyaa',
        'code' => 462,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'MVR',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'MWK' => 
      array (
        'name' => 'Kwacha',
        'code' => 454,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'MK',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'MXN' => 
      array (
        'name' => 'Mexican Peso',
        'code' => 484,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'MYR' => 
      array (
        'name' => 'Malaysian Ringgit',
        'code' => 458,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'RM',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'MZN' => 
      array (
        'name' => 'Mozambique Metical',
        'code' => 943,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'MTn',
        'symbol_first' => true,
        'decimal_mark' => ',',
        'thousands_separator' => '.',
      ),
      'NAD' => 
      array (
        'name' => 'Namibia Dollar',
        'code' => 516,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'NGN' => 
      array (
        'name' => 'Naira',
        'code' => 566,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '₦',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'NIO' => 
      array (
        'name' => 'Cordoba Oro',
        'code' => 558,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'C$',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'NOK' => 
      array (
        'name' => 'Norwegian Krone',
        'code' => 578,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'kr',
        'symbol_first' => false,
        'decimal_mark' => ',',
        'thousands_separator' => '.',
      ),
      'NPR' => 
      array (
        'name' => 'Nepalese Rupee',
        'code' => 524,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '₨',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'NZD' => 
      array (
        'name' => 'New Zealand Dollar',
        'code' => 554,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'OMR' => 
      array (
        'name' => 'Rial Omani',
        'code' => 512,
        'precision' => 3,
        'subunit' => 1000,
        'symbol' => 'ر.ع.',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'PAB' => 
      array (
        'name' => 'Balboa',
        'code' => 590,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'B/.',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'PEN' => 
      array (
        'name' => 'Sol',
        'code' => 604,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'S/',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'PGK' => 
      array (
        'name' => 'Kina',
        'code' => 598,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'K',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'PHP' => 
      array (
        'name' => 'Philippine Peso',
        'code' => 608,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '₱',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'PKR' => 
      array (
        'name' => 'Pakistan Rupee',
        'code' => 586,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '₨',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'PLN' => 
      array (
        'name' => 'Zloty',
        'code' => 985,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'zł',
        'symbol_first' => false,
        'decimal_mark' => ',',
        'thousands_separator' => ' ',
      ),
      'PYG' => 
      array (
        'name' => 'Guarani',
        'code' => 600,
        'precision' => 0,
        'subunit' => 1,
        'symbol' => '₲',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'QAR' => 
      array (
        'name' => 'Qatari Rial',
        'code' => 634,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'ر.ق',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'RON' => 
      array (
        'name' => 'New Romanian Leu',
        'code' => 946,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'Lei',
        'symbol_first' => true,
        'decimal_mark' => ',',
        'thousands_separator' => '.',
      ),
      'RSD' => 
      array (
        'name' => 'Serbian Dinar',
        'code' => 941,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'РСД',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'RUB' => 
      array (
        'name' => 'Russian Ruble',
        'code' => 643,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '₽',
        'symbol_first' => false,
        'decimal_mark' => ',',
        'thousands_separator' => '.',
      ),
      'RWF' => 
      array (
        'name' => 'Rwanda Franc',
        'code' => 646,
        'precision' => 0,
        'subunit' => 1,
        'symbol' => 'FRw',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'SAR' => 
      array (
        'name' => 'Saudi Riyal',
        'code' => 682,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'ر.س',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'SBD' => 
      array (
        'name' => 'Solomon Islands Dollar',
        'code' => 90,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'SCR' => 
      array (
        'name' => 'Seychelles Rupee',
        'code' => 690,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '₨',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'SDG' => 
      array (
        'name' => 'Sudanese Pound',
        'code' => 938,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '£',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'SEK' => 
      array (
        'name' => 'Swedish Krona',
        'code' => 752,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'kr',
        'symbol_first' => false,
        'decimal_mark' => ',',
        'thousands_separator' => ' ',
      ),
      'SGD' => 
      array (
        'name' => 'Singapore Dollar',
        'code' => 702,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'SHP' => 
      array (
        'name' => 'Saint Helena Pound',
        'code' => 654,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '£',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'SLL' => 
      array (
        'name' => 'Leone',
        'code' => 694,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'Le',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'SOS' => 
      array (
        'name' => 'Somali Shilling',
        'code' => 706,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'Sh',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'SRD' => 
      array (
        'name' => 'Surinam Dollar',
        'code' => 968,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'SSP' => 
      array (
        'name' => 'South Sudanese Pound',
        'code' => 728,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '£',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'STD' => 
      array (
        'name' => 'Dobra',
        'code' => 678,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'Db',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'SVC' => 
      array (
        'name' => 'El Salvador Colon',
        'code' => 222,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '₡',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'SYP' => 
      array (
        'name' => 'Syrian Pound',
        'code' => 760,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '£S',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'SZL' => 
      array (
        'name' => 'Lilangeni',
        'code' => 748,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'E',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'THB' => 
      array (
        'name' => 'Baht',
        'code' => 764,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '฿',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'TJS' => 
      array (
        'name' => 'Somoni',
        'code' => 972,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'ЅМ',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'TMT' => 
      array (
        'name' => 'Turkmenistan New Manat',
        'code' => 934,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'T',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'TND' => 
      array (
        'name' => 'Tunisian Dinar',
        'code' => 788,
        'precision' => 3,
        'subunit' => 1000,
        'symbol' => 'د.ت',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'TOP' => 
      array (
        'name' => 'Pa’anga',
        'code' => 776,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'T$',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'TRY' => 
      array (
        'name' => 'Turkish Lira',
        'code' => 949,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '₺',
        'symbol_first' => true,
        'decimal_mark' => ',',
        'thousands_separator' => '.',
      ),
      'TTD' => 
      array (
        'name' => 'Trinidad and Tobago Dollar',
        'code' => 780,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'TWD' => 
      array (
        'name' => 'New Taiwan Dollar',
        'code' => 901,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'TZS' => 
      array (
        'name' => 'Tanzanian Shilling',
        'code' => 834,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'Sh',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'UAH' => 
      array (
        'name' => 'Hryvnia',
        'code' => 980,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '₴',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'UGX' => 
      array (
        'name' => 'Uganda Shilling',
        'code' => 800,
        'precision' => 0,
        'subunit' => 1,
        'symbol' => 'USh',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'USD' => 
      array (
        'name' => 'US Dollar',
        'code' => 840,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'UYU' => 
      array (
        'name' => 'Peso Uruguayo',
        'code' => 858,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => true,
        'decimal_mark' => ',',
        'thousands_separator' => '.',
      ),
      'UZS' => 
      array (
        'name' => 'Uzbekistan Sum',
        'code' => 860,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'лв',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'VEF' => 
      array (
        'name' => 'Bolivar',
        'code' => 937,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'Bs F',
        'symbol_first' => true,
        'decimal_mark' => ',',
        'thousands_separator' => '.',
      ),
      'VES' => 
      array (
        'name' => 'Bolívar Soberano',
        'code' => 928,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'Bs S',
        'symbol_first' => true,
        'decimal_mark' => ',',
        'thousands_separator' => '.',
      ),
      'VED' => 
      array (
        'name' => 'Dijital Bolívar',
        'code' => 926,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'Bs D',
        'symbol_first' => true,
        'decimal_mark' => ',',
        'thousands_separator' => '.',
      ),
      'VND' => 
      array (
        'name' => 'Dong',
        'code' => 704,
        'precision' => 0,
        'subunit' => 1,
        'symbol' => '₫',
        'symbol_first' => true,
        'decimal_mark' => ',',
        'thousands_separator' => '.',
      ),
      'VUV' => 
      array (
        'name' => 'Vatu',
        'code' => 548,
        'precision' => 0,
        'subunit' => 1,
        'symbol' => 'Vt',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'WST' => 
      array (
        'name' => 'Tala',
        'code' => 882,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'T',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'XAF' => 
      array (
        'name' => 'CFA Franc BEAC',
        'code' => 950,
        'precision' => 0,
        'subunit' => 1,
        'symbol' => 'Fr',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'XAG' => 
      array (
        'name' => 'Silver',
        'code' => 961,
        'precision' => 0,
        'subunit' => 1,
        'symbol' => 'oz t',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'XAU' => 
      array (
        'name' => 'Gold',
        'code' => 959,
        'precision' => 0,
        'subunit' => 1,
        'symbol' => 'oz t',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'XCD' => 
      array (
        'name' => 'East Caribbean Dollar',
        'code' => 951,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'XDR' => 
      array (
        'name' => 'SDR (Special Drawing Right)',
        'code' => 960,
        'precision' => 0,
        'subunit' => 1,
        'symbol' => 'SDR',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'XOF' => 
      array (
        'name' => 'CFA Franc BCEAO',
        'code' => 952,
        'precision' => 0,
        'subunit' => 1,
        'symbol' => 'Fr',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'XPF' => 
      array (
        'name' => 'CFP Franc',
        'code' => 953,
        'precision' => 0,
        'subunit' => 1,
        'symbol' => 'Fr',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'YER' => 
      array (
        'name' => 'Yemeni Rial',
        'code' => 886,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '﷼',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'ZAR' => 
      array (
        'name' => 'Rand',
        'code' => 710,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'R',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'ZMW' => 
      array (
        'name' => 'Zambian Kwacha',
        'code' => 967,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => 'ZK',
        'symbol_first' => false,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
      'ZWL' => 
      array (
        'name' => 'Zimbabwe Dollar',
        'code' => 932,
        'precision' => 2,
        'subunit' => 100,
        'symbol' => '$',
        'symbol_first' => true,
        'decimal_mark' => '.',
        'thousands_separator' => ',',
      ),
    ),
  ),
  'notifier' => 
  array (
    'defaults' => 
    array (
      'queue' => 'default',
      'timeout' => 30,
      'retries' => 3,
    ),
    'settings' => 
    array (
      'preferences' => 
      array (
        'enabled' => true,
        'default_channels' => 
        array (
          0 => 'email',
        ),
        'allow_override' => true,
      ),
      'analytics' => 
      array (
        'enabled' => true,
        'track_opens' => true,
        'track_clicks' => true,
        'retention_days' => 90,
      ),
      'rate_limiting' => 
      array (
        'enabled' => true,
        'max_per_minute' => 60,
        'max_per_hour' => 1000,
        'max_per_day' => 10000,
      ),
      'template_cache' => false,
      'log_unreplaced_variables' => false,
    ),
  ),
  'octane' => 
  array (
    'server' => 'roadrunner',
    'https' => false,
    'listeners' => 
    array (
      'Laravel\\Octane\\Events\\WorkerStarting' => 
      array (
        0 => 'Laravel\\Octane\\Listeners\\EnsureUploadedFilesAreValid',
        1 => 'Laravel\\Octane\\Listeners\\EnsureUploadedFilesCanBeMoved',
      ),
      'Laravel\\Octane\\Events\\RequestReceived' => 
      array (
        0 => 'Laravel\\Octane\\Listeners\\CreateConfigurationSandbox',
        1 => 'Laravel\\Octane\\Listeners\\CreateUrlGeneratorSandbox',
        2 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToAuthorizationGate',
        3 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToBroadcastManager',
        4 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToDatabaseManager',
        5 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToDatabaseSessionHandler',
        6 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToFilesystemManager',
        7 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToHttpKernel',
        8 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToLogManager',
        9 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToMailManager',
        10 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToNotificationChannelManager',
        11 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToPipelineHub',
        12 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToCacheManager',
        13 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToSessionManager',
        14 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToQueueManager',
        15 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToRouter',
        16 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToValidationFactory',
        17 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToViewFactory',
        18 => 'Laravel\\Octane\\Listeners\\FlushDatabaseRecordModificationState',
        19 => 'Laravel\\Octane\\Listeners\\FlushDatabaseQueryLog',
        20 => 'Laravel\\Octane\\Listeners\\RefreshQueryDurationHandling',
        21 => 'Laravel\\Octane\\Listeners\\FlushArrayCache',
        22 => 'Laravel\\Octane\\Listeners\\FlushLogContext',
        23 => 'Laravel\\Octane\\Listeners\\FlushMonologState',
        24 => 'Laravel\\Octane\\Listeners\\FlushStrCache',
        25 => 'Laravel\\Octane\\Listeners\\FlushTranslatorCache',
        26 => 'Laravel\\Octane\\Listeners\\FlushVite',
        27 => 'Laravel\\Octane\\Listeners\\PrepareInertiaForNextOperation',
        28 => 'Laravel\\Octane\\Listeners\\PrepareLivewireForNextOperation',
        29 => 'Laravel\\Octane\\Listeners\\PrepareScoutForNextOperation',
        30 => 'Laravel\\Octane\\Listeners\\PrepareSocialiteForNextOperation',
        31 => 'Laravel\\Octane\\Listeners\\FlushLocaleState',
        32 => 'Laravel\\Octane\\Listeners\\FlushQueuedCookies',
        33 => 'Laravel\\Octane\\Listeners\\FlushSessionState',
        34 => 'Laravel\\Octane\\Listeners\\FlushAuthenticationState',
        35 => 'Laravel\\Octane\\Listeners\\EnforceRequestScheme',
        36 => 'Laravel\\Octane\\Listeners\\EnsureRequestServerPortMatchesScheme',
        37 => 'Laravel\\Octane\\Listeners\\GiveNewRequestInstanceToApplication',
        38 => 'Laravel\\Octane\\Listeners\\GiveNewRequestInstanceToPaginator',
      ),
      'Laravel\\Octane\\Events\\RequestHandled' => 
      array (
      ),
      'Laravel\\Octane\\Events\\RequestTerminated' => 
      array (
      ),
      'Laravel\\Octane\\Events\\TaskReceived' => 
      array (
        0 => 'Laravel\\Octane\\Listeners\\CreateConfigurationSandbox',
        1 => 'Laravel\\Octane\\Listeners\\CreateUrlGeneratorSandbox',
        2 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToAuthorizationGate',
        3 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToBroadcastManager',
        4 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToDatabaseManager',
        5 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToDatabaseSessionHandler',
        6 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToFilesystemManager',
        7 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToHttpKernel',
        8 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToLogManager',
        9 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToMailManager',
        10 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToNotificationChannelManager',
        11 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToPipelineHub',
        12 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToCacheManager',
        13 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToSessionManager',
        14 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToQueueManager',
        15 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToRouter',
        16 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToValidationFactory',
        17 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToViewFactory',
        18 => 'Laravel\\Octane\\Listeners\\FlushDatabaseRecordModificationState',
        19 => 'Laravel\\Octane\\Listeners\\FlushDatabaseQueryLog',
        20 => 'Laravel\\Octane\\Listeners\\RefreshQueryDurationHandling',
        21 => 'Laravel\\Octane\\Listeners\\FlushArrayCache',
        22 => 'Laravel\\Octane\\Listeners\\FlushLogContext',
        23 => 'Laravel\\Octane\\Listeners\\FlushMonologState',
        24 => 'Laravel\\Octane\\Listeners\\FlushStrCache',
        25 => 'Laravel\\Octane\\Listeners\\FlushTranslatorCache',
        26 => 'Laravel\\Octane\\Listeners\\FlushVite',
        27 => 'Laravel\\Octane\\Listeners\\PrepareInertiaForNextOperation',
        28 => 'Laravel\\Octane\\Listeners\\PrepareLivewireForNextOperation',
        29 => 'Laravel\\Octane\\Listeners\\PrepareScoutForNextOperation',
        30 => 'Laravel\\Octane\\Listeners\\PrepareSocialiteForNextOperation',
      ),
      'Laravel\\Octane\\Events\\TaskTerminated' => 
      array (
      ),
      'Laravel\\Octane\\Events\\TickReceived' => 
      array (
        0 => 'Laravel\\Octane\\Listeners\\CreateConfigurationSandbox',
        1 => 'Laravel\\Octane\\Listeners\\CreateUrlGeneratorSandbox',
        2 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToAuthorizationGate',
        3 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToBroadcastManager',
        4 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToDatabaseManager',
        5 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToDatabaseSessionHandler',
        6 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToFilesystemManager',
        7 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToHttpKernel',
        8 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToLogManager',
        9 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToMailManager',
        10 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToNotificationChannelManager',
        11 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToPipelineHub',
        12 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToCacheManager',
        13 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToSessionManager',
        14 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToQueueManager',
        15 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToRouter',
        16 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToValidationFactory',
        17 => 'Laravel\\Octane\\Listeners\\GiveNewApplicationInstanceToViewFactory',
        18 => 'Laravel\\Octane\\Listeners\\FlushDatabaseRecordModificationState',
        19 => 'Laravel\\Octane\\Listeners\\FlushDatabaseQueryLog',
        20 => 'Laravel\\Octane\\Listeners\\RefreshQueryDurationHandling',
        21 => 'Laravel\\Octane\\Listeners\\FlushArrayCache',
        22 => 'Laravel\\Octane\\Listeners\\FlushLogContext',
        23 => 'Laravel\\Octane\\Listeners\\FlushMonologState',
        24 => 'Laravel\\Octane\\Listeners\\FlushStrCache',
        25 => 'Laravel\\Octane\\Listeners\\FlushTranslatorCache',
        26 => 'Laravel\\Octane\\Listeners\\FlushVite',
        27 => 'Laravel\\Octane\\Listeners\\PrepareInertiaForNextOperation',
        28 => 'Laravel\\Octane\\Listeners\\PrepareLivewireForNextOperation',
        29 => 'Laravel\\Octane\\Listeners\\PrepareScoutForNextOperation',
        30 => 'Laravel\\Octane\\Listeners\\PrepareSocialiteForNextOperation',
      ),
      'Laravel\\Octane\\Events\\TickTerminated' => 
      array (
      ),
      'Laravel\\Octane\\Contracts\\OperationTerminated' => 
      array (
        0 => 'Laravel\\Octane\\Listeners\\FlushOnce',
        1 => 'Laravel\\Octane\\Listeners\\FlushTemporaryContainerInstances',
      ),
      'Laravel\\Octane\\Events\\WorkerErrorOccurred' => 
      array (
        0 => 'Laravel\\Octane\\Listeners\\ReportException',
        1 => 'Laravel\\Octane\\Listeners\\StopWorkerIfNecessary',
      ),
      'Laravel\\Octane\\Events\\WorkerStopping' => 
      array (
        0 => 'Laravel\\Octane\\Listeners\\CloseMonologHandlers',
      ),
    ),
    'warm' => 
    array (
      0 => 'auth',
      1 => 'cache',
      2 => 'cache.store',
      3 => 'config',
      4 => 'cookie',
      5 => 'db',
      6 => 'db.factory',
      7 => 'db.transactions',
      8 => 'encrypter',
      9 => 'files',
      10 => 'hash',
      11 => 'log',
      12 => 'router',
      13 => 'routes',
      14 => 'session',
      15 => 'session.store',
      16 => 'translator',
      17 => 'url',
      18 => 'view',
    ),
    'flush' => 
    array (
    ),
    'tables' => 
    array (
      'example:1000' => 
      array (
        'name' => 'string:1000',
        'votes' => 'int',
      ),
    ),
    'cache' => 
    array (
      'rows' => 1000,
      'bytes' => 10000,
    ),
    'watch' => 
    array (
      0 => 'app',
      1 => 'bootstrap',
      2 => 'config/**/*.php',
      3 => 'database/**/*.php',
      4 => 'public/**/*.php',
      5 => 'resources/**/*.php',
      6 => 'routes',
      7 => 'composer.lock',
      8 => '.env',
    ),
    'garbage' => 50,
    'max_execution_time' => 30,
  ),
  'passport' => 
  array (
    'guard' => 'web',
    'private_key' => NULL,
    'public_key' => NULL,
    'connection' => NULL,
  ),
  'passport-authorization-core' => 
  array (
    'owner_model' => '\\App\\Models\\User',
    'owner_label_attribute' => 'name',
    'use_database_scopes' => true,
    'cache' => 
    array (
      'enabled' => true,
      'ttl' => 3600,
    ),
    'oauth' => 
    array (
      'allowed_grant_types' => 
      array (
        0 => 'authorization_code',
        1 => 'client_credentials',
        2 => 'password',
        3 => 'personal_access',
        4 => 'implicit',
        5 => 'device',
      ),
    ),
    'models' => 
    array (
      'auth_code' => NULL,
      'client' => NULL,
      'token' => NULL,
      'scope' => NULL,
      'refresh_token' => NULL,
    ),
  ),
  'passport-ui' => 
  array (
    'navigation' => 
    array (
      'client_resource' => 
      array (
        'group' => 'filament-passport-ui::passport-ui.navigation.group',
        'icon' => 
        \Filament\Support\Icons\Heroicon::OutlinedKey,
      ),
    ),
  ),
  'permission' => 
  array (
    'models' => 
    array (
      'permission' => 'Spatie\\Permission\\Models\\Permission',
      'role' => 'Spatie\\Permission\\Models\\Role',
    ),
    'table_names' => 
    array (
      'roles' => 'roles',
      'permissions' => 'permissions',
      'model_has_permissions' => 'model_has_permissions',
      'model_has_roles' => 'model_has_roles',
      'role_has_permissions' => 'role_has_permissions',
    ),
    'column_names' => 
    array (
      'role_pivot_key' => NULL,
      'permission_pivot_key' => NULL,
      'model_morph_key' => 'model_id',
      'team_foreign_key' => 'team_id',
    ),
    'register_permission_check_method' => true,
    'register_octane_reset_listener' => false,
    'events_enabled' => false,
    'teams' => false,
    'team_resolver' => 'Spatie\\Permission\\DefaultTeamResolver',
    'use_passport_client_credentials' => false,
    'display_permission_in_exception' => false,
    'display_role_in_exception' => false,
    'enable_wildcard_permission' => false,
    'cache' => 
    array (
      'expiration_time' => 
      \DateInterval::__set_state(array(
         'from_string' => true,
         'date_string' => '24 hours',
      )),
      'key' => 'spatie.permission.cache',
      'store' => 'default',
    ),
  ),
  'pulse' => 
  array (
    'domain' => NULL,
    'path' => 'pulse',
    'enabled' => true,
    'storage' => 
    array (
      'driver' => 'database',
      'trim' => 
      array (
        'keep' => '7 days',
      ),
      'database' => 
      array (
        'connection' => NULL,
        'chunk' => 1000,
      ),
    ),
    'ingest' => 
    array (
      'driver' => 'storage',
      'buffer' => 5000,
      'trim' => 
      array (
        'lottery' => 
        array (
          0 => 1,
          1 => 1000,
        ),
        'keep' => '7 days',
      ),
      'redis' => 
      array (
        'connection' => NULL,
        'chunk' => 1000,
      ),
    ),
    'cache' => NULL,
    'middleware' => 
    array (
      0 => 'web',
      1 => 'Laravel\\Pulse\\Http\\Middleware\\Authorize',
    ),
    'recorders' => 
    array (
      'Laravel\\Pulse\\Recorders\\CacheInteractions' => 
      array (
        'enabled' => true,
        'sample_rate' => 1,
        'ignore' => 
        array (
          0 => '/(^laravel_vapor_job_attemp(t?)s:)/',
          1 => '/^.+@.+\\|(?:(?:\\d+\\.\\d+\\.\\d+\\.\\d+)|[0-9a-fA-F:]+)(?::timer)?$/',
          2 => '/^[a-zA-Z0-9]{40}$/',
          3 => '/^illuminate:/',
          4 => '/^laravel:pulse:/',
          5 => '/^laravel:reverb:/',
          6 => '/^nova/',
          7 => '/^telescope:/',
        ),
        'groups' => 
        array (
          '/^job-exceptions:.*/' => 'job-exceptions:*',
        ),
      ),
      'Laravel\\Pulse\\Recorders\\Exceptions' => 
      array (
        'enabled' => true,
        'sample_rate' => 1,
        'location' => true,
        'ignore' => 
        array (
        ),
      ),
      'Laravel\\Pulse\\Recorders\\Queues' => 
      array (
        'enabled' => true,
        'sample_rate' => 1,
        'ignore' => 
        array (
        ),
      ),
      'Laravel\\Pulse\\Recorders\\Servers' => 
      array (
        'server_name' => 'data',
        'directories' => 
        array (
          0 => '/',
        ),
      ),
      'Laravel\\Pulse\\Recorders\\SlowJobs' => 
      array (
        'enabled' => true,
        'sample_rate' => 1,
        'threshold' => 1000,
        'ignore' => 
        array (
        ),
      ),
      'Laravel\\Pulse\\Recorders\\SlowOutgoingRequests' => 
      array (
        'enabled' => true,
        'sample_rate' => 1,
        'threshold' => 1000,
        'ignore' => 
        array (
        ),
        'groups' => 
        array (
        ),
      ),
      'Laravel\\Pulse\\Recorders\\SlowQueries' => 
      array (
        'enabled' => true,
        'sample_rate' => 1,
        'threshold' => 1000,
        'location' => true,
        'max_query_length' => NULL,
        'ignore' => 
        array (
          0 => '/(["`])pulse_[\\w]+?\\1/',
          1 => '/(["`])telescope_[\\w]+?\\1/',
        ),
      ),
      'Laravel\\Pulse\\Recorders\\SlowRequests' => 
      array (
        'enabled' => true,
        'sample_rate' => 1,
        'threshold' => 1000,
        'ignore' => 
        array (
          0 => '#^/pulse$#',
          1 => '#^/telescope#',
        ),
      ),
      'Laravel\\Pulse\\Recorders\\UserJobs' => 
      array (
        'enabled' => true,
        'sample_rate' => 1,
        'ignore' => 
        array (
        ),
      ),
      'Laravel\\Pulse\\Recorders\\UserRequests' => 
      array (
        'enabled' => true,
        'sample_rate' => 1,
        'ignore' => 
        array (
          0 => '#^/pulse$#',
          1 => '#^/telescope#',
        ),
      ),
    ),
  ),
  'queue' => 
  array (
    'default' => 'redis',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'connection' => NULL,
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
        'after_commit' => false,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
        'after_commit' => false,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => '',
        'secret' => '',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'default',
        'suffix' => NULL,
        'region' => 'us-east-1',
        'after_commit' => false,
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
        'after_commit' => false,
      ),
      'deferred' => 
      array (
        'driver' => 'deferred',
      ),
      'failover' => 
      array (
        'driver' => 'failover',
        'connections' => 
        array (
          0 => 'database',
          1 => 'deferred',
        ),
      ),
    ),
    'batching' => 
    array (
      'database' => 'mysql',
      'table' => 'job_batches',
    ),
    'failed' => 
    array (
      'driver' => 'database-uuids',
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'queueable-bulk-actions' => 
  array (
    'tables' => 
    array (
      'bulk_actions' => 'bulk_actions',
      'bulk_action_records' => 'bulk_action_records',
    ),
    'models' => 
    array (
      'bulk_action' => 'Bytexr\\QueueableBulkActions\\Models\\BulkAction',
      'bulk_action_record' => 'Bytexr\\QueueableBulkActions\\Models\\BulkActionRecord',
    ),
    'render_hook' => 'tables::toolbar.before',
    'polling_interval' => '5s',
    'queue' => 
    array (
      'connection' => 'redis',
      'queue' => 'default',
    ),
    'resource' => 'Bytexr\\QueueableBulkActions\\Filament\\Resources\\BulkActionResource',
    'colors' => 
    array (
      'queued' => 'gray',
      'in-progress' => 'info',
      'finished' => 'success',
      'failed' => 'danger',
    ),
  ),
  'reverb' => 
  array (
    'default' => 'reverb',
    'servers' => 
    array (
      'reverb' => 
      array (
        'host' => '0.0.0.0',
        'port' => 8080,
        'path' => '',
        'hostname' => 'localhost',
        'options' => 
        array (
          'tls' => 
          array (
          ),
        ),
        'max_request_size' => 10000,
        'scaling' => 
        array (
          'enabled' => false,
          'channel' => 'reverb',
          'server' => 
          array (
            'url' => NULL,
            'host' => '127.0.0.1',
            'port' => '6379',
            'username' => NULL,
            'password' => NULL,
            'database' => '0',
            'timeout' => 60,
          ),
        ),
        'pulse_ingest_interval' => 15,
        'telescope_ingest_interval' => 15,
      ),
    ),
    'apps' => 
    array (
      'provider' => 'config',
      'apps' => 
      array (
        0 => 
        array (
          'key' => 'drig5c2s9nghayizb5k9',
          'secret' => 'dqrgkvrhiawaddqsdopa',
          'app_id' => '870081',
          'options' => 
          array (
            'host' => 'localhost',
            'port' => '8080',
            'scheme' => 'http',
            'useTLS' => false,
          ),
          'allowed_origins' => 
          array (
            0 => '*',
          ),
          'ping_interval' => 60,
          'activity_timeout' => 30,
          'max_connections' => NULL,
          'max_message_size' => 10000,
        ),
      ),
    ),
  ),
  'ringa-outcome-delays' => 
  array (
    'EjFramkopplad' => 60,
    'Upptagen' => 30,
    'Voicemail' => 120,
    'IngetSvar' => 45,
  ),
  'sanctum' => 
  array (
    'stateful' => 
    array (
      0 => 'localhost',
      1 => 'localhost:3000',
      2 => '127.0.0.1',
      3 => '127.0.0.1:8000',
      4 => '::1',
      5 => 'localhost:8000',
    ),
    'guard' => 
    array (
      0 => 'web',
    ),
    'expiration' => NULL,
    'token_prefix' => '',
    'middleware' => 
    array (
      'authenticate_session' => 'Laravel\\Sanctum\\Http\\Middleware\\AuthenticateSession',
      'encrypt_cookies' => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
      'validate_csrf_token' => 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken',
    ),
  ),
  'services' => 
  array (
    'postmark' => 
    array (
      'token' => NULL,
    ),
    'resend' => 
    array (
      'key' => NULL,
    ),
    'ses' => 
    array (
      'key' => '',
      'secret' => '',
      'region' => 'us-east-1',
    ),
    'slack' => 
    array (
      'notifications' => 
      array (
        'bot_user_oauth_token' => NULL,
        'channel' => NULL,
      ),
    ),
  ),
  'session' => 
  array (
    'driver' => 'database',
    'lifetime' => 120,
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => '/home/baba/zzz/nuno/storage/framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'nordic_digital_solutions_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => NULL,
    'http_only' => true,
    'same_site' => 'lax',
    'partitioned' => false,
  ),
  'settings' => 
  array (
    'settings' => 
    array (
    ),
    'setting_class_path' => '/home/baba/zzz/nuno/app/Settings',
    'migrations_paths' => 
    array (
      0 => '/home/baba/zzz/nuno/database/settings',
    ),
    'default_repository' => 'database',
    'repositories' => 
    array (
      'database' => 
      array (
        'type' => 'Spatie\\LaravelSettings\\SettingsRepositories\\DatabaseSettingsRepository',
        'model' => NULL,
        'table' => NULL,
        'connection' => NULL,
      ),
      'redis' => 
      array (
        'type' => 'Spatie\\LaravelSettings\\SettingsRepositories\\RedisSettingsRepository',
        'connection' => NULL,
        'prefix' => NULL,
      ),
    ),
    'encoder' => NULL,
    'decoder' => NULL,
    'cache' => 
    array (
      'enabled' => false,
      'store' => NULL,
      'prefix' => NULL,
      'ttl' => NULL,
    ),
    'global_casts' => 
    array (
      'DateTimeInterface' => 'Spatie\\LaravelSettings\\SettingsCasts\\DateTimeInterfaceCast',
      'DateTimeZone' => 'Spatie\\LaravelSettings\\SettingsCasts\\DateTimeZoneCast',
      'Spatie\\LaravelData\\Data' => 'Spatie\\LaravelSettings\\SettingsCasts\\DataCast',
    ),
    'auto_discover_settings' => 
    array (
      0 => '/home/baba/zzz/nuno/app/Settings',
    ),
    'discovered_settings_cache_path' => '/home/baba/zzz/nuno/bootstrap/cache',
  ),
  'squire' => 
  array (
    'cache-path' => '/home/baba/zzz/nuno/storage/framework/cache',
    'cache-prefix' => 'squire',
  ),
  'structure-discoverer' => 
  array (
    'ignored_files' => 
    array (
    ),
    'structure_scout_directories' => 
    array (
      0 => '/home/baba/zzz/nuno/app',
    ),
    'cache' => 
    array (
      'driver' => 'Spatie\\StructureDiscoverer\\Cache\\LaravelDiscoverCacheDriver',
      'store' => NULL,
    ),
  ),
  'tab-layout-plugin' => 
  array (
    'component' => 
    array (
      'namespace' => 'App\\Filament\\Tabs\\Components',
      'path' => '/home/baba/zzz/nuno/app/Filament/Tabs/Components',
    ),
  ),
  'table-layout-toggle' => 
  array (
    'default_layout' => 'list',
    'toggle_action' => 
    array (
      'enabled' => true,
      'position' => 'tables::toolbar.search.after',
      'list_icon' => 'heroicon-o-list-bullet',
      'grid_icon' => 'heroicon-o-squares-2x2',
    ),
    'persist' => 
    array (
      'persiter' => 'Hydrat\\TableLayoutToggle\\Persisters\\LocalStoragePersister',
      'cache' => 
      array (
        'store' => NULL,
        'time' => 10080,
      ),
      'share_between_pages' => false,
    ),
  ),
  'tags' => 
  array (
    'slugger' => NULL,
    'tag_model' => 'Spatie\\Tags\\Tag',
    'taggable' => 
    array (
      'table_name' => 'taggables',
      'morph_name' => 'taggable',
      'class_name' => 'Illuminate\\Database\\Eloquent\\Relations\\MorphPivot',
    ),
  ),
  'teamkit' => 
  array (
    'defaultCurrency' => 'sek',
    'defaultDateDisplayFormat' => 'M j, Y',
    'defaultIsoDateDisplayFormat' => 'L',
    'defaultDateTimeDisplayFormat' => 'M j, Y H:i:s',
    'defaultIsoDateTimeDisplayFormat' => 'LLL',
    'defaultNumberLocale' => NULL,
    'defaultTimeDisplayFormat' => 'H:i:s',
    'defaultIsoTimeDisplayFormat' => 'LT',
    'theme_mode' => 
    \Filament\Enums\ThemeMode::Light,
    'guest_panel_enabled' => true,
    'admin_panel_enabled' => true,
    'app_panel_enabled' => true,
    'favicon' => 
    array (
      'enabled' => true,
      'manifest' => 
      array (
        'name' => 'Nordic Digital Solutions',
        'icons' => 
        array (
          36 => '0.75',
          48 => '1.0',
          72 => '1.5',
          96 => '2.0',
          144 => '3.0',
          192 => '4.0',
        ),
      ),
      'logo' => 'resources/images/logo-teamkit.png',
      'favicon' => 'resources/favicon/favicon.ico',
    ),
  ),
  'telavox' => 
  array (
    'base_url' => 'https://api.telavox.se',
    'token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiI2NDA5NDk4IiwiYXVkIjoiKiIsImlzcyI6InR2eCIsImlhdCI6MTc2ODIxOTc5MCwianRpIjoiMTkzMzMxMzgifQ.umiaKCC_XzBqBkqv_sAcpDmt-i6rOpZHFLIn-C_cMaOXAm8T2stR6-818DZ3TyAzg-FZUKNkzCm_Q8c0Yk9jwg',
  ),
  'tinker' => 
  array (
    'commands' => 
    array (
    ),
    'alias' => 
    array (
    ),
    'dont_alias' => 
    array (
      0 => 'App\\Nova',
    ),
  ),
  'ui-switcher' => 
  array (
    'driver' => 'session',
    'database_column' => 'ui_preferences',
    'defaults' => 
    array (
      'font' => 'Inter',
      'color' => '#f97316',
      'layout' => 'sidebar',
      'font_size' => 18,
      'density' => 'default',
    ),
    'icon' => 'heroicon-o-swatch',
    'fonts' => 
    array (
      0 => 'Public Sans',
      1 => 'DM Sans',
      2 => 'Nunito Sans',
      3 => 'Roboto',
    ),
    'custom_colors' => 
    array (
      0 => '#ffffff',
      1 => '#6b7280',
      2 => '#000000',
      3 => '#2563eb',
      4 => '#16a34a',
      5 => '#dc2626',
      6 => '#eab308',
      7 => '#f97316',
    ),
    'layouts' => 
    array (
      0 => 'sidebar',
      1 => 'sidebar-collapsed',
      2 => 'sidebar-no-topbar',
      3 => 'topbar',
    ),
    'font_size_range' => 
    array (
      'min' => 12,
      'max' => 20,
    ),
  ),
  'umami' => 
  array (
    'url' => 'https://cloud.umami.is',
    'username' => 'nordicdigitalth@gmail.com',
    'password' => 'Qkx7MyNGSkBZwy8',
    'website_id' => 'd808ea76-a668-41c1-be52-d3cd132e91e9',
    'cache_key' => 'umami.stats',
    'cache_ttl' => 
    \Illuminate\Support\Carbon::__set_state(array(
       'endOfTime' => false,
       'startOfTime' => false,
       'constructedObjectId' => '000000000000349f0000000000000000',
       'clock' => NULL,
       'localMonthsOverflow' => NULL,
       'localYearsOverflow' => NULL,
       'localStrictModeEnabled' => NULL,
       'localHumanDiffOptions' => NULL,
       'localToStringFormat' => NULL,
       'localSerializer' => NULL,
       'localMacros' => NULL,
       'localGenericMacros' => NULL,
       'localFormatFunction' => NULL,
       'localTranslator' => NULL,
       'dumpProperties' => 
      array (
        0 => 'date',
        1 => 'timezone_type',
        2 => 'timezone',
      ),
       'dumpLocale' => NULL,
       'dumpDateProperties' => NULL,
       'date' => '2026-02-04 07:13:55.458879',
       'timezone_type' => 3,
       'timezone' => 'Europe/Stockholm',
    )),
  ),
  'user-field' => 
  array (
    'user_model' => 
    array (
      'class' => 'App\\Models\\User',
      'fields' => 
      array (
        'id' => 'id',
        'avatar_url' => 'avatar_url',
        'heading' => 'name',
        'description' => 'email',
      ),
    ),
    'active_state' => 
    array (
      'show' => false,
      'field' => 'is_active',
    ),
  ),
  'weather-widget' => 
  array (
    'api_key' => 'db3e9b8b2507f9f0893579962f326d28',
    'city' => 'Stockholm',
    'units' => 'metric',
    'refresh_minutes' => 100,
    'icon_set' => 'fill',
    'icon_variant' => 'animated',
    'locale' => NULL,
  ),
  'whatsapp-widget' => 
  array (
    'audio' => true,
    'play_audio_daily' => true,
    'disk' => 'local',
    'url' => 'http://localhost:8000',
    'name' => 'Nordic Digital Solutions',
    'key' => NULL,
    'position' => 'right',
  ),
  'zap' => 
  array (
    'calendar' => 
    array (
      'week_start' => 1,
    ),
    'default_rules' => 
    array (
      'no_overlap' => 
      array (
        'enabled' => true,
        'applies_to' => 
        array (
          0 => 
          \Zap\Enums\ScheduleTypes::APPOINTMENT,
          1 => 
          \Zap\Enums\ScheduleTypes::BLOCKED,
        ),
      ),
      'working_hours' => 
      array (
        'enabled' => false,
        'start' => '07:00',
        'end' => '19:00',
      ),
      'max_duration' => 
      array (
        'enabled' => false,
        'minutes' => 480,
      ),
      'no_weekends' => 
      array (
        'enabled' => false,
        'saturday' => true,
        'sunday' => true,
      ),
    ),
    'conflict_detection' => 
    array (
      'enabled' => true,
      'buffer_minutes' => 0,
    ),
    'time_slots' => 
    array (
      'buffer_minutes' => 0,
    ),
    'validation' => 
    array (
      'require_future_dates' => true,
      'max_date_range' => 365,
      'min_period_duration' => 15,
      'max_periods_per_schedule' => 50,
      'allow_overlapping_periods' => false,
    ),
    'models' => 
    array (
      'schedule' => 'Zap\\Models\\Schedule',
      'schedule_period' => 'Zap\\Models\\SchedulePeriod',
    ),
  ),
  'filament-context-menu' => 
  array (
    'enabled' => true,
  ),
  'db-config' => 
  array (
    'table_name' => 'db_config',
    'cache' => 
    array (
      'prefix' => 'db-config',
      'ttl' => NULL,
    ),
  ),
  'passport-modern-scopes' => 
  array (
    'auto_boot' => 
    array (
      'enabled' => true,
      'groups' => 
      array (
        'api' => 
        array (
          'order' => 'custom',
          'custom_position' => 
          array (
            'after' => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          ),
        ),
      ),
    ),
  ),
);
