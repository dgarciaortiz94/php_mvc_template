<?php

namespace Models;

use Framework\Core\Model;
use PDO;

class Users extends Model
{

    private $username, $firstname, $lastname, $email;
    private $date_register, $last_connection;
    private $status;
    private $token;
    private $role;
    private $pass;


    public function __construct()
    {
        parent::__construct();
    }


    public function constructUser(string $username, string $firstname, string $lastname, string $email, string $pass)
    {
        $user = new Users();

        $user->username = $username;
        $user->firstname = $firstname;
        $user->lastname = $lastname;
        $user->email = $email;
        $user->pass = $pass;

        return $user;
    }



    public function getById(int $id)
    {
        $sql = "SELECT id, username, firstname, lastname, email, profile_picture, status, role FROM $this->table WHERE id = ?";

        $statement = $this->connection->prepare($sql);
        
        $statement->execute(array($id));

        $resulset = $statement->fetchAll(PDO::FETCH_OBJ);

        return $resulset[0];
    }
  

    public function insertUser()
    {
        $sql = "INSERT INTO users(username, firstname, lastname, email, profile_picture, pass, date_register, last_connection, status, role) 
                VALUES(?, ?, ?, ?, 'image-profile-default.jpg', ?, SYSDATE(), SYSDATE(), '1', 3)";

        $statement = $this->connection->prepare($sql);
        
        $success = $statement->execute(array($this->username, $this->firstname, $this->lastname, $this->email, $this->pass));

        return $success;
    }


    public function updatePersonalData(int $id)
    {
        $sql = "UPDATE users SET username = ?, firstname = ?, lastname = ?, email = ? WHERE id = ?";

        $statement = $this->connection->prepare($sql);
        
        $success = $statement->execute(array($this->username, $this->firstname, $this->lastname, $this->email, $id));

        return $success;
    }


    public function updatePass(int $id)
    {
        $sql = "UPDATE users SET pass = ? WHERE id = ?";

        $statement = $this->connection->prepare($sql);
        
        $success = $statement->execute(array($this->pass, $id));

        return $success;
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