<?php

use App\Repository\ItemRepository;
use App\Repository\UserRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;
use App\Model\Db;

require_once __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app
    ->add(new BasePathMiddleware($app))
    ->addErrorMiddleware(true, true, true)
;

$app->get('/users', function (Request $request, Response $response) {
    $response->getBody()->write(json_encode((new UserRepository())->findAll()));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/items', function (Request $request, Response $response) {
    $response->getBody()->write(json_encode([
        'headers' => $request->getHeaders(),
        'items' => (new ItemRepository())->findAll()
    ]));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();