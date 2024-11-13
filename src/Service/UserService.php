<?php

namespace App\Service;

use App\Repository\UserRepository;

class UserService
{
    private UserRepository $repository;
    public function __construct()
    {
        $this->repository = new UserRepository();
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