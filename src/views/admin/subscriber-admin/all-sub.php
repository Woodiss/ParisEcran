<?php 

use parisecran\DBAL\Connector;
use parisecran\Entity\Subscribers;

require_once __DIR__ . '/../auth.php';

$dbh = new Connector();
$subscribersModel = new Subscribers($dbh->dbConnector);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['supp'])) {
        $subscribersModel->deleteSubscribers($_POST['supp']);
    }
}

$subscribers = $subscribersModel->getSubscribersAvgReservation();

$titlePage = "Liste des utilisateurs";
require_once "../admin-header.html.php";

?>
<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Username</th>
            <th>Email</th>
            <th>Date de naissance</th>
            <th>Role</th>
            <th>Reservation moyenne</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($subscribers as $subscriber) { ?>
            <tr>
                <td><?= $subscriber['last_name'] ?></td>
                <td><?= $subscriber['first_name'] ?></td>
                <td><?= $subscriber['username'] ?></td>
                <td><?= $subscriber['email'] ?></td>
                <td><?= $subscriber['birthdate'] ?></td>
                <td><?= $subscriber['role'] ?></td>
                <td><?= $subscriber['moyenne_reservations'] ?></td>
                <td>
                    <a href="update-subscriber.php?id_sub=<?= $subscriber['id'] ?>">Modifier</a><br>
                    <a href="reservation-sub-list.php?id_sub=<?= $subscriber['id'] ?>">Voir les reservations</a>
                    <form action="" method="post">
                        <button type="submit" name="supp" value="<?= $subscriber['id'] ?>">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>


<?php require_once "../admin-footer.html.php"; ?>