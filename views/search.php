<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/repository/patientRepository.php';

$db          = DB::connect();
$patientRepo = new PatientRepository($db);

$keyword   = trim($_GET['search'] ?? '');
$medecinId = isset($_GET['medecin_id']) ? (int)$_GET['medecin_id'] : null;

$doctors        = [];
$slots          = [];
$selectedDoctor = null;

if (!empty($keyword)) {
    $doctors = $patientRepo->searchDoctors($keyword);
}

if ($medecinId) {
    $slots = $patientRepo->getAvailableSlots($medecinId);
    foreach ($doctors as $d) {
        if ($d['medecin_id'] == $medecinId) {
            $selectedDoctor = $d;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedFlow - Trouver un Médecin</title>
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
                <a href="search.php" class="text-blue-600 font-medium border-b-2 border-blue-600 pb-1">Rechercher</a>
                <a href="mesRendezVous.php" class="text-gray-500 hover:text-blue-600 font-medium transition-colors">Mes Rendez-vous</a>
                <div class="h-6 w-px bg-gray-200"></div>
                <a href="logout.php" class="text-red-500 hover:text-red-700 font-medium transition-colors">Déconnexion</a>
            </div>
        </div>
    </div>
</nav>

<div class="max-w-6xl mx-auto px-4 py-8">

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Search bar -->
    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6 mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Trouver un Médecin</h2>
        <form method="GET" class="flex gap-4">
            <input
                type="text"
                name="search"
                placeholder="Nom du médecin ou spécialité (ex: Cardiologue)..."
                value="<?= htmlspecialchars($keyword) ?>"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
            >
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-medium transition-colors whitespace-nowrap">
                Rechercher
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- LEFT: Doctor list -->
        <div>
            <?php if (!empty($keyword) && empty($doctors)): ?>
                <div class="bg-white p-6 rounded-2xl text-center text-gray-500 border border-gray-100">
                    Aucun médecin trouvé pour "<strong><?= htmlspecialchars($keyword) ?></strong>".
                </div>

            <?php elseif (!empty($doctors)): ?>
                <p class="text-sm text-gray-500 mb-3"><?= count($doctors) ?> médecin(s) trouvé(s)</p>
                <div class="grid gap-4">
                    <?php foreach ($doctors as $doc): ?>
                        <div class="bg-white rounded-2xl p-5 shadow-sm border <?= $medecinId == $doc['medecin_id'] ? 'border-blue-500 ring-2 ring-blue-100' : 'border-gray-100' ?> flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    Dr. <?= htmlspecialchars($doc['name']) ?>
                                </h3>
                                <span class="inline-block bg-blue-50 text-blue-600 text-sm px-3 py-1 rounded-full mt-1">
                                    <?= htmlspecialchars($doc['specialite']) ?>
                                </span>
                            </div>
                            <a href="search.php?search=<?= urlencode($keyword) ?>&medecin_id=<?= $doc['medecin_id'] ?>"
                               class="border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                Voir créneaux
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php else: ?>
                <div class="bg-white p-8 rounded-2xl text-center text-gray-400 border border-gray-100">
                    <p>Lancez une recherche pour trouver un médecin.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- RIGHT: Available slots -->
        <div>
            <?php if ($medecinId && $selectedDoctor): ?>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-1">
                        Dr. <?= htmlspecialchars($selectedDoctor['name']) ?>
                    </h3>
                    <p class="text-blue-600 text-sm mb-4"><?= htmlspecialchars($selectedDoctor['specialite']) ?></p>

                    <?php if (empty($slots)): ?>
                        <div class="text-center text-gray-400 py-8">
                            Aucun créneau disponible pour ce médecin.
                        </div>
                    <?php else: ?>
                        <?php
                            $grouped = [];
                            foreach ($slots as $slot) {
                                $grouped[$slot['date']][] = $slot;
                            }
                        ?>
                        <?php foreach ($grouped as $date => $daySlots): ?>
                            <div class="mb-5">
                                <p class="text-sm font-semibold text-gray-500 mb-2">
                                    📅 <?= date('d/m/Y', strtotime($date)) ?>
                                </p>
                                <div class="flex flex-wrap gap-2">
                                    <?php foreach ($daySlots as $slot): ?>
                                        <?php if (!empty($_SESSION['user_id'])): ?>
                                            <form method="POST" action="book.php">
                                                <input type="hidden" name="medecin_id"       value="<?= $medecinId ?>">
                                                <input type="hidden" name="disponibilite_id" value="<?= $slot['id'] ?>">
                                                <input type="hidden" name="date_rdv"         value="<?= $slot['date'] ?>">
                                                <button type="submit"
                                                    class="bg-blue-50 hover:bg-blue-600 hover:text-white text-blue-600 border border-blue-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                                    🕐 <?= substr($slot['heure_debut'], 0, 5) ?>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <a href="login.php"
                                               class="bg-gray-50 text-gray-400 border border-gray-200 px-4 py-2 rounded-lg text-sm font-medium">
                                                🕐 <?= substr($slot['heure_debut'], 0, 5) ?>
                                                <span class="text-xs">(connexion)</span>
                                            </a>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <div class="bg-white p-8 rounded-2xl text-center text-gray-400 border border-gray-100">
                    <p>Sélectionnez un médecin pour voir ses créneaux.</p>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>
</body>
</html>