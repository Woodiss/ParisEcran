<?php 

use parisecran\DBAL\Connector;
use parisecran\Entity\Schedule;

require_once __DIR__ . "/../../vendor/autoload.php";

header('Content-Type: application/json');

// Vérifie si les paramètres nécessaires sont présents
if (isset($_GET['cinema_id']) && isset($_GET['id_film'])) {
    fetchSchedule($_GET);
} else {
    echo json_encode(["error" => "Paramètres manquants"]);
}

function fetchSchedule($params)
{
    try {
        // Connexion à la base de données
        $dbh = new Connector();
        $schedulenModel = new Schedule($dbh->dbConnector);

        // Détermine la méthode à appeler en fonction des paramètres
        if (isset($params['date'])) {
            // Récupération des heures
            $data = $schedulenModel->getSeanceDateByCinemaAndFilmAndDate($params);
            $format = 'G\h i'; // Format pour les heures
            $errorMsg = "Aucune séance trouvée pour ce cinéma, ce film et cette date";
        } else {
            // Récupération des dates
            $data = $schedulenModel->getSeanceDateByCinemaAndFilm($params);
            $format = 'd F'; // Format pour les dates
            $errorMsg = "Aucune séance trouvée pour ce cinéma et ce film";
        }

        if (empty($data)) {
            http_response_code(200);
            echo json_encode([]);
            exit;
        }

        // Organisation des données
        $organizedData = [];
        foreach ($data as $item) {
            $dateTime = new DateTime($item["time_slot"]);
            $formatted = $dateTime->format($format);
            $organizedData[$formatted][] = $item;
        }

        // Renvoie les données sous forme de JSON
        echo json_encode($organizedData);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => "Erreur serveur : " . $e->getMessage()]);
    }
}

?>