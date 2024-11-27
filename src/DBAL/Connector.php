<?php

namespace parisecran\DBAL;

use PDO;
use PDOException;

class Connector
{
    private $pdo;

    public function __construct()
    {
        $dsn = 'mysql:host=localhost;dbname=parisecran;charset=utf8mb4';
        $username = 'root';
        $password = '';
        
        $this->pdo = new \PDO($dsn, $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}
