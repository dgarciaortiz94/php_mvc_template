<?php

namespace Controllers;

use Framework\Authentication\Auth;
use Framework\Core\Controller;
use Framework\Http\Requests\Request;

class RegisterController extends Controller
{

    public function index()
    {
        if (isset(Auth::$user)) {
            header('location: /perfil');
        }else{
            $this->render("register/register");
        }
    }


    public function register(Request $request)
    {
        $success = Auth::register($request);
    }
}