<?php

namespace Framework\Authentication;

use Framework\Http\Requests\Request;
use Framework\Forms\Validations\Validations;
use Models\Users;
use Exception;
use Firebase\JWT\JWT;

require_once "config/Sesions.php";

class Auth
{
    private static $timeExpire = TIME_EXPIRE;
    private static $secretKey = SECRET_KEY;
    private static $encrypt = ENCRYPT;


    public static function logIn(Request $request)
    {
        $username = $request->post['username'];
        $pass = $request->post['pass'];

        $loginIsCorrect = Validations::validateLogin(array($username, $pass));

        if (!$loginIsCorrect) $response = ["status" => false, "response" => "Hay campos vacíos"];
        else{
            if (isset($request->post['remember'])) {
                $rememberUser = $request->post['remember'];
            }

            $userObject = new Users;
            $users = $userObject->getByQuery("SELECT * FROM users WHERE username = '$username'");

            if (count($users) == 1){
                $user = $users[0];

                if (password_verify($pass, $user->pass)) {
                    $token = self::createToken($user);

                    $_SESSION['token'] = $token;

                    if (isset($rememberUser)) {
                        $_COOKIE['session'] = $token;
                    }

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
                    }else{
                        die(header("HTTP/1.1 515 The user could not be saved"));
                    }

                    $token = self::createToken($registeredUser);

                    if (isset($token)) {
                        $_SESSION['token'] = $token;

                        if (isset($$rememberUser)) {
                            $_COOKIE['session'] = $token;
                        }

                        $response = ["status" => true, "response" => "Success"];
                    }else{
                        die(header("HTTP/1.1 516 The token could not be updated"));
                    }

                }else{
                    $response = ["status" => false, "response" => "El usuario ya existe"];
                }
            }
        }


        echo json_encode($response);
    }


    public static function createToken($user)
    {
        $dataToken = array(
            'exp' => self::$timeExpire,
            'aud' => self::Aud(),
            'data' => [
                'id' => $user->id,
                'username' => $user->username,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'email' => $user->email,
                'date_register' => $user->date_register,
                'role' => $user->role,
            ]
        );

        $token = JWT::encode($dataToken, self::$secretKey);

        return $token;
    }


    public static function Check($token)
    {
        if(empty($token))
        {
            throw new Exception("Invalid token supplied.");
        }

        $decode = JWT::decode(
            $token,
            self::$secretKey,
            self::$encrypt
        );

        if($decode->aud !== self::Aud())
        {
            throw new Exception("Invalid user logged in.");
        }
    }


    public static function GetData($token)
    {
        return JWT::decode(
            $token,
            self::$secretKey,
            self::$encrypt
        )->data;
    }


    private static function Aud()
    {
        $aud = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }

        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();

        return sha1($aud);
    }

}