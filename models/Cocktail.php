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
class Cocktail extends DatabaseConnector {
    /*
        TODO: Déclarer les propriétés de la table cocktail
    */

    public function __construct() {
        parent::__construct();
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
    }

    /**
     * Find All
     *
     */
    public function findAll() {
        try {
            $result = $this->getConnection()->query('
                SELECT *
                FROM cocktail
            ');

            return $result->fetchAll();
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * Insert Cocktail
     */
    public function insert(string $name, string $description, string $pictureName, int $alcohol) {
        try {
            $result = $this->getConnection()->prepare(
                'INSERT INTO cocktail(name, content, picture, alcohol_id)
                VALUES (:name, :description, :pictureName, :alcohol)'
            );

            $result->execute([
                'name'          => $name,
                'description'   => $description,
                'pictureName'   => $pictureName,
                'alcohol'       => $alcohol
            ]);

            return $this->getConnection()->lastInsertId();
        } catch (PDOException $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }
}
