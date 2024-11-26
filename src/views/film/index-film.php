<?php 

use parisecran\Entity\Film;
use parisecran\DBAL\Connector;

require_once __DIR__ . "/../../../vendor/autoload.php";

$dbh = new Connector();

$filmModel = new Film($dbh->dbConnector);
$genres = $filmModel->selectAllGenre();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Films</title>
</head>
<body>
    <?php foreach ($genres as $genre) { ?>
        <div>
            <h3><?= $genre['name'] ?></h3>
            <?php $films = $filmModel->getAllFilmsByGenre($genre['id']) ?>
            <?php foreach ($films as $film) { ?>
                <div>
                    <?= $film['title'] ?>
                    <img src="../../../public/images_film/<?= $film['image'] ?>" alt="affiche du film <?= $film['title'] ?>">
                    <?= $film['synopsis'] ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</body>
</html>