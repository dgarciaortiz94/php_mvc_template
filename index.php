<!-- Load Jquery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Load Bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

<?php
session_start();

require_once "vendor/autoload.php";
require_once "config/Base.php";

use Controllers\ErrorController;
use Controllers\IndexController;
use Controllers\LoginController;
use Core\Authentication\Auth;
use Core\Request;
use Firebase\JWT\ExpiredException;
use Models\Status;

$uri = $_SERVER['REQUEST_URI'];

$routes = json_decode(file_get_contents("core/routes.json"), true);

if (isset($routes[$uri])) {
    $classAndFunction = explode(".", $routes[$uri]);

    $namespaceClass = "Controllers\\" . $classAndFunction[0];

    $class = new $namespaceClass;
    $function = $classAndFunction[1];
}else{
    $error = new Status(404, "Not found", "No se pudo encontrar el recurso solicitado");
    return $error->redirectToErrorView();
}


if (!isset($_SESSION['token'])) {
    if (isset($_COOKIE['session'])) {
        $_SESSION['token'] = $_COOKIE['session'];
    }
}


$file = json_decode(file_get_contents("middlewares/middlewares.json"), true);

if (isset($_SESSION['token'])) {
    try{
        $dataUser = Auth::GetData($_SESSION['token']);
    }catch(ExpiredException $e){
        session_destroy();
        header("location: /login");
    }

    
    foreach ($file as $key => $value) 
    {
        if ($uri == $key && $dataUser->role != $value) {
            $error = new Status(403, "Forbidden", "No posees los permisos requeridos para acceder a este apartado");
            return $error->redirectToErrorView();
        }
    }
}else{
    foreach ($file as $key => $value) 
    {
        if ($uri == $key) {
            $error = new Status(401, "Unauthorized", "Necesitas estar logueado para acceder a este apartado");
            return $error->redirectToErrorView();
        }
    }
}

$request = new Request();

$class->$function($request);
