<?php 

use parisecran\Entity\Film;
use parisecran\DBAL\Connector;

require_once __DIR__ . '/../auth.php';

$dbh = new Connector();
$filmModel = new Film($dbh->dbConnector);

$filmList = $filmModel->averageFillRoomByFilm();

$titlePage = "Remplisage des salles";
require_once "../admin-header.html.php";
?>


<h2>Pourcentage de remplissage de salle pour les anciens films</h2>
<table>
    <thead>
        <tr>
            <th>Titre</th>
            <th>Dernière date de diffusion</th>
            <th>Capacité des salles</th>
            <th>Pourcentage de remplissage</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($filmList as $film) { ?>
            <tr>
                <td><?= $film['title'] ?></td>
                <td><?= $film['last_showing_date'] ?></td>
                <td><?= $film['room_capacity'] ?></td>
                <td><?= $film['average_fill_rate'] ?> %</td>
            </tr>
        <?php } ?>
    </tbody>
</table>


<?php require_once "../admin-footer.html.php"; ?>