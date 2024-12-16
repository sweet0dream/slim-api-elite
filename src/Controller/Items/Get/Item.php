<?php

namespace App\Controller\Items\Get;

use App\Controller\Abstract\ItemsAbstract;
use App\Helper\ResponseHelper;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class Item extends ItemsAbstract
{
    public function __invoke(Request $request): Response
    {
        $item = $this->itemService->get(
            $request->getAttribute('id')
        );

        return $this->responseHelper->send(
            $item ?? ['message' => 'Item not found'],
            is_null($item) ? ResponseHelper::NOT_FOUND : ResponseHelper::OK
        );
    }
}
