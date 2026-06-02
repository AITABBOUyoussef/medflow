<?php

class Patient
{
    private int $id;
    private int $userId;
    private ?string $birthDate;

    public function __construct(
        int $id,
        int $userId,
        ?string $birthDate
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->birthDate = $birthDate;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getBirthDate(): ?string
    {
        return $this->birthDate;
    }
}