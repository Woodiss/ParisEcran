<?php 

use parisecran\Entity\Subscribers;
use parisecran\Entity\Reservation;
use parisecran\DBAL\Connector;

require_once __DIR__ . '/../auth.php';

$dbh = new Connector();
$subscribersModel = new Subscribers($dbh->dbConnector);
$reservationModel = new Reservation($dbh->dbConnector);

if($_GET['id_sub']) {
    $sub = $subscribersModel->getSubsById($_GET['id_sub']);
    $reservations = $subscribersModel->reservationByIdSub($_GET['id_sub']);
    if ($sub) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['supp'])) {
                $reservationModel->suppReservation($_POST['supp']);
            }
        }
        
    } else {
        header("Location: all-sub.php");
    }
} else {
    header("Location: all-sub.php");
}


$titlePage = "Les des réservations";
require_once "../admin-header.html.php";

?>

<h3>reserversation pour :</h3>
<table>
    <tbody>
        <tr>
            <td><?= $sub['username'] ?></td>
            <td><?= $sub['email'] ?></td>
            <td><?= $sub['first_name'] ?></td>
            <td><?= $sub['last_name'] ?></td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th>Nombre de place</th>
            <th>Payer</th>
            <th>Total</th>
            <th>Date et heure</th>
            <th>Titre du film</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reservations as $reservation) { ?>
            <tr>
                <td><?= $reservation['booked'] ?></td>
                <td><?php if ($reservation['paid'] == 1) { echo "oui"; } else { echo "non"; } ?></td>
                <td><?= $reservation['amount'] ?> €</td>
                <td><?= $reservation['time_slot'] ?></td>
                <td><?= $reservation['title'] ?></td>
                <td>
                    <form action="" method="post">
                        <button type="submit" name="supp" value="<?= $reservation['id'] ?>">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php require_once "../admin-footer.html.php"; ?>