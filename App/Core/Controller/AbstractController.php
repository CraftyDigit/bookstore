<?php

namespace App\Core\Controller;

use App\Core\Exceptions\FileNotFoundException;
use App\Core\Template\TemplateInterface;
use App\Core\Template\TemplateManager;
use App\Core\Template\TemplateManagerInterface;
use Exception;

abstract class AbstractController implements ControllerInterface
{
    /**
     * @var TemplateInterface
     */
    public TemplateInterface $template;

    /**
     * @param bool $isAdminController
     * @param TemplateManagerInterface $templateManager
     */
    public function __construct(
        public bool $isAdminController = false,
        public TemplateManagerInterface $templateManager = new TemplateManager()
    )
    {
        $this->template = $this->templateManager->getTemplate(
            $this->getDefaultTemplateName(),
            $this->isAdminController
        );
    }

    /**
     * @return string
     */
    public function getDefaultTemplateName(): string
    {
        $classFullName = get_class($this);
        $className = explode('\\',$classFullName)[sizeof(explode('\\',$classFullName)) - 1];

        return strtolower(str_replace('Controller','',$className));
    }

    /**
     * @param array $variables
     * @return void
     * @throws Exception
     */
    protected function output(array $variables = []): void
    {
        $templatePath = $this->template->getPath();
        $output = '';

        if($this->template->checkIfFileExists()){
            extract($variables);

            ob_start();

            include $templatePath;

            $output = ob_get_clean();
        } else {
            throw new FileNotFoundException("Template file '$templatePath' is not exist!");
        }

        print $output;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function render(): void
    {
        $this->output();
    }
}