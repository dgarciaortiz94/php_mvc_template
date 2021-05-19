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

        return $resulset;
    }


    public function getByColumn(string $column, $value)
    {
        $sql = "SELECT * FROM $this->table WHERE ? = ?";

        $statement = $this->connection->prepare($sql);
        
        $resulset = $statement->execute(array($column, $value))->fetchAll(PDO::FETCH_OBJ);

        return $resulset;
    }


    public function getByQuery(string $query)
    {
        $sql = $query;

        $resulset = $this->connection->query($sql)->fetchAll(PDO::FETCH_OBJ);

        return $resulset;
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