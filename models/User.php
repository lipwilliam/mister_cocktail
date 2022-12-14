<?php

declare(strict_types=1);

require_once 'DatabaseConnector.php';
/**
 * UserModel est une classe qui va hérité de Database afin de pouvoir effectuer des requête sur la table User
 *
 * email, pwd, username, created_At
 *
 * Et seulement celle-ci
 */
class User extends DatabaseConnector {
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private bool $isAdmin;
    private \DateTime $created_at;

    public function __construct() {
        parent::__construct();
    }

    public function getId(): int {
        return $this->id;
    }

    /**
     * Get the value of name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);

        return $this;
    }

    /**
     * Get the value of created_at
     */
    public function getCreated_at() {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */
    public function setCreated_at($created_at) {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Find One by email
     *
     */
    public function findByEmail(string $email) {
        try {
            $result = $this->getConnection()->prepare('
                SELECT id, name, email, password, created_at, role_id
                FROM user
                WHERE email = :mail
            ');
            $result->execute(['mail' => $email]);

            return $result->fetch();
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * Find One by email
     */
    public function findByName(string $name) {
        try {
            $result = $this->getConnection()->prepare('
                SELECT id, name, email, password, created_at
                FROM user
                WHERE name = :name
            ');
            $result->execute(['name' => $name]);

            return $result->fetch();
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * Insert User
     */
    public function insert() {
        try {
            $q = $this->getConnection()->prepare(
                'INSERT INTO user(name, email, password, created_at)
                    VALUES (:pseudo, :email, :pass, NOW())'
            );
            // Transmettre le paramètre
            $res = $q->execute([
                'pseudo' => $this->name,
                'email'  => $this->email,
                'pass'   => $this->password
            ]);
            // Test if KO
            if (!$res) {
                return false;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return true;
    }
}
