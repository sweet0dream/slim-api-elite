<?php

declare(strict_types=1);

namespace App\Resolver;

use OpenApi\Attributes as OA;

final class OrdersRequestResolver
{
    #[OA\Schema(
        schema: 'OrdersCriteriaRequest',
        properties: [
            new OA\Property(
                property: 'client',
                properties: [
                    new OA\Property(
                        property: 'id',
                        anyOf: [
                            new OA\Property(type: 'integer', example: 1),
                            new OA\Property(
                                type: 'array',
                                items: new OA\Items(type: 'integer', example: 1),
                                example: [1, 2, 3]
                            )
                        ]
                    )
                ],
                type: 'object'
            ),
            new OA\Property(
                property: 'booster',
                properties: [
                    new OA\Property(
                        property: 'id',
                        anyOf: [
                            new OA\Property(type: 'integer', example: 1),
                            new OA\Property(
                                type: 'array',
                                items: new OA\Items(type: 'integer', example: 1),
                                example: [1, 2, 3]
                            )
                        ]
                    )
                ],
                type: 'object'
            ),
            new OA\Property(
                property: 'status',
                properties: [
                    new OA\Property(
                        property: 'id',
                        anyOf: [
                            new OA\Property(type: 'integer', example: 1),
                            new OA\Property(
                                type: 'array',
                                items: new OA\Items(type: 'integer', example: 1),
                                example: [1, 2, 3]
                            )
                        ]
                    )
                ],
                type: 'object'
            ),
        ],
        type: 'object'
    )]
    public function param(object $data): array
    {
        return array_filter([
            'customer_id' => $data->client->id ?? null,
            'order_executor' => $data->booster->id ?? null,
            'order_status_id' => $data->status->id ?? null,
        ]);
    }
}