<?php

use App\Controller\CityController;
use App\Controller\ItemsController;
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

$city = $app->getContainer()->get('city');

if (is_null($city)) {
    $app->get($_SERVER['REQUEST_URI'], function (Request $request, Response $response) {
        return (new ResponseHelper($response))->send(
            ['message' => 'Domain is undefined'],
            ResponseHelper::NOT_FOUND
        );
    });
} else {
    $app->get('/city', CityController::class);
    $app->get('/items/ids', ItemsController::class . ':getIds');
    $app->get('/item/{id:[0-9]+}', ItemsController::class . ':getItem');
    $app->get('/item/{id:[0-9]+}/reviews', ItemsController::class . ':getItemReviews');
}

$app->run();
