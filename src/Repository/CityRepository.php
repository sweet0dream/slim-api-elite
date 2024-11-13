<?php

namespace App\Repository;

class CityRepository extends AbstractRepository
{
    const string TABLE_REPOSITORY = 'city';
    public function __construct(
        private readonly string $model = self::TABLE_REPOSITORY
    ) {
        parent::__construct($this->model);
    }
}