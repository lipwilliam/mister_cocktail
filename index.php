<?php

// La classe qui va dispatcher les routes en fonction de la demande utilisateur (par defaut vers home)
require_once 'lib/Router.php';
// Appel de la sassion via une classe
require 'lib/Session.php';

// On appel une méthode static au lieu de faire une instanciation
Session::start(); //seulement pour Session on utilise ::

// Ici on récupère le paramètre GET dans la méthode handleRequest
// Ce paramètre GET['page'] s'il existe, nous aidera à instancier le bon controlleur
// ainsi que la bonne méthode d'action

// Debug
// var_dump('POST', $_POST);
// var_dump('FILES', $_FILES);
// die;

// instance
$router = new Router;
// Check Route
$router->handleRequest();
