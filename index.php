<?php

namespace App;

use CraftyDigit\Puff\Container\Container;
use CraftyDigit\Puff\Kernel;

include_once 'vendor/autoload.php';

$container = Container::getInstance();
$kernel = $container->get(Kernel::class);
$kernel->start();