<?php

declare(strict_types=1);

namespace App\Controller\Order;

use App\Factory\OrdersFactory;
use App\Helper\ResponseHelper;
use Exception;
use Slim\Psr7\{Request, Response};
use OpenApi\Attributes as OA;

class PostFindOrdersByCriteria extends AbstractOrder
{
    #[OA\Post(
        path: '/orders',
        operationId: 'findOrdersByCriteria',
        summary: 'Find orders by criteria',
        servers: [new OA\Server(url: 'http://api.kingboost.local')],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                ref: '#/components/schemas/OrdersCriteriaRequest'
            )
        ),
        tags: ['Orders'],
        responses: [
            new OA\Response(
                response: ResponseHelper::OK,
                description: 'Success result',
                content: []
            ),
            new OA\Response(
                response: ResponseHelper::NOT_FOUND,
                description: 'Result not found'
            )
        ]
    )]
    public function __invoke(Request $request): Response
    {
        try {
            $requestData = json_decode($request->getBody()->getContents());
            $orders = $this->service->getFindByCriteria(
                $this->resolver->param($requestData->criteria)
            );
            if (is_null($orders)) {
                throw new Exception(
                    message: "Orders by criteria not found",
                    code: ResponseHelper::NOT_FOUND
                );
            }

            return $this->response->send(OrdersFactory::view($orders));
        } catch(Exception $e) {
            return $this->response->fail(
                message: $e->getMessage(),
                code: $e->getCode()
            );
        }
    }
}