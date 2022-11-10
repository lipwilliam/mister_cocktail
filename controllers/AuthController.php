<?php

declare(strict_types=1);

require_once 'AbstractController.php';
require_once 'lib/AuthInterface.php';
require_once 'models/User.php';

class AuthController extends AbstractController implements AuthInterface {
    private User $userM;

    public function __construct() {
        // Rappel des propriétés et méthodes du parent
        parent::__construct();
        // Composition d'un model
        $this->userM = new User;
    }

    public function login(?array $form): void {
        try {
            // If submit
            if (count($form) > 0) {
                extract($form);
                // Check Empty form
                if ($this->isEmptyForm($form)) throw new LogicException("Merci de remplir tous les champs");
                // Check valid email
                if (!$this->isValidEmail($email)) throw new LogicException("L'email est invalide");
                // Fill User
                if (!$user = $this->userM->findByEmail($email)) throw new LogicException("L'utilisateur n'existe pas");
                // try to save it
                // Need Authenticator Interface
                if ($this->auth($user, $password)) {
                    // Init session
                    Session::init((int) $user['id'], $user['name'], $user['email'], (int) $user['role_id']);
                    // Redirect to home to login
                    $this->redirectTo('home');
                } else throw new LogicException("Mot de passe incorrect");
            }
        } catch (LogicException $e) {
            $this->error = $e->getMessage();
        }
        $error = $this->error ?? null; //si $this->error existe et n'est pas null alors on l'affiche, sinon on affiche null
        // Display form
        $this->render('login', ['error' => $error]); //affiche dans la page login un tableau avec les différentes $error
    }

    public function signin(?array $form): void {
        // Test si data -> traitement
        try {
            // If submit
            if (count($form) > 0) {
                extract($form);
                // Check Empty form
                if ($this->isEmptyForm($form)) throw new LogicException("Merci de remplir tous les champs");
                // Check valid email
                if (!$this->isValidEmail($email)) throw new LogicException("L'email est invalide");
                // yet exist by name
                if ($this->userM->findByName($name)) throw new LogicException("Un utilisateur existe déjà avec ce nom !!! ");
                // yet exist by mail
                if ($this->userM->findByEmail($email)) throw new LogicException("Un utilisateur existe déjà avec cet email !!!");
                // Fill User Model with form datas
                $this->userM
                    ->setEmail($email)
                    ->setName($name)
                    ->setPassword($password);
                // try to save it
                if ($this->userM->insert()) {
                    // Redirect to home to login
                    $this->redirectTo('login');
                } else throw new LogicException("Error Processing Request");
            } else throw new LogicException("Merci de ne pas truquer le form");
        } catch (LogicException $e) {
            $this->error = $e->getMessage();
        }
        $error = $this->error ?? null;

        // Display form
        $this->render('signin', ['error' => $error]); //affiche dans la page signin un tableau avec les différentes $error
    }

    public function logout(): void {
        // Disconnect user
        Session::destroy();
        $this->render('home');
    }

    // implement interface
    public function auth(array $user, string $pass): bool {
        // Check password
        if (!password_verify($pass, $user['password'])) {
            return false;
        }
        return true;
    }
}
