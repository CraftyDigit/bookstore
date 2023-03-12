<?php

namespace App\Controllers\Front;

use CraftyDigit\Puff\Attributes\Controller;
use CraftyDigit\Puff\Attributes\Route;
use CraftyDigit\Puff\Controller\AbstractController;
use Exception;

#[Controller('homepage')]
final class HomepageController extends AbstractController
{
    /**
     * @return void
     * @throws Exception
     */
    #[Route('/', 'homepage')]
    public function homepage(): void
    {
        $templateData['pageTitle'] = 'Homepage';

        $this->output($templateData);
    }
}