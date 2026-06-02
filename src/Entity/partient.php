<?php

require_once 'User.php';

class Patient extends User
{
    private string $phone;

    public function __construct(
        string $name,
        string $email,
        string $password,
        string $phone
    ) {
        parent::__construct($name, $email, $password);
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