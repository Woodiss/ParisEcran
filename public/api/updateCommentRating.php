<?php

use parisecran\DBAL\Connector;
use parisecran\Entity\Comment;
use parisecran\Entity\Subscribers;

session_start();

require_once __DIR__ . "/../../vendor/autoload.php";

header('Content-Type: application/json');

if (isset($_GET['rating']) && isset($_GET['id_comment']) && isset($_GET['id_film']) && isset($_SESSION['id'])) {
    $dbh = new Connector();
    $subscribersModel = new Subscribers($dbh->dbConnector);
    $commentModel = new Comment($dbh->dbConnector);

    $idComment = ($_GET['id_comment'] === 'null') ? null : $_GET['id_comment'];
    $rating = $_GET['rating'];
    if ($rating > 0 && $rating <= 5) {
        if ($idComment != null && $rating != null) {
            // print_r($idComment);
            if ($commentModel->updateCommentRating($idComment, $rating)) {
                $comment = $commentModel->getCommentById($idComment);

                if ($comment) {
                    echo json_encode($comment);
                } else {
                    // http_response_code(404);
                    echo json_encode(["error" => "Commentaire non trouvé"]);
                }
            } else {
                echo json_encode(["error" => "Échec de la mise à jour du commentaire"]);
            }
        } else if ($idComment === null && $rating != null && $_GET['id_film'] != null) {

            if ($reservationPaid =  $subscribersModel->isReservationForFilmAndPaid($_SESSION['id'], $_GET['id_film'])) {
                // print_r($reservationPaid);
                $insertComment = $commentModel->insertCommentRating($rating, $_GET['id_film'], $_SESSION['id']);
                if ($insertComment) {
                    echo json_encode([
                        "
                    success" => "Comment inséré",
                        "id" => $insertComment
                    ]);
                } else {
                    echo json_encode(["error" => "Insertion échoué"]);
                }
            } else {
                // http_response_code(404);
                echo json_encode(["error" => "Pas de reservation payé pour ce film"]);
            }
        } else {
            echo json_encode(["error" => "Paramètres invalides"]);
        }
    } else {
        http_response_code(403);
        echo json_encode(["error" => "Note invalide"]);
    }
} else {
    echo json_encode(["error" => "Paramètres manquants"]);
}
