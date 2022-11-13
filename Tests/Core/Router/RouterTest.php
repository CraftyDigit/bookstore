<?php

namespace Tests\Core\Router;

use App\Core\Controller\ControllerInterface;
use App\Core\Controller\ControllerManager;
use App\Core\Controller\ControllerManagerInterface;
use App\Core\Controller\AbstractController;
use App\Core\Router\Router;
use App\Core\Router\RouterInterface;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class RouterTest extends TestCase
{
    /**
     * @var ControllerInterface|MockObject
     */
    public ControllerInterface|MockObject $controllerMock;

    /**
     * @var ControllerManagerInterface|MockObject
     */
    public ControllerManagerInterface|MockObject $controllerManagerMock;

    /**
     * @var RouterInterface
     */
    public RouterInterface $router;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->controllerMock = $this->getMockForAbstractClass(
            AbstractController::class, [], 'barController', true, true, true, ['render']);

        $this->controllerManagerMock = $this->createMock(ControllerManager::class);
        $this->controllerManagerMock->method('getController')
            ->willReturn($this->controllerMock);

        $this->router = new Router($this->controllerManagerMock);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testFollowRoute(): void
    {
        $this->controllerMock->expects($this->once())
            ->method('render');

        $_SERVER['REQUEST_URI'] = '';

        $this->router->followRoute();

        unset($_SERVER['REQUEST_URI']);
    }
}