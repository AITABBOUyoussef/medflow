<?php

class RendezVousRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Book a new appointment (US 1.2).
     * - Inserts rendez_vous with EN_ATTENTE
     * - Marks the slot as unavailable (disponible = FALSE)
     * Both operations run in a transaction for data consistency.
     */
    public function book(int $patientId, int $medecinId, int $disponibiliteId, string $dateRdv): bool
    {
        try {
            $this->db->beginTransaction();

            // 1. Insert the appointment
            $sql = "
                INSERT INTO rendez_vous (patient_id, medecin_id, disponibilite_id, date_rdv, status)
                VALUES (?, ?, ?, ?, 'EN_ATTENTE')
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$patientId, $medecinId, $disponibiliteId, $dateRdv]);

            // 2. Mark the slot as taken so no other patient can book it
            $sqlSlot = "UPDATE disponibilites SET disponible = FALSE WHERE id = ?";
            $stmtSlot = $this->db->prepare($sqlSlot);
            $stmtSlot->execute([$disponibiliteId]);

            $this->db->commit();
            return true;

        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    /**
     * Update appointment status (used by doctor, but also cancellable by patient).
     */
    public function updateStatus(int $rdvId, string $newStatus): bool
    {
        $sql  = "UPDATE rendez_vous SET status = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$newStatus, $rdvId]);
    }

    /**
     * Get a single rendez_vous by ID.
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM rendez_vous WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
}