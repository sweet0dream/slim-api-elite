<?php

namespace App\Controller\Users\Post;

use App\Controller\Abstract\UsersAbstract;
use App\Helper\ResponseHelper;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class Regin extends UsersAbstract
{
    public function __invoke(Request $request): Response
    {
        $result = $this->userService->regin(
            json_decode(
                $request->getBody()->getContents(),
                true
            )
        );

        return $this->responseHelper->send(
            $result,
            $result['error'] ? ResponseHelper::BAD_REQUEST : ResponseHelper::CREATED
        );
    }
}