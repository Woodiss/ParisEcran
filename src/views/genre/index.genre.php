<?php 

use parisecran\DBAL\Connector;
use parisecran\Entity\Genre;

session_start();

require_once __DIR__ . "/../../../vendor/autoload.php";

$dbh = new Connector();

$Genre= new Genre($dbh->dbConnector);
$genres = $Genre->getGenre();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update']) && isset($_POST['id'])) {
        if (!empty($_POST['name']) && !empty($_POST['helpText'])) {
            $name = htmlspecialchars($_POST['name']);
            $helpText = htmlspecialchars($_POST['helpText']);
            $id = (int)$_POST['id'];

            $updateSuccess = $Genre->updateGenres(['id' => $id, 'name' => $name, 'helpText' => $helpText]);
        }
    }

    if (isset($_POST['delete']) && isset($_POST['id'])) {
        $id = (int)$_POST['id'];
        $deleteSuccess = $Genre->deleteGenres($id);
        $genres = $Genre->getGenre();
    }

    if (isset($_POST['create'])) {
        if (!empty($_POST['name']) && !empty($_POST['helpText'])) {
            $name = htmlspecialchars($_POST['name']);
            $helpText = htmlspecialchars($_POST['helpText']);

            $createSuccess = $Genre->createGenre($name, $helpText);
            $genres = $Genre->getGenre(); 
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Genre</title>
</head>
<body>
    <h1>Admin des genres</h1>
 
    <!-- Formulaire de création -->
    <h2>Ajouter un nouveau genre</h2>
    <form action="" method="POST">
        <label for="name">Nom :</label>
        <input type="text" name="name" id="name" required>
        <label for="helpText">Description :</label>
        <textarea name="helpText" id="helpText" required></textarea>
        <input type="submit" name="create" value="Créer">
    </form>
    <hr>

    <?php foreach ($genres as $genre) { ?>
        <!-- Formulaire de mise à jour -->
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?= $genre['id'] ?>">
            <label for="name">Nom :</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($genre['name']) ?>" required>
            <label for="helpText">Description :</label>
            <textarea name="helpText" id="helpText" required><?= htmlspecialchars($genre['helpText']) ?></textarea>
            <input type="submit" name="update" value="Mettre à jour">
              <!-- Formulaire de suppression -->
        <form action="" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce genre ?');">
            <input type="hidden" name="id" value="<?= $genre['id'] ?>">
            <input type="submit" name="delete" value="Supprimer">
        </form>
        </form>
    <?php } ?>
</body>
</html>