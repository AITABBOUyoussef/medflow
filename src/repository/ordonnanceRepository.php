<?php
class ordonnanceRepository{
    private $db;
    public function __construct($db){
        $this->db = $db;
    }
    public function getByPatient($patientId){
        $sql= "SELECT o.* From ordonnances o JOIN rendez_vous_id = r.id where r.patient_id = ?";
       $stmt = $this->db->prepare($sql);
       $stmt->execute([$patientId]);
       return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
