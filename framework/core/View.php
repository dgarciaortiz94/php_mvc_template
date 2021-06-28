<?php

namespace Framework\Core;

use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;
use Twig\TwigFunction;

Class View
{

    public function __construct()
    {
        $this->loadJquery();
        $this->loadBootstrap();
        $this->loadFontAwesome();
    }

    
    
    public function returnView(string $view, $vars = null)
    {
        $loader = new FilesystemLoader('../views');
        $twig = new Environment($loader, [
            'debug' => true
        ]);

        $cssFunction = new TwigFunction("css", function(string $patch){
            return ROOT . "//css/" . $patch . ".css";
        });

        $jsFunction = new TwigFunction("js", function(string $patch){
            return ROOT . "//js/" . $patch . ".js";
        });

        $imageFunction = new TwigFunction("images", function(string $patch){
            return ROOT . "//images/" . $patch;
        });


        $twig->addFunction($cssFunction);
        $twig->addFunction($jsFunction);
        $twig->addFunction($imageFunction);


        if ($vars == NULL) {
            echo $twig->render($view . ".php");
        }else{
            echo $twig->render($view . ".php", $vars);
        }
    }


    private function loadJquery()
    {
        echo 
        "<!-- Load Jquery -->
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>";
    }


    private function loadBootstrap()
    {
        echo 
        "<!-- Load Bootstrap -->
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css'>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js'></script>";
    }

    private function loadFontAwesome()
    {
        echo 
        "<!-- Load fontawesome -->
        <script defer src='/node_modules/@fortawesome/fontawesome-free/js/brands.js'></script>
        <script defer src='/node_modules/@fortawesome/fontawesome-free/js/solid.js'></script>
        <script defer src='/node_modules/@fortawesome/fontawesome-free/js/fontawesome.js'></script>";
    }

}