<?php

namespace Core;

use PDO;

class Model
{
    protected $connection;
    private $table;


    public function __construct()
    {
        $this->connection = DbConnection::getConnection();
        $this->table = $this->getClassModel(get_called_class());;
    }


    
    
    public function getAll()
    {
        $sql = "SELECT * FROM $this->table";

        $resulset = $this->connection->query($sql)->fetchAll(PDO::FETCH_OBJ);

        return $resulset;
    }

    
    public function getById(int $id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = ?";

        $statement = $this->connection->prepare($sql);
        
        $statement->execute(array($id));

        $resulset = $statement->fetchAll(PDO::FETCH_OBJ);

        return $resulset[0];
    }


    public function getByColumn(string $column, $value)
    {
        $sql = "SELECT * FROM $this->table WHERE $column = ?";

        $statement = $this->connection->prepare($sql);
        
        $statement->execute(array($value));
        
        $resulset = $statement->fetchAll(PDO::FETCH_OBJ);

        return $resulset;
    }


    public function getByQuery(string $query)
    {
        $sql = $query;

        $resulset = $this->connection->query($sql)->fetchAll(PDO::FETCH_OBJ);

        return $resulset;
    }


    public function updateById(int $id, string $column, $value)
    {
        $sql = "UPDATE $this->table SET $column = ? WHERE id = ?";

        $statement = $this->connection->prepare($sql);
        
        $success = $statement->execute(array($value, $id));

        return $success;
    }


    public function getClassModel(String $class)
    {
        $classExplode = explode("\\", $class);

        $classExplodeLastWord = count($classExplode) - 1;

        $className = $classExplode[$classExplodeLastWord];

        return $className;
    }



    /**
     * Get the value of table
     */ 
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Set the value of table
     *
     * @return  self
     */ 
    public function setTable($table)
    {
        $this->table = $table;

        return $this;
    }
}