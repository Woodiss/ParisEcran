<?php

namespace parisecran\Entity;

use DateTime;
use InvalidArgumentException;

class User
{
    private ?int $id = null;
    private string $first_name;
    private string $last_name;
    private string $username;
    private string $email;
    private string $password;
    private DateTime $birthdate;

    private \PDO $connector;

    public function __construct(\PDO $connector)
    {
        $this->connector = $connector;
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


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("L'email est invalide.");
        }
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function getBirthdate(): DateTime
    {
        return $this->birthdate;
    }

    public function setBirthdate(string $birthdate): void
    {
        $this->birthdate = new DateTime($birthdate);
    }

    public function toArray(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
            'birthdate' => $this->birthdate->format('Y-m-d'),
        ];
    }
}
