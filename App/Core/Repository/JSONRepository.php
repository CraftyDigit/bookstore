<?php

namespace App\Core\Repository;

use App\Core\Model;
use Exception;

class JSONRepository extends AbstractRepository
{
    /**
     * Name of JSON file containing data
     *
     * @var string
     */
    private string $dataFileName = '';

    /**
     * Array of items loaded from JSON file
     *
     * @var array
     */
    private array $data = [];

    /**
     * @param string $dataFileName
     * @throws Exception
     */
    public function __construct(string $dataFileName)
    {
        $this->dataFileName = $dataFileName;
        $this->loadData();
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $items = [];

        foreach ($this->data['items'] as $dataItem) {
            $items[] = new Model($dataItem);
        }

        return $items;
    }

    /**
     * @param int $itemId
     * @return Model|null
     */
    public function getOneById(int $itemId): ?Model
    {
        foreach ($this->data['items'] as $dataItem) {
            if ($dataItem['id'] == $itemId) {
                return new Model($dataItem);
            };
        }

        return null;
    }

    /**
     * @return int[]|string[]
     */
    public function getScheme(): array
    {
        return array_keys($this->data['items'][0]);
    }

    /**
     * @return Model
     */
    public function getBlankItem(): Model
    {
        $scheme = $this->getScheme();

        foreach ($scheme as $field) {
            $dataItem[$field] = '';
        }

        return new Model($dataItem);
    }

    /**
     * @param Model $item
     * @return void
     */
    public function setDataItem(Model $item): void
    {
        for ($i = 0; $i < sizeof($this->data['items']); $i++) {
            if ($this->data['items'][$i]['id'] == $item->id) {
                $this->data['items'][$i] = $item->getData();
            }
        }

        if ($this->autoSave) {
            $this->saveData();
        }
    }

    /**
     * @param Model $item
     * @return Model
     */
    public function addDataItem(Model $item): Model
    {
        $maxId = 0;

        for ($i = 0; $i < sizeof($this->data['items']); $i++) {
            $maxId = max($maxId, $this->data['items'][$i]['id']);
        }

        $newItemData = $item->getData();
        $newItemData['id'] = $maxId + 1;

        $this->data['items'][] = $newItemData;

        if ($this->autoSave) {
            $this->saveData();
        }

        return new Model($newItemData);
    }

    /**
     * @param Model $item
     * @return void
     */
    public function deleteDataItem(Model $item): void
    {
        for ($i = 0; $i < sizeof($this->data['items']); $i++) {
            if ($this->data['items'][$i]['id'] == $item->id) {
                array_splice($this->data['items'], $i, 1);
            }
        }

        if ($this->autoSave) {
            $this->saveData();
        }
    }

    /**
     * @return void
     */
    public function saveData(): void
    {
        $file = $this->getDataFileFullName();

        file_put_contents($file, json_encode($this->data));
    }

    /**
     * @return void
     * @throws Exception
     */
    private function loadData(): void
    {
        $file = $this->getDataFileFullName();

        if (file_exists($file)) {
            $this->data = json_decode(file_get_contents($file), 1);
        } else {
            throw new Exception('JSON data file does not exist.');
        }
    }

    /**
     * @return string
     */
    private function getDataFileFullName(): string
    {
        return dirname(__DIR__, 2) . '/Data/' . $this->dataFileName . '.json';
    }
}