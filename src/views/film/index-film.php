<?php

use parisecran\Entity\Film;
use parisecran\DBAL\Connector;

require_once __DIR__ . "/../../../vendor/autoload.php";

$dbh = new Connector();

$filmModel = new Film($dbh->dbConnector);
$allFilms = $filmModel->getAllFilms();



// Déclaration de la variable pour le titre de la page
$titlePage = "Films";
require_once __DIR__ . "/../../../src/views/header.html.php"
?>
<main class="film-index">
    <section class="film-section">
        <h2> <img src="../../../public/svgs/film.svg" alt="logo category">Films à l'affiche <span>(142)</span></h2>
        <div class="container-card-film">
            <button>
                <span>
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.75 22.5L11.25 15L18.75 7.5" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </button>
            <div class="film-content">
                <?php foreach ($allFilms as $film) { ?>
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



    <section class="film-section">
        <h2> <img src="../../../public/svgs/film.svg" alt="logo category">Films à l'affiche <span>(142)</span></h2>
        <div class="container-card-film">
            <button>
                <span>
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.75 22.5L11.25 15L18.75 7.5" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </button>
          
                <div class="film-content">
                    <a href="infos-film.php?id_film=<?= $allFilms[6]['id'] ?>">
                        <figure class="card-film">
                            <?php if ($allFilms[6]['image']) { ?>
                                <img src="<?= "../../../public/images_film/" . $allFilms[6]['image'] ?>" alt="Film <?= $allFilms[6]['title'] ?>">
                            <?php } else { ?>
                                <img src="../../../public/images_film/no-film-image.webp" alt="Film <?= $allFilms[6]['title'] ?>">
                            <?php } ?>
                            <figcaption><?= $allFilms[6]['title'] ?></figcaption>
                        </figure>
                    </a>
                    <a href="infos-film.php?id_film=<?= $allFilms[6]['id'] ?>">
                        <figure class="card-film">
                            <?php if ($allFilms[6]['image']) { ?>
                                <img src="<?= "../../../public/images_film/" . $allFilms[6]['image'] ?>" alt="Film <?= $allFilms[6]['title'] ?>">
                            <?php } else { ?>
                                <img src="../../../public/images_film/no-film-image.webp" alt="Film <?= $allFilms[6]['title'] ?>">
                            <?php } ?>
                            <figcaption><?= $allFilms[6]['title'] ?></figcaption>
                        </figure>
                    </a>
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
</main>
<ul>
    <?php foreach ($allFilms as $film) { ?>
        <li><a href="infos-film.php?id_film=<?= $film['id'] ?>"><?= $film['title'] ?></a></li>
        <li><?= $film['duration'] ?></li>
    <?php } ?>
</ul>
<p>

</p>
<?php require_once __DIR__ . "/../../../src/views/footer.html.php" ?>

<!-- </body>
</html> -->