<?php

namespace App;

use App\Core\Kernel;

include_once 'vendor/autoload.php';

$kernel = new Kernel();
$kernel->start();