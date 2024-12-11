<?php

namespace parisecran\Entity;

use InvalidArgumentException;


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

    public function getSubsById($id_sub)
    {
        $query = "SELECT s.id, s.username, s.email, s.birthdate, s.first_name, s.last_name, s.role FROM subscriber AS s WHERE id = :id_sub";
        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(":id_sub", $id_sub, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
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
                if ($this->addReservation($_SESSION['idReservation'], $user['id'])) {
                    $_SESSION['idReservation'] = "";
                    return header("Location: ../reservation/reservation.php");
                } else {
                    echo "Une erreur avec la reservation c'est produite";
                };
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

    public function updateSubscribersByAdmin($post, $sub)
    {
        extract($post);
        $query = "UPDATE subscriber
                SET email = :email, username = :username, birthdate = :birthdate, first_name = :first_name, last_name = :last_name, role = :role";

        if (!empty($post['password'])) {
            $query .= ", password = :password";
        }

        $query .= " WHERE id = :id";

        $stmt = $this->connector->prepare($query);

        $stmt->bindParam(":id", $sub['id']);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":birthdate", $birthdate);
        $stmt->bindParam(":first_name", $first_name);
        $stmt->bindParam(":last_name", $last_name);
        $stmt->bindParam(":role", $role);

        if (!empty($password)) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bindParam(":password", $password);
        }

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
                FROM reservation AS sc
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
    public function selectReservationNotPaid($idSubscriber)
    {
        $query = "  SELECT 
                        r.id as reservation_id,
                        r.booked as reservation_quantity,
                        r.amount as reservation_price,
                        s.time_slot as reservation_date,
                        f.id as film_id,
                        f.price as film_unit_price,
                        f.title as film_title,
                        f.first_date as film_first_date,
                        f.last_date as film_last_date,
                        f.image as film_image,
                        f.language as film_language,
                        ci.name AS cinema_name,
                        ro.name AS room_name
                    FROM reservation as r
                    JOIN seance as s ON s.id = r.seance_id
                    JOIN film as f ON f.id = s.film_id
                    JOIN room AS ro ON ro.id = s.room_id
                    JOIN cinema AS ci ON ci.id = ro.cinema_id
                    WHERE r.subscriber_id = :subscriber_id
                    AND r.paid = 0
                    AND s.time_slot BETWEEN f.first_date AND f.last_date
                    AND s.time_slot >= NOW();

                    ";

        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(":subscriber_id", $idSubscriber, \PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function deleteReservationNotPaidAndNotValid($idSubscriber)
    {
        $query = "  DELETE r
                    FROM reservation as r
                    JOIN seance as s ON s.id = r.seance_id
                    JOIN film as f ON f.id = s.film_id
                    WHERE r.subscriber_id = :subscriber_id
                    AND r.paid = 0
                    AND s.time_slot < NOW()
                    AND s.time_slot BETWEEN f.first_date AND f.last_date;
                    ";

        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(":subscriber_id", $idSubscriber, \PDO::PARAM_INT);

        $stmt->execute();
    }

    public function addReservation($idFilmSession, $idSubscriber)
    {
        // Combiner la sélection des données du film et l'insertion dans la table reservation
        $query = "  INSERT INTO reservation 
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

    public function recommendationFilms($idSubscriber)
    {
        // requête SQL de type pavé !!!
        $query = "-- Étape 1 : Identifier les films déjà vus par l'utilisateur X
            WITH FilmsVusParX AS (
                SELECT DISTINCT s.film_id
                FROM reservation r
                JOIN seance s ON r.seance_id = s.id
                WHERE r.subscriber_id = :idSubscriber
            ),

            -- Étape 2 : Trouver les utilisateurs ayant le plus de films en commun avec l'utilisateur X
            UtilisateursSimilaires AS (
                SELECT r.subscriber_id, COUNT(*) AS films_en_commun
                FROM reservation r
                JOIN seance s ON r.seance_id = s.id
                JOIN FilmsVusParX fx ON s.film_id = fx.film_id
                WHERE r.subscriber_id != :idSubscriber
                GROUP BY r.subscriber_id
                ORDER BY films_en_commun DESC
                LIMIT 10
            ),

            -- Étape 3 : Identifier les films recommandés (vus par les utilisateurs similaires mais pas par X)
            FilmsRecommandes AS (
                SELECT s.film_id, COUNT(DISTINCT r.subscriber_id) AS nb_sub_reco
                FROM reservation r
                JOIN seance s ON r.seance_id = s.id
                JOIN UtilisateursSimilaires us ON r.subscriber_id = us.subscriber_id
                WHERE s.film_id NOT IN (SELECT film_id FROM FilmsVusParX)
                GROUP BY s.film_id
            )

            -- Étape 4 : Récupérer les détails des films recommandés classés par nombre d'utilisateurs similaires les ayant vus
            SELECT 
                f.*,
                fr.nb_sub_reco
            FROM film f
            JOIN FilmsRecommandes fr ON f.id = fr.film_id
            ORDER BY fr.nb_sub_reco DESC
            LIMIT 5";

        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(':idSubscriber', $idSubscriber, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function getReservationByID($idReservation)
    {
        $query = "  SELECT 
                        -- r.subscriber_id as subscriber_id,
                        r.booked as quantity_reservation,
                        r.amount as amount_reservation,
                        f.price as film_unit_price
                    FROM `reservation` AS r
                    JOIN seance AS se ON se.id = r.seance_id
                    JOIN film AS f ON f.id = se.film_id 
                    WHERE r.id = :idReservation
        ";

        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(':idReservation', $idReservation, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }


    public function updateQuantityReservation($idReservation, $type)
    {
        $reservation = $this->getReservationByID($idReservation);

        if ($type === "increment") {
            $quantityReservation = $reservation['quantity_reservation'] + 1;
            $amountReservation = $reservation['film_unit_price'] * $quantityReservation;
        } elseif ($type === "decrement") {
            $quantityReservation = $reservation['quantity_reservation'] - 1;

            if ($quantityReservation <= 0) {
                // Supprimer la réservation si la quantité est 0 ou moins
                $query = "DELETE FROM `reservation` WHERE id = :idReservation";
                $stmt = $this->connector->prepare($query);
                $stmt->bindParam(':idReservation', $idReservation, \PDO::PARAM_INT);
                return $stmt->execute();
            }

            $amountReservation = $reservation['film_unit_price'] * $quantityReservation;
        } else {
            throw new InvalidArgumentException("Type must be either 'increment' or 'decrement'.");
        }

        $query = "  UPDATE `reservation` 
                SET `booked`= :quantityReservation, `amount`= :amountReservation 
                WHERE id = :idReservation
    ";

        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(':idReservation', $idReservation, \PDO::PARAM_INT);
        $stmt->bindParam(':quantityReservation', $quantityReservation, \PDO::PARAM_INT);
        $stmt->bindParam(':amountReservation', $amountReservation, \PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function getAllNotPaidReservationTotal($idSubscriber)
    {
        $query = "  SELECT 
                        COUNT(*) as number_of_reservation,
                        SUM(r.amount) as total_amount_reservation
                    FROM `reservation` AS r
                    WHERE r.subscriber_id = :idSubscriber
                    AND r.paid = 0
                ";

        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(':idSubscriber', $idSubscriber, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getSubscribersAvgReservation()
    {
        $query = "SELECT s.id, s.username, s.email, s.birthdate, s.first_name, s.last_name, s.role, AVG(booked) AS moyenne_reservations 
            FROM reservation AS r
            JOIN subscriber AS s ON s.id = r.subscriber_id
            GROUP BY subscriber_id
            ORDER BY s.id";
        $stmt = $this->connector->prepare($query);        
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
