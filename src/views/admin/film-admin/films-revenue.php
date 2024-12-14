<?php 

use parisecran\Entity\Film;
use parisecran\DBAL\Connector;

require_once __DIR__ . '/../auth.php';

$dbh = new Connector();
$filmModel = new Film($dbh->dbConnector);

$filmList = $filmModel->CalculTotalRevenue();

$titlePage = "Meilleur revenue";
require_once "../admin-header.html.php";
?>


<h2>Classement des films ayant générer le plus de revenue</h2>
<table>
    <thead>
        <tr>
            <th>Film</th>
            <th>Synopsis</th>
            <th>Affiche</th>
            <th>Revenue</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($filmList as $film) { ?>
            <tr>
                <td><?= $film['title'] ?></td>
                <td><?= $film['synopsis'] ?></td>
                <td class="img"><img src="../../../../public/images_film/<?= $film['image'] ?>" alt=""></td>
                <td><?= $film['total_paid'] ?> €</td>
            </tr>
        <?php } ?>
    </tbody>
</table>


<?php require_once "../admin-footer.html.php"; ?>