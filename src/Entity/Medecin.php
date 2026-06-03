<?php

namespace Src\Entities;

class Medecin extends User
{
    private int $specialiteId;

    public function __construct(
        int $id = 0,
        string $name = '',
        string $email = '',
        string $password = '',
        int $roleId = 0,
        int $specialiteId = 0
    ) {
        parent::__construct($id, $name, $email, $password, $roleId);
        $this->specialiteId = $specialiteId;
    }

    public function getSpecialiteId(): int
    {
        return $this->specialiteId;
    }

    public function setSpecialiteId(int $specialiteId): void
    {
        $this->specialiteId = $specialiteId;
    }
}