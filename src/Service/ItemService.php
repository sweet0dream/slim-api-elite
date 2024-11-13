<?php

namespace App\Service;

use App\Repository\ItemRepository;

class ItemService
{
    private ItemRepository $repository;
    public function __construct()
    {
        $this->repository = new ItemRepository();
    }

    public function all(): array
    {
        return $this->repository->findAll();
    }

    public function get(int $id): array
    {
        return $this->repository->findOne($id);
    }
}