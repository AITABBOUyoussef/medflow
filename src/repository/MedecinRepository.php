<?php

include_once __DIR__ . "/../../config/DB.php";

class MedecinRepository
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = DB::connect();
    }

    public function findById($id)
    {
        $stmt = $this->pdo->prepare("
            SELECT m.*,
                   u.name,
                   u.email,
                   s.nom AS specialite
            FROM medecins m
            INNER JOIN users u
                ON m.user_id = u.id
            INNER JOIN specialites s
                ON m.specialite_id = s.id
            WHERE m.id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function findByUserId($userId)
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM medecins
            WHERE user_id = ?
        ");

        $stmt->execute([$userId]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public static function confirmRdvAction()
    {
        $repository = new RendezVousRepository();

        $repository->confirm($_GET['id']);

        header('Location: index.php?action=medecin_dashboard');
        exit;
    }


    public static function cancelRdvAction()
    {
        $repository = new RendezVousRepository();

        $repository->cancel($_GET['id']);

        header('Location: index.php?action=medecin_dashboard');
        exit;
    }


}