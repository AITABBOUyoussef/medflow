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

    public function findById($id)
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM rendez_vous
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function findByMedecin($medecinId)
    {
        $stmt = $this->pdo->prepare("
            SELECT rv.*,
                   u.name AS patient_name
            FROM rendez_vous rv
            INNER JOIN patients p
                ON rv.patient_id = p.id
            INNER JOIN users u
                ON p.user_id = u.id
            WHERE rv.medecin_id = ?
            ORDER BY rv.date_rdv DESC
        ");

        $stmt->execute([$medecinId]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findByPatient($patientId)
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM rendez_vous
            WHERE patient_id = ?
            ORDER BY date_rdv DESC
        ");

        $stmt->execute([$patientId]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function create($patientId, $medecinId, $dateRdv)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO rendez_vous
            (patient_id, medecin_id, date_rdv, status)
            VALUES (?, ?, ?, 'EN_ATTENTE')
        ");

        return $stmt->execute([
            $patientId,
            $medecinId,
            $dateRdv
        ]);
    }

    public function updateStatus($id, $status)
    {
        $stmt = $this->pdo->prepare("
            UPDATE rendez_vous
            SET status = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $status,
            $id
        ]);
    }

    public function confirm($id)
    {
        return $this->updateStatus($id, 'CONFIRME');
    }

    public function cancel($id)
    {
        return $this->updateStatus($id, 'ANNULE');
    }

    public function finish($id)
    {
        return $this->updateStatus($id, 'TERMINE');
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM rendez_vous
            WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }

    public function countAll()
    {
        $stmt = $this->pdo->query("
            SELECT COUNT(*) AS total
            FROM rendez_vous
        ");

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

public function countByStatus($status): int
{
    $stmt = $this->pdo->prepare("
        SELECT COUNT(*) AS total
        FROM rendez_vous
        WHERE status = ?
    ");

    $stmt->execute([$status]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return (int) $result['total'];
}

}