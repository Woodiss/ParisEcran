<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titlePage ?? "Admin" ?></title>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css"
        >
    <script src="../../../../public/js/admin-casting.js" defer></script>
    <link rel="stylesheet" href="../../../../public/css/admin.css">
</head>
<body>
    <main class="admin-container">

        <aside>
            <nav>
                <h3><a href="../../film/index-film.php">ParisEcran</a></h3>
                <span>Films</span>
                <ul>
                    <li><a href="../film-admin/create-film.php">Ajouter film</a></li>
                    <li><a href="../film-admin/all-films.php">Liste films</a></li>
                    <li><a href="../film-admin/films-revenue.php">Revenue par film</a></li>
                </ul>

                <span>Utilisateurs</span>
                <ul>
                    <li><a href="../subscriber-admin/all-sub.php">Liste des utilisateurs</a></li>
                </ul>

                <span>Genres</span>
                <ul>
                    <li><a href="../film-admin/create-film.php">Ajouter film</a></li>
                    <li><a href="../film-admin/create-film.php">Liste films</a></li>
                    <li><a href="../genre-admin/best-genre.php">Meilleur genre</a></li>
                </ul>

                <span>Cinemas</span>
                <ul>
                    <li><a href="../film-admin/create-film.php">Ajouter film</a></li>
                    <li><a href="../film-admin/create-film.php">Liste films</a></li>
                </ul>

                <span>Infos</span>
                <ul>
                    <li><a href="../infos-admin/inflation.php">Modifier les prix</a></li>
                    <li><a href="../film-admin/create-film.php">Liste films</a></li>
                    <li><a href="../infos-admin/average-fill-room.php">Remplisage des anciens films</a></li>
                </ul>
            </nav>
        </aside>
        
        <div class="global-container">