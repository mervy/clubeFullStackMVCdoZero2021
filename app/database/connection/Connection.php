<?php

namespace Mervy\ActiveRecord\database\connection;

use PDO;
use PDOException;

class Connection
{
    private static $pdo = null;

    public static function connect()
    {
        try {
            if (!static::$pdo) {
                static::$pdo = new PDO("mysql:host=localhost;dbname=_mvc2021", "root", "", [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ]);
            }

            return static::$pdo;
            
        } catch (PDOException $th) {
            var_dump($th->getMessage());
        }
    }
}
