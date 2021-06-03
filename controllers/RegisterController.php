<?php

namespace Controllers;

use Core\Authentication\Auth;
use Core\Controller;
use Core\Request;

class RegisterController extends Controller
{

    public function index()
    {
        if (isset($_SESSION['token'])) {
            header('location: /');
        }else{
            $this->render("register/register");
        }
    }


    public function register(Request $request)
    {
        $success = Auth::register($request);
    }
}