<?php 

use parisecran\DBAL\Connector;
use parisecran\Entity\Subscribers;

require_once __DIR__ . "/../../../vendor/autoload.php";

$dbh = new Connector();

$subscribers = new Subscribers($dbh->dbConnector);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {

    if (!empty($_POST['username']) && 
    !empty($_POST['email']) && 
    !empty($_POST['password']) && 
    !empty($_POST['birthdate']) && 
    !empty($_POST['first_name']) && 
    !empty($_POST['last_name'])) {
    $updateSuccess->updateSubscribers($_POST);
    }
    // $id_sub = $_POST['id'];
    // $username = $_POST['username'];
    // $email = $_POST['email'];
    // $password = $_POST['password'];
    // $birthdate = $_POST['birthdate'];
    // $first_name = $_POST['first_name'];
    // $last_name = $_POST['last_name'];

    // $updateSuccess = $subscribers->updateSubscribers($id_sub, $username, $email, $password, $birthdate, $first_name, $last_name);

//     if ($updateSuccess) {
//         echo " Sub a modifé avec succès";
//     } else {
//         echo "Erreur 404";
//     }
// }     else {
//     echo "ERROR 404";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribers</title>
</head>
<body>

    <h1>Update</h1>
    <form method="POST" action="">
        <!--  id -->
        <input type="number" name="id" placeholder="ID de l'abonné" required><br>
        <!-- formulaire -->
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br>
        <input type="datetime-local" name="birthdate" placeholder="Date de naissance" required><br>
        <input type="text" name="first_name" placeholder="Prénom" required><br>
        <input type="text" name="last_name" placeholder="Nom" required><br>
        <button type="submit">Mettre à jour</button>
    </form>
    <p> 
        <a href="index-del.php">Supprimer un abonné</a>
    </p>


</body>
</html>