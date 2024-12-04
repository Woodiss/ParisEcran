<?php

namespace parisecran\Entity;

class Cinema
{
    private \PDO $connector;

    public function __construct(\PDO $connector) 
    {
        $this->connector = $connector;      
    }

    public function getCinemasByBorough(): array
    {
        // Requête SQL pour obtenir les cinémas et leurs quartiers
        $query = "SELECT borough, name, presentation, address, phone, email FROM cinema ORDER BY borough";
        $stmt = $this->connector->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // public function getDirectorsByCinema(string $cinemaName): array
    // {
    //     $query = "
    //         SELECT 
    //             c.firstName AS Prenom,
    //             c.lastName AS Nom,
    //             r.role AS Role,
    //             f.title AS Film,
    //             ci.name AS Cinema
    //         FROM 
    //             cinema ci
    //         JOIN 
    //             room ro ON ci.id = ro.cinema_id
    //         JOIN 
    //             seance s ON ro.id = s.room_id
    //         JOIN 
    //             film f ON s.film_id = f.id
    //         JOIN 
    //             role r ON f.id = r.film_id
    //         JOIN 
    //             casting c ON r.casting_id = c.id
    //         WHERE 
    //             ci.name = :cinemaName AND r.role = 'Réalisateur'
    //     ";
    
    //     $stmt = $this->connector->prepare($query);
    //     $stmt->bindParam(':cinemaName', $cinemaName, \PDO::PARAM_STR);
    //     $stmt->execute();
    
    //     return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    // }

    public function getDirectorsByCinema(string $cinemaName)
{
    // Requête SQL avec GROUP_CONCAT pour regrouper les réalisateurs
    $query = "
        SELECT 
            ci.name AS Cinema,
            GROUP_CONCAT(DISTINCT CONCAT(c.firstName, ' ', c.lastName) ORDER BY c.lastName) AS Directors,
            GROUP_CONCAT(DISTINCT f.title ORDER BY f.title) AS Films
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
            ci.name = :cinemaName AND r.role = 'Réalisateur'
        GROUP BY 
            ci.name
    ";
    $stmt = $this->connector->prepare($query);
    $stmt->bindParam(':cinemaName', $cinemaName, \PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

public function getFilmsByCinemaRating(): array
{
    $query = "
        SELECT 
            f.title AS Film, 
            AVG(s.notation) AS NoteMoyenne
        FROM 
            schedule s
        JOIN 
            seance se ON s.seance_id = se.id
        JOIN 
            room ro ON se.room_id = ro.id
        JOIN 
            cinema ci ON ro.cinema_id = ci.id
        JOIN 
            film f ON se.film_id = f.id
        GROUP BY 
            f.id
        ORDER BY 
            NoteMoyenne DESC
    ";

    $stmt = $this->connector->query($query);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}




}
?>
