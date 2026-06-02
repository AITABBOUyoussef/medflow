<?php
class croneaux {
    private string $datHeure;
    private bool $disponible;

    public function __construct($datHeure , $disponible)
    {
        $this->datHeure = $datHeure;
        $this->disponible = $disponible;
    }
    public function getTime():string{
        return $this->datHeure;
    }
    public function getDisponible():string {
    return $this->disponible;
    }

    public function setTime(string $datHeure){
        return $this->datHeure;
    }
    public function setDisponible(string $disponible){
        return $this->disponible;
    }
}