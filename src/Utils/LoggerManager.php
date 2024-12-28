<?php
namespace App\Utils;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LoggerManager {
    private static $logger;

    public static function getLogger(): Logger {
        if (!self::$logger) {
            self::$logger = new Logger('app_workshop');

            $logFile = __DIR__ . '/../../logs/app_workshop.log';

            if (!file_exists(dirname($logFile))) {
                mkdir(dirname($logFile), 0777, true);
            }

            $handler = new StreamHandler($logFile, Logger::DEBUG); // Nivel mínimo: DEBUG
            self::$logger->pushHandler($handler);
        }

        return self::$logger;
    }
}