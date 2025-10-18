<?php

declare(strict_types=1);

namespace App\Controller\Order;

use App\Helper\ResponseHelper;
use App\Resolver\OrdersRequestResolver;
use App\Service\OrderService;

abstract class AbstractOrder
{
    public function __construct(
        protected OrderService $service,
        protected ResponseHelper $response,
        protected OrdersRequestResolver $resolver
    ) {
    }
}