<?php 

use parisecran\DBAL\Connector;
use parisecran\Entity\Subscribers;

session_start();

require_once __DIR__ . "/../../../vendor/autoload.php";

$dbh = new Connector();
$subscribersModel = new Subscribers($dbh->dbConnector);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // print_r($_POST);

    if (!empty($_POST['first_name']) &&
        !empty($_POST['last_name']) && 
        !empty($_POST['username']) &&
        !empty($_POST['email']) &&
        !empty($_POST['password']) &&
        !empty($_POST['birthdate']) &&
        isset($_POST['agree'])
    ) { 
        if($_POST['password'] == $_POST['confirm_password']){
            $subscribersModel->registerUser($_POST);
        }
    } else {
        $errors = "Certains champs ne sont pas correctement remplis.";
    }
$titlePage = "Inscription";
}
require_once __DIR__ . "/../../../src/views/header.html.php";

?>
    <form class="pi-form" action="" method="post">
        <h1>Inscription</h1>
        <p><?= isset($errors) ? $errors : '' ?></p>

        <!-- Nom et Prénom côte à côte -->
        <div class="pi-row">
            <input type="text" name="last_name" placeholder="Nom*">
            <input type="text" name="first_name" placeholder="Prénom*">
        </div>

        <input type="text" name="username" placeholder="Nom d'utilisateur*">
        <input type="email" name="email" placeholder="Email*">
        <input type="password" name="password" placeholder="Mot de passe*">
        <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe*">
        <input type="date" name="birthdate" placeholder="Date de naissance*">

        <!-- Conditions générales -->
        <p>
            <input type="checkbox" name="agree">J'accepte les conditions générales*
        </p>

        <!-- Bouton de connexion -->
        <input type="submit" value="Connexion">

        <!-- Champ obligatoire -->
        <p>* Champs obligatoires</p>
    </form>
</body>

 
</html>