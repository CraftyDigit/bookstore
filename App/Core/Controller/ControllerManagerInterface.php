<?php

namespace App\Core\Controller;

interface ControllerManagerInterface
{
    /**
     * @param string $controllerName
     * @param bool $isAdminController
     * @param string $relatedPath
     * @return ControllerInterface
     */
    public function getController(
        string $controllerName, bool $isAdminController = false, string $relatedPath = '/'
    ): ControllerInterface;
}