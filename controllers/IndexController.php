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

        $success = Auth::logIn($username, $pass);

        if (!$success) {
            die(header("HTTP/1.0 513 Login failure"));;
        }
    }


    public function verToken()
    {
        $this->render('verToken');
    }
}