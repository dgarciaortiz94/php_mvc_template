<?php

namespace Controllers;

use Core\Authentication\Auth;
use Core\Controller;
use Core\Request;
use Models\Users;

class ProfileController extends Controller
{

    public function index()
    {
        $userData = Auth::GetData($_SESSION['token']);

        $this->data["userData"] = $userData;

        $this->render("profile/personalData/personalData");
    }


    public function security()
    {
        $this->render("profile/security/security");
    }


    public function logOff()
    {
        session_destroy();

        if (isset($_COOKIE['session'])) {
            setcookie('session');
        }

        header("location: /login");
    }


    public function updatePersonalData(Request $request)
    {
        $userData = Auth::GetData($_SESSION['token']);

        $id = $userData->id;
        $username = $request->post['username'];
        $firstname = $request->post['firstname'];
        $lastname = $request->post['lastname'];
        $email = $request->post['email'];

        $userObject = new Users();
        $user = $userObject->constructUser($username, $firstname, $lastname, $email, "");

        $success = $user->updatePersonalData($id);

        if ($success) {
            $myUser = $userObject->getByColumn("id", $id)[0];

            $token = Auth::createToken($myUser);

            $_SESSION['token'] = $token;

            if (isset($_COOKIE['session'])) {
                $_COOKIE['session'] = $token;
            }

            header("location: /perfil");
        }else{
            return;
        }
        
    }


    public function updatePass(Request $request)
    {
        $userData = Auth::GetData($_SESSION['token']);

        $id = $userData->id;
        $lastPass = $request->post['lastPass'];
        $newPass = $request->post['newPass'];
        $repeatNewPass = $request->post['repeatNewPass'];

        if ($newPass !== $repeatNewPass) {
            return "Las contraseñas no coinciden";
        }

        $userObject = new Users();
        $user = $userObject->getById($id);

        $passwordIsSame = password_verify($lastPass, $user->pass);

        if ($passwordIsSame) {
            $newUserObject = new Users();
            $newUser = $newUserObject->constructUser("", "", "", "", password_hash($newPass, PASSWORD_DEFAULT));

            $success = $newUser->updatePass($id);

            if ($success) {
                header("location: /perfil");
            }else{
                return "No se pudo actualizar la contraseña";
            }
        }else{
            return "La contraseña antigua es errónea";
        }
    }

}