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
class Ingredient extends DatabaseConnector {
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
                FROM ingredient
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
                FROM ingredient'
            );

            return $result->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Insert ingredient
     */
    public function insert(string $name): void {
        try {
            $result = $this->getConnection()->prepare(
                'INSERT INTO ingredient (name) VALUES (:name)'
            );
            $result->execute(['name' => $name]);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
    }

    /**
     * Insert ingredient
     */
    public function assocCocktail(int $cocktailId, array $ingredients): void {
        try {
            foreach ($ingredients as $ingredient) {
                $result = $this->getConnection()->prepare(
                    'INSERT INTO cocktail_assoc(cocktail_id, ingredient_id) VALUES (:id_cocktail, :id_ingredient)'
                );
                $result->execute([
                    'id_cocktail' => $cocktailId,
                    'id_ingredient' => (int) $ingredient
                ]);
            }
        } catch (PDOException $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }
}
