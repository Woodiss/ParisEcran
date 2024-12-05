<?php 

use parisecran\DBAL\Connector;
use parisecran\Entity\Film;

session_start();

require_once __DIR__ . "/../../../vendor/autoload.php";

$dbh = new Connector();

$filmModel = new Film($dbh->dbConnector);
$genres = $filmModel->selectAllGenre();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_FILES['image']['name'])) {
    
    if (!empty($_POST['title']) && 
        !empty($_POST['synopsis']) && 
        !empty($_POST['duration']) && 
        !empty($_POST['price']) && 
        !empty($_POST['language']) && 
        !empty($_POST['genre_id'])) {
            
            $filmModel->createFilm($_POST, $_FILES);
    } else {
        echo 'champs vides?';
    }
} else {
    echo 'post vide';
}
var_dump($_POST);
echo "<br>";
var_dump($_FILES);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="title">title</label>
        <input type="text" id="title" name="title">

        <label for="image">image</label>
        <input type="file" id="image" name="image">

        <label for="synopsis">synopsis</label>
        <input type="text" id="synopsis" name="synopsis">

        <label for="duration">duration</label>
        <input type="time" id="duration" name="duration">

        <label for="price">price</label>
        <input type="number" id="price" name="price">

        <label for="language">language</label>
        <select name="language" id="language">
            <option value="français">Français</option>
            <option value="VO">VO</option>
        </select>

        <label for="genre_id">Genre</label>
        <select name="genre_id" id="genre_id">
            <?php foreach ($genres as $genre) { ?>
                <option value="<?= $genre['id'] ?>"><?= $genre['name'] ?></option>
            <?php } ?>
        </select>

        <button type="submit">Ajouter</button>
    </form>

</body>
</html>