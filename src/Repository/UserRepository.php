<?php

namespace App\Repository;

class UserRepository extends AbstractRepository
{
    const string TABLE_REPOSITORY = 'user';
    public function __construct(
        private readonly string $model = self::TABLE_REPOSITORY
    ) {
        parent::__construct($this->model);
    }
}