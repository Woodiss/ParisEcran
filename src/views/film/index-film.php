<?php 

use Steph\parisecran\Entity\Film;
use Steph\parisecran\DBAL\Connector;

require_once __DIR__ . "/../../../vendor/autoload.php";

$dbh = new Connector();

$film = new Film($dbh->dbConnector);
$allFilms = $film->getAllFilms();

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
        <?php foreach ($Allfilms as $film) { ?>
            <li><?= $film['title'] ?></li>
            <li><?= $film['duration'] ?></li>
        <?php } ?>
    </ul>

</body>
</html>