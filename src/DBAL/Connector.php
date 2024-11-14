<?php

namespace Steph\parisecran\DBAL;

class Connector
{
    // const DSN = "mysql:dbname=parisecran;host=localhost";
    const DSN = "mysql:dbname=spectacledb;host=localhost";

    public \PDO $dbConnector;

    public function __construct()
    {
       $this->dbConnector = new \PDO(self::DSN, 'root', '');
    }
}
