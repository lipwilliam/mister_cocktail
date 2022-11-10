<?php

declare(strict_types=1);

require_once 'AbstractController.php';
require_once 'models/Alcohol.php';
require_once 'models/Ingredient.php';

class DashboardController extends AbstractController {
    private Alcohol $alcoholModel;
    private Ingredient $ingredientModel;

    public function __construct() {
        parent::__construct();
        $this->alcoholModel = new Alcohol;
        $this->ingredientModel = new Ingredient;
    }

    public function index(): void {
        // Check if user isAdmin
        if (!Session::isAdmin()) {
            Session::destroy();
            $this->redirectTo('login');
        }
        // Redirection
        $this->render('dashboard', [
            'alcoholsCount' => count($this->alcoholModel->findAll()),
            'ingredientsCount' => count($this->ingredientModel->findAll())
        ]);
    }

    public function addAlcohol(?array $form = null): void {
        // Check if user isAdmin
        if (!Session::isAdmin()) {
            Session::destroy();
            $this->redirectTo('login');
        }
        try {
            // Si le post n'est pas vide
            if (count($form) > 0) {
                // Check if exist
                if ($this->alcoholModel->findByName($form['alcohol'])) {
                    throw new LogicException("Le produit existe déjà");
                }

                // Save it
                $this->alcoholModel->insert($form['alcohol']);
                // Redirection
                $this->redirectTo('dashboard');
            }
        } catch (LogicException $e) {
            $this->error = $e->getMessage();
        }

        $error = $this->error ?? null;
        // Sinon
        // On affiche le form
        $this->render('dashboard_add_alcohol', ['error' => $error]);
    }

    public function addIngredient(?array $form = null): void {
        // Check if user isAdmin
        if (!Session::isAdmin()) {
            Session::destroy();
            $this->redirectTo('login');
        }
        try {
            // Si le post n'est pas vide
            if (count($form) > 0) {
                // Check if exist
                if ($this->ingredientModel->findByName($form['ingredient'])) {
                    throw new LogicException("Le produit existe déjà");
                }

                // Save it
                $this->ingredientModel->insert($form['ingredient']);
                // Redirection
                $this->redirectTo('dashboard');
            }
        } catch (LogicException $e) {
            $this->error = $e->getMessage();
        }

        $error = $this->error ?? null;
        // Sinon
        // On affiche le form
        $this->render('dashboard_add_ingredient', ['error' => $error]);
    }
}
