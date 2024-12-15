<?php 

use parisecran\Entity\Genre;
use parisecran\DBAL\Connector;

require_once __DIR__ . '/../auth.php';

$dbh = new Connector();
$genreModel = new Genre($dbh->dbConnector);

$genreList = $genreModel->getGenreByNumberBooked();

if (isset($_GET['order_by'])) {
    $orderBy = $_GET['order_by'];
} else {
    $orderBy = 'AverageRating DESC';
}

$titlePage = "Classement meilleur genre";
require_once "../admin-header.html.php";
?>

<h2>Genre les plus populaires</h2>
<table>
    <thead>
        <tr>
            <th>Position</th>
            <th>Genre</th>
            <th>Nombre de reservations</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($genreList as $key => $genre) { ?>
            <tr>
                <td data-column-name="Position"><?= $key +1 ?></td>
                <td data-column-name="Genre"><?= $genre['genre'] ?></td>
                <td data-column-name="Nombre de reservations"><?= $genre['total_reservations'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php require_once "../admin-footer.html.php"; ?>