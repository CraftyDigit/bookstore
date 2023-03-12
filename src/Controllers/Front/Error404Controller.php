<?php

namespace App\Controllers\Front;

use CraftyDigit\Puff\Attributes\Controller;
use CraftyDigit\Puff\Attributes\Route;
use CraftyDigit\Puff\Controller\AbstractController;
use Exception;

#[Controller('error404')]
final class Error404Controller extends AbstractController
{
    /**
     * @return void
     * @throws Exception
     */
    #[Route(path: '/error/404', name: 'error_404', isPublic: false)]
    public function error404(): void
    {
        $template = $this->templateManager->getTemplate('Front/404');
        
        $this->render($template);
    }
}