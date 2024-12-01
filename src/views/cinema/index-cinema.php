<?php 

use parisecran\Entity\Cinema;
use parisecran\DBAL\Connector;

require_once __DIR__ . "/../../../vendor/autoload.php";

// Initialiser la connexion à la base de données
$dbh = new Connector();

// Créer une instance de la classe Cinema
$cinema = new Cinema($dbh->dbConnector);

// Récupérer les cinémas par arrondissement
$cinemaByBorough = $cinema->getCinemaByBorough();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema By Borough</title>
</head>
<body>

    <ul>
        <?php foreach ($cinemaByBorough as $cinemas) { 
            // Récupérer les détails du cinéma pour chaque cinéma
            $cinemaData = $cinema->getCinemaDetails($cinemas['name']);
        ?>
            <li><strong>Cinema:</strong> <?= $cinemas['name'] ?></li>
            <li><strong>Présentation:</strong> <?= $cinemas['presentation'] ?></li>
            <li><strong>Adresse:</strong> <?= $cinemas['address'] ?></li>
            <li><strong>Borough:</strong> <?= $cinemas['borough'] ?></li>
            <li><strong>Téléphone:</strong> <?= $cinemas['phone'] ?></li>
            <li><strong>Email:</strong> <?= $cinemas['email'] ?></li>
            <hr>
            
            <ul>
                <p>Afficher les realistaeur qui ont travailé dans un film donné :</p>
                <?php foreach ($cinemaData as $data) { ?>
                    <li><?= $data['Prenom'] ?> <?= $data['Nom'] ?> (<?= $data['Role'] ?>) - Film: <?= $data['Film'] ?></li>
                <?php } ?>
            </ul>
            <hr>
        <?php } ?>
    </ul>

</body>
</html>
