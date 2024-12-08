<?php

namespace App\Controller\Items\Get;

use App\Controller\Abstract\ItemsAbstract;
use Slim\Psr7\Response;

class Ids extends ItemsAbstract
{
    public function __invoke(): Response
    {
        return $this->responseHelper->send(
            $this->itemService->getIds()
        );
    }
}
