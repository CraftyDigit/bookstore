<?php

namespace Core\Repository;

use App\Core\Exceptions\FileNotFoundException;
use App\Core\Model\Model;
use App\Core\Repository\JSONRepository;
use App\Core\Repository\RepositoryInterface;
use PHPUnit\Framework\TestCase;

final class JSONRepositoryTest extends TestCase
{
    /**
     * @var RepositoryInterface
     */
    public RepositoryInterface $repo;

    /**
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        JSONRepositoryTest::createTestDataFile();
    }

    /**
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        JSONRepositoryTest::deleteTestDataFile();
    }

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->repo = new JSONRepository('testData');
    }

    /**
     * @return void
     */
    public function testGetScheme(): void
    {
        $scheme = $this->repo->getScheme();
        $this->assertSame(['id', 'name'], $scheme);
    }

    /**
     * @return void
     */
    public function testGetAll(): void
    {
        $allItems = $this->repo->getAll();
        $this->assertCount(2, $allItems);
    }

    /**
     * @return void
     * @throws FileNotFoundException
     */
    public function testDataNotSavedAutomaticallyWithAutoSaveSetToFalse(): void
    {
        $allDataItems = $this->repo->getAll();

        $this->repo->autoSave = false;
        $this->repo->deleteItem($allDataItems[0]);
        $this->repo->loadData();

        $this->assertEquals($allDataItems, $this->repo->getAll());

        JSONRepositoryTest::remakeTestDataFile();
    }

    /**
     * @return void
     * @throws FileNotFoundException
     */
    public function testSaveData()
    {
        $dataItem = $this->repo->getOneById(0);

        $this->repo->autoSave = false;
        $this->repo->deleteItem($dataItem);
        $this->repo->saveData();
        $this->repo->loadData();

        $predicatedRepoData[] = new Model(['id' => '1', 'name' => 'bar']);

        $this->assertEquals ($predicatedRepoData, $this->repo->getAll());

        JSONRepositoryTest::remakeTestDataFile();
    }

    /**
     * @return void
     */
    public function testUpdateItem(): void
    {
        $initialItem = $this->repo->getOneById(0);

        $initialItem->name = 'baz';

        $this->repo->updateItem($initialItem);

        $updatedItem = $this->repo->getOneById(0);

        $this->assertEquals($initialItem, $updatedItem);

        JSONRepositoryTest::remakeTestDataFile();
    }

    /**
     * @return void
     */
    public function testGetOneById(): void
    {
        $dataItem = $this->repo->getOneById('0');
        $this->assertEquals($dataItem, new Model(['id' => 0, 'name' => 'foo']));
    }

    /**
     * @return void
     */
    public function testGetOneByIdReturnNullOnWrongId(): void
    {
        $dataItem = $this->repo->getOneById('10');
        $this->assertNull($dataItem);
    }

    /**
     * @return void
     */
    public function testGetBlankItem(): void
    {
        $dataItem = $this->repo->getBlankItem();
        $this->assertEquals($dataItem, new Model(['id' => '', 'name' => '']));
    }

    /**
     * @return void
     */
    public function testAddItem(): void
    {
        $newItem = $this->repo->getBlankItem();

        $newItem->name = 'baz';

        $this->repo->addItem($newItem);

        $returnedItem = $this->repo->getOneById(2);

        $this->assertInstanceOf(Model::class, $returnedItem);

        JSONRepositoryTest::remakeTestDataFile();
    }

    /**
     * @return void
     */
    public function testDeleteItem(): void
    {
        $dataItem = $this->repo->getOneById('0');
        $this->repo->deleteItem($dataItem);

        $this->assertNull($this->repo->getOneById('0'));

        JSONRepositoryTest::remakeTestDataFile();
    }

    /**
     * @return void
     */
    static function remakeTestDataFile(): void
    {
        JSONRepositoryTest::deleteTestDataFile();
        JSONRepositoryTest::createTestDataFile();
    }

    /**
     * @return string
     */
    static function getTestDataFileName(): string
    {
        $rootDir = dirname(__DIR__, 3);
        $dataDir = $rootDir . '/App/Data/';

        return $dataDir . 'testData.json';
    }

    /**
     * @return void
     */
    static function createTestDataFile(): void
    {
        $dataFileName = JSONRepositoryTest::getTestDataFileName();

        if (!file_exists($dataFileName)) {
            $data = [
                'items' => [
                    ['id' => '0' , 'name' => 'foo'],
                    ['id' => '1', 'name' => 'bar']
                ]
            ];

            file_put_contents($dataFileName, json_encode($data));
        }
    }

    /**
     * @return void
     */
    static function deleteTestDataFile(): void
    {
        $dataFileName = JSONRepositoryTest::getTestDataFileName();

        if (file_exists($dataFileName)) {
            unlink($dataFileName);
        }
    }
}
