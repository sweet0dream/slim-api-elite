<?php

use App\Helper\ResponseHelper;
use App\Service\CityService;
use App\Service\ItemService;
use App\Service\UserService;
use DI\Container;
use Slim\Psr7\Response as Response;
use Slim\Psr7\Request as Request;
use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

(Dotenv\Dotenv::createImmutable(__DIR__ . '/../'))->load();

$container = new Container();
$container->set('city', function () {
    return isset($_SERVER['HTTP_DOMAIN']) ? (new CityService($_SERVER['HTTP_DOMAIN']))->getCity() : null;
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
        return (new ResponseHelper($response))->send(
            ['message' => 'City not found'],
            ResponseHelper::NOT_FOUND
        );
    });
} else {
    $app->get('/city', function (Request $request, Response $response) {
        return (new ResponseHelper($response))->send(
            $this->get('city')
        );
    });

    $app->get('/users', function (Request $request, Response $response) {
        return (new ResponseHelper($response))->send(
            (new UserService($this->get('city')))->all()
        );
    });

    $app->get('/user/{id}', function (Request $request, Response $response, array $args) {
        return (new ResponseHelper($response))->send(
            (new UserService($this->get('city')))->get($args['id'])
        );
    });

    $app->get('/items/ids', function (Request $request, Response $response) {
        return (new ResponseHelper($response))->send(
            (new ItemService($this->get('city')))->getIdsActive()
        );
    });

    $app->get('/item/{id}', function (Request $request, Response $response, array $args) {
        $itemService = new ItemService($this->get('city'));
        return (new ResponseHelper($response))->send(
            $itemService->get($args['id'])
        );
    });

    $app->get('/item/{id}/reviews', function (Request $request, Response $response, array $args) {
        $itemService = new ItemService($this->get('city'));
        return (new ResponseHelper($response))->send(
            $itemService->getReviews($args['id'])
        );
    });
}

$app->run();
