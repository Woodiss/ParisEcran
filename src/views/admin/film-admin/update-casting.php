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
            if (!empty($_POST['realisateur']) && 
            !empty($_POST['actors']) && 
            !empty($_POST['soundDesigners'])) {
                $filmModel->upddateCastings($_POST, $_GET['id_film']);
            }
        }

        $genreModel = new Genre($dbh->dbConnector);
        $genres = $genreModel->getGenre();
        $allCastings = $filmModel->getCastings();
        $rolesList = $filmModel->getFilmRoles($_GET['id_film']);
    } else {
        header("Location: all-films.php");
    }
} else {
    header("Location: all-films.php");
}


$titlePage = "Modifier le casting";
require_once "../admin-header.html.php";

?>

<form action="" method="POST" enctype="multipart/form-data">
    <h2>Modifier le casting pour "<?= $film['title'] ?>"</h2>
    <label for="realisateur">réalisateur</label>
    <select name="realisateur" id="realisateur">
        <?php foreach ($allCastings as $castings) { ?>
            <option value="<?= $castings['id'] ?>" <?php if ($castings['id'] == $rolesList['realisateur']['id']) echo "selected"; ?>><?= $castings['firstName'] . ' ' . $castings['lastName'] ?></option>
        <?php } ?>
    </select>

    <div id="actors-container">
        <?php foreach ($rolesList['acteurs'] as $index => $actor) { ?>
            <div class="actor-select">
                <label for="actor_<?= $index ?>">Acteur <?= $index + 1 ?> :</label>
                <div class="select-button">
                    <select name="actors[]" id="actor_<?= $index ?>">
                        <?php foreach ($allCastings as $option) { ?>
                            <option value="<?= $option['id'] ?>" 
                            <?= $option['id'] == $actor['id'] ? 'selected' : '' ?>>
                            <?= $option['firstName'] . ' ' . $option['lastName'] ?>
                        </option>
                        <?php } ?>
                    </select>
                    <button type="button" class="remove-actor">Supprimer</button>
                </div>
            </div>
        <?php } ?>
    </div>
    <button type="button" id="add-actor">Ajouter un acteur</button>

    <div id="soundDesigner-container">
        <?php foreach ($rolesList['sound-designer'] as $index => $soundDesigner) { ?>
            <div class="soundDesigner-select">
                <label for="soundDesigner_<?= $index ?>">Sound-designer <?= $index + 1 ?> :</label>
                <div class="select-button">
                    <select name="soundDesigners[]" id="soundDesigner_<?= $index ?>">
                        <?php foreach ($allCastings as $option) { ?>
                            <option value="<?= $option['id'] ?>" 
                            <?= $option['id'] == $soundDesigner['id'] ? 'selected' : '' ?>>
                            <?= $option['firstName'] . ' ' . $option['lastName'] ?>
                        </option>
                        <?php } ?>
                    </select>
                    <button type="button" class="remove-soundDesigner">Supprimer</button>
                </div>
            </div>
        <?php } ?>
    </div>
    <button type="button" id="add-soundDesigner">Ajouter un sound-designer</button>

        
    <button type="submit">Modifier</button>
</form>

<?php require_once "../admin-footer.html.php"; ?>