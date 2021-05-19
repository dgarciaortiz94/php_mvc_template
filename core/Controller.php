<?php

namespace Core;

require "View.php";

class Controller
{
    public $data;

    protected function render(string $view)
    {   
        $viewObject = new View();

        $viewObject->returnView($view, $this->data);
    }

}