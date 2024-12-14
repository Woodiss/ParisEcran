<?php 

use parisecran\DBAL\Connector;
use parisecran\Entity\Cinema;

require_once __DIR__ . "/../../vendor/autoload.php";

header('Content-Type: application/json');

if (isset($_GET['cinema_id']) && is_numeric($_GET['cinema_id'])) {
    fetchRooms($_GET);
} else {
    echo json_encode(["error" => "Paramètres manquants ou incorrects"]);
}

function fetchRooms($params)
{
    try {
        $dbh = new Connector();
        $cinemaModel = new Cinema($dbh->dbConnector);
        $rooms = $cinemaModel->getRoomByCinema($params['cinema_id']);
        
        if (!$rooms) {
            echo json_encode(["error" => "Aucune salle trouvée pour ce cinéma"]);
        } else {
            echo json_encode($rooms);
        }
    } catch (Exception $e) {
        echo json_encode(["error" => "Erreur serveur: " . $e->getMessage()]);
    }
}


?>