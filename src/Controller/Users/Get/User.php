<?php

namespace App\Controller\Users\Get;

use App\Controller\Abstract\UsersAbstract;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class User extends UsersAbstract
{
    public function __invoke(Request $request): Response
    {
        return $this->responseHelper->send(
            $this->userService->get(
                $request->getAttribute('id')
            )
        );
    }
}