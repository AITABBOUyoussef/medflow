<?php

class admin_repository{
    private PDO $db;

    public function __construct(PDO $databaseConnection) {
        $this->db = $databaseConnection;
    }

    public function createDoctor(string $doctor_name, string $doctor_email, string $doctor_password, int $specialite_id) {
    try {
        $this->db->beginTransaction();

        $queryUser = "INSERT INTO users (name, email, password,role_id) 
                      VALUES (:doctor_name, :doctor_email, :doctor_password, 2)";
        
        $stmtUser = $this->db->prepare($queryUser);

        $hashedPassword = password_hash($doctor_password, PASSWORD_BCRYPT);

        $stmtUser->execute([
            ':doctor_name'     => $doctor_name,
            ':doctor_email'    => $doctor_email,
            ':doctor_password' => $hashedPassword
        ]);

        $userId = $this->db->lastInsertId();

        $queryDoctor = "INSERT INTO medecins (user_id, specialite_id) 
                        VALUES (:user_id, :specialite_id)";
        
        $stmtDoctor = $this->db->prepare($queryDoctor);
        $stmtDoctor->execute([
            ':user_id'       => $userId,
            ':specialite_id' => $specialite_id
        ]);

        $this->db->commit();
        return true;

    } catch (PDOException $e) {
        if ($this->db->inTransaction()) {
            $this->db->rollBack();
        }
        error_log("Erreur createDoctor : " . $e->getMessage());
        return false;
    }
}
public function getAllDoctors() {
    try {
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
public function creatSpécialité($name_spécialité){
    try {
        $query = "INSERT INTO `specialites` (`nom`) VALUES (:nom_specialite)";
        $stmtUser = $this->db->prepare($query);
        
        $result = $stmtUser->execute([
            ':nom_specialite' => $name_spécialité,
        ]);
        
        return $result; 
        
    } catch(PDOException $e) {
        error_log("Erreur createSpecialite : " . $e->getMessage());
        return false;
    }
}
public function updateDoctor(int $id, string $doctor_name, int $specialite_id, string $doctor_status): bool {
    try {
        $this->db->beginTransaction();

        $stmtUser = $this->db->prepare("UPDATE users SET name = ?, statut = ? WHERE id = ?");
        $stmtUser->execute([$doctor_name, $doctor_status, $id]);

        $stmtMed = $this->db->prepare("UPDATE medecins SET specialite_id = ? WHERE user_id = ?");
        $stmtMed->execute([$specialite_id, $id]);

        $this->db->commit();
        return true;

    } catch (PDOException $e) {
        $this->db->rollBack();
        die("Erreur Repository: " . $e->getMessage()); 
    }
}
public function deleteSpécialité(string $name): bool {
    try {
        $queryDocs = "DELETE FROM medecins WHERE specialite_id = (SELECT id FROM specialites WHERE nom = ?)";
        $stmtDocs = $this->db->prepare($queryDocs);
        $stmtDocs->execute([$name]);
        $querySpec = "DELETE FROM specialites WHERE nom = ?";
        $stmtSpec = $this->db->prepare($querySpec);
        $stmtSpec->execute([$name]);
        return $stmtSpec->rowCount() > 0;
    } catch (PDOException $e) {
        die("Erreur Repository (Delete Spécialité): " . $e->getMessage()); 
    }
}
}
