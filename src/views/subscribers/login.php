<?php
use parisecran\DBAL\Connector;
use parisecran\Entity\Subscribers;

session_start();

require_once __DIR__ . "/../../../vendor/autoload.php";

$dbh = new Connector();
$subscribersModel = new Subscribers($dbh->dbConnector);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (!empty($_POST['email']) && !empty($_POST['password'])) { 

        $subscribersModel->connexionSubcriber($_POST);
    } else {
        echo 'champs vides?';
    }
} else {

    // echo 'post vide';
}

if (isset($_SESSION['id'])) {
    echo $_SESSION['first_name'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="../../../public/css/login.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Manrope:wght@200..800&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>Connexion</title>
</head>
<body>
    <div class="container">
        <h1>Connexion</h1>
        <form class="form" action="" method="POST">
            <input type="email" placeholder="Email*" name="email" required><br>
            <input type="password" placeholder="Mot de passe*" name="password" required><br>
            <a href="inscritpion.html" class="link">Créer un compte</a><br>
            <button type="submit" class="btn">Connexion </button>
            <p style="color: red;">*Champs obligatoires</p>
        </form>
        
    </div>
</body>
</html>