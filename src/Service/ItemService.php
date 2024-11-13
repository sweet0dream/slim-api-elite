<?php

namespace App\Service;

use App\Repository\ItemRepository;

class ItemService
{
    private ItemRepository $repository;
    public function __construct(
        private readonly ?int $cityId
    )
    {
        $this->repository = new ItemRepository();
    }

    public function all(): array
    {
        return $this->repository->findBy(['city_id' => $this->cityId]);
    }

    public function get(int $id): ?array
    {
        return $this->repository->findOneBy([
            'id' => $id,
            'city_id' => $this->cityId
        ])[0];
    }
}