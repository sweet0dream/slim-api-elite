<?php

namespace App\Controller\Items\Get;

use App\Helper\ResponseHelper;
use App\Service\ItemService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ItemsIdsController
{
    private ItemService $itemService;
    public function __construct(
        private readonly ContainerInterface $container,
        private readonly ResponseHelper $responseHelper
    )
    {
        try {
            $this->itemService = new ItemService($this->container->get('city'));
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
            $this->responseHelper->send(
                ['error' => $e->getMessage()],
                ResponseHelper::BAD_REQUEST
            );
        }
    }

    public function __invoke(): Response {
        return $this->responseHelper->send(
            $this->itemService->getIds()
        );
    }
}
