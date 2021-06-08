<?php
session_start();

require_once "vendor/autoload.php";

require_once "config/Base.php";

use Framework\Authentication\Auth;
use Framework\Http\Middlewares\Middlewares;
use Framework\Http\Requests\Request;
use Framework\Http\Routes\Routes;
use Framework\Http\Status\Status;
use Firebase\JWT\ExpiredException;

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

require "routes/web.php";


//Comprobamos si hay cookie de sesion(Permanecer Conectado) y en ese caso se la asignamos a la sesión.
if (!isset($_SESSION['token'])) {
    if (isset($_COOKIE['session'])) {
        $_SESSION['token'] = $_COOKIE['session'];
    }
}


//Sistema de enrutamiento
$routes = Routes::$$method;

if (isset($routes[$uri])) {
    $classAndFunction = explode(".", $routes[$uri]['controllerAndFunction']);

    $namespaceClass = "Controllers\\" . $classAndFunction[0];

    $class = new $namespaceClass;
    $function = $classAndFunction[1];
}else{
    $error = new Status(404, "Not found", "No se pudo encontrar el recurso solicitado");
    return $error->redirectToErrorView();
}


//Comprobamos los middlewares para saber si podemos acceder a la ruta especificada con nuestro usuario.
$middlewares = Middlewares::$middlewares;

if (isset($_SESSION['token'])) {
    try{
        $dataUser = Auth::GetData($_SESSION['token']);
    }catch(ExpiredException $e){
        session_destroy();
        header("location: /login");
    }


    if (isset($middlewares[$uri]) && !in_array($dataUser->role, $middlewares[$uri]['role'])) {
        $error = new Status(403, "Forbidden", "No posees los permisos requeridos para acceder a este apartado");
        return $error->redirectToErrorView();
    }
}else{
    if (isset($middlewares[$uri])) {
        $error = new Status(401, "Unauthorized", "Necesitas estar logueado para acceder a este apartado");
        return $error->redirectToErrorView();
    }
}


$request = new Request();

$class->$function($request);
