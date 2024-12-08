<?php

namespace App\Controller\Items\Get;

use App\Controller\Abstract\ItemAbstract;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class Reviews extends ItemAbstract
{
    public function __invoke(Request $request): Response
    {
        return $this->responseHelper->send(
            $this->itemService->getReviews(
                $request->getAttribute('id')
            )
        );
    }
}
