<?php 

use parisecran\DBAL\Connector;
use parisecran\Entity\Comment;

session_start();

require_once __DIR__ . "/../../vendor/autoload.php";

header('Content-Type: application/json');

// Vérifie si les paramètres nécessaires sont présents
if (isset($_GET['react_type']) && isset($_GET['comm_id']) && isset($_SESSION['id'])) {
    $dbh = new Connector();
    $commentModel = new Comment($dbh->dbConnector);
    
    $commentModel->updateReact($_GET, $_SESSION['id']);
} else {
    echo json_encode(["error" => "Paramètres manquants"]);
}

?>