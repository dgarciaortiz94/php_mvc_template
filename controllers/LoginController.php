<?php

namespace Controllers;

use Core\Authentication\Auth;
use Core\Controller;
use Core\Request;

class LoginController extends Controller
{

    public function index()
    {
        if (isset($_SESSION['token'])) {
            header('location: /');
        }else{
            $this->render("login/login");
        }
    }


    public function login(Request $request)
    {
        $success = Auth::logIn($request);
    }
}