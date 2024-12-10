<?php

use parisecran\DBAL\Connector;
use parisecran\Entity\Subscribers;

session_start();

require_once __DIR__ . "/../../../vendor/autoload.php";

$dbh = new Connector();
$subscribersModel = new Subscribers($dbh->dbConnector);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (!empty($_POST['email']) && !empty($_POST['password'])) { 

        $subscribersModel->loginSubcriber($_POST);
    } else {
        echo 'champs vides?';
    }
}
// print_r($_SESSION);
$titlePage = "Connexion";

require_once __DIR__ . "/../../../src/views/header.html.php";

?>
    <div class="pc-container">
        <h1>Connexion</h1>
        <form class="pc-form" action="" method="POST">
            <input type="email" placeholder="Email*" name="email" required><br>
            <input type="password" placeholder="Mot de passe*" name="password" required><br>
            <a href="./register.php" class="pc-link">Créer un compte</a><br>
            <button type="submit" class="pc-btn">Connexion </button>
            <p style="color: red;">*Champs obligatoires</p>
        </form>
        
    </div>
</body>
</html>