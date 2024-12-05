<?php 

use parisecran\DBAL\Connector;
use parisecran\Entity\Subscribers;

session_start();

require_once __DIR__ . "/../../../vendor/autoload.php";

$dbh = new Connector();
$subscribersModel = new Subscribers($dbh->dbConnector);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deco'])) {
        $subscribersModel->logoutSubcriber();
    }
}

if (!isset($_SESSION['id'])) {
    header("Location: ../subscribers/login.php");
}


print_r($_SESSION);

?>



<form action="" method="post">
    <button type="submit" name="deco" value="true">Déconnexion</button>
</form>