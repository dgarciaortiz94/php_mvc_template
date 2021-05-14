<?php

namespace Controllers;

use Core\Controller;
use Models\Users;
use Helpers\Request;

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