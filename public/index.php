<?php

use App\Service\CityService;
use App\Service\ItemService;
use App\Service\UserService;
use DI\Container;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Slim\Psr7\Response as Response;
use Slim\Psr7\Request as Request;
use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$container = new Container();
$container->set('city', function () {
    return (new CityService($_SERVER['HTTP_DOMAIN']))->getCity();
});
AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addRoutingMiddleware();
$app
    ->add(new BasePathMiddleware($app))
    ->addErrorMiddleware(true, true, true)
;

if (is_null($app->getContainer()->get('city'))) {
    $app->get($_SERVER['REQUEST_URI'], function (Request $request, Response $response) {
        $response->getBody()->write(json_encode(['message' => 'City not found']));

        return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
    });
} else {
    $app->get('/city', function (Request $request, Response $response) {
        $response->getBody()->write(json_encode($this->get('city')));

        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->get('/users', function (Request $request, Response $response) {
        $response->getBody()->write(json_encode((new UserService($this->get('city')['id']))->all()));

        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->get('/user/{id}', function (Request $request, Response $response, array $args) {
        $response->getBody()->write(json_encode((new UserService($this->get('city')['id']))->get($args['id'])));

        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->get('/items', function (Request $request, Response $response) {
        $response->getBody()->write(json_encode((new ItemService($this->get('city')['id']))->all()));

        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->get('/item/{id}', function (Request $request, Response $response, array $args) {
        $response->getBody()->write(json_encode((new ItemService($this->get('city')['id']))->get($args['id'])));

        return $response->withHeader('Content-Type', 'application/json');
    });
}

$app->run();
