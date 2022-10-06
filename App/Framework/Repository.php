<?php

namespace App\Framework;

class Repository
{
    private $dataFileName = '';
    private $data = [];

    public $autoSave = true;

    /**
     * @param string $dataFileName
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
     * @return Model|false
     */
    public function getOneById(int $itemId)
    {
        foreach ($this->data['items'] as $dataItem) {
            if ($dataItem['id'] == $itemId) {
                return new Model($dataItem);
            };
        }

        return false;
    }

    /**
     * @return int[]|string[]
     */
    public function getScheme()
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
    public function setDataItem(Model $item)
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
    public function deleteDataItem(Model $item)
    {
        for ($i = 0; $i < sizeof($this->data['items']); $i++) {
            if ($this->data['items'][$i]['id'] == $item->id) {
                array_splice($this->data['items'], $i, 1);
                //unset($this->data['items'][$i]);
            }
        }

        if ($this->autoSave) {
            $this->saveData();
        }
    }

    /**
     * @return void
     */
    public function saveData()
    {
        $file = $this->getDataFileFullName();

        file_put_contents($file, json_encode($this->data));
    }

    /**
     * @return void
     */
    private function loadData()
    {
        $file = $this->getDataFileFullName();

        if (file_exists($file)) {
            $this->data = json_decode(file_get_contents($file), 1);
        }
    }

    /**
     * @return string
     */
    private function getDataFileFullName(): string
    {
        return dirname(__DIR__) . '/Data/' . $this->dataFileName . '.json';
    }
}