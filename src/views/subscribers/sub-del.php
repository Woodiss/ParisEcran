<?php 

use Narut\parisecran\DBAL\Connector;
use Narut\parisecran\Entity\Subscribers;

require_once __DIR__ . "/../../../vendor/autoload.php";

$dbh = new Connector();

$subscribers = new Subscribers($dbh->dbConnector);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['delete_id'])) {
    $id_sub = $_POST['delete_id'];

    $deleteSuccess = $subscribers->deleteSubscriber($id_sub);

    if ($deleteSuccess) {
        echo "Abonné supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression de l'abonné.";
    }
} else {
    echo "Requête invalide ou identifiant manquant.";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer </title>
</head>
<body>
    <h1>Supprimer un sub</h1>
    <form method="POST" action="">
        <input type="number" name="delete_id" placeholder="ID de sub à supprimer" required><br>
        <button type="submit">Supprimer</button>
    </form>
</body>
</html>