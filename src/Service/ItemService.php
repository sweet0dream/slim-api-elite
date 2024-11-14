<?php

namespace App\Service;

use App\Helper\ItemHelper;
use App\Repository\ItemRepository;

class ItemService
{
    private ItemRepository $repository;
    private ItemHelper $itemHelper;
    public function __construct(
        private readonly array $city
    )
    {
        $this->repository = new ItemRepository();
        $this->itemHelper = new ItemHelper();
    }

    public function all(): array
    {
        return $this->itemHelper->prepareItems(
            $this->repository->findBy(['city_id' => $this->city['id']]),
            $this->city
        );
    }

    public function getIdsActive(): array
    {
        return $this->itemHelper->getAllIds(
            $this->repository->findBy(
                ['city_id' => $this->city['id'], 'status_active' => 1],
                ['date_top' => 'DESC']
            )
        );
    }

    public function get(int $id): ?array
    {
        return $this->itemHelper->prepareItem(
            $this->repository->findOneBy([
                'id' => $id,
                'city_id' => $this->city['id']
            ]),
            $this->city
        );
    }
}