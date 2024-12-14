<?php

use parisecran\Entity\Film;
use parisecran\DBAL\Connector;

session_start();

require_once __DIR__ . "/../../../vendor/autoload.php";

$dbh = new Connector();

$filmModel = new Film($dbh->dbConnector);
$genres = $filmModel->selectAllGenre();
$FilmsByBorough = $filmModel->getFilmByBorough();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['search'])) {
        $filmList = $filmModel->searchFilm($_POST);
    }
}

// Déclaration de la variable pour le titre de la page
$titlePage = "Films";
require_once __DIR__ . "/../../../src/views/header.html.php";

?>

<main class="film-index">
    <?php if (!isset($filmList)) { 
        foreach ($genres as $genre) { ?>
            <section class="film-section">
                <h2> <img src="../../../public/svgs/film.svg" alt="logo category"> <?= $genre['name'] ?> <span><?= $genre['film_count'] ?></span></h2>
                <div class="container-card-film">
                    <button>
                        <span>
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.75 22.5L11.25 15L18.75 7.5" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </button>
                    <div class="film-content">
                        <?php $films = $filmModel->getAllFilmsByGenre($genre['id']) ?>
                        <?php foreach ($films as $film) { ?>
                            <a href="infos-film.php?id_film=<?= $film['id'] ?>">
                                <figure class="card-film">
                                    <?php if ($film['image']) { ?>
                                        <img src="<?= "../../../public/images_film/" . $film['image'] ?>" alt="Film <?= $film['title'] ?>">
                                    <?php } else { ?>
                                        <img src="../../../public/images_film/no-film-image.webp" alt="Film <?= $film['title'] ?>">
                                    <?php } ?>
                                    <figcaption><?= $film['title'] ?></figcaption>
                                </figure>
                            </a>
                        <?php } ?>
                    </div>
                    <button>
                        <span>
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.25 22.5L18.75 15L11.25 7.5" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </button>

                </div>
            </section>

        <?php } ?>
        
        <section class="film-section">
            <h2> <img src="../../../public/svgs/film.svg" alt="logo category"> Film par arondissement</h2>
            <div class="container-card-film">
                <button>
                    <span>
                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.75 22.5L11.25 15L18.75 7.5" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </button>
                <div class="film-content">
                    <?php foreach ($FilmsByBorough as $film) { ?>
                        <a href="infos-film.php?id_film=<?= $film['id'] ?>">
                            <figure class="card-film">
                                <?php if ($film['image']) { ?>
                                    <img src="<?= "../../../public/images_film/" . $film['image'] ?>" alt="Film <?= $film['title'] ?>">
                                <?php } else { ?>
                                    <img src="../../../public/images_film/no-film-image.webp" alt="Film <?= $film['title'] ?>">
                                    <?php } ?>
                                    <figcaption><?= $film['title'] ?></figcaption>
                            </figure>
                        </a>
                    <?php } ?>
                </div>
                <button>
                    <span>
                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.25 22.5L18.75 15L11.25 7.5" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </button>
            </div>     
        </section>
    <?php } else if (count($filmList) > 0) { ?>
        <section class="film-section">
            <h2> <img src="../../../public/svgs/film.svg" alt="logo category">Films rechercher</h2>
            <div class="container-card-film">
                <button>
                    <span>
                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.75 22.5L11.25 15L18.75 7.5" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </button>
                <div class="film-content">
                    <?php foreach ($filmList as $film) { ?>
                        <a href="infos-film.php?id_film=<?= $film['id'] ?>">
                            <figure class="card-film">
                                <?php if ($film['image']) { ?>
                                    <img src="<?= "../../../public/images_film/" . $film['image'] ?>" alt="Film <?= $film['title'] ?>">
                                <?php } else { ?>
                                    <img src="../../../public/images_film/no-film-image.webp" alt="Film <?= $film['title'] ?>">
                                    <?php } ?>
                                    <figcaption><?= $film['title'] ?></figcaption>
                            </figure>
                        </a>
                    <?php } ?>
                </div>
                <button>
                    <span>
                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.25 22.5L18.75 15L11.25 7.5" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </button>
            </div>     
        </section>
    <?php } else { ?>
        <p>Aucun film trouvé</p>
    <?php } ?>
</main>
<?php require_once __DIR__ . "/../../../src/views/footer.html.php" ?>