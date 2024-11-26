<?php 

use parisecran\Entity\Film;
use parisecran\DBAL\Connector;

require_once __DIR__ . "/../../../vendor/autoload.php";

$dbh = new Connector();

$filmModel = new Film($dbh->dbConnector);

if (!empty($_GET["id_film"])){
    $id_film = $_GET["id_film"];

    $film = $filmModel->selectFilmById($id_film);
    $comments = $filmModel->selectCommentByIdFilm($id_film);
    $castings = $filmModel->selectRoleByIdFilm($id_film);
    $average = $filmModel->selectRoleByIdFilm($id_film);
} else {
    header("Location: index-film.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    if ($film) {
        echo $film['title'] ;
    } else {
        echo "Pas de représentaion pour ce film";
    }
     
     ?>

    <?php foreach ($castings as $casting) { ?>
        <br>
        <span><?= $casting['role'] ?></span>
        <span><?= $casting['firstName'] ?></span>
        <span><?= $casting['lastName'] ?></span>
    <?php } ?>
    <section>
        <h2>Critiques du film</h2>
        <?php foreach ($comments as $comment) { ?>
            <div>
                <span>prenom nom : <?= $comment['first_name'] . " " . $comment['last_name']?></span>
                <br>
                <span>note : <?= $comment['notation'] ?></span>
                <br>
                <span>commentaire : <?= $comment['comment'] ?></span>
            </div>
        <?php } ?>
    </section>
</body>
</html>