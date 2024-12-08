<?php

namespace App\Controller\Items\Get;

use App\Controller\Abstract\ItemsAbstract;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class Items extends ItemsAbstract
{
    public function __invoke(Request $request): Response
    {
        return $this->responseHelper->send(
            $this->itemService->get(
                $request->getAttribute('id')
            )
        );
    }
}
