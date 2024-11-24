<?php 

use parisecran\Entity\Film;
use parisecran\DBAL\Connector;

require_once __DIR__ . "/../../../vendor/autoload.php";

$dbh = new Connector();

$filmModel = new Film($dbh->dbConnector);
$filmModel->createRoom();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Films</title>
</head>
<body>

    <ul>
        <?php foreach ($allFilms as $film) { ?>
            <li><a href="infos-film.php?id_film=<?= $film['id'] ?>"><?= $film['title'] ?></a></li>
            <li><?= $film['duration'] ?></li>
        <?php } ?>
    </ul>

</body>
</html>