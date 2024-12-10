<?php 

namespace parisecran\Entity;

use Exception;

class Film
{
    private \PDO $connector;

    public function __construct(\PDO $connector)
    {
        $this->connector = $connector;
    }

    public function getAllFilms()
    {
        $query = "SELECT f.*, g.name FROM film AS f JOIN genre AS g ON g.id = f.genre_id";
        $stmt = $this->connector->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllFilmsByGenre($genre_id)
    {
        $query = "SELECT * 
                FROM film
                WHERE genre_id = :genre_id
                AND CURRENT_DATE BETWEEN first_date AND last_date;";
        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(":genre_id", $genre_id);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createFilm($post, $files)
    {
        // dirname(__DIR__, 2) remonte de deux dossier
        $folder = dirname(__DIR__, 2) . "/public/images_film/";

        // créer le dossier si besoin
        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $path = $folder . $files['image']['name'];
        
        $tmpName = $files['image']['tmp_name'];
        if (move_uploaded_file($tmpName, $path)) {
            extract($post);
            $image = $files['image']['name'];

            $query = "INSERT INTO `film`(`title`, `image`, `synopsis`, `duration`, `price`, `language`, `genre_id`) 
            VALUES (:title, :image, :synopsis, :duration, :price, :language, :genre_id)";
            $query = "INSERT INTO `film`(`title`, `image`, `synopsis`, `duration`, `price`, `language`, `genre_id`, `first_date`, `last_date`) 
            VALUES (:title, :image, :synopsis, :duration, :price, :language, :genre_id, :firstDate, :lastDate)";
            $stmt = $this->connector->prepare($query);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":image", $image);
            $stmt->bindParam(":synopsis", $synopsis);
            $stmt->bindParam(":duration", $duration);
            $stmt->bindParam(":price", $price);
            $stmt->bindParam(":language", $language);
            $stmt->bindParam(":genre_id", $genre_id);
            $stmt->bindParam(":firstDate", $firstDate);
            $stmt->bindParam(":lastDate", $lastDate);
    
            $stmt->execute();
        };
    }

    public function deleteFilmById($film_id)
    {
        $query = "DELETE FROM film WHERE id = :id";
        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(":id", $film_id);
        $stmt->execute();
    }

    public function updateFilm($post, $files, $film)
    {
        // dirname(__DIR__, 2) remonte de deux dossier
        $folder = dirname(__DIR__, 2) . "/public/images_film/";

        // créer le dossier si besoin
        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        // check si une image a été soumis
        if (isset($files['image']) && $files['image']['error'] == 0) {
            $newImagePath = $folder . $files['image']['name'];

            // save l'image dans le dossier
            if (move_uploaded_file($files['image']['tmp_name'], $newImagePath)) {
                if (!empty($film['image']) && file_exists($folder . $film['image'])) {
                    // supprimer l'ancienne image
                    unlink($folder . $film['image']);
                    $imageName = $files['image']['name'];
                }
            } else {
                throw new Exception("Erreur lors du téléchargement de l'image.");
            }
        } else {
            $imageName = $film['image'];
        }

        extract($post);


        $query = "UPDATE `film` 
                    SET `title` = :title, 
                        `image` = :image, 
                        `synopsis` = :synopsis, 
                        `duration` = :duration, 
                        `price` = :price, 
                        `language` = :language, 
                        `genre_id` = :genre_id,
                        `first_date` = :firstDate, 
                        `last_date` = :lastDate
                    WHERE `id` = :id";

        $stmt = $this->connector->prepare($query);

        // Liaison des paramètres
        $stmt->bindParam(":id", $film['id']);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":image", $imageName);
        $stmt->bindParam(":synopsis", $synopsis);
        $stmt->bindParam(":duration", $duration);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":language", $language);
        $stmt->bindParam(":genre_id", $genre_id);
        $stmt->bindParam(":firstDate", $firstDate);
        $stmt->bindParam(":lastDate", $lastDate);

