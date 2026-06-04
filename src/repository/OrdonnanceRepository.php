<?php

include_once __DIR__ . "/../../config/DB.php";
include_once __DIR__ . "/BaseRepository.php";

class OrdonnanceRepository extends BaseRepository
{
  

    public static function create($rendezVousId, $contenu)
    {
        $stmt = self::getConnection()->prepare("
            INSERT INTO ordonnances
            (rendez_vous_id, contenu)
            VALUES (?, ?)
        ");

        return $stmt->execute([
            $rendezVousId,
            $contenu
        ]);
    }


    public function getByPatient(int $patientId): array
    {
        $sql = "
            SELECT
                o.id,
                o.contenu,
                r.date_rdv,
                u.name   AS medecin_name,
                s.nom    AS specialite,
                r.id     AS rdv_id
            FROM ordonnances o
            JOIN rendez_vous  r ON o.rendez_vous_id = r.id
            JOIN medecins     m ON m.id = r.medecin_id
            JOIN users        u ON u.id = m.user_id
            JOIN specialites  s ON s.id = m.specialite_id
            WHERE r.patient_id = :pid
            ORDER BY r.date_rdv DESC
        ";

        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute([':pid' => $patientId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get a single prescription by rendez_vous_id.
     */
    public function getByRdvId(int $rdvId): ?array
    {
        $stmt = self::getConnection()->prepare(
            "SELECT * FROM ordonnances WHERE rendez_vous_id = ? LIMIT 1"
        );
        $stmt->execute([$rdvId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
}