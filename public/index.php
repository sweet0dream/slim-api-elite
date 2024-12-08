<?php

use App\Controller\City\Get\CityController;
use App\Controller\Items\Get\ItemReviewsController;
use App\Controller\Items\Get\ItemsIdsController;
use App\Controller\Items\Get\ItemController;
use App\Helper\ResponseHelper;
use App\Service\CityService;
use DI\Container;
use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;
use Slim\Psr7\Request as Request;
use Slim\Psr7\Response as Response;

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

$city = $app->getContainer()->get('city');

$route = [
    'get' => [
        '/city' => CityController::class,
        '/items/ids' => ItemsIdsController::class,
        '/item/{id:[0-9]+}' => ItemController::class,
        '/item/{id:[0-9]+}/reviews' => ItemReviewsController::class
    ],
    'post' => []
];

if (is_null($city)) {
    $app->get($_SERVER['REQUEST_URI'], function (Request $request, Response $response) {
        return (new ResponseHelper($response))->send(
            ['message' => 'Domain is undefined'],
            ResponseHelper::NOT_FOUND
        );
    });
} else {
    foreach ($route as $method => $data) {
        array_walk($data, function ($action, $url) use ($app, $method) {
            $app->$method($url, $action);
        });
    }
}

$app->run();
