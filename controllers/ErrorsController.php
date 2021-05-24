<?php

namespace Controllers;

use Core\Authentication\Auth;
use Core\Controller;
use Core\Request;

class ErrorsController extends Controller
{

    public function __construct()
    {

    }


    public function error404()
    {
        $this->data[""] = "";

        $this->render('errors/404');
    }


    public function index()
    {   
        $this->render("index");
    }


    public function login(Request $request)
    {
        $username = $request->post['username'];
        $pass = $request->post['pass'];

        $success = Auth::logIn($username, $pass);

        if (!$success) {
            die(header("HTTP/1.0 513 Login failure"));;
        }
    }


    public function verToken()
    {
        $this->render('verToken');
    }


    public function prueba()
    {
        echo "Esta es la prueba";
    }
}