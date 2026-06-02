<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Repository/admin_repository.php';


// 1. Dima bda s-session bch t-stakhdem les messages flash
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
// 2. Vérification dyal s-système POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Récupération de la data m l-formulaire
    $doctor_name   = trim($_POST['doctor_name'] ?? '');
    $doctor_email  = trim($_POST['doctor_email'] ?? '');
    $doctor_password = $_POST['doctor_password'] ?? '';
    $specialite_id = isset($_POST['specialite_id']) ? (int)$_POST['specialite_id'] : 0;

    // Validation sghira dyal l-champs (US 3.1)
    if (!empty($doctor_name) && !empty($doctor_email) && !empty($doctor_password) && $specialite_id > 0) {
        
        // 3. Appel dyal la méthode li gaddina
        $result = $repository->createDoctor($doctor_name, $doctor_email, $doctor_password, $specialite_id);

        if ($result) {
            // Message dyal Succès
            $_SESSION['success'] = "Le compte du Dr. " . htmlspecialchars($doctor_name) . " a été créé avec succès !";
        } else {
            // Message dyal Erreur f s-système (Email déjà existant par exemple)
            $_SESSION['error'] = "Une erreur est survenue lors de la création du compte. L'email est peut-être déjà utilisé.";
        }

    } else {
        $_SESSION['error'] = "Veuillez remplir tous les champs obligatoires (*) !";
    }

    // 4. Redirection direct l l-page dyal l-dashboard/médecins bash mat-répétach la requête ila dar actualiser
    header('Location: ../../views/dashboard_admin.php');
    exit();
}


