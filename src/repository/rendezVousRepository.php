<?php

class rendezVousRepository{
    private $db;
    public function __construct($db){
        $this->db = $db;
    }
    public function create($patientId, $medecinId, $dateRdv)
    {
    $sql = "INSERT INTO rendez_vous(patient_id,medecin_id,date_rdv,status)
    VALUES(?,?,?,'EN_ATTENTE')";

    $stmt =$this->db->prepare($sql);
    return $stmt->execute([
        $patientId,
        $medecinId,
        $dateRdv
    ]);
   }
}

?>