<?php

namespace Tests\Core\Repository;

use App\Core\Config;
use App\Core\Exceptions\ClassNotFoundException;
use App\Core\Repository\RepositoryInterface;
use App\Core\Repository\RepositoryManager;
use App\Core\Repository\RepositoryManagerInterface;
use Exception;
use PHPUnit\Framework\TestCase;

final class RepositoryManagerTest extends TestCase
{
    /**
     * @var RepositoryManagerInterface
     */
    public RepositoryManagerInterface $repositoryManager;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->repositoryManager = new RepositoryManager();
        $this->config = Config::getInstance();
    }

    /**
     * @return void
     * @throws ClassNotFoundException
     * @throws Exception
     */
    public function testGetRepository(): void
    {
        $rootDir = dirname(__DIR__, 3);
        $dataDir = $rootDir . '/App/Data/';

        foreach (scandir($dataDir) as $dirMember) {
            if (!in_array($dirMember, ['.', '..'])) {
                $dataFileName = $dirMember;
            }
        }

        if (isset($dataFileName)) {
            $entityName = str_replace('.json', '', $dataFileName);
            $repo = $this->repositoryManager->getRepository($entityName);
            $this->assertInstanceOf(RepositoryInterface::class, $repo);
        } else {
            throw new Exception('No data files found.');
        }
    }
}
