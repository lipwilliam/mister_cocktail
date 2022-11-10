<?php

declare(strict_types=1);

require_once 'DatabaseConnector.php';
/**
 * CocktailModel est une classe qui va hérité de Database afin de pouvoir effectuer des requête sur la table User
 *
 * liste des champs de la table cocktail
 *
 * Et seulement celle-ci
 */
class Alcohol extends DatabaseConnector {
    /*
        TODO: Déclarer les propriétés de la table cocktail
    */
    private int $id;
    private string $name;

    public function __construct() {
        parent::__construct();

        $this->name = '';
    }

    // Getter / Setter

    /**
     * Find One by id
     *
     */
    public function findById(int $id) {
    }

    /**
     * Find One by name
     */
    public function findByName(string $name) {
        try {
            $result = $this->getConnection()->prepare(
                'SELECT id
                FROM alcohol
                WHERE name = :name'
            );

            $result->execute(['name' => $name]);
            return $result->fetch();
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * Find All
     *
     */
    public function findAll() {
        try {
            $result = $this->getConnection()->query(
                'SELECT id, name
                FROM alcohol'
            );

            return $result->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Insert Alcohol
     */
    public function insert(string $name): void {
        try {
            $result = $this->getConnection()->prepare(
                'INSERT INTO alcohol (name) VALUES (:name)'
            );
            $result->execute(['name' => $name]);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
    }
}
