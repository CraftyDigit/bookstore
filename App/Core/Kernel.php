<?php

namespace App\Core;

include_once 'Autoloader.php';

class Kernel
{
    /**
     *This method will start the app
     *
     * @return void
     */
    static function start(): void
    {
        Autoloader::register();
        ErrorReporter::setHandlers();
        Router::followRoute();
    }
}