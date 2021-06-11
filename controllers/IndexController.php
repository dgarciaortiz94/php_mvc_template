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


    public function prueba(Request $request)
    {
        echo "El nombre del usuario es: " . $request->get["name"];
    }

}