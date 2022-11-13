<?php

namespace Tests\Core\Template;

use App\Core\Template\TemplateInterface;
use App\Core\Template\TemplateManager;
use App\Core\Template\TemplateManagerInterface;
use Exception;
use PHPUnit\Framework\TestCase;

final class TemplateManagerTest extends TestCase
{
    /**
     * @var TemplateManagerInterface
     */
    public TemplateManagerInterface $templateManager;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->templateManager = new TemplateManager();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetTemplate(): void
    {
        $rootDir = dirname(__DIR__, 3);
        $templatesFrontDir = $rootDir . '/App/Templates/Front/';

        foreach (scandir($templatesFrontDir) as $dirMember) {
            if (!in_array($dirMember, ['.', '..'])) {
                $templateFileName = $dirMember;
            }
        }

        if (isset($templateFileName)) {
            $templateName = str_replace('.php', '', $templateFileName);
            $template = $this->templateManager->getTemplate($templateName);
            $this->assertInstanceOf(TemplateInterface::class, $template);
        } else {
            throw new Exception('No front templates found.');
        }
    }
}