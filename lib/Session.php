<?php

declare(strict_types=1);

/**
 * Classe représentant la session php $_SESSION
 *
 * liste de fonctionnalitées :
 *      - start(): void // Démarrage de la session, afin de pouvoir l'utiliser
 *      - destroy(): void // Destruction de la session, afin de déconnecter le user
 *      - init(id, nom, email, ... (role) ): void // Remplissage de la session avec les infos du user
 *      - isConnected(): bool // méthode retournerai un booléen pour dire si oui ou non quelqu'un est connecté
 *      - getLogged(): array // méthode retournerai les infos du user connecté
 *
 * Usage de l'opérateur static '::'
 * Pour utiliser des props ou méthodes static au sein de la class elle-même
 */
class Session {
    public static function start(): void { //static nous permet de ne pas avoir à utiliser l'instanciation pour faire l'appel des méthodes d'une classe
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function destroy(): void {
        $_SESSION['auth'] = [];
        unset($_SESSION['auth']);
    }

    public static function init(int $id, string $nom, string $email, int $isAdmin): void {
        //TODO Comment savoir si admin ou pas? Faire ce qu'il faut pour les différencier
        $_SESSION['auth'] = [
            'id'    => $id,
            'name'  => $nom,
            'email' => $email,
            'admin' => $isAdmin === 2 ? false : true //voir bdd mister_cocktail_oo
        ];
    }

    public static function isConnected(): bool {
        return isset($_SESSION['auth']) ?? false; //test pour savoir si la variable a gauche existe et n'est pas null et on la return, sinon on return false
    }

    public static function isAdmin(): bool {
        return $_SESSION['auth']['admin'] ?? false; //test pour savoir si la variable a gauche existe et n'est pas null et on la return, sinon on return false
    }

    public static function getLogged() {
        // il faut utiliser 'self' ou le nom de la classe elle-même, ici 'Session' devant l'opérateur
        return self::isConnected() ? $_SESSION['auth'] : false; //on peut utiliser le self:: a cause du static de la function isConnected
    }

    public static function setError(string $error = null): void {
        $_SESSION['error'] = $error;
    }

    public static function getError(): ?string {
        return isset($_SESSION['error']) ? $_SESSION['error'] : null; //si la clé error existe et n'est pas null dans array SESSION on la return, sinon on return null
    }

    public static function addFlash(string $error = null): void {
        $_SESSION['flash'] = $error;
    }

    public static function hasFlash(): bool {
        return count($_SESSION['flash']) > 0;
    }

    public static function getFlash(): ?string {
        return $_SESSION['flash'] ?? null; // si la clé flash existe et n'est pas null alors on la return sinon on return null
    }
}
