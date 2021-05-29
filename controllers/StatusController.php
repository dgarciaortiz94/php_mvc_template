<?php

namespace Controllers;

use Core\Authentication\Auth;
use Core\Controller;
use Core\Request;
use Models\Status;

class StatusController extends Controller
{
    private $status;


    public function __construct(Status $status)
    {
        $this->status = $status;
    }


    public function index()
    {
        $this->data["title"] = $_SERVER['REQUEST_URI'];
        $this->data["errorTitle"] = "Error " . $this->status->getStatus() . ": " . $this->status->getStatusText();
        $this->data["errorMessage"] = $this->status->getErrorMessage();

        $this->render('errors/error');
    }

}