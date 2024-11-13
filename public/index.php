<?php

use App\Repository\ItemRepository;
use App\Repository\UserRepository;
use App\Service\ItemService;
use App\Service\UserService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app
    ->add(new BasePathMiddleware($app))
    ->addErrorMiddleware(true, true, true)
;

$app->get('/users', function (Request $request, Response $response) {
    $response->getBody()->write(json_encode((new UserService())->all()));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/user/{id}', function (Request $request, Response $response, array $args) {
    $response->getBody()->write(json_encode((new UserService())->get($args['id'])));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/items', function (Request $request, Response $response) {
    $response->getBody()->write(json_encode((new ItemService())->all()));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/item/{id}', function (Request $request, Response $response, array $args) {
    $response->getBody()->write(json_encode((new ItemService())->get($args['id'])));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();