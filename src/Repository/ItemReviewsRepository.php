<?php

namespace App\Repository;

class ItemReviewsRepository extends AbstractRepository
{
    const string TABLE_REPOSITORY = 'item_reviews';
    public function __construct(
        private readonly string $model = self::TABLE_REPOSITORY
    ) {
        parent::__construct($this->model);
    }
}