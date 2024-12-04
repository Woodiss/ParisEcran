<?php

namespace parisecran\Entity;

class Actor
{
    private \PDO $connector;

    public function __construct(\PDO $connector)
    {
        $this->connector = $connector;
    }

    public function getAllActors()
    {
        $query =
            "SELECT DISTINCT 
                c.id AS casting_id,
                c.firstName AS firstname,
                c.lastName AS lastname,
                r.role AS role
              FROM casting c
              JOIN role r ON c.id = r.casting_id
              WHERE r.role = 'acteur' 
              ORDER BY firstname

            ";
        $stmt = $this->connector->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getFavoriteActors()
    {
        // Requête 1 : Artistes préférés des spectateurs
        $query = "SELECT 
                c.id AS id_artiste,
                c.firstName AS firstname,
                c.lastName AS lastname,
                AVG(com.notation) AS average_notation
            FROM casting c
            JOIN role r ON c.id = r.casting_id
            JOIN film f ON r.film_id = f.id
            JOIN comment com ON com.film_id = f.id
            WHERE com.notation IS NOT NULL
            GROUP BY c.id
            ORDER BY average_notation DESC
            LIMIT 5";
        $stmt = $this->connector->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getActorCollabs($idActor)
    {
        // Requête 2 : Liste des artistes ayant participé avec un artiste donné à au moins deux films différents avec la moyenne de l'acteur concerné faites par rapport à tous les films et pas seulement les films en communs (COALESCE : Si aucune notation n'est disponible pour actor2, la valeur retournée sera 0 )
        $query = "SELECT 
                    c1.firstName AS actor1_firstname,
                    c1.lastName AS actor1_lastname,
                    c2.id AS actor2_id,
                    c2.firstName AS actor2_firstname,
                    c2.lastName AS actor2_lastname,
                    COUNT(DISTINCT r1.film_id) AS films_ensemble,
                    COALESCE((
                        SELECT AVG(com.notation)
                        FROM role r2_all
                        JOIN comment com ON com.film_id = r2_all.film_id
                        WHERE r2_all.casting_id = c2.id AND com.notation IS NOT NULL
                    ), 0) AS average_notation
                FROM casting c1
                JOIN role r1 ON c1.id = r1.casting_id
                JOIN role r2 ON r1.film_id = r2.film_id AND r1.casting_id != r2.casting_id
                JOIN casting c2 ON r2.casting_id = c2.id
                WHERE c1.id = :idActor
                GROUP BY c1.id, c2.id
                HAVING films_ensemble >= 2
                ORDER BY average_notation DESC";

            // -- Requêttes sans la moyenne de actor2
            // SELECT 
            // c1.firstName AS actor1_firstname,
            // c1.lastName AS actor1_lastname,
            // c2.firstName AS actor2_firstname,
            // c2.lastName AS actor2_lastname,
            // COUNT(DISTINCT r1.film_id) AS films_ensemble
            // FROM casting c1
            // JOIN role r1 ON c1.id = r1.casting_id
            // JOIN role r2 ON r1.film_id = r2.film_id AND r1.casting_id != r2.casting_id
            // JOIN casting c2 ON r2.casting_id = c2.id
            // WHERE c1.id = :idActor
            // GROUP BY c1.id, c2.id
            // HAVING films_ensemble >= 2;
        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(":idActor", $idActor);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getVersatileActors()
    {
        // Requête 3 : Existe-t-il des artistes ayant tenu au moins trois fonctions différentes sur des films différents ?
        $query =

            "   SELECT 
                c.id AS id_artiste,
                c.firstName AS firstname,
                c.lastName AS lastname,
                GROUP_CONCAT(DISTINCT r.role SEPARATOR ', ') AS roles_distincts,
                COUNT(DISTINCT r.role) AS nb_fonctions
            FROM casting c
            JOIN role r ON c.id = r.casting_id
            GROUP BY c.id
            HAVING nb_fonctions >= 3;
        ";
        $stmt = $this->connector->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}