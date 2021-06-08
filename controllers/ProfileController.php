<?php

namespace Controllers;

use Framework\Authentication\Auth;
use Framework\Core\Controller;
use Framework\Forms\Validations\Validations;
use Framework\Http\Requests\Request;
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

        $successValidateForm = Validations::validateRegister($request->post, $email);

        if ($successValidateForm === "empty fields") $response = ["status" => false, "response" => "Hay campos vacíos"];
        else if ($successValidateForm === "wrong email") $response = ["status" => false, "response" => "El email no tiene un formato correcto"];
        else {
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

                $response = ["status" => true, "response" => "Success"];
            }else{
                die(header("HTTP/1.1 515 The user could not be saved"));
            }
        }

        echo json_encode($response);
    }


    public function updatePass(Request $request)
    {
        $userData = Auth::GetData($_SESSION['token']);

        $id = $userData->id;
        $lastPass = $request->post['lastPass'];
        $newPass = $request->post['newPass'];
        $repeatNewPass = $request->post['repeatNewPass'];

        $successValidateForm = Validations::dataIsEmpty($request->post);

        if ($successValidateForm) {
            $userObject = new Users();
            $user = $userObject->getById($id);
    
            $passwordIsSame = password_verify($lastPass, $user->pass);
    
            if ($passwordIsSame) {
                $newUserObject = new Users();
                $newUser = $newUserObject->constructUser("", "", "", "", password_hash($newPass, PASSWORD_DEFAULT));
    
                $success = $newUser->updatePass($id);
    
                if ($success) {
                    $response = ["status" => true, "response" => "Success"];

                    if ($newPass !== $repeatNewPass) {
                        $response = ["status" => false, "response" => "Las contraseñas no coinciden"];
                    }else{
                        if ($lastPass === $newPass) {
                            $response = ["status" => false, "response" => "La contraseña antigua y nueva es la misma"];
                        }
                    }
                }else{
                    die(header("HTTP/1.1 516 The password could not be saved"));
                }
            }else{
                $response = ["status" => false, "response" => "La contraseña antigua no es correcta"];
            }   
        }else{
            $response = ["status" => false, "response" => "Hay campos vacíos"];
        }

        echo json_encode($response);
    }

}