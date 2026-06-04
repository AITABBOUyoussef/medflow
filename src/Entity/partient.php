<?php

require_once 'User.php';

// ضروري نديرو use حيت الـ User داخلة ف Namespace
use Src\Entities\User;

class Patient extends User
{
    private string $phone;

    public function __construct(
        string $name = '',
        string $email = '',
        string $password = '',
        string $phone = '',
        int $id = 0,     
        int $roleId = 0
    ) {
        parent::__construct($id, $name, $email, $password, $roleId);
        $this->phone = $phone;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }
}