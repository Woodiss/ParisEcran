<?php

namespace parisecran\Entity;

class Cinema
{
    private \PDO $connector;

    public function __construct(\PDO $connector) 
    {
        $this->connector = $connector;      
    }

    public function getAllCinemas(): array
    {
        $query = "SELECT * FROM cinema";
        $stmt = $this->connector->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getDirectorsByCinema($orderBy): array
    {
        $query = "SELECT 
                    ci.id AS cinema_id,
                    ci.name AS cinemaName,
                    ci.borough AS borough,
                    ci.address AS address,
                    ci.presentation AS presentation,
                    ci.address AS Address,
                    ST_X(ci.geolocation) AS longitude,
                    ST_Y(ci.geolocation) AS latitude,
                    ci.phone AS phone,
                    ci.email AS email,
            GROUP_CONCAT(DISTINCT CONCAT(c.firstName, ' ', c.lastName) ORDER BY c.lastName ASC SEPARATOR ', ') AS directors,
            AVG(com.notation) AS AverageRating
            FROM cinema ci
            JOIN room AS ro ON ci.id = ro.cinema_id
            JOIN seance AS s ON ro.id = s.room_id
            JOIN film AS f ON s.film_id = f.id
            JOIN role AS r ON f.id = r.film_id
            JOIN casting AS c ON r.casting_id = c.id
            LEFT JOIN comment AS com ON f.id = com.film_id
            WHERE r.role = 'realisateur'
            GROUP BY ci.id
            ORDER BY $orderBy;";
    
        $stmt = $this->connector->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCinemaGeoLocation($post): array
    {
        $query = "SELECT 
                    ci.id AS cinema_id,
                    ci.name AS cinemaName,
                    ci.borough AS borough,
                    ci.address AS address,
                    ci.presentation AS presentation,
                    ST_X(ci.geolocation) AS longitude,
                    ST_Y(ci.geolocation) AS latitude,
                    ci.phone AS phone,
                    ci.email AS email,
                    GROUP_CONCAT(DISTINCT CONCAT(c.firstName, ' ', c.lastName) ORDER BY c.lastName ASC SEPARATOR ', ') AS directors,
                    AVG(com.notation) AS AverageRating,
                    ST_Distance_Sphere(ci.geolocation, POINT(:longitude, :latitude)) AS distance
                FROM cinema ci
                JOIN room AS ro ON ci.id = ro.cinema_id
                JOIN seance AS s ON ro.id = s.room_id
                JOIN film AS f ON s.film_id = f.id
                JOIN role AS r ON f.id = r.film_id
                JOIN casting AS c ON r.casting_id = c.id
                LEFT JOIN comment AS com ON f.id = com.film_id
                WHERE r.role = 'realisateur'
                GROUP BY ci.id
                ORDER BY distance ASC
                LIMIT 3;";
        $stmt = $this->connector->prepare($query);
        $stmt->execute([':longitude' => $post['longitude'], ':latitude' => $post['latitude']]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function getRoomByBorough(): array
    {
        $query = "SELECT c.*, GROUP_CONCAT(DISTINCT CONCAT(r.name, ' ')) AS rooms FROM room AS r
        JOIN cinema AS c ON c.id = r.cinema_id
        GROUP BY c.id
        ORDER BY c.borough;";
        $stmt = $this->connector->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getRoomByCinema($cinemaId): array
    {
        $query = "SELECT * FROM room WHERE cinema_id = :cinemaId";
        $stmt = $this->connector->prepare($query);
        $stmt->execute([':cinemaId' => $cinemaId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // public function createseance
    public function createSeance($post)
    {
        extract($post);
        $datetime = $date . ' ' . $heure . ':00';
        $query = "INSERT INTO seance (time_slot, language, film_id, room_id) VALUES (:time_slot, :language, :film_id, :room_id)";

        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(':time_slot', $datetime);
        $stmt->bindParam(':language', $language);
        $stmt->bindParam(':film_id', $film);
        $stmt->bindParam(':room_id', $room);
        $stmt->execute();
    }
}
?>
