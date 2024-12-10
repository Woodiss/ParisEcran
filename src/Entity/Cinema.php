<?php

namespace parisecran\Entity;

class Cinema
{
    private \PDO $connector;

    public function __construct(\PDO $connector) 
    {
        $this->connector = $connector;      
    }

    public function getDirectorsByCinema(): array
    {
        $query = "SELECT 
                    ci.id AS cinema_id,
                    ci.name AS cinemaName,
                    ci.borough AS borough,
                    ci.presentation AS presentation,
                    ci.address AS address,
                    ST_X(ci.geolocation) AS longitude,
                    ST_Y(ci.geolocation) AS latitude,
                    ci.phone AS phone,
                    ci.email AS email,
                    GROUP_CONCAT(DISTINCT CONCAT(c.firstName, ' ', c.lastName) ORDER BY c.lastName ASC SEPARATOR ', ') AS directors
                FROM cinema ci
                JOIN room ro ON ci.id = ro.cinema_id
                JOIN seance s ON ro.id = s.room_id
                JOIN film f ON s.film_id = f.id
                JOIN role r ON f.id = r.film_id
                JOIN casting c ON r.casting_id = c.id
                WHERE r.role = 'Réalisateur'
                GROUP BY ci.id
                ORDER BY ci.borough ASC
        ";
    
        $stmt = $this->connector->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}
?>
