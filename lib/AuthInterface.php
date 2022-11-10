<?php

declare(strict_types=1);

interface AuthInterface { //Interface est un autre mot clé pour parler caractérisé une Class. abstract en est un autre par exmple
    public function auth(array $user, string $password): bool;
}
