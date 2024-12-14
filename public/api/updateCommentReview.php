<?php

use parisecran\DBAL\Connector;
use parisecran\Entity\Comment;
use parisecran\Entity\Subscribers;

session_start();

require_once __DIR__ . "/../../vendor/autoload.php";

header('Content-Type: application/json');

if (isset($_GET['new_comment']) && isset($_GET['id_comment']) && isset($_GET['id_film']) && isset($_SESSION['id'])) {
    $dbh = new Connector();
    $subscribersModel = new Subscribers($dbh->dbConnector);
    $commentModel = new Comment($dbh->dbConnector);

    $idComment = ($_GET['id_comment'] === 'null') ? null : $_GET['id_comment'];
    $newComment = ($_GET['new_comment'] === 'null') ? null : $_GET['new_comment'];

    // print_r($_GET['id_comment']);
    // print_r($idComment);


    if ($idComment != null && $newComment != null) {
        // print_r($idComment);
        // echo json_encode(["test" => "La ligne 'comment' existe et peux être modifier"]);
        $emptyReaction =  json_encode(["like" => [], "dubious" => [], "dislikes" => [], "surprised" => []]);

        if ($commentModel->updateCommentReview($idComment, $newComment, $emptyReaction, $_SESSION['id'])) {
            $comment = $commentModel->getCommentById($idComment);
            if ($comment) {
                echo json_encode($comment);
            } else {
                echo json_encode(["error" => "Commentaire non trouvé"]);
            }
        } else {
            echo json_encode(["error" => "Échec de la mise à jour du commentaire"]);
        }
    } else if ($idComment === null && $newComment != null && $_GET['id_film'] != null) {
        // print_r($idComment);
        // echo json_encode(["test" => "La ligne 'comment' n'existe pas encore"]);

        if ($reservationPaid =  $subscribersModel->isReservationForFilmAndPaid($_SESSION['id'], $_GET['id_film'])) {
            // print_r($reservationPaid);
            $emptyReaction =  json_encode(["like" => [], "dubious" => [], "dislikes" => [], "surprised" => []]);

            $insertComment = $commentModel->insertCommentReview($_GET['id_film'], $_SESSION['id'], $newComment, $emptyReaction);
            $comment = $commentModel->getCommentById($insertComment);

            if ($insertComment) {
                echo json_encode([
                    "success" => "Comment inséré",
                    "id" => $insertComment,
                    "comment" => $comment['comment']
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
    echo json_encode(["error" => "Paramètres manquants"]);
}
