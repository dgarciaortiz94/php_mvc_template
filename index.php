<?php
session_start();

require_once "vendor/autoload.php";

use Controllers\IndexController;
use Core\Authentication\Auth;
use Core\Request;


if (isset($_REQUEST['class'])) {
    $namespaceClass = "Controllers\\" . $_REQUEST["class"];
    $class = new $namespaceClass();
}else{
    $class = new IndexController();
}

$function = isset($_REQUEST["function"]) ? $_REQUEST["function"] : "index";

$namespaceClass = explode("\\", get_class($class));  //EXTRACT CLASS NAME WITHOUT NAMESPACE, ONLY CLASS NAME
$className = array_pop($namespaceClass);

$file = json_decode(file_get_contents("middlewares/middlewares.json"), true);

if (isset($_SESSION['token'])) {
    $dataUser = Auth::GetData($_SESSION['token']);

    foreach ($file as $key => $value) 
    {
        $functionAndClass = explode(".", $key);
        $middlewareClass = $functionAndClass[0];
        $middlewareFunction = $functionAndClass[1];

        if ($className == $middlewareClass && $function == $middlewareFunction && $dataUser->role != $value) {
            die(header('HTTP/1.1 512 Access not allowed for your user'));
        }
    }
}else{
    foreach ($file as $key => $value) 
    {
        $functionAndClass = explode(".", $key);
        $middlewareClass = $functionAndClass[0];
        $middlewareFunction = $functionAndClass[1];

        if ($className == $middlewareClass && $function == $middlewareFunction) {
            die(header('HTTP/1.1 512 Access not allowed for your user'));
        }
    }
}

$request = new Request();

$class->$function($request);
