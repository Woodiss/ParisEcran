<?php 

namespace parisecran\Entity;

class Film
{
    private \PDO $connector;

    public function __construct(\PDO $connector)
    {
        $this->connector = $connector;
    }

    public function getAllFilms()
    {
        $query = "SELECT * FROM film";
        $stmt = $this->connector->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createFilm($post, $files)
    {
        $folder = __DIR__ . "/public/images_film/";

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
            $stmt = $this->connector->prepare($query);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":image", $image);
            $stmt->bindParam(":synopsis", $synopsis);
            $stmt->bindParam(":duration", $duration);
            $stmt->bindParam(":price", $price);
            $stmt->bindParam(":language", $language);
            $stmt->bindParam(":genre_id", $genre_id);
    
            $stmt->execute();
        };
    }

    public function selectAllGenre()
    {
        $query = "SELECT * FROM `genre`";
        $stmt = $this->connector->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function selectFilmById($id_film)
    {
        $query = "SELECT *
            FROM film AS f
            JOIN genre AS g ON f.genre_id = g.id
            JOIN role AS r ON r.film_id = f.id
            JOIN casting AS c ON c.id = r.casting_id
            WHERE f.id = :id";
        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(":id", $id_film);

        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function selectRoleByIdFilm($id_film)
    {
        $query = "SELECT *
            FROM role AS r
            JOIN casting AS c ON r.casting_id = c.id
            WHERE r.film_id = :id";
        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(":id", $id_film);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function selectCommentByIdFilm($id_film)
    {
        $query = "SELECT * 
            FROM `schedule` AS sc
            JOIN subscriber AS s ON s.id = sc.subscriber_id
            WHERE film_id = :id";
        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(":id", $id_film);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function averageNotation($id_film)
    {
        $query = "SELECT AVG(notation) AS average
            FROM schedule 
            WHERE film_id = :id";
        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(":id", $id_film);

        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}

?>