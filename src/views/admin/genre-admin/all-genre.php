<?php 

use parisecran\DBAL\Connector;
use parisecran\Entity\genre;

require_once __DIR__ . '/../auth.php';


$dbh = new Connector();
$genre = new genre($dbh->dbConnector);
$genres = $genre->getgenre();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update']) && isset($_POST['id'])) {
        if (!empty($_POST['name']) && !empty($_POST['helpText'])) {
            $name = htmlspecialchars($_POST['name']);
            $helpText = htmlspecialchars($_POST['helpText']);
            $id = (int)$_POST['id'];

            $updateSuccess = $genre->updateGenres(['id' => $id, 'name' => $name, 'helpText' => $helpText]);
        }
    }

    if (isset($_POST['delete']) && isset($_POST['id'])) {
        $id = (int)$_POST['id'];
        $deleteSuccess = $genre->deleteGenres($id);
        $genres = $genre->getgenre();
    }

    if (isset($_POST['create'])) {
        if (!empty($_POST['name']) && !empty($_POST['helpText'])) {
            $name = htmlspecialchars($_POST['name']);
            $helpText = htmlspecialchars($_POST['helpText']);

            $createSuccess = $genre->createGenre($name, $helpText);
            $genres = $genre->getgenre(); 
        }
    }
}

$genres = $genre->getgenre();

$titlePage = "Classement meilleur genre";
require_once "../admin-header.html.php";

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>genre</title>
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
        </form>
        <!-- Formulaire de suppression -->
        <form action="" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce genre ?');">
            <input type="hidden" name="id" value="<?= $genre['id'] ?>">
            <input type="submit" name="delete" value="Supprimer">
        </form>
    <?php } ?>
</body>
</html>

<?php require_once "../admin-footer.html.php"; ?>