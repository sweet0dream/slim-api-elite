<?php

declare(strict_types=1);

namespace App\Controller\Customer;

use App\Factory\CustomerFactory;
use App\Helper\ResponseHelper;
use App\Service\CustomerService;
use Exception;
use Slim\Psr7\{Request, Response};
use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/customer/{id}',
    operationId: 'GetCustomerById',
    summary: 'Get customer by ID',
    servers: [new OA\Server(url: 'http://api.kingboost.local')],
    tags: ['Customers'],
    parameters: [new OA\Parameter(
        name: 'id',
        description: 'ID customer',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )],
    responses: [
        new OA\Response(
            response: ResponseHelper::OK,
            description: 'Success result',
            content: new OA\JsonContent(
                ref: '#/components/schemas/CustomerResponse'
            )
        ),
        new OA\Response(
            response: ResponseHelper::NOT_FOUND,
            description: 'Result not found'
        )
    ]
)]
final readonly class GetCustomerById
{
    public function __construct(
        private CustomerService $customerService,
        private ResponseHelper $response
    ) {
    }

    public function __invoke(Request $request): Response
    {
        try {
            $customerId = $request->getAttribute('id');
            $customer = $this->customerService->get((int) $customerId);
            if (is_null($customer)) {
                throw new Exception(
                    message: "Customer id {$customerId} not found",
                    code: ResponseHelper::NOT_FOUND
                );
            }

            return $this->response->send(
                CustomerFactory::view($customer)
            );
        } catch (Exception $e) {
            return $this->response->fail(
                message: $e->getMessage(),
                code: $e->getCode()
            );
        }
    }
}