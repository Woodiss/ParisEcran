<?php 

use parisecran\DBAL\Connector;
use parisecran\Entity\Film;

require_once __DIR__ . '/../auth.php';

$dbh = new Connector();
$filmModel = new Film($dbh->dbConnector);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['supp'])) {
        $filmModel->deleteFilmById($_POST['supp']);
    }
}

$films = $filmModel->getAllFilms();


$titlePage = "Ajouter un film";
require_once "../admin-header.html.php";

?>
<body>
    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Image</th>
                <th>Synopsis</th>
                <th>Durée</th>
                <th>Prix</th>
                <th>Langue</th>
                <th>Genre</th>
                <th>premiere diffusion</th>
                <th>dernière diffusion</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($films as $film) { ?>
                <tr>
                    <td><?= $film['title'] ?></td>
                    <td><?= $film['image'] ?></td>
                    <td><?= $film['synopsis'] ?></td>
                    <td><?= $film['duration'] ?></td>
                    <td><?= $film['price'] ?></td>
                    <td><?= $film['language'] ?></td>
                    <td><?= $film['name'] ?></td>
                    <td><?= $film['first_date'] ?></td>
                    <td><?= $film['last_date'] ?></td>
                    <td>
                        <a href="update-film.php?id_film=<?= $film['id'] ?>">Modifier</a>
                        <a href="update-casting.php?id_film=<?= $film['id'] ?>">Modifier casting</a>
                        <a href="add-seance.php?id_film=<?= $film['id'] ?>">Ajouter Seance</a>
                        <form action="" method="post">
                            <button type="submit" name="supp" value="<?= $film['id'] ?>">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php require_once "../admin-footer.html.php"; ?>