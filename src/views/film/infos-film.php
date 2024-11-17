<?php 

use parisecran\Entity\Film;
use parisecran\DBAL\Connector;

require_once __DIR__ . "/../../../vendor/autoload.php";

$dbh = new Connector();

$film = new Film($dbh->dbConnector);

if (!empty($_GET["id_film"])){

    $film = $film->selectFilmById($_GET["id_film"]);
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
    <?php echo $film['title'] ?>
</body>
</html>