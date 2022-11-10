<?php

namespace App\Core\Repository;

interface RepositoryManagerInterface
{
    /**
     * @param string $dataSourceName
     * @return RepositoryInterface
     */
    public function getRepository(string $dataSourceName): RepositoryInterface;
}