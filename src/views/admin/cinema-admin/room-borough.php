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

<h2>Salles des cinémas par arrondisement</h2>

<!-- Afin d'avoir un affichage propre je récupère les cinema et utilise GROUP_CONCAT pour les salles -->
<?php foreach ($cinemaRoomList as $cinema) { ?>
    <table>
        <thead>
            <tr>
                <th>Nom du cinéma</th>
                <th>Arrondissement</th>
                <th>addresse</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $cinema['name'] ?></td>
                <td><?= $cinema['borough'] ?></td>
                <td><?= $cinema['address'] ?></td>
                <td><?= $cinema['email'] ?></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4"><?= $cinema['rooms'] ?></th>
            </tr>
        </tfoot>
    </table>
<?php } ?>


<?php require_once "../admin-footer.html.php"; ?>