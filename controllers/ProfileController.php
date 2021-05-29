<?php

namespace Controllers;

use Core\Authentication\Auth;
use Core\Controller;
use Core\Request;

class ProfileController extends Controller
{

    public function index()
    {
        $userData = Auth::GetData($_SESSION['token']);

        $this->data["userData"] = $userData;

        $this->render("profile/profile");
    }

}