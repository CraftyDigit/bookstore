<?php

namespace App\Core;

use App\Core\ErrorReporter\ErrorReporter;
use App\Core\ErrorReporter\ErrorReporterInterface;
use App\Core\Router\Router;
use App\Core\Router\RouterInterface;
use Exception;

{
    /**
     * @param RouterInterface $router
     * @param ErrorReporterInterface $errorReporter
     */
    public function __construct(
        public ErrorReporterInterface $errorReporter = new ErrorReporter(),
        public RouterInterface $router = new Router()
    )
    {}

    /**
     * This method will start the app
     *
     * @return void
     * @throws Exception
     */
    function start(): void
    {
        $this->errorReporter->setHandlers();
        $this->router->followRoute();
    }
}