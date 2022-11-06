<?php

namespace App\Core;

use App\Core\Exceptions\FileNotFoundException;
use Exception;

abstract class Controller
{
    /**
     * @var string
     */
    protected string $templateName = '';

    /**
     * @return string
     */
    public function getTemplateName(): string
    {
        return $this->templateName;
    }

    /**
     * @param string $templateName
     */
    public function setTemplateName(string $templateName): void
    {
        $this->templateName = $templateName;
    }

    /**
     * @var bool
     */
    protected bool $isAdminController = false;

    /**
     * @return bool
     */
    public function isAdminController(): bool
    {
        return $this->isAdminController;
    }

    /**
     * @param bool $isAdminController
     */
    public function setIsAdminController(bool $isAdminController): void
    {
        $this->isAdminController = $isAdminController;
    }

    public function __construct()
    {
        $this->templateName = $this->getDefaultTemplateName();
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
     * @param string|null $templateName
     * @return string
     */
    public function getTemplateFullName(string $templateName = null): string
    {
        $templateName = $templateName ?: $this->templateName;
        $templateInnerDirectory = $this->isAdminController ? 'Admin' : 'Front';

        return dirname(__DIR__) . '/Templates/' . $templateInnerDirectory .'/'. $templateName . '.php';
    }

    /**
     * @param string|null $templateName
     * @param array $variables
     * @return void
     * @throws Exception
     */
    protected function output(string $templateName = null, array $variables = []): void
    {
        $templateFullName = $this->getTemplateFullName($templateName);
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

    /**
     * @return void
     * @throws Exception
     */
    public function render(): void
    {
        $this->output();
    }
}