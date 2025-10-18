<?php

declare(strict_types=1);

namespace App\Controller\Order;

use App\Factory\OrderFactory;
use App\Helper\ResponseHelper;
use App\Service\OrderService;
use Exception;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

final readonly class GetOrderById
{
    public function __construct(
        private OrderService $orderService,
        private ResponseHelper $response
    ) {
    }

    public function __invoke(Request $request): Response
    {
        try {
            $orderId = $request->getAttribute('id');
            $order = $this->orderService->get((int) $orderId);
            if (is_null($order)) {
                throw new Exception(
                    message: "Order id {$orderId} not found",
                    code: ResponseHelper::NOT_FOUND
                );
            }

            return $this->response->send(
                OrderFactory::view($order)
            );
        } catch (Exception $e) {
            return $this->response->fail(
                message: $e->getMessage(),
                code: $e->getCode()
            );
        }
    }
}
