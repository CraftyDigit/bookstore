<?php

namespace App\Controllers\Front;

use App\Core\Controller\AbstractController;
use Exception;

final class Error500Controller extends AbstractController
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