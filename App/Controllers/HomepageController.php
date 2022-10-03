<?php

namespace App\Controllers;

use App\Framework\Controller;

class HomepageController extends Controller
{

    /**
     * @return void
     */
    public function render()
    {
        $templateData['pageTitle'] = 'Homepage';

        $this->output('homepage', $templateData);
    }

}