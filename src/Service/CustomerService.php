<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\CustomerRepository;
use App\Repository\OrderRepository;
use Exception;

final class CustomerService
{
    private CustomerRepository $repository;

    public function __construct()
    {
        $this->repository = new CustomerRepository();
    }

    /**
     * @throws Exception
     */
    public function get(int $id): ?array
    {
        return $this->repository->findOneBy([
            'customer_id' => $id
        ]);
    }
}