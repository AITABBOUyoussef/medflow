<?php

include_once __DIR__ . "/../../config/DB.php";
include_once __DIR__ . "/BaseRepository.php";

class RendezVousRepository extends BaseRepository
{
 
    public static function findAll()
    {
        $stmt = self::getConnection()->prepare("
            SELECT *
            FROM rendez_vous
            ORDER BY date_rdv DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function findById($id)
    {
        $stmt = self::getConnection()->prepare("
            SELECT *
            FROM rendez_vous
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public static function findByMedecin($medecinId)
    {
        $stmt = self::getConnection()->prepare("
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

    public static function findByPatient($patientId)
    {
        $stmt = self::getConnection()->prepare("
            SELECT *
            FROM rendez_vous
            WHERE patient_id = ?
            ORDER BY date_rdv DESC
        ");

        $stmt->execute([$patientId]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function create($patientId, $medecinId, $dateRdv)
    {
        $stmt = self::getConnection()->prepare("
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

    public static function updateStatus($id, $status)
    {
        $stmt = self::getConnection()->prepare("
            UPDATE rendez_vous
            SET status = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $status,
            $id
        ]);
    }

    public static function confirm($id)
    {
        return self::updateStatus($id, 'CONFIRME');
    }

    public static function cancel($id)
    {
        return self::updateStatus($id, 'ANNULE');
    }

    public static function finish($id)
    {
        return self::updateStatus($id, 'TERMINE');
    }

    public static function delete($id)
    {
        $stmt = self::getConnection()->prepare("
            DELETE FROM rendez_vous
            WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }

    public static function countAll()
    {
        $stmt = self::getConnection()->query("
            SELECT COUNT(*) AS total
            FROM rendez_vous
        ");

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

public static function countByStatus($status): int
{
    $stmt = self::getConnection()->prepare(
        "SELECT COUNT(*) AS total FROM rendez_vous WHERE status = ?"
    );

    $stmt->execute([$status]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return (int) $result['total'];
}

}