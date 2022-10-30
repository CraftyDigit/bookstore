<?php

namespace App\Core\Repository;

use App\Core\Model;

interface RepositoryInterface
{
    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @param int $itemId
     * @return Model|null
     */
    public function getOneById(int $itemId): ?Model;

    /**
     * @return int[]|string[]
     */
    public function getScheme(): array;

    /**
     * @return Model
     */
    public function getBlankItem(): Model;

    /**
     * @param Model $item
     * @return void
     */
    public function updateItem(Model $item): void;

    /**
     * @param Model $item
     * @return Model
     */
    public function addItem(Model $item): Model;

    /**
     * @param Model $item
     * @return void
     */
    public function deleteItem(Model $item): void;
}