<?php

use App\Controller\Customer\GetCustomerById;
use App\Controller\Order\{GetOrderById, GetOrdersByCustomerId, GetOrdersByOrderExecutor, PostFindOrdersByCriteria};

final class Routes
{
    private const array GET = [
        '/order/{id:[0-9]+}' => GetOrderById::class,
        '/customer/{id:[0-9]+}' => GetCustomerById::class
    ];
    private const array POST = [
        '/orders' => PostFindOrdersByCriteria::class,
    ];
    private const array PATCH = [];
    private const array DELETE = [];
    private const array AVAILABLE_ROUTES = [
        'get' => self::GET,
        'post' => self::POST,
        'patch' => self::PATCH,
        'delete' => self::DELETE
    ];

    public static function get(): array
    {
        return self::AVAILABLE_ROUTES;
    }
}