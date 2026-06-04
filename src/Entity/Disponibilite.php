<?php

namespace Src\Entities;

class Disponibilite
{
    private int $id;
    private int $medecinId;
    private string $date;
    private string $heureDebut;
    private string $heureFin;
    private bool $disponible;

    public function __construct(
        int $id = 0,
        int $medecinId = 0,
        string $date = '',
        string $heureDebut = '',
        string $heureFin = '',
        bool $disponible = true
    ) {
        $this->id = $id;
        $this->medecinId = $medecinId;
        $this->date = $date;
        $this->heureDebut = $heureDebut;
        $this->heureFin = $heureFin;
        $this->disponible = $disponible;
    }

    public function getId(): int { return $this->id; }
    public function getMedecinId(): int { return $this->medecinId; }
    public function getDate(): string { return $this->date; }
    public function getHeureDebut(): string { return $this->heureDebut; }
    public function getHeureFin(): string { return $this->heureFin; }
    public function isDisponible(): bool { return $this->disponible; }
}