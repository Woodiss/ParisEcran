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
<?php

use parisecran\Entity\User;
use parisecran\DBAL\Connector;

require_once __DIR__ . '/../../DBAL/Connector.php';
require_once __DIR__ . '/../../Entity/User.php';


    $connector = new Connector();
    $user = new User($connector->dbConnector);
    

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!empty($_POST['first_name']) &&
            !empty($_POST['last_name']) && 
            !empty($_POST['username']) &&
            !empty($_POST['email']) &&
            !empty($_POST['password']) &&
            !empty($_POST['birthdate'])
        ) { 
            if($_POST['password'] !== $_POST['confirm_password']){
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
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>
    <form method="POST" >
        <label>Prénom*: <input type="text" name="first_name" value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>" required></label>
        <label>Nom*: <input type="text" name="last_name" value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>" required></label>
        <label>Nom d'utilisateur*: <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required></label>
        <label>Email*: <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required></label>
        <label>Mot de passe*: <input type="password" name="password" required></label>
        <label>Confirmer le mot de passe*: <input type="password" name="confirm_password" required></label>
        <label>Date de naissance*: <input type="date" name="birthdate" value="<?= htmlspecialchars($_POST['birthdate'] ?? '') ?>" required></label>
        <label><input type="checkbox" name="accepted_terms" required> J'accepte les conditions générales</label>
        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>
