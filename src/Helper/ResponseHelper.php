<?php

namespace App\Helper;

use Slim\Psr7\Response;

class ResponseHelper
{
    const int NOT_FOUND = 404;
    const int OK = 200;
    const int CREATED = 201;
    const int NO_CONTENT = 204;
    const int BAD_REQUEST = 400;
    const int SERVER_ERROR = 500;

    public function __construct(
        private readonly Response $response
    ) {
    }

    public function send(
        array $content,
        ?int $code = self::OK
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
            ->withStatus($code)
            ->withHeader('Content-Type', 'application/json')
        ;
    }

    public function fail(
        string $message,
        ?int $code
    ): Response
    {
        return $this->send([
            'message' => $message,
        ], $code !== 0 ? $code : self::SERVER_ERROR);
    }
}