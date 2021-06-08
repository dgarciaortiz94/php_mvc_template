<?php

namespace Framework\Core;

use PDO;
use PDOException;

require "config/Database.php";

class DbConnection extends PDO
{

    private static $connection;


    private function __construct()
    {
        try {
            self::$connection = parent::__construct(DATABASE . ":dbname=" . DBNAME . ";host=" . HOST, USER, PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
        } catch (PDOException $e) {
            echo 'Falló la conexión a la base de datos: ' . $e->getMessage();
        }
    }


    public static function getConnection()
    {
        if (!isset(self::$connection)) {
            self::$connection = new self();
        }

        return self::$connection;
    }

}