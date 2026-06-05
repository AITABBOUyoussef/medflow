<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../config/DB.php';
require_once __DIR__ . '/../../src/repository/ordonnanceRepository.php';
require_once __DIR__ . '/../../src/repository/patientRepository.php';

$user = $_SESSION['user'] ?? [];
$userId = $_SESSION['user_id'] ?? ($user['id'] ?? null);
$userRole = $_SESSION['role'] ?? ($user['role'] ?? null);

// Must be logged in as patient
if (empty($userId) || $userRole !== 'PATIENT') {
    header('Location: login.php');
    exit;
}

$rdvId = (int) ($_GET['rdv_id'] ?? 0);

if (!$rdvId) {
    header('Location: mesRendezVous.php');
    exit;
}

$db      = DB::connect();
$ordoRepo = new OrdonnanceRepository($db);
$ordo     = $ordoRepo->getByRdvId($rdvId);

if (!$ordo) {
    $_SESSION['error'] = "Ordonnance introuvable.";
    header('Location: mesRendezVous.php');
    exit;
}

// Force browser to download as .txt
header('Content-Type: text/plain; charset=utf-8');
header('Content-Disposition: attachment; filename="ordonnance_rdv_' . $rdvId . '.txt"');
echo $ordo['contenu'];
exit;