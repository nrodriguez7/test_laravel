<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [

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

    'default' =>  array_key_exists('LOG_CHANNEL',$_SERVER) ? $_SERVER['LOG_CHANNEL'] :  env('LOG_CHANNEL', 'stack'),

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
        'cloudwatch' => [
            'driver' => 'custom',
            'via' => \App\Logging\CloudWatchLoggerFactory::class,
            'sdk' => [
                'region' => array_key_exists('CLOUDWATCH_LOG_REGION',$_SERVER) ? $_SERVER['CLOUDWATCH_LOG_REGION'] : env('CLOUDWATCH_LOG_REGION', 'us-west-2'),
                'version' => 'latest',
                'credentials' => [
                    'key' => array_key_exists('AWS_ACCESS_KEY_ID',$_SERVER) ? $_SERVER['AWS_ACCESS_KEY_ID'] : env('AWS_ACCESS_KEY_ID'),
                    'secret' => array_key_exists('AWS_SECRET_ACCESS_KEY',$_SERVER) ? $_SERVER['AWS_SECRET_ACCESS_KEY'] : env('AWS_SECRET_ACCESS_KEY')
                ]
            ],
            'retention' => array_key_exists('CLOUDWATCH_LOG_RETENTION_DAYS',$_SERVER) ? $_SERVER['CLOUDWATCH_LOG_RETENTION_DAYS'] : env('CLOUDWATCH_LOG_RETENTION_DAYS',7),
            'level' => array_key_exists('CLOUDWATCH_LOG_LEVEL',$_SERVER) ? $_SERVER['CLOUDWATCH_LOG_LEVEL'] : env('CLOUDWATCH_LOG_LEVEL','info')
        ],
        'logglycustom' => [
            'driver' => 'custom',
            'via' => \App\Logging\LogglyLoggerFactory::class,
            'key' => array_key_exists('LOGGLY_KEY',$_SERVER) ? $_SERVER['LOGGLY_KEY'] : env('LOGGLY_KEY')
        ],
        'loggly' => [
            'driver' => 'monolog',
            'handler' => Monolog\Handler\LogglyHandler::class,
            'formatter' => Monolog\Formatter\JsonFormatter::class,
            'with' => [
                'token' =>  array_key_exists('LOGGLY_KEY',$_SERVER) ? $_SERVER['LOGGLY_KEY'] : env('LOGGLY_KEY'),
                'tag' => str_replace(' ', '_', env('APP_NAME') . '_' . env('APP_ENV')),
            ]
        ],
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
            'days' => 14,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => 'critical',
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => 'debug',
            'handler' => SyslogUdpHandler::class,
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => 'debug',
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => 'debug',
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
