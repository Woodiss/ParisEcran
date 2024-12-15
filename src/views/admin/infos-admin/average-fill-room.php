<?php 

use parisecran\Entity\Film;
use parisecran\DBAL\Connector;

require_once __DIR__ . '/../auth.php';

$dbh = new Connector();
$filmModel = new Film($dbh->dbConnector);


if (isset($_GET['old'])) {
    $filmList = $filmModel->averageFillRoomByOldFilm();
} else {
    $filmList = $filmModel->averageFillRoomByFilm();
}

$titlePage = "Remplisage des salles";
require_once "../admin-header.html.php";
?>


<h2>Taux de remplissage des salles pour les <?=  isset($_GET['old']) ? 'anciens' : '' ?> films</h2>
<table>
    <thead>
        <tr>
            <th>Titre</th>
            <th>Dernière date de diffusion</th>
            <th>Capacité des salles</th>
            <th>Taux de remplissage</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($filmList as $film) { ?>
            <tr>
                <td data-column-name="Titre"><?= $film['title'] ?></td>
                <td data-column-name="Dernière date de diffusion"><?= $film['last_showing_date'] ?></td>
                <td data-column-name="Capacité des salles"><?= $film['room_capacity'] ?></td>
                <td data-column-name="Taux de remplissage"><?= $film['average_fill_rate'] ?> %</td>
            </tr>
        <?php } ?>
    </tbody>
</table>


<?php require_once "../admin-footer.html.php"; ?>