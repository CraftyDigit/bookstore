<?php

namespace App\Controllers\Front;

use CraftyDigit\Puff\Attributes\Controller;
use CraftyDigit\Puff\Attributes\Route;
use CraftyDigit\Puff\Controller\AbstractController;
use Exception;

#[Controller('error500')]
final class Error500Controller extends AbstractController
{
    /**
     * @return void
     * @throws Exception
     */
    #[Route(path: '/error/500', name: 'error_500', isPublic: false)]
    public function error500(): void
    {
        $template = $this->templateManager->getTemplate('Front/500');
        
        $this->render($template);
    }
}