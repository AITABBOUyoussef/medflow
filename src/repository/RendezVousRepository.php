<?php

include_once __DIR__ . "/../../config/DB.php";

class RendezVousRepository
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = DB::connect();
    }

    public function findAll()
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM rendez_vous
            ORDER BY date_rdv DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

 
}