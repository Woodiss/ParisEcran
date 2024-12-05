<?php

namespace parisecran\Entity;


class Subscribers 
{
    private \PDO $connector;

    public function __construct(\PDO $connector)
    {
        $this->connector = $connector;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function getSubscribers()
    {
        $query = "SELECT * FROM subscriber";
        $stmt = $this->connector->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    function registerUser($post): bool 
    {
        extract($post);
        
        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO subscriber (first_name, last_name, username, email, password, birthdate)
                VALUES (:first_name, :last_name, :username, :email, :password, :birthdate)";

        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(":first_name", $first_name);
        $stmt->bindParam(":last_name", $last_name);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":birthdate", $birthdate);
        
        return $stmt->execute();
    }

    public function loginSubcriber($post)
    {
        extract($post);
        $query = "SELECT * FROM subscriber WHERE email = :email";
        $stmt = $this->connector->prepare($query);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['role'] = $user['role'];

            header("Location: ../film/index-film.php");
        } else {
            echo "Email et/ou mot de passe incorrect.";
        }
    }

    public function logoutSubcriber()
    {
        session_destroy();
        $_SESSION = [];
    }

    public function updateSubscribers($post)
    {

        extract($post);
        $query = "UPDATE subscriber
              SET email = :email, username = :username , password = :password, birthdate = :birthdate, first_name = :first_name, last_name = :last_name
              WHERE id = :id";
         $stmt = $this->connector->prepare($query);

         extract($post);
         $stmt->bindParam(":id", $id);
         $stmt->bindParam(":username", $username);
         $stmt->bindParam(":email", $email);
         $stmt->bindParam(":password", $password);
         $stmt->bindParam(":birthdate", $birthdate);
         $stmt->bindParam(":first_name", $first_name);
         $stmt->bindParam(":last_name", $last_name);

        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deleteSubscribers($id_sub)
{
    $query = "DELETE FROM subscriber WHERE id = :id";
    $stmt = $this->connector->prepare($query);

    $stmt->bindParam(":id", $id_sub, \PDO::PARAM_INT);

    return $stmt->execute(); 
}

}


?>