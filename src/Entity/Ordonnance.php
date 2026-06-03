<?php

namespace Src\Entities;

class Ordonnance
{
    private int $id;
    private int $rendezVousId;
    private string $contenu;

    public function __construct(
        int $id = 0,
        int $rendezVousId = 0,
        string $contenu = ''
    ) {
        $this->id = $id;
        $this->rendezVousId = $rendezVousId;
        $this->contenu = $contenu;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRendezVousId(): int
    {
        return $this->rendezVousId;
    }

    public function getContenu(): string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): void
    {
        $this->contenu = $contenu;
    }
}