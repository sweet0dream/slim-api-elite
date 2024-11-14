<?php

namespace App\Service;

use App\Repository\UserRepository;

class UserService
{
    private UserRepository $repository;
    public function __construct(
        private readonly array $city
    )
    {
        $this->repository = new UserRepository();
    }

    public function all(): array
    {
        return $this->repository->findBy(['city_id' => $this->city['id']]);
    }

    public function get(int $id): ?array
    {
        return $this->repository->findOneBy([
            'id' => $id,
            'city_id' => $this->city['id']
        ])[0];
    }
}