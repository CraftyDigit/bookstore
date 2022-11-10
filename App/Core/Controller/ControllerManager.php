<?php

namespace App\Core\Controller;

use App\Controllers\Front\Error404Controller;

class ControllerManager implements ControllerManagerInterface
{
    /**
     * @param string $controllerName
     * @param bool $isAdminController
     * @param string $relatedPath
     * @return ControllerInterface
     */
    public function getController(
        string $controllerName, bool $isAdminController = false, string $relatedPath = '/'
    ): ControllerInterface
    {
        $controllerFullName = 'App\Controllers';
        $controllerFullName .= $isAdminController ? '\Admin' : '\Front';
        $controllerFullName .= $relatedPath === '/' ? '' : str_replace('/', '\\', $relatedPath);
        $controllerFullName .= '\\' . $controllerName . 'Controller';

        if ( class_exists($controllerFullName) ) {
            /** @var ControllerInterface $controller */
            $controller = new $controllerFullName();
        } else {
            $controller = new Error404Controller();
        }

        return $controller;
    }
}