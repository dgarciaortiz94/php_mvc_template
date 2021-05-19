<?php

namespace Core;

Class View
{
    
    public function returnView(string $view, array $vars = array())
    {
        foreach ($vars as $key => $value) {
            $$key = $value;
        }

        require "views/$view.php";
    }


    public static function include(String $file)
    {
        include_once "views/includes/$file.php";
    }


    public static function require(String $file)
    {
        require_once "views/includes/$file.php";
    }


    public static function css(String $file)
    {
        echo "public/css/$file.css";
    }


    public static function js(String $file)
    {
        echo "public/js/$file.js";
    }


    public static function image(String $file)
    {
        echo "public/js/$file";
    }

}