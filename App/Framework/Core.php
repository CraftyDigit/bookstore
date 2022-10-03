<?php

namespace App\Framework;

class Core
{

    /**
     * @return void
     */
    static function start()
    {
        Router::followRoute();
    }

}