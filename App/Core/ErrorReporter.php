<?php

namespace App\Core;

use App\Controllers\Front\Error500Controller;
use ErrorException;

class ErrorReporter
{
    /**
     * This method enables correct error handling and reporting
     *
     * @return void
     */
    public static function setHandlers(): void
    {
        error_reporting(E_ALL);

        $config = Config::getInstance();
        $mode = $config->mode;

        if ($mode === 'prod') {
            ini_set('display_errors', false);
            ini_set('log_errors', true);
        } else {
            ini_set('display_errors', true);
            ini_set('log_errors', false);
        }

        set_exception_handler('App\Core\ErrorReporter::exceptionHandler');
        set_error_handler('App\Core\ErrorReporter::errorHandler');
        register_shutdown_function('App\Core\ErrorReporter::criticalErrorHandler');
    }

    /**
     * @param $e
     * @return void
     */
    public static function exceptionHandler($e): void
    {
        error_log($e);
        http_response_code(500);

        if (filter_var(ini_get('display_errors'), FILTER_VALIDATE_BOOLEAN)) {
            echo $e;
        } else {
            $controller = new Error500Controller();
            $controller->render();
        }

        exit;
    }

    /**
     * @param $level
     * @param $message
     * @param string $file
     * @param int $line
     * @return void
     */
    public static function errorHandler($level, $message, string $file = '', int $line = 0): void
    {
        $e = new ErrorException($message, 0, $level, $file, $line);
        self::exceptionHandler($e);
    }

    /**
     * @return void
     */
    public static function criticalErrorHandler(): void
    {
        $error = error_get_last();
        if ($error !== null) {
            $e = new ErrorException(
                $error['message'], 0, $error['type'], $error['file'], $error['line']
            );
            self::exceptionHandler($e);
        }
    }
}