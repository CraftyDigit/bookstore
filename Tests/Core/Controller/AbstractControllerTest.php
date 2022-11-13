<?php

namespace Tests\Core\Controller;

use App\Core\Controller\AbstractController;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class AbstractControllerTest extends TestCase
{
    /**
     * @var AbstractController|MockObject
     */
    public AbstractController|MockObject $controller;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->controller = $this->getMockForAbstractClass(AbstractController::class,[],'fooController');
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testIfRenderThrowExceptionWhenTemplateFileNotExist(): void
    {
        $templateFile = $this->createControllerTemplateFile();
        $this->controller->template = $this->controller->templateManager->getTemplate(
            $this->controller->isAdminController,
            'baz'
        );

        $this->expectException('Exception');
        $this->controller->render();

        unlink($templateFile);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testIfRenderPrintsTemplateFile()
    {
        $content = '<h1>baz</h1>';
        $templateFile = $this->createControllerTemplateFile($content);

        $this->controller->render();

        $this->expectOutputString($content);

        unlink($templateFile);
    }

    /**
     * @param string $content
     * @return string
     */
    private function createControllerTemplateFile(string $content = ''): string
    {
        $templateFile = $this->controller->template->getPath();

        file_put_contents($templateFile, $content);

        return $templateFile;
    }
}