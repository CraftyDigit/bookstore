<?php

namespace App\Core;

use App\Controllers\Front\Error404Controller;
use Exception;

class Router
{
    /**
     * @return void
     * @throws Exception
     */
    static function followRoute(): void
    {
        $controllerName = 'App\Controllers';
        $path = explode('?', $_SERVER['REQUEST_URI'])[0];

        $path = $path === '/' ? '/homepage' : $path;

        if (str_contains($path, '/admin/')) {
            $path = str_replace('/admin', '/Admin', $path);
        } else {
            $path = '/Front' . $path;
        }

        $pathArr = explode('/', $path);

        for ($i = 1; $i < sizeof($pathArr); $i++) {
            if ($i + 1 < sizeof($pathArr)) {
                $pathChunk = $pathArr[$i];
            } else {
                $pathChunk = ucfirst($pathArr[$i]) . 'Controller';
            }

            $controllerName .= '\\' . $pathChunk;
        }

        if ( class_exists($controllerName) ) {
            /** @var Controller $controller */
            $controller = new $controllerName();
        } else {
            $controller = new Error404Controller();
        }

        $controller->render();
    }
}