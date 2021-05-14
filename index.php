<?php

require_once "vendor/autoload.php";

use Controllers\IndexController;
use Helpers\Request;

if (isset($_GET["class"])) {
    $namespaceClass = "Controllers\\" . $_GET["class"];
    $class = new $namespaceClass();
}else{
    $class = new IndexController();
}

$function = isset($_GET["function"]) ? $_GET["function"] : "index";

if (count($_POST) > 0) {
    $request = new Request();

    $class->$function($request);
}elseif (count($_GET) > 0) {
    $request = new Request();

    $class->$function($request);
}else{
    $class->$function();
}
