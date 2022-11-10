<?php

namespace App\Controllers\Front;

use App\Core\Controller\AbstractController;
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