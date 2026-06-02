<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../Repository/admin_repository.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $database = new Database();
    $dbConnection = $database->connect();

    $repository = new admin_repository($dbConnection);
}