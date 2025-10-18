<?php

declare(strict_types=1);

namespace App\Factory;

final class OrdersFactory extends AbstractFactory implements FactoryInterface
{

    public function data(array $data): array
    {
        return [
            'count' => count($data),
            'data' => array_map(fn($item) => OrderFactory::view($item), $data)
        ];
    }
}