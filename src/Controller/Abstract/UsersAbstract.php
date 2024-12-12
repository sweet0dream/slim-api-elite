<?php

namespace App\Controller\Abstract;

use App\Helper\ResponseHelper;
use App\Service\UserService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class UsersAbstract
{
    protected UserService $userService;
    public function __construct(
        private readonly ContainerInterface $container,
        protected readonly ResponseHelper $responseHelper,
    )
    {
        try {
            $this->userService = new UserService($this->container->get('city'));
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
            $this->responseHelper->send(
                ['error' => $e->getMessage()],
                ResponseHelper::BAD_REQUEST
            );
        }
    }
}