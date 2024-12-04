<?php 

use parisecran\Entity\Cinema;
use parisecran\DBAL\Connector;

require_once __DIR__ . "/../../../vendor/autoload.php";

$dbh = new Connector();
$cinema = new Cinema($dbh->dbConnector);

// Récupérer les informations sur les cinémas et leurs réalisateurs
$cinemaData = $cinema->getDirectorsByCinema();

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
    <?php foreach ($cinemaData as $cinema): ?>
        <li><strong>Cinéma:</strong> <?= htmlspecialchars($cinema['CinemaName']) ?></li>
        <li><strong>Présentation:</strong> <?= htmlspecialchars($cinema['Presentation'] ?? 'N/A') ?></li>
        <li><strong>Adresse:</strong> <?= htmlspecialchars($cinema['Address']) ?></li>
        <li><strong>Borough:</strong> <?= htmlspecialchars($cinema['Borough']) ?></li>
        <li><strong>Téléphone:</strong> <?= htmlspecialchars($cinema['Phone'] ?? 'N/A') ?></li>
        <li><strong>Email:</strong> <?= htmlspecialchars($cinema['Email'] ?? 'N/A') ?></li>
        <li><strong>Geolocation:</strong> <?= htmlspecialchars($cinema['Geolocation'] ?? 'N/A') ?></li>
        <li><strong>Réalisateurs:</strong> <?= htmlspecialchars($cinema['Directors'] ?? 'Aucun réalisateur trouvé') ?></li>
        <hr>
    <?php endforeach; ?>
</ul>

</body>
</html>
