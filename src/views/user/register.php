<?php

use parisecran\Entity\Subscribers;
use parisecran\DBAL\Connector;

require_once __DIR__ . "/../../../vendor/autoload.php";

$dbh = new Connector();
$user = new Subscribers($dbh->dbConnector);
    
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!empty($_POST['first_name']) &&
        !empty($_POST['last_name']) && 
        !empty($_POST['username']) &&
        !empty($_POST['email']) &&
        !empty($_POST['password']) &&
        !empty($_POST['birthdate'])
    ) { 
        if($_POST['password'] == $_POST['confirm_password']){
            $user->registerUser($_POST);
        }
    }
    
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../public/css/register.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lobster&family=Manrope:wght@200..800&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <title>Inscription</title>
</head>
<body>
    <form class="form">
        <h1>Inscription</h1>

        <!-- Nom et Prénom côte à côte -->
        <div class="row">
            <input type="text" placeholder="  Nom*">
            <input type="text" placeholder="  Prénom*">
        </div>

        <input type="text" placeholder="Nom d'utilisateur*">
        <input type="email" placeholder="Email*">
        <input type="password" placeholder="Mot de passe*">
        <input type="password" placeholder="Confirmer le mot de passe*">
        <input type="date" placeholder="Date de naissance*">

        <!-- Conditions générales -->
        <p>
            <input type="checkbox"> J'accepte les conditions générales*
        </p>

        <!-- Bouton de connexion -->
        <input type="button" value="Connexion">

        <!-- Champ obligatoire -->
        <p>* Champs obligatoires</p>
    </form>
</body>

 
</html>
