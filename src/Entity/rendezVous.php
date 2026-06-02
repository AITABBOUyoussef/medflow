<?php
class RendezVous
{
    private int $id;
    private int $patientId;
    private int $medecinId;
    private string $dateRdv;
    private string $status;

    public function __construct(
        int $id,
        int $patientId,
        int $medecinId,
        string $dateRdv,
        string $status
    ) {
        $this->id = $id;
        $this->patientId = $patientId;
        $this->medecinId = $medecinId;
        $this->dateRdv = $dateRdv;
        $this->status = $status;
    }
}
