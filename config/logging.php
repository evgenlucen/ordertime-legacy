<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [


    'dir_new_register_event' => __DIR__ . DIRECTORY_SEPARATOR . '../storage/logs/new_register.log',
    'dir_form_submit' => __DIR__ . DIRECTORY_SEPARATOR . '../storage/logs/form_submit.log',
    'dir_getcourse_deal_events' => __DIR__ . DIRECTORY_SEPARATOR . '../storage/logs/deal_events.log',
    'dir_getcourse_user_events' => __DIR__ . DIRECTORY_SEPARATOR . '../storage/logs/user_events.log',
    'dir_error' => __DIR__ . DIRECTORY_SEPARATOR . '../storage/logs/error.log',
    'dir_amo_analytics' => __DIR__ . DIRECTORY_SEPARATOR . '../storage/logs/amo_analytics.log',
    'dir_sb_analytics' => __DIR__ . DIRECTORY_SEPARATOR . '../storage/logs/sb_analytics.log',
    'dir_event' => __DIR__ . DIRECTORY_SEPARATOR . '../storage/logs/event.log',
    'dir_event_lesson' => __DIR__ . DIRECTORY_SEPARATOR . '../storage/logs/event_lesson.log',
    'dir_amo_helper_add_tags' => __DIR__ . DIRECTORY_SEPARATOR . '../storage/logs/amo_helper_add_tags.log',
    'dir_amo_helper_change_lead_status' => __DIR__ . DIRECTORY_SEPARATOR . '../storage/logs/amo_helper_change_lead_status.log',
    'dir_bizon_reports' => __DIR__ . DIRECTORY_SEPARATOR . '../storage/logs/bizon_reports.log',

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Deprecations Log Channel
    |--------------------------------------------------------------------------
    |
    | This option controls the log channel that should be used to log warnings
    | regarding deprecated PHP and library features. This allows you to get
    | your application ready for upcoming major versions of dependencies.
    |
    */

    'deprecations' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 14,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => env('LOG_LEVEL', 'critical'),
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => SyslogUdpHandler::class,
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],
    ],

];
