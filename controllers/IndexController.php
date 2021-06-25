<?php

namespace Controllers;

use Framework\Authentication\Auth;
use Framework\Core\Controller;

class IndexController extends Controller
{

    public function index()
    {  
        $this->data["prueba"] = "miprueba";

        $this->render("index");
    }

}