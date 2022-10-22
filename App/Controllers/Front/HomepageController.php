<?php

namespace App\Controllers\Front;

use App\Core\Controller;

class HomepageController extends Controller
{
    /**
     * @return void
     */
    public function render(): void
    {
        $templateData['pageTitle'] = 'Homepage';

        $this->output('homepage', $templateData);
    }
}