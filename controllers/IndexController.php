<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Users;

class IndexController extends Controller
{

    public function __construct()
    {

    }


    public function index()
    {
        $user = new Users();

        $this->data["users"] = $user->getAll();
        
        $this->render("index");
    }


    public function prueba(Request $request)
    {
        $user = new Users();

        $this->data["users"] = $user->getById($request->get["id"]);

        $this->render("prueba");
    }
}