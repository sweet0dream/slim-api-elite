<?php

namespace App\Controller\Items\Get;

use App\Controller\Abstract\ItemAbstract;
use App\Helper\ItemHelper;
use App\Helper\ResponseHelper;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class Field extends ItemAbstract
{
    public function __invoke(Request $request): Response
    {
        $getField = ItemHelper::getField($request->getAttribute('type'));

        return $this->responseHelper->send(
            $getField ?? ['error' => 'Type is unknown'],
            [ResponseHelper::OK, ResponseHelper::NOT_FOUND][(int) is_null($getField)]
        );
    }
}