<?php 

use parisecran\Entity\Genre;
use parisecran\DBAL\Connector;

require_once __DIR__ . '/../auth.php';

$dbh = new Connector();
$genreModel = new Genre($dbh->dbConnector);

$genreList = $genreModel->getGenreByNumberBooked();

$titlePage = "Classement meilleur genre";
require_once "../admin-header.html.php";


if (isset($_GET['order_by'])) {
    $orderBy = $_GET['order_by'];
} else {
    $orderBy = 'AverageRating DESC';
}
?>


<h2>Classement des genres de films pupulaire</h2>
<table>
    <thead>
        <tr>
            <th>Genre</th>
            <th>Nombre de reservations</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($genreList as $genre) { ?>
            <tr>
                <td><?= $genre['genre'] ?></td>
                <td><?= $genre['total_reservations'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php require_once "../admin-footer.html.php"; ?>