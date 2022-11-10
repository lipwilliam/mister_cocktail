<?php

declare(strict_types=1);

require_once 'AbstractController.php';
require_once 'models/Cocktail.php';
require_once 'models/Alcohol.php';
require_once 'models/Ingredient.php';

class CocktailController extends AbstractController {
    private Cocktail $cocktailModel;
    private Alcohol $alcoholModel;
    private Ingredient $ingredientModel;

    public function __construct() {
        parent::__construct();
        // On a accès aux méthodes du model qui gère les Cocktails
        $this->cocktailModel = new Cocktail;
        $this->alcoholModel = new Alcohol;
        $this->ingredientModel = new Ingredient;
    }

    public function index(): void {
        // Use Cocktail Model to get all cocktails
        // Transmettre une variable qui les contient tous
        $cocktails = $this->cocktailModel->findAll();
        // Redirection
        $this->render('cocktails', $cocktails); //On affiche dans la view = template = page cocktails, les $cocktails
    }

    /**
     * Methode de traitement du formulaire d'ajout
     *
     * Ici, 1 - soit on affiche le form pour la 1ère fois
     * Soit 2 - on le traite, (success, error)
     *
     * @param array|null $form
     * @return void
     */
    public function add(?array $form): void {
        try {
            // 2 On traite
            if (isset($form) && count($form) > 0) {
                // Traitement
                // Extract de $_POST et $_FILES (merge)
                extract($form);
                // Check Empty form
                if ($this->isEmptyForm($form)) throw new LogicException("Merci de remplir tous les champs");
                // Check ingredients list
                if (count($form['ingredients']) === 0) throw new LogicException("Merci de selectionner au moins 1 ingrédient");
                // Check ingredients list (équivalent de $_FILES[’picture'])
                if (empty($picture['name'])) throw new LogicException("Merci de selectionner une photo");

                // Check File updloaded
                if ($form["picture"]["error"] == 0) {
                    // src : https://www.tutorialrepublic.com/php-tutorial/php-file-upload.php
                    // Check Extension - Size - Name
                    // Extension allowed
                    $extAllowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
                    $ext = pathinfo($form["picture"]['name'], PATHINFO_EXTENSION);
                    if (!array_key_exists($ext, $extAllowed)) throw new LogicException("Merci de choisir une photo au format suivant : png, jpg, jpeg");
                    // Save file on server
                    move_uploaded_file($form["picture"]["tmp_name"], "templates/www/img/" . $form["picture"]['name']);
                    // Check Ingredients
                    // Insertion du cocktail (2 steps : create cocktail, associate ingredients)
                    $cocktail_id = $this->cocktailModel->insert($name, $content, $picture['name'], (int) $alcohol_id);
                    // Assoc ingredients to cocktail
                    $this->ingredientModel->assocCocktail((int) $cocktail_id, $ingredients);

                    // Rediriger
                    $this->redirectTo('cocktails');
                }
            }
        } catch (LogicException $e) {
            $this->error = $e->getMessage();
        }

        // Define error
        $error = $this->error ?? null;
        // 1 On affiche
        // Transmettre 2 variables qui les contient tous (alcohols, ingredients)
        // Use Alcohol Model and Ingredient Model to build a cocktail
        $alcohols = $this->alcoholModel->findAll();
        $ingredients = $this->ingredientModel->findAll();

        // Redirection
        $this->render('add_cocktail', [
            'alcohols'      => $alcohols,
            'ingredients'   => $ingredients,
            'error'         => $error
        ]);
    }
}
