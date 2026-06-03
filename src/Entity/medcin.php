<?php

require_once 'User.php';

// ضروري نديرو use حيت الـ User داخلة ف Namespace
use Src\Entities\User;

class Medecin extends User
{
    private string $specialite;

    public function __construct(
        string $name = '',
        string $email = '',
        string $password = '',
        string $specialite = '',
        int $id = 0,
        int $roleId = 0
    ) {
        parent::__construct($id, $name, $email, $password, $roleId);
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