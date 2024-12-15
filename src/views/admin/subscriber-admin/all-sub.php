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
    <h2>Liste des utilisateurs</h2>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Username</th>
            <th>Email</th>
            <th>Date de naissance</th>
            <th>Rôle</th>
            <th>Reservation moyenne</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($subscribers as $subscriber) { ?>
            <tr>
                <td data-column-name="Nom"><?= $subscriber['last_name'] ?></td>
                <td data-column-name="Prénom"><?= $subscriber['first_name'] ?></td>
                <td data-column-name="Username"><?= $subscriber['username'] ?></td>
                <td data-column-name="Email"><?= $subscriber['email'] ?></td>
                <td data-column-name="Date de naissance"><?= $subscriber['birthdate'] ?></td>
                <td data-column-name="Rôle"><?= $subscriber['role'] ?></td>
                <td data-column-name="Reservation moyenne"><?= $subscriber['moyenne_reservations'] ?></td>
                <td data-column-name="Action">
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