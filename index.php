<?php
session_start();

require_once "vendor/autoload.php";

use Controllers\IndexController;
use Core\Request;


echo $_SERVER['REQUEST_METHOD'] . "<br>";

if (isset($_GET["class"])) {
    $namespaceClass = "Controllers\\" . $_GET["class"];
    $class = new $namespaceClass();
}else{
    $class = new IndexController();
}

$function = isset($_GET["function"]) ? $_GET["function"] : "index";

if (count($_POST) > 0) {
    $request = new Request();

    if (isset($_GET["class"])) {
        $namespaceClass = "Controllers\\" . $_GET["class"];
        $class = new $namespaceClass();

        $function = isset($_GET["function"]) ? $_GET["function"] : "index";
    }else{
        $myClass = $request->post['class'];   
        $namespaceClass = "Controllers\\" . $myClass;
    
        $class = new $namespaceClass;
        $function = $request->post['function'];
    }

    $class->$function($request);
}elseif (count($_GET) > 2 || (!isset($_GET['function']) && count($_GET) > 1) || (!isset($_GET['class']) && !isset($_GET['function']) && count($_GET) > 0)) {
    $request = new Request();

    $class->$function($request);
}else{
    $class->$function();
}
