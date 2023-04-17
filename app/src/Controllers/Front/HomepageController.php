<?php

namespace App\src\Controllers\Front;

use CraftyDigit\Puff\Attributes\Controller;
use CraftyDigit\Puff\Attributes\Route;
use CraftyDigit\Puff\Controller\AbstractController;

#[Controller('homepage')]
final class HomepageController extends AbstractController
{
    #[Route('/', 'homepage')]
    public function homepage(): void
    {
        $templateData['pageTitle'] = 'Homepage';

        $this->templateEngine->display('Front/homepage', $templateData);
    }
}