<?php
header('Content-Type: application/json');
use parisecran\Entity\Actor;
use parisecran\DBAL\Connector;

require_once __DIR__ . "/../../vendor/autoload.php";

$dbh = new Connector();
$actorModel = new Actor($dbh->dbConnector);

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Le paramètre 'id' est requis."]);
    exit;
}

$actorId = $_GET['id'];

try {
    $actorCollabs = $actorModel->getActorCollabs($actorId);

    if (empty($actorCollabs)) {
        http_response_code(200);
        echo json_encode([]);
    } else {
        http_response_code(200);
        echo json_encode($actorCollabs);
    }
} catch (Exception $e) {
    // Pour les exceptions
    http_response_code(500);
    echo json_encode(["error" => "Une erreur est survenue.", "details" => $e->getMessage()]);
}

