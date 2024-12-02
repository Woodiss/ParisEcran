<?php 

namespace parisecran\Entity;

class Schedule
{
    private \PDO $connector;

    public function __construct(\PDO $connector)
    {
        $this->connector = $connector;
    }

    public function getAllCinemas()
    {
        $query = "SELECT * FROM cinema";
        $stmt = $this->connector->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getSeanceDateByCinemaAndFilm($post)
    {
        extract($post);

        $query = "SELECT se.*, r.cinema_id, c.id AS cinema_id, c.name, DATE(se.time_slot) AS time_slot
            FROM seance AS se
            JOIN room AS r ON r.id = se.room_id
            JOIN cinema AS c ON r.cinema_id = :cinema_id
            WHERE c.id = 1 AND DATE(se.time_slot) >= CURDATE() AND se.film_id = :id_film
            GROUP BY DATE(se.time_slot)
            LIMIT 5";
        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(':cinema_id', $cinema);
        $stmt->bindParam(':id_film', $id_film);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getSeanceDateByCinemaAndFilmAndDate($post)
    {
        extract($post);

        $query = "SELECT se.*, r.cinema_id, c.id AS cinema_id, c.name, TIME(se.time_slot) AS time_slot
            FROM seance AS se
            JOIN room AS r ON r.id = se.room_id
            JOIN cinema AS c ON r.cinema_id = :cinema_id
            WHERE c.id = 1 AND DATE(se.time_slot) = :date AND se.film_id = :id_film
            LIMIT 5";
        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(':cinema_id', $cinema);
        $stmt->bindParam(':id_film', $id_film);
        $stmt->bindParam(':date', $date);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}