<?php

declare(strict_types=1);

require_once 'AbstractController.php';

class HomeController extends AbstractController {
    public function __construct() {
        parent::__construct();
    }

    public function index(): void {
        // Redirection
        $this->render('home');
    }

    public function contact(): void {
        // Redirection
        $this->render('contact');
    }
}
