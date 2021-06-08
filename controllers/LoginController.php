<?php

namespace Controllers;

use Framework\Authentication\Auth;
use Framework\Core\Controller;
use Framework\Http\Requests\Request;

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