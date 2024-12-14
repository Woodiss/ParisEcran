<?php 

use parisecran\Entity\Reservation;
use parisecran\DBAL\Connector;

require_once __DIR__ . '/../auth.php';

$dbh = new Connector();
$reservationModel = new Reservation($dbh->dbConnector);


$reservationList = $reservationModel->staticReservationNumber();


$titlePage = "Remplisage des salles";
require_once "../admin-header.html.php";
?>

<h2>Nombre d'utilisateur ayant reserver X place</h2>

<table>
    <thead>
        <tr>
            <th>Nombre de place</th>
            <th>Nombre d'utilisateur ayant reserver</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reservationList as $reservation) { ?>
            <tr>
                <td><?= $reservation['number_of_seats_reserved'] ?></td>
                <td><?= $reservation['number_sub'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php require_once "../admin-footer.html.php"; ?>