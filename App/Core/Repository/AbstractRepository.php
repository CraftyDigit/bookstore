<?php

namespace App\Core\Repository;

use App\Core\Model;

abstract class AbstractRepository
{
    /**
     * @var bool
     */
    public bool $autoSave = true;

    /**
     * @return array
     */
    abstract public function getAll(): array;

    /**
     * @param int $itemId
     * @return Model|null
     */
    abstract public function getOneById(int $itemId): ?Model;

    /**
     * @return int[]|string[]
     */
    abstract public function getScheme(): array;

    /**
     * @return Model
     */
    abstract public function getBlankItem(): Model;

    /**
     * @param Model $item
     * @return void
     */
    abstract public function setDataItem(Model $item): void;

    /**
     * @param Model $item
     * @return Model
     */
    abstract public function addDataItem(Model $item): Model;

    /**
     * @param Model $item
     * @return void
     */
    abstract public function deleteDataItem(Model $item): void;

    /**
     * @return void
     */
    abstract public function saveData(): void;
}