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
    <script src="../../../../public/js/add-seance.js" defer></script>
    <link rel="stylesheet" href="../../../../public/css/admin.css">
</head>
<body>
    <main class="admin-container">

        <aside>
            <nav>
                <h3><a href="../../film/index-film.php">ParisEcran</a></h3>
                
                <span>Utilisateurs</span>
                <ul></ul>
                <ul>
                    <li><a href="../subscriber-admin/all-sub.php">Liste des utilisateurs</a></li>
                </ul>

                <span>Films</span>
                <ul>
                    <li><a href="../film-admin/create-film.php">Ajouter film</a></li>
                    <li><a href="../film-admin/all-films.php">Liste films</a></li>
                    <li><a href="../film-admin/films-revenue.php">Revenue par film</a></li>
                </ul>
                
                <span>Genres</span>
                <ul>
                    <li><a href="../genre-admin/best-genre.php">Meilleur genre</a></li>
                </ul>

                <span>Cinemas</span>
                <ul>
                    <li><a href="../cinema-admin/room-borough.php">Salle par arrondisement</a></li>
                    <li><a href="../cinema-admin/add-seance.php">Ajouter une séance</a></li>
                </ul>

                <span>Infos</span>
                <ul>
                    <li><a href="../infos-admin/inflation.php">Modifier les prix</a></li>
                    <li><a href="../infos-admin/static-reservation.php">Statistiques par nombre de place reserver</a></li>
                    <li><a href="../infos-admin/more-5.php">Commentaire avec plus de 5 likes</a></li>
                    <li><a href="../infos-admin/average-fill-room.php">Remplisage des films</a></li>
                    <li><a href="../infos-admin/average-fill-room.php?old=true">Remplisage des anciens films</a></li>
                </ul>
            </nav>
        </aside>
        
        <div class="global-container">