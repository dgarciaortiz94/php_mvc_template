<?php

namespace Controllers;

use Core\Controller;
use Core\Request;


class IndexController extends Controller
{

    public function index()
    {  
        $this->render("index");
    }
}