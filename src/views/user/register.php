<?php

use parisecran\Entity\User;
use parisecran\DBAL\Connector;

require_once __DIR__ . '/../../DBAL/Connector.php';
require_once __DIR__ . '/../../Entity/User.php';


    $connector = new Connector();
    $pdo = $connector->getPdo();

    
    function validateUserData(array $data): array {
        $errors = [];
        
        if (empty($data['first_name'])) $errors[] = "Le prénom est requis.";
        if (empty($data['last_name'])) $errors[] = "Le nom est requis.";
        if (empty($data['username'])) $errors[] = "Le nom d'utilisateur est requis.";
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Un email valide est requis.";
        }
        if (empty($data['password']) || strlen($data['password']) < 6) {
            $errors[] = "Le mot de passe doit contenir au moins 6 caractères.";
        }
        if ($data['password'] !== $data['confirm_password']) {
            $errors[] = "Les mots de passe ne correspondent pas.";
        }
        if (empty($data['birthdate'])) $errors[] = "La date de naissance est requise.";
        
        return $errors;
    }
    
    function registerUser(PDO $pdo, User $user): bool {
        $stmt = $pdo->prepare("
            INSERT INTO subscriber (first_name, last_name, username, email, password, birthdate)
            VALUES (:first_name, :last_name, :username, :email, :password, :birthdate)
        ");
        return $stmt->execute($user->toArray());
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Nettoyage des données
        $data = array_map('trim', $_POST);
        
        // Validation
        $errors = validateUserData($data);
        
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p style='color: red;'>".htmlspecialchars($error)."</p>";
            }
        } else {
            // Hashage du mot de passe
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            
            // Création de l'objet User
            $user = new User(
                $data['first_name'],
                $data['last_name'],
                $data['username'],
                $data['email'],
                $data['password'],
                $data['birthdate']
            );
            
            // Enregistrement de l'utilisateur
            if (registerUser($pdo, $user)) {
                echo "<p style='color: green;'>Inscription réussie !</p>";
            } else {
                echo "<p style='color: red;'>Erreur lors de l'enregistrement.</p>";
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
    <form method="POST">
        <label>Prénom*: <input type="text" name="first_name" value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>" required></label><br>
        <label>Nom*: <input type="text" name="last_name" value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>" required></label><br>
        <label>Nom d'utilisateur*: <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required></label><br>
        <label>Email*: <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required></label><br>
        <label>Mot de passe*: <input type="password" name="password" required></label><br>
        <label>Confirmer le mot de passe*: <input type="password" name="confirm_password" required></label><br>
        <label>Date de naissance*: <input type="date" name="birthdate" value="<?= htmlspecialchars($_POST['birthdate'] ?? '') ?>" required></label><br>
        <label><input type="checkbox" name="accepted_terms" required> J'accepte les conditions générales</label><br>
        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>
