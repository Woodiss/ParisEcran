<?php

namespace parisecran\Entity;


class Subscribers 
{
    private \PDO $connector;

    public function __construct(\PDO $connector)
    {
        $this->connector = $connector;
    }

    public function getSubscribers()
    {
        $query = "SELECT * FROM subscriber";
        $stmt = $this->connector->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function updateSubscribers($id_sub, $username , $email, $password, $birthdate, $first_name, $last_name )
    {
        $query = "UPDATE subscriber
              SET email = :email, username = :username , password = :password, birthdate = :birthdate, first_name = :first_name, last_name = :last_name
              WHERE id = :id";
         $stmt = $this->connector->prepare($query);

         $stmt->bindParam(":id", $id_sub);
         $stmt->bindParam(":username", $username);
         $stmt->bindParam(":email", $email);
         $stmt->bindParam(":password", $password);
         $stmt->bindParam(":birthdate", $birthdate);
         $stmt->bindParam(":first_name", $first_name);
         $stmt->bindParam(":last_name", $last_name);

        $stmt->execute();

        return $stmt->fetch();
    }
}


?>