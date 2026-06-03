<?php

class PatientRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function searchDoctor($keyword)
    {
        $sql = "SELECT m.id, u.name,  s.nom  FROM medecins m
               
                JOIN users u ON m.user_id = u.id
                JOIN specialites s ON m.specialite_id = s.id
                WHERE u.name LIKE ?
                OR s.nom LIKE ?";

        $stmt = $this->db->prepare($sql);

        $search = "%".$keyword."%";

        $stmt->execute([$search, $search]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}