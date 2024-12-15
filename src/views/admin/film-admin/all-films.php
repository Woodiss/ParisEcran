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

    <h2>Liste des films</h2>
    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Image</th>
                <th>Synopsis</th>
                <th>Durée</th>
                <th>Prix</th>
                <th>Genre</th>
                <th>Premiere diffusion</th>
                <th>Dernière diffusion</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($films as $film) { ?>
                <tr>
                    <td data-column-name="Titre"><?= $film['title'] ?></td>
                    <td data-column-name="Image" class="img"><img src="../../../../public/images_film/<?= $film['image'] ?>" alt=""></td>
                    <!-- <td data-column-name="Image"><?= $film['image'] ?></td> -->
                    <td data-column-name="Synopsis" data-content="<?= $film['synopsis'] ?>" class="text-collapse"><?= tronquerTexte($film['synopsis'], 100) ?></td>
                    <td data-column-name="Durée"><?= $film['duration'] ?></td>
                    <td data-column-name="Prix"><?= $film['price'] ?></td>
                    <td data-column-name="Genre"><?= $film['name'] ?></td>
                    <td data-column-name="Premiere diffusion"><?= $film['first_date'] ?></td>
                    <td data-column-name="Dernière diffusion"><?= $film['last_date'] ?></td>
                    <td data-column-name="Action">
                        <a href="update-film.php?id_film=<?= $film['id'] ?>">Modifier</a>
                        <a href="update-casting.php?id_film=<?= $film['id'] ?>">Modifier casting</a>
                        <form action="" method="post">
                            <button type="submit" name="supp" value="<?= $film['id'] ?>">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php require_once "../admin-footer.html.php"; ?>