<?php

namespace Core\Middlewares;

use Core\Routes\Routes;

class Middlewares
{
    private $route;
    private $userProperty;
    private $value;

    public static $middlewares;


    public function __construct(string $route, string $userProperty, array $value)
    {
        $this->route = $route;
        $this->userProperty = $userProperty;
        $this->value = $value;

        self::$middlewares[$route] = [$userProperty => $value];
    }

}