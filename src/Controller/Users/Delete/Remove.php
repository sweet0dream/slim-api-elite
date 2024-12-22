<?php

namespace App\Controller\Users\Delete;

use App\Controller\Abstract\UsersAbstract;
use App\Helper\ResponseHelper;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class Remove extends UsersAbstract
{
    public function __invoke(Request $request): Response
    {
        $result = $this->userService->remove(
            $request->getAttribute('id')
        );

        return $this->responseHelper->send(
            ['error' => $result ? 'User removed' : 'User not found'],
            $result ? ResponseHelper::NO_CONTENT : ResponseHelper::NOT_FOUND
        );
    }
}