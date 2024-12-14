<?php

use parisecran\DBAL\Connector;
use parisecran\Entity\Subscribers;

session_start();

require_once __DIR__ . "/../../../vendor/autoload.php";

$dbh = new Connector();
$subscribersModel = new Subscribers($dbh->dbConnector);

if (!empty($_SESSION['id'])) {
    $subscribersModel->logoutSubcriber();
}else {
    header("Location: ../film/index-film.php");
}

