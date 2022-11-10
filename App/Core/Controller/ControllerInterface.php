<?php

namespace App\Core\Controller;

interface ControllerInterface
{
    /**
     * @return void
     */
    public function render(): void;
}