<?php 

use parisecran\Entity\Cinema;
use parisecran\DBAL\Connector;

require_once __DIR__ . "/../../../vendor/autoload.php";

// Initialiser la connexion à la base de données
$dbh = new Connector();
$cinema = new Cinema($dbh->dbConnector);

// Récupérer les cinémas par arrondissement
$cinemaByBorough = $cinema->getCinemasByBorough(); 
// Récupérer les cinémas par notation
$filmsByRating = $cinema->getFilmsByCinemaRating();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinémas</title>
</head>
<body>

<h1>Cinémas par arrondissement</h1>
<ul>
    <?php foreach ($cinemaByBorough as $cinemas): ?>
        <?php 
            // Récupérer les réalisateurs et films pour chaque cinéma
            $directorsData = $cinema->getDirectorsByCinema($cinemas['name']); 
        ?>
        <li><strong>Cinéma:</strong> <?= htmlspecialchars($cinemas['name']) ?></li>
        <li><strong>Présentation:</strong> <?= htmlspecialchars($cinemas['presentation'] ?? 'N/A') ?></li>
        <li><strong>Adresse:</strong> <?= htmlspecialchars($cinemas['address']) ?></li>
        <li><strong>Borough:</strong> <?= htmlspecialchars($cinemas['borough']) ?></li>
        <li><strong>Téléphone:</strong> <?= htmlspecialchars($cinemas['phone'] ?? 'N/A') ?></li>
        <li><strong>Email:</strong> <?= htmlspecialchars($cinemas['email'] ?? 'N/A') ?></li>
        <hr>
        <ul>
            <p><strong>Réalisateurs dans ce cinéma :</strong> <?= htmlspecialchars($directorsData[0]['Directors'] ?? 'Aucun réalisateur trouvé') ?></p>
            <p><strong>Films :</strong> <?= htmlspecialchars($directorsData[0]['Films'] ?? 'Aucun film trouvé') ?></p>
        </ul>
        <hr>
    <?php endforeach; ?>
</ul>

<h1>Liste des films triée par la note moyenne des séances</h1>
<table border="1">
    <thead>
        <tr>
            <th>Film</th>
            <th>Note Moyenne</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($filmsByRating as $filmRating) { ?>
            <tr>
                <td><?= htmlspecialchars($filmRating['Film']) ?></td>
                <td><?= number_format($filmRating['NoteMoyenne'], 2) ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>
