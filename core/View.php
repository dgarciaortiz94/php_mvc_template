<?php

namespace Core;

use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;

Class View
{

    public function __construct()
    {
        $this->loadJquery();
        $this->loadBootstrap();
    }

    
    
    public function returnView(string $view, $vars = null)
    {
        /*
        if (isset($vars)) {
            foreach ($vars as $key => $value) {
                $$key = $value;
            }
        }

        require "views/$view.php";
        */

        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader, [
            'debug' => true
        ]);

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

}