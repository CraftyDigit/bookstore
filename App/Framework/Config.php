<?php

namespace App\Framework;

class Config
{
    private static $instance = null;
    private $parameters = [];

    private function __construct()
    {
        $this->loadParameters();
    }

    /**
     * @return Config|null
     */
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new Config();
        }

        return self::$instance;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->parameters[$name];
    }

    /**
     * @return void
     */
    private function loadParameters()
    {
        $configFile = dirname(__DIR__) . '/Framework/' . 'config.json';

        if (file_exists($configFile)) {
            $this->parameters = json_decode(file_get_contents($configFile), 1);
        }
    }

}