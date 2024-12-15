<?php 

use parisecran\Entity\Film;
use parisecran\Entity\Cinema;
use parisecran\DBAL\Connector;

require_once __DIR__ . '/../auth.php';

$dbh = new Connector();
$filmModel = new Film($dbh->dbConnector);
$cinemaModel = new Cinema($dbh->dbConnector);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['film']) && 
    !empty($_POST['cinema']) && 
    !empty($_POST['room']) && 
    !empty($_POST['date']) && 
    !empty($_POST['language']) && 
    !empty($_POST['heure'])) {
        $cinemaModel->createSeance($_POST);
    }
}

$films = $filmModel->getAllFilms();
$cinemas = $cinemaModel->getAllCinemas();


$titlePage = "Ajouter une seance";
require_once "../admin-header.html.php";
?>


<form action="" method="POST">
    <h1>Ajouter une seance</h1>

    <label for="film">Films</label>
    <select name="film" id="film">
        <?php foreach ($films as $film) { ?>
            <option value="<?= $film['id'] ?>"><?= $film['title'] ?></option>
        <?php } ?>
    </select>
  
    <label for="cinema">Cinémas</label>
    <select name="cinema" id="cinema">
        <option value="#">Sélectionner un cinéma</option>
        <?php foreach ($cinemas as $cinema) { ?>
            <option value="<?= $cinema['id'] ?>"><?= $cinema['name'] ?></option>
        <?php } ?>
    </select>

    <label for="language">Choix de la version</label>
    <select name="language" id="language">
        <option value="VF">Français</option>
        <option value="VOSTFR">Sous-Titrée en Français</option>
        <option value="VO">Version original</option>
    </select>

    <p id="erreur"></p>
    <select name="room" id="room">

    </select>

    <label for="date">date</label>
    <input type="date" name="date" id="date">

    <label for="heure">heure</label>
    <input type="time" name="heure" id="heure">


    <button type="submit">Ajouter</button>
</form>

<?php require_once "../admin-footer.html.php"; ?>