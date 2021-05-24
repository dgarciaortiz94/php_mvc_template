<?php
session_start();

require_once "vendor/autoload.php";

use Controllers\ErrorsController;
use Controllers\IndexController;
use Core\Authentication\Auth;
use Core\Request;


$uri = $_SERVER['REQUEST_URI'];

$routes = json_decode(file_get_contents("core/routes.json"), true);

if (isset($routes[$uri])) {
    $classAndFunction = explode(".", $routes[$uri]);

    $namespaceClass = "Controllers\\" . $classAndFunction[0];

    $class = new $namespaceClass;
    $function = $classAndFunction[1];
}else{
    $class = new ErrorsController();
    $function = "error404";
}


$file = json_decode(file_get_contents("middlewares/middlewares.json"), true);

if (isset($_SESSION['token'])) {
    $dataUser = Auth::GetData($_SESSION['token']);

    foreach ($file as $key => $value) 
    {
        if ($uri == $key && $dataUser->role != $value) {
            die(header('HTTP/1.1 512 Access not allowed for your user'));
        }
    }
}else{
    foreach ($file as $key => $value) 
    {
        if ($uri == $key) {
            die(header('HTTP/1.1 512 Access not allowed for your user'));
        }
    }
}

$request = new Request();

$class->$function($request);
