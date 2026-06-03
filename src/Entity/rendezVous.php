<?php

namespace Src\Entities;

class RendezVous
{
    private int $id;
    private int $patientId;
    private int $medecinId;
    private string $dateRdv;
    private string $status;

    public function __construct(
        int $id = 0,
        int $patientId = 0,
        int $medecinId = 0,
        string $dateRdv = '',
        string $status = 'EN_ATTENTE'
    ) {
        $this->id = $id;
        $this->patientId = $patientId;
        $this->medecinId = $medecinId;
        $this->dateRdv = $dateRdv;
        $this->status = $status;
    }

    public function getId(): int { return $this->id; }
    public function getPatientId(): int { return $this->patientId; }
    public function getMedecinId(): int { return $this->medecinId; }
    public function getDateRdv(): string { return $this->dateRdv; }
    public function getStatus(): string { return $this->status; }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}