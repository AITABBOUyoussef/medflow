<?php

include_once __DIR__ . "/../../config/DB.php";

class OrdonnanceRepository
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = DB::connect();
    }

    public function create($rendezVousId, $contenu)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO ordonnances
            (rendez_vous_id, contenu)
            VALUES (?, ?)
        ");

        return $stmt->execute([
            $rendezVousId,
            $contenu
        ]);
    }
}