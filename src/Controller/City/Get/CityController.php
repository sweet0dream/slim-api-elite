<?php

namespace App\Controller\City\Get;

use App\Helper\ResponseHelper;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Response;

readonly class CityController
{
    public function __construct(
        private ContainerInterface $container,
        private ResponseHelper $responseHelper
    )
    {
    }

    public function __invoke(): Response
    {
        return $this->responseHelper->send(
            $this->container->get('city')
        );
    }
}