<?php

namespace App\Controllers;

use App\Framework\Controller;

class Error404Controller extends Controller
{

    /**
     * @return void
     */
    public function render()
    {
        $this->output('404');
    }

}