<?php

class admin_repository{
    private PDO $db;

    public function __construct(PDO $databaseConnection) {
        $this->db = $databaseConnection;
    }

    public function createDoctor(string $doctor_name, string $doctor_email, string $doctor_password, int $specialite_id) {
    try {
        // 1. Bdaw b transation bash ila t'plantat chi haja f t-table s-taniya y-retraita kolshi
        $this->db->beginTransaction();

        // 2. Insérer s-compte f t-table users m3a l-role 'MEDECIN'
        $queryUser = "INSERT INTO users (name, email, password,role_id) 
                      VALUES (:doctor_name, :doctor_email, :doctor_password, 2)";
        
        $stmtUser = $this->db->prepare($queryUser);

        // Hashage dyal l-password bch ykon sécurisé
        $hashedPassword = password_hash($doctor_password, PASSWORD_BCRYPT);

        $stmtUser->execute([
            ':doctor_name'     => $doctor_name,
            ':doctor_email'    => $doctor_email,
            ':doctor_password' => $hashedPassword
        ]);

        // 3. Khod l-ID dyal user li yallah t-creea daba nict
        $userId = $this->db->lastInsertId();

        // 4. Insérer l-médecin f t-table medecins m3a l-spécialité dyalo (US 3.1)
        $queryDoctor = "INSERT INTO medecins (user_id, specialite_id) 
                        VALUES (:user_id, :specialite_id)";
        
        $stmtDoctor = $this->db->prepare($queryDoctor);
        $stmtDoctor->execute([
            ':user_id'       => $userId,
            ':specialite_id' => $specialite_id
        ]);

        // Ila kolshi daz mzyan, kan-validiw l-khdma
        $this->db->commit();
        return true;

    } catch (PDOException $e) {
        // Ila bghina n-raj3o l-base de données kif kant f l-wl f7alt l-khata
        if ($this->db->inTransaction()) {
            $this->db->rollBack();
        }
        // Tqder t-affichi l-erreur hna b err_log aw die() l-debug
        error_log("Erreur createDoctor : " . $e->getMessage());
        return false;
    }
}
public function getAllDoctors() {
    try {
        // SQL m9ad 100% 3la hssab l-tables dyalk
        $query = "SELECT 
                    users.name AS doctor_name,  
                    specialites.nom AS specialite_nom
                  FROM users 
                  JOIN medecins ON users.id = medecins.user_id
                  JOIN specialites ON specialites.id = medecins.specialite_id
                  ORDER BY users.id DESC";
                  
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur getAllDoctors : " . $e->getMessage());
        return [];
    }
}
}
