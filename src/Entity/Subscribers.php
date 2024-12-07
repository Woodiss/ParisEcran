<?php

namespace parisecran\Entity;


class Subscribers
{
    private \PDO $connector;

    public function __construct(\PDO $connector)
    {
        $this->connector = $connector;

        // lancement de la session
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
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['birthdate'] = $user['birthdate'];

            if (!empty($_SESSION['idReservation'])) {
                echo "A une reservation en attente";
                print_r($_SESSION);
                if ($this->addSchedule($_SESSION['idReservation'], $user['id'])) {
                    $_SESSION['idReservation'] = "";
                    return header("Location: ../reservation/reservation.php");
                } else {
                    echo "Une erreur avec la reservation c'est produite";
                }
                ;
            }

            header("Location: ../film/index-film.php");
        } else {
            echo "Email et/ou mot de passe incorrect.";
        }
    }

    public function logoutSubcriber()
    {
        session_destroy();
        $_SESSION = [];
        header("Location: ../film/index-film.php");
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

    public function SelectReservationPaid($id_sub)
    {
        $query = "SELECT 
                    sc.*, 
                    se.*, 
                    f.title, 
                    f.image, 
                    ci.name AS cinema_name,
                    r.name AS room_name,
                    c.id AS comment_id,
                    CASE 
                        WHEN c.id IS NOT NULL THEN 1
                        ELSE 0
                    END AS has_commented
                FROM schedule AS sc
                JOIN seance AS se ON se.id = sc.seance_id
                JOIN film AS f ON f.id = se.film_id
                JOIN room AS r ON r.id = se.room_id
                JOIN cinema AS ci ON ci.id = r.cinema_id
                LEFT JOIN comment AS c 
                    ON c.film_id = se.film_id AND c.subscriber_id = sc.subscriber_id
                WHERE sc.subscriber_id = :id_sub
                AND sc.paid = 1;";

        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(":id_sub", $id_sub, \PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addSchedule($idFilmSession, $idSubscriber)
    {
        // Combiner la sélection des données du film et l'insertion dans la table schedule
        $query = "  INSERT INTO schedule 
                    (booked, paid, amount, seance_id, subscriber_id)
                SELECT 
                    1 AS booked, 
                    0 AS paid, 
                    f.price AS amount, 
                    se.id AS seance_id, 
                    :subscriber_id AS subscriber_id
                FROM seance AS se
                JOIN film AS f ON f.id = se.film_id 
                WHERE se.id = :idFilmSession
        ";

        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(':idFilmSession', $idFilmSession, \PDO::PARAM_INT);
        $stmt->bindParam(':subscriber_id', $idSubscriber, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
