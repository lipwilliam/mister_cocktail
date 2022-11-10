<?php

declare(strict_types=1);

require_once 'controllers/HomeController.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/CocktailController.php';
require_once 'controllers/DashboardController.php';

class Router {
    /**
     * Méthode de redirection vers les actions demandées
     * Via le $_GET['page'] ou 'home' par défaut
     * Chaque méthode appelée, interrogera la bdd si besoin
     * et effectuera les contrôle de formulaire nécessaire
     *
     * *NB: Il sera donc nécessaire de transmettre ces POSTs si une soumission est effectuée
     *
     * @return void
     */
    public function handleRequest(): void {
        // Define route
        $route = $_GET['page'] ?? 'home';
        // Merge file in post if exist and not null, otherwise return null
        $params = $_POST ?? null;

        // TODO Refactoring du router
        // Dispatch route
        switch ($route) {
            case 'home':
                $controller = new HomeController();
                $controller->index();
                break;
            case 'contact':
                $controller = new HomeController();
                $controller->contact();
                break;
            case 'cocktails':
                $controller = new CocktailController();
                $controller->index();
                break;
            case 'add_cocktail':
                // Post exist and File exist = > merge
                $params = array_merge($_POST, $_FILES ?? []);
                $controller = new CocktailController();
                $controller->add($params);
                break;
            case 'login':
                $controller = new AuthController();
                $controller->login($params);
                break;
            case 'signin':
                $controller = new AuthController();
                $controller->signin($params);
                break;
            case 'logout':
                $controller = new AuthController();
                $controller->logout();
                break;
            case 'dashboard':
                $controller = new DashboardController();
                $controller->index();
                break;
            case 'add_alcohol':
                $controller = new DashboardController();
                $controller->addAlcohol($params);
                break;
            case 'add_ingredient':
                $controller = new DashboardController();
                $controller->addIngredient($params);
                break;
        }
    }
}
