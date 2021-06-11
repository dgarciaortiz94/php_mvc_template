<?php

namespace Framework\Http\Requests;

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


    public static function setRequest(array $vars)
    {
        $request = new Request();

        $httpMethod = strtolower($_SERVER['REQUEST_METHOD']);

        foreach ($vars as $field => $value) {
            $request->$httpMethod[$field] = $value;
            $request->requestVars[$_SERVER['REQUEST_METHOD']][$field] = $value;
        }

        return $request;
    }


    public function getRequest()
    {
        return $this->requestVars;
    }

}