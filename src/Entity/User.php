<?php

declare(strict_types=1);
namespace Src\Entities;
class User
{
    protected int $id;
    protected string $name;
    protected string $email;
    protected string $password;
    protected int $roleId;

    public function __construct(
        int $id = 0,
        string $name = '',
        string $email = '',
        string $password = '',
        int $roleId = 0
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->roleId = $roleId;
    }

    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getEmail(): string { return $this->email; }
    public function getPassword(): string { return $this->password; }
    public function getRoleId(): int { return $this->roleId; }

    public function setName(string $name): void { $this->name = $name; }
    public function setEmail(string $email): void { $this->email = $email; }
    public function setPassword(string $password): void { $this->password = $password; }
    public function setRoleId(int $roleId): void { $this->roleId = $roleId; }
}