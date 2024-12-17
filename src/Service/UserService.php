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

    public function login(array $data): array
    {
        $validated = $this->userHelper->validateField($data, UserHelper::FIELD_LOGIN);

        $user = $this->repository->findOneBy([
            'login' => $data['login'],
            'city_id' => $this->city['id']
        ]);

        $errorMessage = match (true) {
            !is_null($validated) => $validated,
            is_null($user) => 'User not found',
            !password_verify($data['password'], $user['password']) => 'Wrong password',
            default => null
        };

        if (is_null($errorMessage)) {
            $user = $this->repository->updateById(
                $user['id'],
                ['hash' => $this->userHelper->generateAuthHash()]
            );
        }

        return $errorMessage
            ? ['error' => $errorMessage]
            : $this->userHelper->loginUser($user);
    }

    public function regin(array $data): array
    {
        $validated = $this->userHelper->validateField($data, UserHelper::FIELD_REGIN);

        $existUser = $this->repository->findOneBy(['login' => $data['login']]);

        $errorMessage = match (true) {
            !is_null($validated) => $validated,
            !is_null($existUser) => 'Login already exist',
            default => null
        };

        if (is_null($errorMessage)) {
            $user = $this->repository->insert([
                'city_id' => $this->city['id'],
                'type' => $data['type'] ?? 'reg',
                'login' => $data['login'],
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                'password_view' => base64_encode($data['password']),
                'phone' => $data['phone'],
                'code' => base64_encode($data['code']),
                'balance' => $this->city['user']['start_balance'],
            ]);

            return $this->login([
                'login' => $user['login'],
                'password' => $data['password'],
            ]);
        }

        return ['error' => $errorMessage];
    }

    public function remove(int $id): bool
    {
        $user = $this->repository->findOneBy([
            'id' => $id,
        ]);

        return !is_null($user) && $this->repository->deleteById($user['id']);
    }

    public function update(
        int $id,
        array $data,
        string $field
    ): array
    {
        $value = $data[$field] ?? null;

        $user = $this->repository->findOneBy(['id' => $id]);

        $errorMessage = match (true) {
            is_null($user) => 'User not found',
            empty($value) => 'Field {' . $field . '} value empty',
            default => null
        };

        if (is_null($errorMessage)) {
            $user = $this->repository->updateById($user['id'], [$field => match ($field) {
                UserHelper::FIELD_PASSWORD => password_hash($value, PASSWORD_DEFAULT),
                default => $value,
            }]);
        }

        return $errorMessage ? ['error' => $errorMessage] : [];
    }
}