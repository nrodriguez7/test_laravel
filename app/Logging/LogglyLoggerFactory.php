<?php

namespace App\Logging;

use Monolog\Logger;
use Monolog\Handler\LogglyHandler;

class LogglyLoggerFactory
{
    public const LEVEL_INFO = 200;
    public const LEVEL_NOTICE = 250;
    public const LEVEL_WARNING = 300;
    public const LEVEL_ERROR = 400;
    public const LEVEL_CRITICAL = 500;
    public const LEVEL_ALERT = 550;
    public const LEVEL_EMERGENCY = 600;

    public const MESSAGE_RUNTIME_ERROR = 'RUNTIME ERROR';
    public const MESSAGE_DB_ERROR = 'DB ERROR';
    public const MESSAGE_PAGE_NOT_FOUND = 'PAGE NOT FOUND';
    public const MESSAGE_CRON_RUNTIME_ERROR= 'CRON RUNTIME ERROR';
    public const MESSAGE_CRON_HAS_BAD_ARGUMENTS = 'CRON HAS BAD ARGUMENTS';
    public const MESSAGE_CRON_NO_RUNING_OR_EXIT = 'CRON NOT RUNNING OR EXIT';
    public const MESSAGE_CRON_SCRIPT_EXIT = 'CRON SCRIPT EXIT';
    public const MESSAGE_API_ERROR = 'API';
    public const MESSAGE_IMAGE_UPLOAD = 'IMAGE UPLOAD ERROR';
    public const MESSAGE_DEBUG = 'DEBUG';
    public const MESSAGE_DOCUMENT_UPLOAD = 'DOCUMENT UPLOAD';
    public const MESSAGE_STRIPE_ERROR = 'STRIPE ERROR';
    public const MESSAGE_PQ_PUBLISH_ERROR = 'PAYQUICKER PUBLISH ERROR';
    public const MESSAGE_PQ_PAYOUT_ERROR = 'PAYQUICKER PAYOUT ERROR';
    public const MESSAGE_PQ_TOKEN_ERROR = 'PAYQUICKER TOKEN ERROR';

    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {

        $key = $config["key"];

        // Log group name, will be created if none
        $groupName = config('app.name') . '-' . config('app.env');

        $handler = new LogglyHandler($key.'/tag/monolog', Logger::INFO);

        $logger  = new Logger('12345');
        $logger->pushHandler($handler);

  //      $logger->log(200, "AAA", array() );



        return $logger;
    }
}
