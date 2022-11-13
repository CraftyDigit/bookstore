<?php

namespace Tests\Core\Controller;

use App\Core\Controller\ControllerInterface;
use App\Core\Controller\ControllerManager;
use App\Core\Controller\ControllerManagerInterface;
use PHPUnit\Framework\TestCase;
use Exception;

final class ControllerManagerTest extends TestCase
{
    /**
     * @var ControllerManagerInterface
     */
    public ControllerManagerInterface $controllerManager;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->controllerManager = new ControllerManager();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetController(): void
    {
        $rootDir = dirname(__DIR__, 3);
        $controllersFrontDir = $rootDir . '/App/Controllers/Admin/';

        foreach (scandir($controllersFrontDir) as $dirMember) {
            if (!in_array($dirMember, ['.', '..'])) {
                $controllerFileName = $dirMember;
            }
        }

        if (isset($controllerFileName)) {
            $controllerName = str_replace('Controller.php', '', $controllerFileName);
            $controller = $this->controllerManager->getController($controllerName);
            $this->assertInstanceOf(ControllerInterface::class, $controller);
        } else {
            throw new Exception('No front controllers found.');
        }
    }

    /**
     * @return void
     */
    public function testGetControllerReturn404ErrorControllerIfControllerNotFound(): void
    {
        $controller = $this->controllerManager->getController('Foo');
        $this->assertStringEndsWith('Error404Controller', get_class($controller));
    }
}
