<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/repository/patientRepository.php';
require_once __DIR__ . '/../src/repository/rendezVousRepository.php';

// Must be logged in as patient
if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'PATIENT') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: search.php');
    exit;
}

$medecinId       = (int) ($_POST['medecin_id']       ?? 0);
$disponibiliteId = (int) ($_POST['disponibilite_id'] ?? 0);
$dateRdv         =        $_POST['date_rdv']          ?? '';

if (!$medecinId || !$disponibiliteId || !$dateRdv) {
    $_SESSION['error'] = "Informations manquantes pour la réservation.";
    header('Location: search.php');
    exit;
}

$db          = DB::connect();
$patientRepo = new PatientRepository($db);
$rdvRepo     = new RendezVousRepository($db);

$patient = $patientRepo->getByUserId($_SESSION['user_id']);

if (!$patient) {
    $_SESSION['error'] = "Profil patient introuvable.";
    header('Location: search.php');
    exit;
}

$success = $rdvRepo->book($patient['id'], $medecinId, $disponibiliteId, $dateRdv);

if ($success) {
    $_SESSION['success'] = "✅ Rendez-vous réservé avec succès ! Statut : EN ATTENTE de confirmation.";
    header('Location: mesRendezVous.php');
} else {
    $_SESSION['error'] = "Erreur lors de la réservation. Le créneau est peut-être déjà pris.";
    header('Location: search.php');
}
exit;