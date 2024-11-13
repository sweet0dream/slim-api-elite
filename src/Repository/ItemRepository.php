<?php

namespace App\Repository;

class ItemRepository extends AbstractRepository
{
    const string TABLE_REPOSITORY = 'item';
    public function __construct(
        private readonly string $model = self::TABLE_REPOSITORY
    ) {
        parent::__construct($this->model);
    }
}