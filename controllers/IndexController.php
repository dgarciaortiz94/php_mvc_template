<?php

namespace Controllers;

use Framework\Core\Controller;
use Framework\Http\Requests\Request;

class IndexController extends Controller
{

    public function index()
    {  
        $this->data["prueba"] = "miprueba";

        $this->render("index");
    }

}