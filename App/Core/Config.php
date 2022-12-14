<?php

namespace App\Core;

class Config
{
    /**
     * @var Config|null
     */
    private static ?Config $instance = null;

    /**
     * @var array
     */
    private array $parameters = [];

    private function __construct()
    {
        $this->loadParameters();
    }

    /**
     * @return Config
     */
    public static function getInstance(): Config
    {
        if (self::$instance == null) {
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
    private function loadParameters(): void
    {
        $configFile = dirname(__DIR__) . '/config.json';

        if (file_exists($configFile)) {
            $this->parameters = json_decode(file_get_contents($configFile), 1);
        }
    }

}