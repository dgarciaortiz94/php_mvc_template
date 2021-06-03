<?php

namespace Models;

use Controllers\StatusController;

class Status
{
    private $status;
    private $statusText;
    private $errorMessage;


    public function __construct(int $status, string $statusText, string $errorMessage = "")
    {   
        $this->status = $status;
        $this->statusText = $statusText;
        $this->errorMessage = $errorMessage;

        header("HTTP/1.1 " . $status . " " . $statusText, $status);
    }


    public function redirectToErrorView()
    {
        $StatusController = new StatusController($this);

        $StatusController->index();
    }


    public function returnJson()
    {
        $error = array(
            "status" => $this->status,
            "statusText" => $this->statusText,
            "errorMessage" => $this->errorMessage
        );

        return json_encode($error);
    }


    
    

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the value of statusText
     */ 
    public function getStatusText()
    {
        return $this->statusText;
    }

    /**
     * Get the value of errorMessage
     */ 
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}