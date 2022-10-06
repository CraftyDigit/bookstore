<?php

namespace App\Framework;

class Controller
{

    public $templateName = '';
    public $isAdminController = false;

    public function __construct()
    {
        $this->templateName = $this->getDefaultTemplateName();
    }

    /**
     * @return string
     */
    private function getDefaultTemplateName()
    {
        $classFullName = get_class($this);
        $className = explode('\\',$classFullName)[sizeof(explode('\\',$classFullName)) - 1];

        return strtolower(str_replace('Controller','',$className));
    }

    /**
     * @return void
     */
    public function render()
    {
        $this->output();
    }

    /**
     * @param string|null $templateName
     * @param array $variables
     * @return void
     */
    protected function output(string $templateName = null, array $variables = [])
    {
        $config = Config::getInstance();
        $templateName = $templateName ?: $this->templateName;
        $templateInnerDirectory = $this->isAdminController ?
            $config->admin_template_inner_path : $config->front_template_inner_path;
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