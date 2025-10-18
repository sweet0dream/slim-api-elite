<?php

declare(strict_types=1);

namespace App\Factory;

final class OrderFactory extends AbstractFactory implements FactoryInterface
{

    public function data(array $data): array
    {
        return [
            'id' => $data['order_id'] ?? null,
            'creator_id' => (int) $data['customer_id'] ?? null,
            'executor_id' => (int) $data['order_executor'] ?? null,
            'order_status_id' => $data['order_status_id'] ?? null,
            'price' => [
                'total' => (float) $data['total'],
                'full_total' => (float) $data['full_total'],
                'currency' => $data['currency_code'] ?? null
            ]
        ];
    }
}
