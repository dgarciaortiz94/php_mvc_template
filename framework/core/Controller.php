<?php

namespace Framework\Core;

require "View.php";

class Controller
{
    public $data;


    public function __construct()
    {
        $this->data['root'] = ROOT;
    }


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