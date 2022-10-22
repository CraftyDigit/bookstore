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

    public function __construct()
    {
        $config = Config::getInstance();
        $this->dataSourceType = $config->data_source_type;
    }

    /**
     * @param string $dataSourceName
     * @return AbstractRepository
     * @throws Exception
     */
    public function getRepository(string $dataSourceName): AbstractRepository
    {
        $repositoryClass = __NAMESPACE__ .'\\'. $this->dataSourceType . 'Repository';

        if (class_exists($repositoryClass)) {
            return new $repositoryClass($dataSourceName);
        } else {
            throw new Exception('Repository class not found');
        }
    }
}