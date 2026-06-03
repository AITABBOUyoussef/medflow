<?php

namespace Src\Entities;

class Patient extends User
{
    private string $birthDate;

    public function __construct(
        int $id = 0,
        string $name = '',
        string $email = '',
        string $password = '',
        int $roleId = 0,
        string $birthDate = ''
    ) {
        parent::__construct($id, $name, $email, $password, $roleId);
        $this->birthDate = $birthDate;
    }

    public function getBirthDate(): string
    {
        return $this->birthDate;
    }

    public function setBirthDate(string $birthDate): void
    {
        $this->birthDate = $birthDate;
    }
}