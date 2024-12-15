<?php 

use parisecran\DBAL\Connector;
use parisecran\Entity\Film;

require_once __DIR__ . '/../auth.php';

$dbh = new Connector();

$filmModel = new Film($dbh->dbConnector);
$genres = $filmModel->selectAllGenre();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_FILES['image']['name'])) {
    
    if (!empty($_POST['title']) && 
        !empty($_POST['synopsis']) && 
        !empty($_POST['duration']) && 
        !empty($_POST['price']) && 
        !empty($_POST['genre_id']) && 
        !empty($_POST['firstDate']) && 
        !empty($_POST['lastDate'])) {
            
            $filmModel->createFilm($_POST, $_FILES);
    }
}

$titlePage = "Ajouter un film";
require_once "../admin-header.html.php";

?>

<form action="" method="POST" enctype="multipart/form-data">
    <label for="title">Titre</label>
    <input type="text" id="title" name="title">

    <label for="image">Image</label>
    <input type="file" id="image" name="image">

    <label for="synopsis">Synopsis</label>
    <textarea name="synopsis" id="synopsis"></textarea>

    <label for="duration">Durée</label>
    <input type="time" id="duration" name="duration" value="02:00">

    <label for="price">Prix</label>
    <input type="number" id="price" name="price" value="20">

    <label for="firstDate">Première diffusion</label>
    <input type="date" id="firstDate" name="firstDate" value="<?= date('Y-m-d') ?>">

    <label for="lastDate">Dernière diffusion</label>
    <input type="date" id="lastDate" name="lastDate" value="<?= date('Y-m-d', strtotime('+2 months')) ?>">

    <label for="genre_id">Genre</label>
    <select name="genre_id" id="genre_id">
        <?php foreach ($genres as $genre) { ?>
            <option value="<?= $genre['id'] ?>"><?= $genre['name'] ?></option>
        <?php } ?>
    </select>

    <button type="submit">Ajouter</button>
</form>

    <?php require_once "../admin-footer.html.php"; ?>