<?php

namespace Core;

require "View.php";

class Controller
{
    public $data;

    protected function render(string $view)
    {   
        $viewObject = new View();

        if (isset($this->data)) {
            $viewObject->returnView($view, $this->data);
        }else{
            $viewObject->returnView($view);
        }
    }

}