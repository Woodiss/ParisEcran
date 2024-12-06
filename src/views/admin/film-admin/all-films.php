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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
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
                        <form action="" method="post">
                            <button type="submit" name="supp" value="<?= $film['id'] ?>">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>