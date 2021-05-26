<?php

namespace Core\Authentication;

use Core\Request;
use Core\Validations\Validations;
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

        if (!$loginIsCorrect) die(header("HTTP/1.0 518 There are empty fields"));

        if (isset($request->post['remember'])) {
            $rememberUser = $request->post['remember'];
        }

        $userObject = new Users;
        $users = $userObject->getByQuery("SELECT * FROM users WHERE username = '$username' AND pass = '$pass'");

        if (count($users) == 1){
            $user = $users[0];

            $token = self::createToken($user);

            $_SESSION['token'] = $token;

            if (isset($$rememberUser)) {
                $_COOKIE['session'] = $token;
            }

            return true;
        }else{
            die(header("HTTP/1.0 513 Incorrect data"));
        }
    }


    public static function register(Request $request)
    {
        $username = $request->post['username'];
        $pass = $request->post['pass'];
        $firstname = $request->post['firstname'];
        $lastname = $request->post['firstname'];
        $email = $request->post['email'];
        $repeatPass = $request->post['repeatPass'];

        $dataArray = array($username, $pass, $firstname, $lastname, $email, $repeatPass);

        $registerIsCorrect = Validations::validateRegister($dataArray, $email);

        if ($registerIsCorrect == "empty fields") die(header("HTTP/1.0 518 There are empty fields"));
        if ($registerIsCorrect == "email not valid") die(header("HTTP/1.0 518 Email not valid"));

        $userObject = new Users;
        $users = $userObject->getByColumn("username", $username);

        if (count($users) == 0){
            $user = $userObject->constructUser($username, $firstname, $lastname, $email, $pass);

            $success = $user->insertUser();

            if ($success) {
                $registeredUser = $userObject->getByColumn("username", $username)[0];
            }else{
                die(header("HTTP/1.0 515 The user could not be saved"));
            }

            $token = self::createToken($registeredUser);

            $success = $user->updateById($registeredUser->id, "token", $token);

            if ($success) {
                $_SESSION['token'] = $token;

                if (isset($$rememberUser)) {
                    $_COOKIE['session'] = $token;
                }

                return true;
            }else{
                die(header("HTTP/1.0 516 The token could not be updated"));
            }

        }else{
            die(header("HTTP/1.0 517 Username exists"));
        }
    }


    private static function createToken(Users $user)
    {
        $dataToken = array(
            'exp' => self::$timeExpire,
            'aud' => self::Aud(),
            'data' => [
                'id' => $user->id,
                'username' => $user->username,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
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