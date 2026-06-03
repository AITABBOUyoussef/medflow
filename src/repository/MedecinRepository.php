<?php

include_once __DIR__ . "/../../config/DB.php";
class MedecinRepository
{

    private $pdo;
    public function __construct()
    {
        $this->pdo = DB::connect();
    }


}