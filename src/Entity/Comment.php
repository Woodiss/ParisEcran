<?php

namespace parisecran\Entity;

class Comment
{
    private \PDO $connector;

    public function __construct(\PDO $connector)
    {
        $this->connector = $connector;
    }

    public function selectCommentByIdFilm($id_film)
    {
        $query = "  SELECT s.first_name, s.last_name, s.username, c.comment, c.reactions, c.notation, c.id AS comment_id
                    FROM comment AS c
                    JOIN subscriber AS s ON s.id = c.subscriber_id
                    WHERE c.film_id = :id
                    AND c.comment IS NOT NULL
                    ORDER BY comment_id DESC
                    LIMIT 30;
                    ";
        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(":id", $id_film);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function updateReact($get, $idUser)
    {
        extract($get);

        $query = "SELECT * FROM comment WHERE id = :id";
        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(":id", $comm_id);

        $stmt->execute();

        $comment = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$comment) {
            return false;
        }


        $reactions = json_decode($comment['reactions'], true);

        if (($key = array_search($idUser, $reactions[$react_type])) !== false) {
            unset($reactions[$react_type][$key]);
        } else {
            $reactions[$react_type][] = $idUser;
        }

        $reactionsJson = json_encode($reactions);

        $queryUpdate = "UPDATE `comment` SET `reactions`= :reactions WHERE id = :id";
        $stmtUpdate = $this->connector->prepare($queryUpdate);
        $stmtUpdate->bindParam(":reactions", $reactionsJson);
        $stmtUpdate->bindParam(":id", $comm_id);

        $stmtUpdate->execute();
    }
    public function updateCommentRating($idComment, $rating)
    {
        $query = "  UPDATE `comment` 
                    SET `notation`= :rating 
                    WHERE id = :id_comment
                ";
        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(":id_comment", $idComment);
        $stmt->bindParam(":rating", $rating);

        return $stmt->execute();
    }

    public function getCommentById($idComment)
    {
        $query = "  SELECT * 
                    FROM comment 
                    WHERE id = :id_comment";
        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(":id_comment", $idComment, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function insertCommentRating($rating, $filmId, $subscriberId)
    {
        $query = "INSERT INTO `comment`
                (`film_id`, `subscriber_id`, `notation`) 
              VALUES (:filmId, :subscriberId, :rating)";
        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(":filmId", $filmId);
        $stmt->bindParam(":rating", $rating);
        $stmt->bindParam(":subscriberId", $subscriberId);

        if ($stmt->execute()) {
            return $this->connector->lastInsertId();
        }

        return false;
    }
    public function updateCommentReview($idComment, $newReview, $emptyReaction, $idSuscriber)
    {
        $query = "  UPDATE `comment` 
                    SET `comment` = :new_review ,`reactions` = :empty_reaction
                    WHERE id = :id_comment
                    AND subscriber_id = :id_subscriber
                ";
        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(":id_comment", $idComment);
        $stmt->bindParam(":new_review", $newReview);
        $stmt->bindParam(":empty_reaction", $emptyReaction);
        $stmt->bindParam(":id_subscriber", $idSuscriber);

        return $stmt->execute();
    }
    public function insertCommentReview($filmId,$subscriberId,$comment, $emptyReaction)
    {
        $query = "  INSERT INTO `comment`
                        (`film_id`, `subscriber_id`,`comment`, `reactions`) 
                    VALUES (:filmId, :subscriberId, :comment, :empty_reaction)
                ";
        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(":filmId", $filmId);
        $stmt->bindParam(":subscriberId", $subscriberId);
        $stmt->bindParam(":comment", $comment);
        $stmt->bindParam(":empty_reaction", $emptyReaction);
        // $stmt->bindParam(":rating", $rating);

        if ($stmt->execute()) {
            return $this->connector->lastInsertId();
        }

        return false;
    }
}
