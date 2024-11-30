<?php

namespace parisecran\Entity;

class Cinema
{
    private \PDO $connector;

    public function __construct(\PDO $connector) 
    {
        $this->connector = $connector;      
    }

    public function getCinemaByBorough()
    {
        // Récupérer tous les cinémas sans filtre
        $query = "SELECT * FROM cinema";
        $stmt = $this->connector->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les informations sur le personnel, le rôle, le film et le cinéma spécifié.
     * 
     * @param string $cinemaName Nom du cinéma pour filtrer les résultats
     * @return array Résultat de la requête
     */
    public function getCinemaDetails(string $cinemaName): array
    {
        // Récupérer les informations sur les acteurs, films, et rôles pour un cinéma spécifique
        $query = "
            SELECT 
                c.firstName AS Prenom,
                c.lastName AS Nom,
                r.role AS Role,
                f.title AS Film,
                ci.name AS Cinema
            FROM 
                cinema ci
            JOIN 
                room ro ON ci.id = ro.cinema_id
            JOIN 
                representation rep ON ro.id = rep.room_id
            JOIN 
                film f ON rep.film_id = f.id
            JOIN 
                role r ON f.id = r.film_id
            JOIN 
                casting c ON r.casting_id = c.id
            WHERE 
                ci.name = :cinemaName
        ";

        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(':cinemaName', $cinemaName, \PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}
?>
