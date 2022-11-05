<?php

namespace App\Core;

include_once 'vendor/autoload.php';

class Kernel
{
    /**
     *This method will start the app
     *
     * @return void
     */
    static function start(): void
    {
        ErrorReporter::setHandlers();
        Router::followRoute();
    }
}