<?php
require_once __DIR__ . '/../../config/database.php';

$totalRDV = 0;
$totalSpecialites = 0;
$totalMedecins = 0;
$moyenneRDV = 0;
$tauxAnnulation = 0;
$specialites = [];
$doctorsList = [];

try {
    $dbClass = new Database();
    $db = $dbClass->connect();

    $querySpec = "SELECT id, nom FROM specialites ORDER BY nom ASC";
    $stmtSpec = $db->prepare($querySpec);
    $stmtSpec->execute();
    $specialites = $stmtSpec->fetchAll(PDO::FETCH_ASSOC);

    $queryDocs = "SELECT 
                users.id, 
                users.name AS doctor_name, 
                users.statut AS statut, 
                specialites.nom AS specialite_nom
              FROM users 
              INNER JOIN medecins ON users.id = medecins.user_id
              INNER JOIN specialites ON specialites.id = medecins.specialite_id
              ORDER BY users.id DESC";

    $stmtDocs = $db->prepare($queryDocs);
    $stmtDocs->execute();
    $doctorsList = $stmtDocs->fetchAll(PDO::FETCH_ASSOC);

    $queryTotalRDV = "SELECT COUNT(*) AS total FROM `rendez_vous`";
    $stmtTotal = $db->query($queryTotalRDV);
    $totalRDV = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    $queryTotalSpec = "SELECT COUNT(*) AS total FROM `specialites`";
    $stmtSpecCount = $db->query($queryTotalSpec);
    $totalSpecialites = $stmtSpecCount->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    $queryTotalDocs = "SELECT COUNT(*) AS total FROM `medecins`";
    $stmtDocsCount = $db->query($queryTotalDocs);
    $totalMedecins = $stmtDocsCount->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    $moyenneRDV = ($totalMedecins > 0) ? round($totalRDV / $totalMedecins, 1) : 0;

    $queryAnnule = "SELECT COUNT(*) AS total FROM `rendez_vous` WHERE `status` = 'Annulé' OR `status` = 'ANNULE'";
    $stmtAnnule = $db->query($queryAnnule);
    $totalAnnule = $stmtAnnule->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    $tauxAnnulation = ($totalRDV > 0) ? round(($totalAnnule / $totalRDV) * 100, 1) : 0;
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
$baseUrl = sprintf(
    "%s://%s%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME'],
    dirname($_SERVER['REQUEST_URI'], 3)
);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Médecins</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-50/50 min-h-screen font-sans antialiased text-slate-600 dynamic-layout">

    <?php include_once __DIR__ . '/../layout/aside_admin.php'; ?>

    <div class="lg:pl-72 w-full transition-all duration-300">
        <?php include_once __DIR__ . '/../layout/header_admin.php'; ?>
    </div>

    <main class="pt-24 pb-12 px-4 sm:px-6 lg:pl-72 max-w-[1600px] mx-auto transition-all duration-300">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-emerald-50 text-emerald-700 p-3 rounded-lg mb-4 text-sm border border-emerald-200">
                <i class="fa-solid fa-check-circle mr-2"></i> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-rose-50 text-rose-700 p-3 rounded-lg mb-4 text-sm border border-rose-200">
                <i class="fa-solid fa-triangle-exclamation mr-2"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        <div class="mb-6">
            <h1 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-user-doctor text-cyan-500"></i> Liste des Médecins
            </h1>
            <p class="text-xs text-slate-400">Consultez, modifiez et gérez le statut de tous les médecins inscrits.</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden transition-all">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200/60 select-none">
                            <th class="p-4 pl-6 uppercase tracking-wider text-[10px]">Médecin</th>
                            <th class="p-4 uppercase tracking-wider text-[10px]">Spécialité</th>
                            <th class="p-4 uppercase tracking-wider text-[10px]">Statut</th>
                            <th class="p-4 pr-6 uppercase tracking-wider text-[10px] text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 align-middle">
                        <?php if (!empty($doctorsList)): ?>
                            <?php foreach ($doctorsList as $doc): ?>
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    
                                    <td class="p-4 pl-6 font-semibold text-slate-800 whitespace-nowrap">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-full bg-cyan-50 flex items-center justify-center text-cyan-600 font-bold text-[11px] border border-cyan-100">
                                                Dr
                                            </div>
                                            <span>Dr. <?php echo htmlspecialchars($doc['doctor_name']); ?></span>
                                        </div>
                                    </td>
                                    
                                    <td class="p-4 text-slate-500 font-medium whitespace-nowrap">
                                        <?php echo htmlspecialchars($doc['specialite_nom']); ?>
                                    </td>
                                    
                                    <td class="p-4 whitespace-nowrap">
                                        <?php if ($doc['statut'] === 'Actif'): ?>
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 font-semibold text-[10px] border border-emerald-100/50">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-sm shadow-emerald-400"></span> Actif
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-300 text-red-600 font-semibold text-[10px] border border-slate-200/40">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span> Désactivé
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="p-4 pr-6 text-right font-medium whitespace-nowrap">
                                        <div class="inline-flex items-center justify-end gap-2">
                                            <button type="button"
                                                onclick="openEditModal(<?php echo $doc['id']; ?>, '<?php echo addslashes($doc['doctor_name']); ?>', '<?php echo addslashes($doc['specialite_nom']); ?>', '<?php echo $doc['statut']; ?>')"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-cyan-600 bg-cyan-50/50 hover:bg-cyan-100/70 active:scale-95 rounded-xl transition-all border-none cursor-pointer group/btn">
                                                <i class="fa-regular fa-pen-to-square text-[13px] transition-transform group-hover/btn:scale-105"></i>
                                                Modifier
                                            </button>
                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="p-8 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <i class="fa-regular fa-folder-open text-2xl text-slate-300"></i>
                                        <p class="text-xs">Aucun médecin trouvé dans la base de données.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <div id="editDoctorModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden items-center justify-center p-4 transition-all duration-300">
        <div id="modalBox" class="bg-white rounded-2xl border border-slate-100 shadow-xl w-full max-w-md overflow-hidden transform scale-95 opacity-0 transition-all duration-200">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-regular fa-pen-to-square text-cyan-500"></i> Modifier le Médecin
                </h3>
                <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 transition-colors bg-transparent border-none cursor-pointer">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>
            <!-- Bdel had sstar -->
            <form action="<?php echo $baseUrl; ?>/index.php?action=update_doctor" method="POST" class="p-6 space-y-4">
                <input type="hidden" name="action" value="update_doctor">
                <input type="hidden" id="edit_doctor_id" name="doctor_id">

                <div class="space-y-1.5">
                    <label for="edit_doctor_name" class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Nom complet</label>
                    <input type="text" id="edit_doctor_name" name="doctor_name" required
                        class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition-all text-slate-800 font-medium">
                </div>

                <div class="space-y-1.5">
                    <label for="edit_specialite_id" class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Spécialité</label>
                    <select id="edit_specialite_id" name="specialite_id" required
                        class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition-all text-slate-800 font-medium">
                        <?php foreach ($specialites as $spec): ?>
                            <option value="<?php echo $spec['id']; ?>"><?php echo htmlspecialchars($spec['nom']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label for="edit_doctor_status" class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Statut</label>
                    <select id="edit_doctor_status" name="doctor_status" required
                        class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition-all text-slate-800 font-medium">
                        <option value="Actif">Actif</option>
                        <option value="Désactivé">Désactivé</option>
                    </select>
                </div>

                <div class="pt-2 flex justify-end gap-2 border-t border-slate-100">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 text-xs font-semibold text-slate-500 bg-slate-100 hover:bg-slate-200/80 active:scale-95 rounded-xl transition-all border-none cursor-pointer">
                        Annuler
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-xs font-semibold text-white bg-cyan-500 hover:bg-cyan-600 active:scale-95 shadow-sm shadow-cyan-200 rounded-xl transition-all border-none cursor-pointer">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, name, specialiteNom, statut) {
            const modal = document.getElementById('editDoctorModal');
            const box = document.getElementById('modalBox');
            document.getElementById('edit_doctor_id').value = id;
            document.getElementById('edit_doctor_name').value = name;
            document.getElementById('edit_doctor_status').value = statut;

            const selectSpec = document.getElementById('edit_specialite_id');
            for (let i = 0; i < selectSpec.options.length; i++) {
                if (selectSpec.options[i].text.trim() === specialiteNom.trim()) {
                    selectSpec.selectedIndex = i;
                    break;
                }
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(() => {
                box.classList.remove('scale-95', 'opacity-0');
                box.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeEditModal() {
            const modal = document.getElementById('editDoctorModal');
            const box = document.getElementById('modalBox');

            box.classList.remove('scale-100', 'opacity-100');
            box.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 200);
        }

        window.onclick = function(event) {
            const modal = document.getElementById('editDoctorModal');
            if (event.target === modal) {
                closeEditModal();
            }
        }
    </script>
</body>

</html>