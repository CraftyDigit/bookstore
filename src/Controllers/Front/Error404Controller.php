<?php

namespace App\Controllers\Front;

use CraftyDigit\Puff\Controller\AbstractController;
use Exception;

final class Error404Controller extends AbstractController
{
    /**
     * @return void
     * @throws Exception
     */
    public function render(): void
    {
        $this->template = $this->templateManager->getTemplate('404');
        $this->output();
    }
}