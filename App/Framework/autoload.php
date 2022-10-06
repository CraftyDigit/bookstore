<?php

spl_autoload_register(function($class) {

    $rootDirectory = dirname(__DIR__, 2) . '/';
    $file = $rootDirectory . str_replace('\\', '/', $class) . '.php';

    if (file_exists($file)) {
        require $file;
    }

});