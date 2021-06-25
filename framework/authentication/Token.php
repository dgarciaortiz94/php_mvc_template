<?php

namespace Framework\Authentication;

use Exception;
use Firebase\JWT\JWT;

require_once "../config/Sesions.php";

class Token
{
    private static $timeExpire = TIME_EXPIRE;
    private static $secretKey = SECRET_KEY;
    private static $encrypt = ENCRYPT;

    public static $token;


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
                'profile_picture' => $user->profile_picture,
                'email' => $user->email,
                'role' => $user->role,
            ]
        );

        $token = JWT::encode($dataToken, self::$secretKey);

        self::$token = $token;
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