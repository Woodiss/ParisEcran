<?php

namespace parisecran\Entity;

class Cinema
{
    private \PDO $connector;

    public function __construct(\PDO $connector) 
    {
        $this->connector = $connector;      
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

}
?>
