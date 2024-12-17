<?php

namespace App\Controller\Users\Put;

use App\Controller\Abstract\UsersAbstract;
use App\Helper\ResponseHelper;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class Update extends UsersAbstract
{
    public function __invoke(Request $request): Response
    {
        $pathUrl = explode('/', $request->getUri()->getPath());

        $result = $this->userService->update(
            $request->getAttribute('id'),
            json_decode(
                $request->getBody()->getContents(),
                true
            ),
            end($pathUrl)
        );

        return $this->responseHelper->send(
            $result,
            $result['error'] ? ResponseHelper::BAD_REQUEST : ResponseHelper::NO_CONTENT
        );
    }
}