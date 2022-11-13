<?php

namespace Tests\Core\Template;

use App\Core\Template\Template;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class TemplateTest extends TestCase
{
    /**
     * @var Template|MockObject
     */
    public Template|MockObject $template;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->template = $this->getMockBuilder(Template::class)
            ->setConstructorArgs(['foo'])
            ->onlyMethods([])
            ->getMock();
    }

    /**
     * @return void
     */
    public function testGetName(): void
    {
        $this->assertSame($this->template->getName(), 'foo');
    }

    /**
     * @return void
     */
    public function testGetFullName(): void
    {
        $this->assertSame($this->template->getFullName(), 'Front/foo');
    }

    /**
     * @return void
     */
    public function testGetPath(): void
    {
        $this->assertStringEndsWith('App/Templates/Front/foo.php', $this->template->getPath());
    }

    /**
     * @return void
     */
    public function testCheckIfFileExists(): void
    {
        $templateFile = $this->createTemplateFile();
        $this->assertSame(file_exists($templateFile), $this->template->checkIfFileExists());

        if (file_exists($this->template->getPath())) {
            unlink($this->template->getPath());
        }
    }

    /**
     * @return void
     */
    public function testIfIsAdminTemplateDefaultValueIsFalse(): void
    {
        $this->assertStringContainsString('Front/', $this->template->getFullName());
    }

    /**
     * @return string
     */
    private function createTemplateFile(): string
    {
        $filePath = $this->template->getPath();

        file_put_contents($filePath, '');

        return $filePath;
    }
}