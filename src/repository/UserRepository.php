<?php
include_once __DIR__ . "/../../config/DB.php";
class UserRepository
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = DB::connect();
    }



}