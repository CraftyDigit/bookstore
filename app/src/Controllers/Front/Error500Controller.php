<?php

namespace App\src\Controllers\Front;

use CraftyDigit\Puff\Attributes\Controller;
use CraftyDigit\Puff\Attributes\Route;
use CraftyDigit\Puff\Controller\AbstractController;

#[Controller('error500')]
final class Error500Controller extends AbstractController
{
    #[Route(path: '/error/500', name: 'error_500', isPublic: false)]
    public function error500(): void
    {
        $this->templateEngine->display('Front/404');
    }
}