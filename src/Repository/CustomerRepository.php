<?php

declare(strict_types=1);

namespace App\Repository;

final class CustomerRepository extends AbstractRepository
{
    const string TABLE_REPOSITORY = 'oc_customer';
    public function __construct(
        private readonly string $model = self::TABLE_REPOSITORY
    ) {
        parent::__construct($this->model);
    }
}
