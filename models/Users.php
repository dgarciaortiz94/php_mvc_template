<?php

namespace Models;

use Core\Model;

class Users extends Model
{

    private $username, $firstname, $lastname;
    private $date_register, $last_connection;
    private $status;
    private $token;
    private $role;


    public function __construct()
    {
        parent::__construct();
    }
  


    /**
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of firstname
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */ 
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */ 
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of date_register
     */ 
    public function getDate_register()
    {
        return $this->date_register;
    }

    /**
     * Set the value of date_register
     *
     * @return  self
     */ 
    public function setDate_register($date_register)
    {
        $this->date_register = $date_register;

        return $this;
    }

    /**
     * Get the value of last_connection
     */ 
    public function getLast_connection()
    {
        return $this->last_connection;
    }

    /**
     * Set the value of last_connection
     *
     * @return  self
     */ 
    public function setLast_connection($last_connection)
    {
        $this->last_connection = $last_connection;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of token
     */ 
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */ 
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }
}