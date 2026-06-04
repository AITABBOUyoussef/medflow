<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/repository/patientRepository.php';

// Auth check
if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'PATIENT') {
    header('Location: login.php');
    exit;
}

$db          = DB::connect();
$patientRepo = new PatientRepository($db);
$patient     = $patientRepo->getByUserId($_SESSION['user_id']);

if (!$patient) {
    header('Location: login.php');
    exit;
}

$appointments = $patientRepo->getAppointments($patient['id']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedFlow - Mes Rendez-vous</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen font-sans">

<!-- Navbar -->
<nav class="bg-white shadow-sm border-b border-gray-100">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <span class="text-2xl font-bold text-blue-600">MedFlow</span>
            </div>
            <div class="flex items-center space-x-8">
                <a href="dashboard.php" class="text-gray-500 hover:text-blue-600 font-medium transition-colors">Accueil</a>
                <a href="search.php" class="text-gray-500 hover:text-blue-600 font-medium transition-colors">Rechercher un médecin</a>
                <a href="mesRendezVous.php" class="text-blue-600 font-medium border-b-2 border-blue-600 pb-1">Mes Rendez-vous</a>
                <div class="h-6 w-px bg-gray-200"></div>
                <a href="logout.php" class="text-red-500 hover:text-red-700 font-medium transition-colors">Déconnexion</a>
            </div>
        </div>
    </div>
</nav>

<div class="max-w-5xl mx-auto px-4 py-8">

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Mes Rendez-vous</h1>
        <a href="search.php" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl text-sm font-medium transition-colors">
            + Nouveau RDV
        </a>
    </div>

    <?php if (empty($appointments)): ?>
        <div class="bg-white p-12 rounded-2xl text-center text-gray-400 border border-gray-100">
            <p class="text-lg mb-3">Vous n'avez aucun rendez-vous.</p>
            <a href="search.php" class="text-blue-600 hover:underline text-sm">Prendre un rendez-vous →</a>
        </div>

    <?php else: ?>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="p-4 text-sm font-semibold text-gray-600">Médecin</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Spécialité</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Date & Heure</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Statut</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Ordonnance</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($appointments as $rdv): ?>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="p-4 font-medium text-gray-900">
                                Dr. <?= htmlspecialchars($rdv['medecin_name']) ?>
                            </td>
                            <td class="p-4 text-gray-600">
                                <?= htmlspecialchars($rdv['specialite']) ?>
                            </td>
                            <td class="p-4 text-gray-600">
                                <?= date('d/m/Y', strtotime($rdv['date_rdv'])) ?>
                                <?php if (!empty($rdv['heure_debut'])): ?>
                                    à <?= substr($rdv['heure_debut'], 0, 5) ?>
                                <?php endif; ?>
                            </td>
                            <td class="p-4">
                                <?php
                                $badgeClass = match($rdv['status']) {
                                    'EN_ATTENTE' => 'bg-yellow-100 text-yellow-800',
                                    'CONFIRME'   => 'bg-green-100 text-green-800',
                                    'TERMINE'    => 'bg-gray-100 text-gray-800',
                                    'ANNULE'     => 'bg-red-100 text-red-800',
                                    default      => 'bg-gray-100 text-gray-600',
                                };
                                $label = match($rdv['status']) {
                                    'EN_ATTENTE' => 'EN ATTENTE',
                                    'CONFIRME'   => 'CONFIRMÉ',
                                    'TERMINE'    => 'TERMINÉ',
                                    'ANNULE'     => 'ANNULÉ',
                                    default      => $rdv['status'],
                                };
                                ?>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $badgeClass ?>">
                                    <?= $label ?>
                                </span>
                            </td>
                            <td class="p-4">
                                <?php if ($rdv['status'] === 'TERMINE' && !empty($rdv['ordonnance'])): ?>
                                    <a
                                        href="download_ordonnance.php?rdv_id=<?= $rdv['rdv_id'] ?>"
                                        class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center gap-1"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                        Télécharger
                                    </a>
                                <?php else: ?>
                                    <span class="text-gray-300 text-sm">—</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>
</body>
</html>