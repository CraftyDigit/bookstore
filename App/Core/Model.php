<?php

namespace App\Core;

class Model
{
    /**
     * @var array
     */
    private array $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->data[$name];
    }

    /**
     * @param $name
     * @param $value
     * @return void
     */
    public function __set($name, $value): void
    {
        $this->data[$name] = $value;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}