<?php

namespace App\Core;

use App\Core\Exceptions\FileNotFoundException;
use Exception;

abstract class Controller
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
     * @throws Exception
     */
    public function render(): void
    {
        $this->output();
    }

    /**
     * @param string|null $templateName
     * @param array $variables
     * @return void
     * @throws Exception
     */
    protected function output(string $templateName = null, array $variables = []): void
    {
        $config = Config::getInstance();
        $templateName = $templateName ?: $this->templateName;
        $templateInnerDirectory = $this->isAdminController ? 'Admin' : 'Front';
        $templateFullName = dirname(__DIR__) . '/Templates/' . $templateInnerDirectory .'/'. $templateName . '.php';
        $output = '';

        if(file_exists($templateFullName)){
            extract($variables);

            ob_start();

            include $templateFullName;

            $output = ob_get_clean();
        } else {
            throw new FileNotFoundException("Template file '$templateFullName' is not exist!");
        }

        print $output;
    }

}