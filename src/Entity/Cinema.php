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
        $query = "
            SELECT 
                ci.name AS CinemaName,
                ci.borough AS Borough,
                ci.presentation AS Presentation,
                ci.address AS Address,
                ci.geolocation AS Geolocation,
                ci.phone AS Phone,
                ci.email AS Email,
                GROUP_CONCAT(DISTINCT CONCAT(c.firstName, ' ', c.lastName) ORDER BY c.lastName ASC SEPARATOR ', ') AS Directors
            FROM 
                cinema ci
            JOIN 
                room ro ON ci.id = ro.cinema_id
            JOIN 
                seance s ON ro.id = s.room_id
            JOIN 
                film f ON s.film_id = f.id
            JOIN 
                role r ON f.id = r.film_id
            JOIN 
                casting c ON r.casting_id = c.id
            WHERE 
                r.role = 'Réalisateur'
            GROUP BY 
                ci.id
            ORDER BY 
                ci.borough ASC
        ";
    
        $stmt = $this->connector->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}
?>
