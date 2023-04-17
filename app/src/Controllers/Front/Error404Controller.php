<?php

namespace App\src\Controllers\Front;

use CraftyDigit\Puff\Attributes\Controller;
use CraftyDigit\Puff\Attributes\Route;
use CraftyDigit\Puff\Controller\AbstractController;

#[Controller('error404')]
final class Error404Controller extends AbstractController
{
    #[Route(path: '/error/404', name: 'error_404', isPublic: false)]
    public function error404(): void
    {
        $this->templateEngine->display('Front/404');
    }
}