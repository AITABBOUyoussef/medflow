<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Repository/admin_repository.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$database = new Database();
$dbConnection = $database->connect();
$repository = new admin_repository($dbConnection);
// Security Check: Ila l-User machi Admin, rej3o direct (RBAC Check)
// if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 3) {
//     header('Location: ../views/auth/login.php');
//     exit();
// }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $doctor_name   = trim($_POST['doctor_name'] ?? '');
    $doctor_email  = trim($_POST['doctor_email'] ?? '');
    $doctor_password = $_POST['doctor_password'] ?? '';
    $specialite_id = isset($_POST['specialite_id']) ? (int)$_POST['specialite_id'] : 0;

    if (!empty($doctor_name) && !empty($doctor_email) && !empty($doctor_password) && $specialite_id > 0) {
        
        $result = $repository->createDoctor($doctor_name, $doctor_email, $doctor_password, $specialite_id);

        if ($result) {
            $_SESSION['success'] = "Le compte du Dr. " . htmlspecialchars($doctor_name) . " a été créé avec succès !";
        } else {
            $_SESSION['error'] = "Une erreur est survenue lors de la création du compte. L'email est peut-être déjà utilisé.";
        }

    } else {
        $_SESSION['error'] = "Veuillez remplir tous les champs obligatoires (*) !";
    }

    header('Location: ../../views/dashboard_admin.php');
    exit();
}


