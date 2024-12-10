<?php 

use parisecran\Entity\Film;
use parisecran\Entity\Genre;
use parisecran\DBAL\Connector;

require_once __DIR__ . '/../auth.php';

$dbh = new Connector();
$filmModel = new Film($dbh->dbConnector);


if($_GET['id_film']) {
    $film = $filmModel->selectFilmById($_GET['id_film']);
    if ($film) {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['title']) && 
            !empty($_POST['synopsis']) && 
            !empty($_POST['duration']) && 
            !empty($_POST['price']) && 
            !empty($_POST['language']) && 
            !empty($_POST['genre_id'])&& 
            !empty($_POST['firstDate']) && 
            !empty($_POST['lastDate'])) {
                
                $filmModel->updateFilm($_POST, $_FILES, $film);
            }
        }
        $genreModel = new Genre($dbh->dbConnector);
        $genres = $genreModel->getGenre();

    } else {
        header("Location: all-films.php");
    }
} else {
    header("Location: all-films.php");
}


$titlePage = "Modifier le film";
require_once "../admin-header.html.php";

?>


<form action="" method="POST" enctype="multipart/form-data">
    <label for="title">Titre</label>
    <input type="text" id="title" name="title" value="<?= $film['title'] ?>">
    
    <label for="image">Image</label>
    <input type="file" id="image" name="image" value="<?= $film['image'] ?>">
    
    <label for="synopsis">Synopsis</label>
    <textarea name="synopsis" id="synopsis"><?= $film['synopsis'] ?></textarea>
    
    <label for="duration">Durée</label>
    <input type="time" id="duration" name="duration" value="<?= $film['duration'] ?>">
    
    <label for="price">Prix</label>
    <input type="number" id="price" name="price" value="<?= $film['price'] ?>">
    
    <label for="language">Langue</label>
    <select name="language" id="language">
        <option value="français">Français</option>
        <option value="VO">VO</option>
    </select>

    <label for="firstDate">Première diffusion</label>
    <input type="date" id="firstDate" name="firstDate" value="<?= $film['first_date'] ?>">

    <label for="lastDate">Dernière diffusion</label>
    <input type="date" id="lastDate" name="lastDate" value="<?= $film['last_date'] ?>">
    
    <label for="genre_id">Genre</label>
    <select name="genre_id" id="genre_id">
        <?php foreach ($genres as $genre) { ?>
            <option value="<?= $genre['id'] ?>" <?php if ($genre['id'] == $film['genre_id']) echo "selected"; ?>><?= $genre['name'] ?></option>
        <?php } ?>
    </select>
        
        <button type="submit">Modifier</button>
</form>

<?php require_once "../admin-footer.html.php"; ?>