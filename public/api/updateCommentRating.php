<?php 

// use parisecran\DBAL\Connector;
// use parisecran\Entity\Comment;
// use parisecran\Entity\Subscribers;

// session_start();

// require_once __DIR__ . "/../../vendor/autoload.php";

// header('Content-Type: application/json');

// if (isset($_GET['rating']) && isset($_GET['id_comment'])  && isset($_SESSION['id'])) {
//     $dbh = new Connector();
//     $subscribersModel = new Subscribers($dbh->dbConnector);
//     $commentModel = new Comment($dbh->dbConnector);
//     // print_r($_GET);
//     if ($_GET['id_comment'] != null) {

//         $test = $commentModel->getCommentById($_GET['id_comment']);
//         if ($commentModel->updateCommentRating($_GET['id_comment'], $_GET['rating'])) {
//             print_r($test);
//             $response = [
//                 "test" => $test
//             ];
//             echo json_encode($response);
//         }
//         ;
        

//         // $response = [
//         //     "null" => "c'est null"
//         // ];
//     } else {

//     }

// } else {
//     // echo json_encode(["error" => "Paramètres manquants"]);
// }

use parisecran\DBAL\Connector;
use parisecran\Entity\Comment;
use parisecran\Entity\Subscribers;

session_start();

require_once __DIR__ . "/../../vendor/autoload.php";

header('Content-Type: application/json');

if (isset($_GET['rating']) && isset($_GET['id_comment']) && isset($_SESSION['id'])) {
    $dbh = new Connector();
    $subscribersModel = new Subscribers($dbh->dbConnector);
    $commentModel = new Comment($dbh->dbConnector);
    
    $idComment = $_GET['id_comment'];
    $rating = $_GET['rating'];
    
    if ($idComment != null && $rating != null) {
        // print_r($idComment);
        if ($commentModel->updateCommentRating($idComment, $rating)) {
            $comment = $commentModel->getCommentById($idComment);
            
            if ($comment) {
                echo json_encode($comment);
            } else {
                echo json_encode(["error" => "Commentaire non trouvé"]);
            }
        } else {
            echo json_encode(["error" => "Échec de la mise à jour du commentaire"]);
        }
    } else {
        echo json_encode(["error" => "Paramètres invalides"]);
    }
} else {
    echo json_encode(["error" => "Paramètres manquants"]);
}