        // Exécuter la requête
        $stmt->execute();
    }

    // 5. Afficher le nombre de spectacles par catégorie
    public function selectAllGenre()
    {
        $query = "SELECT 
                    g.id,
                    g.name,
                    COUNT(f.id) AS film_count
                FROM genre AS g
                LEFT JOIN film AS f 
                    ON g.id = f.genre_id
                    AND CURRENT_DATE BETWEEN f.first_date AND f.last_date
                GROUP BY g.id, g.name";
        $stmt = $this->connector->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function selectFilmById($id_film)
    {
        $query = "SELECT 
                    f.*,
                    g.name AS genre,
                    ROUND((
                        SELECT (AVG(c.notation))
                        FROM comment AS c
                        WHERE c.film_id = f.id
                    ), 0) AS average,
                    -- Réalisateur
                    (SELECT CONCAT(c.firstName, ' ', c.lastName)
                    FROM role AS r
                    JOIN casting AS c ON c.id = r.casting_id
                    WHERE r.film_id = f.id AND r.role = 'realisateur'
                    LIMIT 1) AS realisateur,
                    -- Acteurs
                    (SELECT GROUP_CONCAT(CONCAT(c.firstName, ' ', c.lastName) SEPARATOR ', ')
                    FROM role AS r
                    JOIN casting AS c ON c.id = r.casting_id
                    WHERE r.film_id = f.id AND r.role = 'acteur') AS acteurs
                FROM film AS f
                JOIN genre AS g ON f.genre_id = g.id
                WHERE f.id = :id";
        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(":id", $id_film);

        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // 2. Afficher les spectacles par arrondissement
    public function getFilmByBorough()
    {
        $query = "SELECT 
                f.id,
                f.title,
                f.image,
                c.borough
            FROM film AS f
            JOIN seance AS s ON s.film_id = f.id
            JOIN room AS r ON r.id = s.room_id
            JOIN cinema AS c ON c.id = r.cinema_id
            WHERE c.borough IS NOT NULL
            GROUP BY f.id
            ORDER BY c.borough ASC";
        $stmt = $this->connector->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Pour tous les spectacles ayant lieu un jour donné, augmenter le prix de 10% (les réservations déjà payées ne sont pas concernées)
    public function updateInflation($post)
    {
        extract($post);
        
        $query = "UPDATE reservation AS r
            JOIN seance AS s
            ON r.seance_id = s.id
            SET r.amount = r.amount + (r.amount * :percentage / 100)
            WHERE DATE(s.time_slot) = :date;";
        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(":percentage", $percentage);
        $stmt->bindParam(":date", $date);
        $stmt->execute();
    }

    public function getFilmRoles($filmId)
    {
        // Tableau pour stocker les résultats
        $result = [
            'realisateur' => null,
            'acteurs' => [],
            'sound-designer' => []
        ];
    
        // real
        $queryRealisateur = "SELECT c.* FROM film AS f
            JOIN role AS r ON r.film_id = f.id
            JOIN casting AS c ON c.id = r.casting_id
            WHERE f.id = :filmId AND r.role = 'realisateur'";
        $stmtRealisateur = $this->connector->prepare($queryRealisateur);
        $stmtRealisateur->execute([':filmId' => $filmId]);
        $result['realisateur'] = $stmtRealisateur->fetch(\PDO::FETCH_ASSOC);
    
        // acteurs
        $queryActeurs = "SELECT c.* FROM film AS f
            JOIN role AS r ON r.film_id = f.id
            JOIN casting AS c ON c.id = r.casting_id
            WHERE f.id = :filmId AND r.role = 'acteur'";
        $stmtActeurs = $this->connector->prepare($queryActeurs);
        $stmtActeurs->execute([':filmId' => $filmId]);
        $result['acteurs'] = $stmtActeurs->fetchAll(\PDO::FETCH_ASSOC);
    
        // sound design
        $querySoundDesign = "SELECT c.* FROM film AS f
            JOIN role AS r ON r.film_id = f.id
            JOIN casting AS c ON c.id = r.casting_id
            WHERE f.id = :filmId AND r.role = 'sound-designer'";
        $stmtSoundDesign = $this->connector->prepare($querySoundDesign);
        $stmtSoundDesign->execute([':filmId' => $filmId]);
        $result['sound-designer'] = $stmtSoundDesign->fetchAll(\PDO::FETCH_ASSOC);
    
        return $result;
    }

    public function getCastings()
    {
        $query = "SELECT * FROM casting";
        $stmt = $this->connector->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function upddateCastings($post, $id_film)
    {
        // supprimer les roles
        $queryDelete = "DELETE FROM `role` WHERE film_id = :id_film";
        $stmtDelete = $this->connector->prepare($queryDelete);
        $stmtDelete->bindParam(":id_film", $id_film);
        $stmtDelete->execute();

        // ajouter du real
        $queryAddReal = "INSERT INTO `role`(`role`, `casting_id`, `film_id`) VALUES ('realisateur', :id_real, :id_film)";
        $stmtAddReal = $this->connector->prepare($queryAddReal);
        $stmtAddReal->bindParam(":id_real", $post['realisateur']);
        $stmtAddReal->bindParam(":id_film", $id_film);
        $stmtAddReal->execute();

        // ajouter des acteurs
        foreach ($post['actors'] as $actor) {
            $queryAddActor = "INSERT INTO `role`(`role`, `casting_id`, `film_id`) VALUES ('acteur', :id_actor, :id_film)";
            $stmtAddActor = $this->connector->prepare($queryAddActor);
            $stmtAddActor->bindParam(":id_actor", $actor);
            $stmtAddActor->bindParam(":id_film", $id_film);
            $stmtAddActor->execute();
        }

        // ajouter des sound designer
        foreach ($post['soundDesigner'] as $soundDesigner) {
            $queryAddSoundDesigner = "INSERT INTO `role`(`role`, `casting_id`, `film_id`) VALUES ('sound-designer', :id_soundDesigner, :id_film)";
            $stmtAddSoundDesigner = $this->connector->prepare($queryAddSoundDesigner);
            $stmtAddSoundDesigner->bindParam(":id_soundDesigner", $soundDesigner);
            $stmtAddSoundDesigner->bindParam(":id_film", $id_film);
            $stmtAddSoundDesigner->execute();
        }
    
    }
}
?>