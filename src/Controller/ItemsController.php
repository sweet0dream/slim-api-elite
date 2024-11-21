<?php

namespace App\Controller;

use App\Service\ItemService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use App\Helper\ResponseHelper;
use Psr\Container\NotFoundExceptionInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ItemsController
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

    public function getIds(): Response {
        return $this->responseHelper->send(
            $this->itemService->getIds()
        );
    }

    public function getItem(Request $request): Response {
        return $this->responseHelper->send(
            $this->itemService->get(
                $request->getAttribute('id')
            )
        );
    }

    public function getItemReviews(Request $request): Response
    {
        return $this->responseHelper->send(
            $this->itemService->getReviews(
                $request->getAttribute('id')
            )
        );
    }
}