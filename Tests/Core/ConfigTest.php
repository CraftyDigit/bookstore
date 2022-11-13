<?php

namespace Tests\Core;

use PHPUnit\Framework\TestCase;
use App\Core\Config;

final class ConfigTest extends TestCase
{
    /**
     * @var Config
     */
    public Config $config;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->config = Config::getInstance();
    }

    /**
     * @return void
     */
    public function testIfSingleton(): void
    {
        $this->assertSame(Config::getInstance(), $this->config, 'Config class not follow the "singleton" pattern');
    }

    /**
     * @return void
     */
    public function testMagicGet(): void
    {
        $this->assertNotNull($this->config->data_source_type, 'Config data is not accessible thru __get method.');
    }
}
