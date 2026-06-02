<?php

class admin_repository{
    private PDO $db;

    public function __construct(PDO $databaseConnection) {
        $this->db = $databaseConnection;
    }
}