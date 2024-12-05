<?php 

use parisecran\Entity\BddGenerate;
use parisecran\DBAL\Connector;

session_start();

require_once __DIR__ . "/../../../vendor/autoload.php";

$dbh = new Connector();

$filmModel = new BddGenerate($dbh->dbConnector);
$allCine = $filmModel->selectCine();


foreach ($allCine as $cine) { 
    $filmModel->createRoom($cine['id']);
}
