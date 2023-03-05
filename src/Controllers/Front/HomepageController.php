<?php

namespace App\Controllers\Front;

use CraftyDigit\Puff\Controller\AbstractController;
use Exception;

final class HomepageController extends AbstractController
{
    /**
     * @return void
     * @throws Exception
     */
    public function render(): void
    {
        $templateData['pageTitle'] = 'Homepage';

        $this->output($templateData);
    }
}