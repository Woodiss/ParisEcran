<?php 

use parisecran\Entity\Subscribers;
use parisecran\Entity\Genre;
use parisecran\DBAL\Connector;

require_once __DIR__ . '/../auth.php';

$dbh = new Connector();
$subscribersModel = new Subscribers($dbh->dbConnector);


if($_GET['id_sub']) {
    $sub = $subscribersModel->getSubsById($_GET['id_sub']);
    if ($sub) {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['username']) && 
            !empty($_POST['email']) && 
            !empty($_POST['birthdate']) && 
            !empty($_POST['first_name']) && 
            !empty($_POST['last_name']) && 
            isset($_POST['role']) && $_POST['role'] !== '') {
                $subscribersModel->updateSubscribersByAdmin($_POST, $sub);
                $sub = $subscribersModel->getSubsById($_GET['id_sub']);
            }
        }
    } else {
        header("Location: all-sub.php");
    }
} else {
    header("Location: all-sub.php");
}


$titlePage = "Modifier un utilisateur";
require_once "../admin-header.html.php";

?>

<form action="" method="POST">
    <label for="username">Pseudo</label>
    <input type="text" id="username" name="username" value="<?= $sub['username'] ?>">

    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?= $sub['email'] ?>">

    <label for="password">Mot de passe</label>
    <input type="text" id="password" name="password" placeholder="Laissez vide pour ne pas modifier">

    <label for="birthdate">Date de naissance</label>
    <input type="date" id="birthdate" name="birthdate" value="<?= $sub['birthdate'] ?>">

    <label for="first_name">Prénom</label>
    <input type="text" id="first_name" name="first_name" value="<?= $sub['first_name'] ?>">

    <label for="last_name">Nom</label>
    <input type="text" id="last_name" name="last_name" value="<?= $sub['last_name'] ?>">

    <label for="role">Role</label>
    <input type="number" id="role" name="role" value="<?= $sub['role'] ?>">
        
    <button type="submit">Modifier</button>
</form>

<?php require_once "../admin-footer.html.php"; ?>