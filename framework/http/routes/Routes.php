<?php

namespace Framework\Http\Routes;

use Framework\Http\Middlewares\Middlewares;

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
        $startParameterPosition = strpos($route, "{");
        $finishParameterPosition = strpos($route, "}");

        $substringLenght = $finishParameterPosition - $startParameterPosition;

        $parameterName = substr($route, $startParameterPosition, $substringLenght);

        $parameterValue = substr($_SERVER['REQUEST_URI'], $startParameterPosition, $substringLenght);

        $$parameterName = $parameterValue;

        self::$GET[$route] = ["controllerAndFunction" => $controllerAndFunction]; //   /usuario/12 = UserController.getUser, [12 => id]

        return new Routes($route);
    }


    public static function POST(string $route, string $controllerAndFunction)
    {
        self::$POST[$route] = ["controllerAndFunction" => $controllerAndFunction];

        return new Routes($route);
    }


    public static function PUT(string $route, string $controllerAndFunction)
    {
        self::$PUT[$route] = ["controllerAndFunction" => $controllerAndFunction];

        return new Routes($route);
    }


    public static function PATCH(string $route, string $controllerAndFunction)
    {
        self::$PATCH[$route] = ["controllerAndFunction" => $controllerAndFunction];

        return new Routes($route);
    }


    public static function DELETE(string $route, string $controllerAndFunction)
    {
        self::$DELETE[$route] = ["controllerAndFunction" => $controllerAndFunction];

        return new Routes($route);
    }




    public function middleware(string $userProperty, array $value)
    {
        $middleware = new Middlewares($this->route, $userProperty, $value);
    }

}