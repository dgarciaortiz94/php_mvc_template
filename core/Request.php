<?php

namespace Core;

class Request
{
    private $request;
    private $requestVars;

    public function __construct()
    {
        if (count($_POST) > 0) {
            $this->request = $_POST;
            $this->requestVars = array("type" => "POST");

            foreach ($this->request as $field => $value) {
                $this->post[$field] = $value;
                $this->requestVars["POST"][$field] = $value;
            }
        }
        elseif (count($_GET) > 0) {
            $this->request = $_GET;
            $this->requestVars = array("type" => "GET");

            foreach ($this->request as $field => $value) {     
                if ($field == "class" || $field == "function") {
                    continue;
                }

                $this->get[$field] = $value;
                $this->requestVars["GET"][$field] = $value;
            }
        }
    }


    public function getRequest()
    {
        return $this->requestVars;
    }

}