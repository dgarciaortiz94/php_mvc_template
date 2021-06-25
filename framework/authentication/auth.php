<?php

namespace Framework\Authentication;

use Framework\Http\Requests\Request;
use Framework\Forms\Validations\Validations;
use Models\Users;

class Auth
{
    public static $user;


    public static function logIn(Request $request)
    {
        $username = $request->post['username'];
        $pass = $request->post['pass'];

        $loginIsCorrect = Validations::validateLogin(array($username, $pass));

        if (!$loginIsCorrect) $response = ["status" => false, "response" => "Hay campos vacíos"];
        else{
            if (isset($request->post['remember'])) $rememberUser = $request->post['remember'];

            $userObject = new Users;
            $users = $userObject->getByQuery("SELECT * FROM users WHERE username = '$username'");

            if (count($users) == 1){
                $user = $users[0];

                if (password_verify($pass, $user->pass)) {
                    Token::createToken($user);
                    self::setAuth($user);

                    if (isset($rememberUser)) setcookie("session", json_encode(self::$user), TIME_EXPIRE, "/");

                    $response = ["status" => true, "response" => "Success"];
                }else{
                    $response = ["status" => false, "response" => "Usuario o contraseña incorrectos"];
                }
            }else{
                $response = ["status" => false, "response" => "Usuario o contraseña incorrectos"];
            }
        }

        echo json_encode($response);
    }



    public static function register(Request $request)
    {
        $username = $request->post['username'];
        $pass = $request->post['pass'];
        $firstname = $request->post['firstname'];
        $lastname = $request->post['lastname'];
        $email = $request->post['email'];
        $repeatPass = $request->post['repeatPass'];

        if ($pass !== $repeatPass) $response = ["status" => false, "response" => "Las contraseñas deben coincidir"];
        else {
            $dataArray = array($username, $pass, $firstname, $lastname, $email, $repeatPass);

            $registerIsCorrect = Validations::validateRegister($dataArray, $email);

            if ($registerIsCorrect === "empty fields") $response = ["status" => false, "response" => "Hay campos vacíos"];
            else if ($registerIsCorrect === "wrong email") $response = ["status" => false, "response" => "El email no tiene un formato correcto"];
            else {
                $pass = password_hash($pass, PASSWORD_DEFAULT);

                $userObject = new Users;
                $users = $userObject->getByColumn("username", $username);

                if (count($users) == 0){
                    $user = $userObject->constructUser($username, $firstname, $lastname, $email, $pass);

                    $success = $user->insertUser();

                    if ($success) {
                        $registeredUser = $userObject->getByColumn("username", $username)[0];

                        Token::createToken($registeredUser);
                        Auth::setAuth($registeredUser);

                        $response = ["status" => true, "response" => "Success"];
                    }else{
                        die(header("HTTP/1.1 515 The user could not be saved"));
                    }
                }else{
                    $response = ["status" => false, "response" => "El usuario ya existe"];
                }
            }
        }


        echo json_encode($response);
    }



    public static function setAuth($user)
    {
        self::$user = $user;

        $_SESSION["auth"] = self::$user;

        if (isset($_COOKIE['session'])) setcookie("session", json_encode(self::$user), TIME_EXPIRE, "/");
    }
}