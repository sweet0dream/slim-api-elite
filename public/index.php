<?php

use DI\Container;
use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;

require_once dirname(__DIR__) . '/vendor/autoload.php';
(Dotenv\Dotenv::createImmutable(dirname(__DIR__)))->load();
require_once dirname(__DIR__) . '/routes.php';

$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addRoutingMiddleware();
$app
    ->add(new BasePathMiddleware($app))
    ->addErrorMiddleware(
        displayErrorDetails: true,
        logErrors: true,
        logErrorDetails: true
    )
;

foreach (Routes::get() as $method => $data) {
    array_walk($data, function ($action, $url) use ($app, $method) {
        $app->$method($url, $action);
    });
}

$app->run();
