<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\OrderRepository;
use Exception;

final class OrderService
{
    private OrderRepository $orderRepository;
    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
    }

    /**
     * @throws Exception
     */
    public function get(int $id): ?array
    {
        return $this->orderRepository->findOneBy([
            'order_id' => $id
        ]);
    }

    /**
     * @throws Exception
     */
    public function getFindByCriteria(array $criteria): ?array
    {
        $result = $this->orderRepository->findBy($criteria);

        return !empty($result) ? $result : null;
    }
}