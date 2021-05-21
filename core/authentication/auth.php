<?php

namespace Core\Authentication;

use Models\Users;
use Exception;
use Firebase\JWT\JWT;

require_once "config/Sesions.php";

class Auth
{

    private static $timeExpire = TIME_EXPIRE;
    private static $secretKey = SECRET_KEY;
    private static $encrypt = ENCRYPT;


    public static function logIn(string $username, string $pass)
    {
        $userObject = new Users;
        $users = $userObject->getByQuery("SELECT * FROM users WHERE username = '$username' AND pass = '$pass'");

        if (count($users) == 1 && $users[0]->role == 1){
            $user = $users[0];

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

            $_SESSION['token'] = $token;

            return true;
        }else{
            return false;
        }
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