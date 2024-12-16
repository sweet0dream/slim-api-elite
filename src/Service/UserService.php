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

    public function login(array $data): ?array
    {
        $user = $this->repository->findOneBy([
            'login' => $data['login'],
            'city_id' => $this->city['id']
        ]);

        if (
            $user
            && password_verify($data['password'], $user['password'])
            && $this->repository->updateById($user['id'], ['hash' => $this->userHelper->generateAuthHash()])
        ) {
            return $this->userHelper->loginUser(
                    $this->repository->findOneBy(['id' => $user['id']])
            );
        }

        return null;
    }

    public function regin(array $data): ?array
    {
        $data = [
            'city_id' => $this->city['id'],
            'type' => $data['type'] ?? 'reg',
            'login' => $data['login'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'password_view' => base64_encode($data['password']),
            'phone' => $data['phone'],
            'code' => base64_encode($data['code']),
            'balance' => $this->city['user']['start_balance'],
        ];

        return $data;
    }
}