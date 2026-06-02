<?php

require_once 'User.php';

class Medecin extends User
{
    private string $specialite;

    public function __construct(
        string $name,
        string $email,
        string $password,
        string $specialite
    ) {
        parent::__construct($name, $email, $password);
        $this->specialite = $specialite;
    }

    public function getSpecialite(): string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): void
    {
        $this->specialite = $specialite;
    }
}