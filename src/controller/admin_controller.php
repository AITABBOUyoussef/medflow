<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Repository/admin_repository.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$database = new Database();
$dbConnection = $database->connect();
$repository = new admin_repository($dbConnection);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['action']) && $_POST['action'] === 'update_doctor') {
        
        $doctor_id     = (int)($_POST['doctor_id'] ?? 0);
        $doctor_name   = trim($_POST['doctor_name'] ?? '');
        $specialite_id = (int)($_POST['specialite_id'] ?? 0);
        $doctor_status = trim($_POST['doctor_status'] ?? 'Actif');

        if ($doctor_id > 0 && !empty($doctor_name) && $specialite_id > 0) {
            
            $isUpdated = $repository->updateDoctor($doctor_id, $doctor_name, $specialite_id, $doctor_status);

            if ($isUpdated) {
                $_SESSION['success'] = "Le profil du médecin (Dr. " . htmlspecialchars($doctor_name) . ") a été modifié avec succès !";
            } else {
                $_SESSION['error'] = "Une erreur est survenue lors de la modification dans la base de données.";
            }
            
        } else {
            $_SESSION['error'] = "Veuillez vérifier les informations saisies. Tous les champs sont obligatoires.";
        }

        header('Location: ../../views/admin/dashboard_admin.php');
        exit();
    }

    if (isset($_POST['action']) && $_POST['action'] === 'delete_specialite') {
        
        $specialite_name = trim($_POST['specialite_name'] ?? '');

        if (!empty($specialite_name)) {
            
            $isDeleted = $repository->deleteSpécialité($specialite_name);

            if ($isDeleted) {
                $_SESSION['success'] = "La spécialité a été supprimée avec succès !";
            } else {
                $_SESSION['error'] = "Impossible de supprimer la spécialité. Elle est peut-être liée à un médecin.";
            }
        } else {
            $_SESSION['error'] = "Nom de spécialité invalide.";
        }

        header('Location: ../../views/admin/dashboard_admin.php');
        exit();
    }

    if (isset($_POST['doctor_name']) && !isset($_POST['action'])) { 
        
        $doctor_name     = trim($_POST['doctor_name'] ?? '');
        $doctor_email    = trim($_POST['doctor_email'] ?? '');
        $doctor_password = $_POST['doctor_password'] ?? '';
        $specialite_id   = isset($_POST['specialite_id']) ? (int)$_POST['specialite_id'] : 0;

        if (!empty($doctor_name) && !empty($doctor_email) && !empty($doctor_password) && $specialite_id > 0) {
            
            $result = $repository->createDoctor($doctor_name, $doctor_email, $doctor_password, $specialite_id);

            if ($result) {
                $_SESSION['success'] = "Le حساب du Dr. " . htmlspecialchars($doctor_name) . " a été créé avec succès !";
            } else {
                $_SESSION['error'] = "Une erreur est survenue lors de la création du compte. L'email est peut-être déjà utilisé.";
            }
        } else {
            $_SESSION['error'] = "Veuillez remplir tous les champs obligatoires (*) !";
        }

        header('Location: ../../views/admin/dashboard_admin.php');
        exit();
    }

    if (isset($_POST['add_spécialité'])) {
        $name_spécialité = htmlspecialchars(trim($_POST['spécialité_name'] ?? ''));

        if (empty($name_spécialité)) {
            header('Location: ../../views/admin/dashboard_admin.php?erreur_empty');
            exit(); 
        }
        
        $succ = $repository->creatSpécialité($name_spécialité);

        if ($succ) {
            header('Location: ../../views/admin/dashboard_admin.php?op=scc');
            exit();
        } else {
            header('Location: ../../views/admin/dashboard_admin.php?error=db_error');
            exit();
        }
    }
}

header('Location: ../../views/admin/dashboard_admin.php');
exit();