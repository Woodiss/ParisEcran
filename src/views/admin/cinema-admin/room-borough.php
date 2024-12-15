<?php

use parisecran\Entity\Cinema;
use parisecran\DBAL\Connector;

require_once __DIR__ . '/../auth.php';

$dbh = new Connector();
$cinemaModel = new Cinema($dbh->dbConnector);


$cinemaRoomList = $cinemaModel->getRoomByBorough();


$titlePage = "Salles des cinémas par arrondisement";
require_once "../admin-header.html.php";
?>

<h2>Salles de cinéma par arrondissement</h2>

<!-- Afin d'avoir un affichage propre je récupère les cinema et utilise GROUP_CONCAT pour les salles -->
<table>
    <thead>
        <tr>
            <th>Nom du cinéma</th>
            <th>Arrondissement</th>
            <th>Adresse</th>
            <th>Email</th>
            <th>Salles</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cinemaRoomList as $cinema) { ?>
            <tr>
                <td data-column-name="Nom du cinéma"><?= $cinema['name'] ?></td>
                <td data-column-name="Arrondissement"><?= $cinema['borough'] ?></td>
                <td data-column-name="Adresse"><?= $cinema['address'] ?></td>
                <td data-column-name="Email"><?= $cinema['email'] ?></td>
                <td data-column-name="Salles"><?= $cinema['rooms'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>


<?php require_once "../admin-footer.html.php"; ?>