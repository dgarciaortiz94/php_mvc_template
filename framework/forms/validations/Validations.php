<?php

namespace Framework\Forms\Validations;

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
            return "wrong email";
        }

        return true;
    }


    public static function dataIsEmpty(array $data)
    {
        foreach ($data as $key) {
            if (empty($key)) {
                return false;
            }
        }

        return true;
    }


    public static function validateEmail(string $email)
    {
        $emailIsValid = filter_var($email, FILTER_VALIDATE_EMAIL);

        return $emailIsValid;
    }

}