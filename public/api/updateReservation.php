<?php 

use parisecran\DBAL\Connector;
use parisecran\Entity\Subscribers;

session_start();

require_once __DIR__ . "/../../vendor/autoload.php";

header('Content-Type: application/json');

if (isset($_GET['id_reservation']) && isset($_GET['action_type']) && isset($_SESSION['id'])) {
    $dbh = new Connector();
    $subscribersModel = new Subscribers($dbh->dbConnector);
    
    if ($subscribersModel->updateQuantityReservation($_GET['id_reservation'], $_GET['action_type'])) {
        $reservation = $subscribersModel->getReservationByID($_GET['id_reservation']);
        $totalReservation = $subscribersModel->getAllNotPaidReservationTotal($_SESSION['id']);

        $response = [
            "reservation" => $reservation,
            "total_reservation" => $totalReservation
        ];
        echo json_encode($response);
    }
    

} else {
    echo json_encode(["error" => "Paramètres manquants"]);
}