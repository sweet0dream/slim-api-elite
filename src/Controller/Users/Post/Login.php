<?php

namespace App\Controller\Users\Post;

use App\Controller\Abstract\UsersAbstract;
use App\Helper\ResponseHelper;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class Login extends UsersAbstract
{
    public function __invoke(Request $request): Response
    {
        $hash = $this->userService->login(
            json_decode(
                $request->getBody()->getContents(),
                true
            )
        );

        return $this->responseHelper->send(
            $hash ?? ['message' => 'Login or password incorrect'],
            is_null($hash) ? ResponseHelper::NOT_FOUND : ResponseHelper::OK
        );
    }
}