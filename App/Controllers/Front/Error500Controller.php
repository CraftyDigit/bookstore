<?php

namespace App\Controllers\Front;

use App\Core\Controller;

class Error500Controller extends Controller
{
    /**
     * @return void
     */
    public function render(): void
    {
        $this->output('500');
    }
}