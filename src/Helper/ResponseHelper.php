<?php

namespace App\Helper;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ResponseHelper
{
    const int NOT_FOUND = 404;
    const int OK = 200;

    public function __construct(
        private readonly Response $response
    ) { }

    public function send(
        array $content,
        ?int $statusCode = self::OK
    ): Response
    {
        $this
            ->response
            ->getBody()
            ->write(
                json_encode($content)
            )
        ;

        return $this
            ->response
            ->withStatus($statusCode)
            ->withHeader('Content-Type', 'application/json')
        ;
    }
}