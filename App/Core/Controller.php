<?php

namespace App\Core;

class Controller
{
    /**
     * @var string
     */
    public string $templateName = '';

    /**
     * @var bool
     */
    public bool $isAdminController = false;

    public function __construct()
    {
        $this->templateName = $this->getDefaultTemplateName();
    }

    /**
     * @return string
     */
    protected function getDefaultTemplateName(): string
    {
        $classFullName = get_class($this);
        $className = explode('\\',$classFullName)[sizeof(explode('\\',$classFullName)) - 1];

        return strtolower(str_replace('Controller','',$className));
    }

    /**
     * @return void
     */
    public function render(): void
    {
        $this->output();
    }

    /**
     * @param string|null $templateName
     * @param array $variables
     * @return void
     */
    protected function output(string $templateName = null, array $variables = []): void
    {
        $config = Config::getInstance();
        $templateName = $templateName ?: $this->templateName;
        $templateInnerDirectory = $this->isAdminController ? 'Admin' : 'Front';
        $templateFullName = dirname(__DIR__) . '/Templates/' . $templateInnerDirectory .'/'. $templateName . '.php';
        $output = NULL;

        if(file_exists($templateFullName)){
            extract($variables);

            ob_start();

            include $templateFullName;

            $output = ob_get_clean();
        }

        print $output;
    }

}