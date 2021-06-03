<?php

namespace Core\Routes;

use Core\Middlewares\Middlewares;
use Core\Routes\Routes as RoutesRoutes;

class Routes
{
    public static $GET;
    public static $POST;
    public static $PUT;
    public static $PATCH;
    public static $DELETE;

    private $route;

    
    public function __construct(string $route)
    {
        $this->route = $route;
    }




    public static function GET(string $route, string $controllerAndFunction,  array $parameters = NULL)
    {
        self::$GET[$route] = ["controllerAndFunction" => $controllerAndFunction, "parameters" => $parameters]; //   /usuario/12 = UserController.getUser, [12 => id]

        return new RoutesRoutes($route);
    }


    public static function POST(string $route, string $controllerAndFunction)
    {
        self::$POST[$route] = ["controllerAndFunction" => $controllerAndFunction];

        return new RoutesRoutes($route);
    }


    public static function PUT(string $route, string $controllerAndFunction)
    {
        self::$PUT[$route] = ["controllerAndFunction" => $controllerAndFunction];

        return new RoutesRoutes($route);
    }


    public static function PATCH(string $route, string $controllerAndFunction)
    {
        self::$PATCH[$route] = ["controllerAndFunction" => $controllerAndFunction];

        return new RoutesRoutes($route);
    }


    public static function DELETE(string $route, string $controllerAndFunction)
    {
        self::$DELETE[$route] = ["controllerAndFunction" => $controllerAndFunction];

        return new RoutesRoutes($route);
    }




    public function middleware(string $userProperty, array $value)
    {
        $middleware = new Middlewares($this->route, $userProperty, $value);
    }

}