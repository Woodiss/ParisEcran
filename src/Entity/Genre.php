<?php

namespace parisecran\Entity;

class Genre
{
    private \PDO $connector;

    public function __construct(\PDO $connector)
    {
        $this->connector = $connector;
    }

    public function getGenre()
    {
        $query = "SELECT * FROM genre";
        $stmt = $this->connector->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function updateGenres($post)
    {
        extract($post);
        
        $query = "UPDATE genre
            SET name = :name, helpText = :helpText 
            WHERE id = :id";
         $stmt = $this->connector->prepare($query);

         extract($post);
         $stmt->bindParam(":id", $id);
         $stmt->bindParam(":name", $name);
         $stmt->bindParam(":helpText", $helpText);

        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deleteGenres($id)
    {
        $query = "DELETE FROM genre WHERE id = :id";
        $stmt = $this->connector->prepare($query);
        
        $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    public function createGenre($name, $helpText)
    {
    $query = "INSERT INTO genre (name, helpText) VALUES (:name, :helpText)";
    $stmt = $this->connector->prepare($query);

    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":helpText", $helpText);

    return $stmt->execute();
    }

}

?>