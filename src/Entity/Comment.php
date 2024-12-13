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
        $query = "SELECT s.first_name, s.last_name, s.username, c.comment, c.reactions, c.notation, c.id AS comment_id
            FROM comment AS c
            JOIN subscriber AS s ON s.id = c.subscriber_id
            WHERE film_id = :id
            ORDER BY comment_id DESC
            LIMIT 30";
        $stmt = $this->connector->prepare($query);
        $stmt->bindParam(":id", $id_film);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function updateReact($get, $idUser) {
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

    public function MoreThanFiveLike()
    {
        $query = "SELECT 
                    s.last_name, 
                    s.first_name, 
                    c.*, 
                    JSON_LENGTH(reactions->'$.like') AS like_count
                FROM comment AS c
                JOIN subscriber AS s ON s.id = c.subscriber_id
                WHERE JSON_LENGTH(reactions->'$.like') > 5
                ORDER BY like_count DESC";
        $stmt = $this->connector->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}