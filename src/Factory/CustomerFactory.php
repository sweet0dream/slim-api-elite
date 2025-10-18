<?php

declare(strict_types=1);

namespace App\Factory;

use OpenApi\Attributes as OA;

final class CustomerFactory extends AbstractFactory implements FactoryInterface
{
    private const string ROLE_BOOSTER = 'booster';
    private const string ROLE_CUSTOMER = 'customer';
    private const array ROLE = [
        self::ROLE_CUSTOMER,
        self::ROLE_BOOSTER
    ];

    #[OA\Schema(
        schema: 'CustomerResponse',
        properties: [
            new OA\Property(
                property: 'id',
                type: 'integer',
                example: 111
            ),
            new OA\Property(
                property: 'role',
                type: 'string',
                example: self::ROLE_BOOSTER
            ),
            new OA\Property(
                property: 'name',
                type: 'string',
                example: 'Test Test'
            ),
            new OA\Property(
                property: 'email',
                type: 'string',
                example: 'test@test.com'
            ),
            new OA\Property(
                property: 'active',
                type: 'boolean',
                example: true
            )
        ],
        type: 'object'
    )]
    public function data(array $data): array
    {
        return [
            'id' => $data['customer_id'] ?? null,
            'role' => $this->getRole($data),
            'name' => $this->getName($data),
            'email' => $data['email'] ?? null,
            'active' => (bool) $data['status']
        ];
    }

    private function getRole(array $data): string
    {
        $role = (int) ($data['customer_group_id'] == 2 && $data['booster'] == 1);

        return self::ROLE[$role];
    }

    private function getName(array $data): string
    {
        return $data['firstname'] . (!in_array($data['lastname'], ['Empty', '']) ? ' ' . $data['lastname'] : '');
    }
}