<?php

declare(strict_types=1);
/**
 * Cette classe contient des comportements qui vont être utiles à tous nos controleurs
 * Ex : redirection, récupération d'erreurs, enregistrement d'une erreur, test si varaiable vide ou null, si email valide, ...
 */
abstract class AbstractController {
    private ?string $error;

    public function __construct() {
        $this->error = null;
    }

    // Behaviors
    /**
     * Rendu de la vue associée
     *
     * @param string $viewName
     * @param array|null $args
     * @return void
     */
    protected function render(string $viewName, ?array $args = null): void { //affiche dans le template designé le 2e parametre
        $params = $args;
        $template = $viewName;
        include_once 'layout.php';
    }

    /**
     * Redirection vers une autre page
     *
     * @param string $routeName
     * @return void
     */
    protected function redirectTo(string $routeName = 'home'): void {
        header("Location: index.php?page=$routeName");
        exit;
    }

    /**
     * Debug
     *
     * @param array $args
     * @return void
     */
    protected function dd(array $args): void {
        echo '<pre>';
        print_r($args);
        echo '</pre>';
    }

    /**
     * Get the value of error
     */
    protected function getError() {
        return $this->error;
    }

    /**
     * Set the value of error
     *
     * @return  self
     */
    protected function setError($error) {
        $this->error = $error;
        return $this;
    }

    // Behaviors move to FormValidator class
    /**
     * Valider qu'un formulaire ne soit pas remplit
     *
     * @param array $form
     * @return boolean
     */
    protected function isNullForm(array $form): bool {
        foreach ($form as $field) {
            if (is_null($field)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Valider qu'un formulaire soit vide
     *
     * @param array $form
     * @return boolean
     */
    protected function isEmptyForm(array $form): bool {
        foreach ($form as $field) {
            if (empty($field)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Valider un email
     *
     * @param [type] $email
     * @return boolean
     */
    protected function isValidEmail($email): bool {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    /**
     * Limiter un rendu textuel
     *
     * @param [type] $text
     * @param [type] $limit
     * @return void
     */
    public function limitText($text, $limit) {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos   = array_keys($words);
            $text  = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }
}
