<?php 

namespace parisecran\Entity;

class Reservation
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

    public function getSeanceDateByCinemaAndFilm($get)
    {
        extract($get);

        $query = "SELECT se.*, r.cinema_id, c.id AS cinema_id, c.name, DATE(se.time_slot) AS time_slot
            FROM seance AS se
            JOIN room AS r ON r.id = se.room_id
            JOIN cinema AS c ON r.cinema_id = c.id
            WHERE c.id = :cinema_id AND DATE(se.time_slot) >= CURDATE() AND se.film_id = :id_film
            GROUP BY DATE(se.time_slot)
            LIMIT 6";
        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(':cinema_id', $cinema_id);
        $stmt->bindParam(':id_film', $id_film);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getSeanceDateByCinemaAndFilmAndDate($get)
    {
        extract($get);
        $query = "SELECT se.*, r.cinema_id, c.id AS cinema_id, c.name, TIME(se.time_slot) AS time_slot, f.language, r.name
            FROM seance AS se
            JOIN room AS r ON r.id = se.room_id
            JOIN cinema AS c ON r.cinema_id = c.id
            JOIN film AS f ON f.id = se.film_id
            WHERE c.id = :cinema_id AND DATE(se.time_slot) = :date AND se.film_id = :id_film";
        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(':cinema_id', $cinema_id);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':id_film', $id_film);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function suppReservation($idReservation)
    {
        $query = "DELETE FROM `reservation` WHERE id = :idReservation";
        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(':idReservation', $idReservation, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function staticReservationNumber()
    {
        $query = "SELECT total_places AS number_of_seats_reserved, 
                    COUNT(*) AS number_sub 
                FROM ( SELECT subscriber_id, 
                        SUM(booked) AS total_places 
                    FROM reservation 
                    GROUP BY reservation.subscriber_id ) AS user_totals 
                    GROUP BY total_places 
                    ORDER BY total_places ASC;";

        $stmt = $this->connector->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}