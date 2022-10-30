<?php

namespace App\Core\Repository;

use App\Core\Config;
use Exception;

class RepositoryManager
{
    /**
     * @var string
     */
    protected string $dataSourceType = '';

    public function __construct(string $dataSourceType = null)
    {
        $config = Config::getInstance();

        $this->dataSourceType = $dataSourceType ?? $config->data_source_type;
    }

    /**
     * @param string $dataSourceName
     * @return RepositoryInterface
     * @throws Exception
     */
    public function getRepository(string $dataSourceName): RepositoryInterface
    {
        $repositoryClass = __NAMESPACE__ .'\\'. $this->dataSourceType . 'Repository';

        if (class_exists($repositoryClass)) {
            return new $repositoryClass($dataSourceName);
        } else {
            throw new Exception('Repository class not found');
        }
    }
}