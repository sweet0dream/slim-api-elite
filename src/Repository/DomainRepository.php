<?php

namespace App\Repository;

class DomainRepository extends AbstractRepository
{
    const string TABLE_REPOSITORY = 'domain';
    public function __construct(
        private readonly string $model = self::TABLE_REPOSITORY
    ) {
        parent::__construct($this->model);
    }
}