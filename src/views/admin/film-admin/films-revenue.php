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
                <td data-column-name="Titre"><?= $film['title'] ?></td>
                <td data-column-name="Synopsis" data-content="<?= $film['synopsis'] ?>" class="text-collapse"><?= tronquerTexte($film['synopsis'], 200) ?></td>
                <td data-column-name="Affiche" class="img"><img src="../../../../public/images_film/<?= $film['image'] ?>" alt=""></td>
                <td data-column-name="Revenue" class="price"><?= $film['total_paid'] ?> €</td>
            </tr>
        <?php } ?>
    </tbody>
</table>


<?php require_once "../admin-footer.html.php"; ?>