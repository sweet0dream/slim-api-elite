<?php

use App\Controller\City\Get\Main as GetCity;
use App\Controller\Items\Get\Reviews as GetItemReviews;
use App\Controller\Items\Get\Ids as GetIds;
use App\Controller\Items\Get\Item as GetItem;
use App\Controller\Items\Get\Field as GetField;
use App\Controller\Users\Get\User as GetUser;
use App\Controller\Users\Post\Login as LoginUser;
use App\Controller\Users\Post\Regin as ReginUser;
use App\Controller\Users\Put\Update as UpdateUser;
use App\Controller\Users\Delete\Remove as RemoveUser;
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
        '/city' => GetCity::class,
        '/items/ids' => GetIds::class,
        '/item/{id:[0-9]+}' => GetItem::class,
        '/item/{id:[0-9]+}/reviews' => GetItemReviews::class,
        '/item/field/{type}' => GetField::class,
        '/user/{id:[0-9]+}' => GetUser::class
    ],
    'post' => [
        '/user/login' => LoginUser::class,
        '/user/regin' => ReginUser::class
    ],
    'put' => [
        '/user/{id:[0-9]+}/password' => UpdateUser::class,
        '/user/{id:[0-9]+}/phone' => UpdateUser::class
    ],
    'delete' => [
        '/user/{id:[0-9]+}' => RemoveUser::class
    ]
];

if (is_null($city)) {
    $method = strtolower($_SERVER['REQUEST_METHOD']);
    $app->$method($_SERVER['REQUEST_URI'], function (Request $request, Response $response) {
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
