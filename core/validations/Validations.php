<?php

namespace Core\Validations;

class Validations
{

    public static function validateLogin($data)
    {
        $dataIsEmpty = self::dataIsEmpty($data);

        if (!$dataIsEmpty) return false;

        return true;
    }


    public static function validateRegister($data, $email)
    {
        $dataIsEmpty = self::dataIsEmpty($data);

        $emailIsValid = self::validateEmail($email);

        if (!$dataIsEmpty) {
            return "empty fields";
        }

        if (!$emailIsValid) {
            return "email not valid";
        }

        return true;
    }


    public static function dataIsEmpty(array $data)
    {
        foreach ($data as $key) {
            if (empty($key) || $key == " ") {
                return false;
            }
        }

        return true;
    }


    public static function validateEmail(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;

        return true;
    }

}