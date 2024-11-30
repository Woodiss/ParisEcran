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
