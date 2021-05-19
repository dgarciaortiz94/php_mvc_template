<?php

namespace Controllers;

use Core\Authentication\Auth;
use Core\Controller;
use Core\Request;
use Models\Users;

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


    public function login(Request $request)
    {
        $username = $request->post['username'];
        $pass = $request->post['pass'];

        Auth::logIn($username, $pass);
    }


    public function verToken()
    {
        $this->data["h"] = "";

        $this->render('verToken');
    }
}