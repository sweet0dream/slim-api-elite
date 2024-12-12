<?php

namespace App\Service;

use App\Helper\UserHelper;
use App\Repository\UserRepository;

class UserService
{
    private UserRepository $repository;
    private UserHelper $userHelper;
    public function __construct(
        private readonly array $city
    )
    {
        $this->repository = new UserRepository();
        $this->userHelper = new UserHelper();
    }

    public function all(): array
    {
        return $this->repository->findBy(['city_id' => $this->city['id']]);
    }

    public function get(int $id): ?array
    {
        return $this->userHelper->prepareUser(
            $this->repository->findOneBy([
                'id' => $id,
                'city_id' => $this->city['id']
            ])
        );
    }
}