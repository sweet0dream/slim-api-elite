<?php

namespace App\Controller\Items\Get;

use App\Controller\Abstract\ItemAbstract;
use Slim\Psr7\Response;

class Ids extends ItemAbstract
{
    public function __invoke(): Response
    {
        return $this->responseHelper->send(
            $this->itemService->getIds()
        );
    }
}
