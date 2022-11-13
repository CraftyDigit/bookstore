<?php

namespace Tests\Core;

use App\Core\ErrorReporter\ErrorReporter;
use App\Core\ErrorReporter\ErrorReporterInterface;
use App\Core\Kernel;
use App\Core\Router\Router;
use App\Core\Router\RouterInterface;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class KernelTest extends TestCase
{
    /**
     * @var ErrorReporterInterface|MockObject
     */
    public ErrorReporterInterface|MockObject $errorReporterMock;

    /**
     * @var RouterInterface|MockObject
     */
    public RouterInterface|MockObject $routerMock;

    /**
     * @var Kernel
     */
    public Kernel $kernel;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->errorReporterMock = $this->createMock(ErrorReporter::class);
        $this->routerMock = $this->createMock(Router::class);
        $this->kernel = new Kernel($this->errorReporterMock, $this->routerMock);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testStart()
    {
        $this->errorReporterMock->expects($this->once())
            ->method('setHandlers');

        $this->routerMock->expects($this->once())
            ->method('followRoute');

        $this->kernel->start();
    }
}
