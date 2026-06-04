<?php

class PatientRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Search doctors by name OR specialty.
     * Returns doctor info + specialty name.
     */
    public function searchDoctors(string $keyword): array
    {
        $sql = "
            SELECT
                u.id        AS user_id,
                u.name,
                s.nom       AS specialite,
                m.id        AS medecin_id
            FROM medecins m
            JOIN users      u ON u.id = m.user_id
            JOIN specialites s ON s.id = m.specialite_id
            WHERE u.name LIKE :kw
               OR s.nom  LIKE :kw
            ORDER BY s.nom, u.name
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':kw' => "%{$keyword}%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all available slots for a given doctor.
     */
    public function getAvailableSlots(int $medecinId): array
    {
        $sql = "
            SELECT id, date, heure_debut, heure_fin
            FROM disponibilites
            WHERE medecin_id = :mid
              AND disponible  = TRUE
              AND date        >= CURDATE()
            ORDER BY date, heure_debut
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':mid' => $medecinId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all appointments for a patient (past + future).
     * Includes doctor name, specialty, and prescription if any.
     */
    public function getAppointments(int $patientId): array
    {
        $sql = "
            SELECT
                r.id            AS rdv_id,
                r.date_rdv,
                r.status,
                d.heure_debut,
                u.name          AS medecin_name,
                s.nom           AS specialite,
                o.contenu       AS ordonnance
            FROM rendez_vous r
            JOIN medecins    m ON m.id = r.medecin_id
            JOIN users       u ON u.id = m.user_id
            JOIN specialites s ON s.id = m.specialite_id
            LEFT JOIN disponibilites d ON d.medecin_id = m.id
                AND d.date = r.date_rdv
            LEFT JOIN ordonnances o ON o.rendez_vous_id = r.id
            WHERE r.patient_id = :pid
            ORDER BY r.date_rdv DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':pid' => $patientId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get the patient row linked to a user_id.
     */
    public function getByUserId(int $userId): ?array
    {
        $sql  = "SELECT * FROM patients WHERE user_id = :uid LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':uid' => $userId]);
        $row  = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
}