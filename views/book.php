<?php
session_start();

// Auth check
if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'PATIENT') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: search.php');
    exit;
}

require_once __DIR__ . '/../config/database.php';

$medecin_id = (int) ($_POST['medecin_id'] ?? 0);
$disponibilite_id = (int) ($_POST['disponibilite_id'] ?? 0);
$date_rdv = $_POST['date_rdv'] ?? '';

// Validate inputs
if ($medecin_id <= 0 || $disponibilite_id <= 0 || $date_rdv === '') {
    $_SESSION['error'] = "Informations manquantes pour la réservation.";
    header('Location: search.php');
    exit;
}

try {
    $db = DB::connect();

    // Get patient record linked to user
    $stmt = $db->prepare('SELECT id FROM patients WHERE user_id = :user_id LIMIT 1');
    $stmt->execute([':user_id' => (int) $_SESSION['user_id']]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$patient) {
        $_SESSION['error'] = "Profil patient introuvable.";
        header('Location: search.php');
        exit;
    }

    $patient_id = (int) $patient['id'];

    // Begin transaction
    $db->beginTransaction();

    try {
        // Insert appointment into rendez_vous
        $stmt = $db->prepare(
            'INSERT INTO rendez_vous (patient_id, medecin_id, date_rdv, status)
             VALUES (:patient_id, :medecin_id, :date_rdv, :status)'
        );
        $stmt->execute([
            ':patient_id' => $patient_id,
            ':medecin_id' => $medecin_id,
            ':date_rdv' => $date_rdv,
            ':status' => 'EN_ATTENTE',
        ]);

        // Mark slot as unavailable
        $stmt = $db->prepare(
            'UPDATE disponibilites SET disponible = FALSE WHERE id = :id'
        );
        $stmt->execute([':id' => $disponibilite_id]);

        // Commit transaction
        $db->commit();

        $_SESSION['success'] = "Rendez-vous réservé !";
        header('Location: mesRendezVous.php');
        exit;

    } catch (PDOException $e) {
        // Rollback on any database error
        $db->rollBack();
        throw $e;
    }

} catch (Exception $e) {
    $_SESSION['error'] = "Erreur lors de la réservation. Le créneau est peut-être déjà pris.";
    header('Location: search.php');
    exit;
}
?>