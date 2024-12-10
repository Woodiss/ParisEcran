<?php 

use parisecran\DBAL\Connector;
use parisecran\Entity\Film;

require_once __DIR__ . '/../auth.php';

$dbh = new Connector();
$filmModel = new Film($dbh->dbConnector);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['date']) && !empty($_POST['percentage']) && is_numeric($_POST['percentage'])) {
        
        $percentage = floatval($_POST['percentage']);
        if ($percentage >= -100 && $percentage <= 100) {
            $filmModel->updateInflation($_POST);
        }
    }
}

$titlePage = "inflation";
require_once "../admin-header.html.php";

?>
<form action="" method="POST">
    <h1>Modifier le prix</h1>
    <label for="date">date</label>
    <input type="date" id="date" name="date">

    <label for="percentage">pourcentage du changement</label>
    <input type="number" id="percentage" name="percentage" placeholder="Exemple: 10 ou -10" min="-100" max="100">

    <button type="submit">Modifier prix</button>
</form>


<?php require_once "../admin-footer.html.php"; ?>