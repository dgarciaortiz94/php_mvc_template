<?php

namespace App;

require_once "vendor/autoload.php";

use App\Controllers\IndexController;
use App\Core\Request;

$class = isset($_GET['class']) ? $class = new $_GET["class"]() : $class = new IndexController();

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
