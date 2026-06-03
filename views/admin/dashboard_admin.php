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
                    specialites.nom AS specialite_nom,
                    'Actif' AS statut
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
?>

<!DOCTYPE html>
<html lang="fr" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedFlow - Administration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="h-full antialiased text-slate-800">

    <div class="flex min-h-screen">
        
        <?php include_once __DIR__ . '/../layout/aside_admin.php'; ?>

        <div class="flex flex-col flex-1 lg:pl-64">
            
            <?php include_once __DIR__ . '/../layout/header_admin.php'; ?>

            <main class="flex-1 p-4 sm:p-6 lg:p-8 space-y-8 max-w-[1600px] w-full mx-auto">
                
               <section id="stats" class="space-y-3">
                    <div class="flex items-center gap-2">
                        <span class="w-1 h-3.5 bg-cyan-500 rounded-full"></span>
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tableau de bord de l'activité</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-white p-5 rounded-2xl border border-slate-200/60 shadow-sm flex justify-between items-center transition-all hover:shadow-md">
                            <div class="space-y-1">
                                <p class="text-xs font-medium text-slate-400">Taux d'Annulation</p>
                                <h3 class="text-2xl font-bold text-rose-600 tracking-tight"><?php echo $tauxAnnulation; ?>%</h3>
                                <span class="inline-flex items-center text-[10px] font-semibold text-slate-400 bg-slate-50 px-1.5 py-0.5 rounded-md">Basé sur le flux global</span>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center text-lg shadow-inner">
                                <i class="fa-solid fa-calendar-xmark"></i>
                            </div>
                        </div>

                        <div class="bg-white p-5 rounded-2xl border border-slate-200/60 shadow-sm flex justify-between items-center transition-all hover:shadow-md">
                            <div class="space-y-1">
                                <p class="text-xs font-medium text-slate-400">Moy. RDV / Praticien</p>
                                <h3 class="text-2xl font-bold text-emerald-600 tracking-tight"><?php echo $moyenneRDV; ?> <span class="text-xs font-normal text-slate-400">/méd</span></h3>
                                <span class="text-[10px] text-emerald-600 font-semibold bg-emerald-50 px-1.5 py-0.5 rounded-md">Sur <?php echo $totalMedecins; ?> inscrit(s)</span>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-lg shadow-inner">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                        </div>

                        <div class="bg-white p-5 rounded-2xl border border-slate-200/60 shadow-sm flex justify-between items-center transition-all hover:shadow-md">
                            <div class="space-y-1">
                                <p class="text-xs font-medium text-slate-400">Total Consultations</p>
                                <h3 class="text-2xl font-bold text-slate-800 tracking-tight"><?php echo number_format($totalRDV); ?></h3>
                                <span class="text-[10px] text-slate-400 font-medium">Flux total enregistré</span>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-500 flex items-center justify-center text-lg shadow-inner">
                                <i class="fa-solid fa-folder-closed"></i>
                            </div>
                        </div>

                        <div class="bg-white p-5 rounded-2xl border border-slate-200/60 shadow-sm flex justify-between items-center transition-all hover:shadow-md">
                            <div class="space-y-1">
                                <p class="text-xs font-medium text-slate-400">Spécialités Actives</p>
                                <h3 class="text-2xl font-bold text-cyan-600 tracking-tight"><?php echo $totalSpecialites; ?> <span class="text-xs font-normal text-slate-400">Filtres</span></h3>
                                <span class="text-[10px] text-slate-400 font-medium">Disponibles sur la plateforme</span>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-lg shadow-inner">
                                <i class="fa-solid fa-sliders"></i>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                    
                    <section id="medecins" class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm space-y-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-4">
                            <div>
                                <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                                    <i class="fa-solid fa-user-doctor text-cyan-500"></i> Gestion de l'Équipe Médicale
                                </h2>
                                <p class="text-[11px] text-slate-400">Gérez les accès et associez les spécialités requises au profil.</p>
                            </div>
                        </div>

                        <form action="../src/controller/admin_controller.php" method="POST" class="bg-slate-50/70 p-4 rounded-xl border border-slate-200/60 space-y-4">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Création d'un compte Praticien</p>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="block text-[11px] font-semibold text-slate-600">Nom complet du Médecin <span class="text-rose-500">*</span></label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 text-xs">
                                            <i class="fa-regular fa-user"></i>
                                        </span>
                                        <input name="doctor_name" type="text" placeholder="Dr. Prénom Nom" class="w-full pl-8 pr-3 py-2 rounded-xl border border-slate-200 text-xs bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all" required>
                                    </div>
                                </div>
                                
                                <div class="space-y-1">
                                    <label class="block text-[11px] font-semibold text-slate-600">Spécialité Principale <span class="text-rose-500">*</span></label>
                                    <select name="specialite_id" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white text-slate-600 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all" required>
                                        <option value="">Choisir la spécialité...</option>
                                        <?php if (!empty($specialites)): ?>
                                            <?php foreach ($specialites as $spec): ?>
                                                <option value="<?php echo htmlspecialchars($spec['id']); ?>">
                                                    <?php echo htmlspecialchars($spec['nom']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="" disabled>Aucune spécialité trouvée</option>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="space-y-1">
                                    <label class="block text-[11px] font-semibold text-slate-600">Adresse Email <span class="text-rose-500">*</span></label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 text-xs">
                                            <i class="fa-regular fa-envelope"></i>
                                        </span>
                                        <input name="doctor_email" type="email" placeholder="dr.nom@medflow.com" class="w-full pl-8 pr-3 py-2 rounded-xl border border-slate-200 text-xs bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all" required>
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <label class="block text-[11px] font-semibold text-slate-600">Mot de passe <span class="text-rose-500">*</span></label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 text-xs">
                                            <i class="fa-solid fa-lock"></i>
                                        </span>
                                        <input name="doctor_password" type="password" placeholder="••••••••" class="w-full pl-8 pr-3 py-2 rounded-xl border border-slate-200 text-xs bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex justify-end pt-2">
                                <button name="submit" type="submit" class="px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold rounded-xl text-xs transition-all shadow-sm shadow-cyan-600/10 flex items-center gap-2">
                                    <i class="fa-solid fa-plus text-[10px]"></i> Enregistrer le médecin
                                </button>
                            </div>
                        </form>

                        <div class="overflow-x-auto border border-slate-200/60 rounded-xl shadow-sm">
                            <table class="w-full text-left text-xs min-w-[500px]">
                                <thead>
                                    <tr class="bg-slate-50/70 text-slate-500 font-semibold border-b border-slate-200/60">
                                        <th class="p-3.5 pl-4">Médecin</th>
                                        <th class="p-3.5">Spécialité</th>
                                        <th class="p-3.5">Statut</th>
                                        <th class="p-3.5 pr-4 text-right">Actions</th>
                                    </tr>
                                <thead>
                                <tbody class="divide-y divide-slate-100">
                                    <?php if (!empty($doctorsList)): ?>
                                        <?php foreach ($doctorsList as $doc): ?>
                                            <tr class="hover:bg-slate-50/40 transition-colors">
                                                <td class="p-3.5 pl-4 font-semibold text-slate-800">
                                                    Dr. <?php echo htmlspecialchars($doc['doctor_name']); ?>
                                                </td>
                                                <td class="p-3.5 text-slate-500">
                                                    <?php echo htmlspecialchars($doc['specialite_nom']); ?>
                                                </td>
                                                <td class="p-3.5">
                                                    <?php if ($doc['statut'] === 'Actif'): ?>
                                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-medium text-[10px]">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Actif
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-slate-100 text-slate-400 font-medium text-[10px]">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Désactivé
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="p-3.5 pr-4 text-right space-x-3 font-medium">
                                                <button type="button" 
                                                    onclick="openEditModal(<?php echo $doc['id']; ?>, '<?php echo addslashes($doc['doctor_name']); ?>', '<?php echo addslashes($doc['specialite_nom']); ?>', '<?php echo $doc['statut']; ?>')" 
                                                    class="text-cyan-600 hover:text-cyan-700 hover:underline bg-transparent border-none cursor-pointer">
                                                Modifier
                                                </button>
                                                    <?php if ($doc['statut'] === 'Actif'): ?>
                                                        <a href="../src/controller/admin_controller.php?action=toggle_status&id=<?php echo $doc['id']; ?>" class="text-rose-600 hover:text-rose-700 hover:underline">Désactiver</a>
                                                    <?php else: ?>
                                                        <a href="../src/controller/admin_controller.php?action=toggle_status&id=<?php echo $doc['id']; ?>" class="text-emerald-600 hover:text-emerald-700 hover:underline">Réactiver</a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="p-4 text-center text-slate-400">Aucun médecin trouvé dans la base de données.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <section id="specialites" class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm space-y-5">
                        <div>
                            <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                                <i class="fa-solid fa-stethoscope text-cyan-500"></i> Référentiel Spécialités
                            </h2>
                            <p class="text-[11px] text-slate-400">Ajoutez ou supprimez les filtres du parcours patient.</p>
                        </div>

                        <form action="../src/controller/admin_controller.php" method="POST" class="flex gap-2">
                            <input name="spécialité_name" type="text" placeholder="Ex: Neurologue..." class="flex-1 px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 bg-white transition-all">
                            <button name="add_spécialité" type="submit" class="px-3 py-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-xl text-xs transition-all shadow-sm">
                                Ajouter
                            </button>
                        </form>

                        <div class="space-y-2 max-h-[290px] overflow-y-auto pr-1">
                            <?php if (!empty($specialites)): ?>
                                <?php foreach ($specialites as $spec): ?>
                                    <div class="flex justify-between items-center p-3 rounded-xl bg-slate-50 border border-slate-100 hover:border-slate-200 transition-all text-xs group">
                                        <span class="font-medium text-slate-700 flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 rounded-full bg-cyan-500"></span> <?php echo htmlspecialchars($spec['nom']); ?>
                                        </span>
                                        <button type="button" class="text-slate-400 hover:text-rose-600 transition-colors text-xs opacity-0 group-hover:opacity-100 lg:opacity-100">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-slate-400 text-center py-2">Aucune spécialité.</p>
                            <?php endif; ?>
                        </div>
                    </section>

                </div>
            </main>
        </div>
    </div>
        <!-- Edit Doctor Modal (Hidden by Default) -->
<div id="editDoctorModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm transition-all duration-300">
    
    <!-- Modal Content Box -->
    <div class="bg-white w-full max-w-md rounded-2xl border border-slate-200/80 shadow-2xl overflow-hidden transform transition-all scale-95 duration-300 opacity-0" id="modalBox">
        
        <!-- Header -->
        <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <span class="p-2 bg-cyan-50 text-cyan-600 rounded-xl text-xs shadow-inner">
                    <i class="fa-solid fa-user-pen"></i>
                </span>
                <div>
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Modifier le Praticien</h3>
                    <p class="text-[10px] text-slate-400 font-medium">Mettre à jour les accès du médecin</p>
                </div>
            </div>
            <button onclick="closeEditModal()" class="w-7 h-7 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-all">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- Form -->
        <form action="../src/controller/admin_controller.php" method="POST" class="p-6 space-y-4">
            <!-- Hidden Input for Doctor ID -->
            <input type="hidden" name="action" value="update_doctor">
            <input type="hidden" name="doctor_id" id="edit_doctor_id">

            <!-- Name Input -->
            <div class="space-y-1">
                <label class="block text-[11px] font-semibold text-slate-600">Nom complet <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 text-xs">
                        <i class="fa-regular fa-user"></i>
                    </span>
                    <input name="doctor_name" id="edit_doctor_name" type="text" class="w-full pl-8 pr-3 py-2 rounded-xl border border-slate-200 text-xs bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all" required>
                </div>
            </div>

            <!-- Specialite Select -->
            <div class="space-y-1">
                <label class="block text-[11px] font-semibold text-slate-600">Spécialité Principale <span class="text-rose-500">*</span></label>
                <select name="specialite_id" id="edit_specialite_id" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white text-slate-600 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all" required>
                    <option value="">Choisir...</option>
                    <?php foreach ($specialites as $spec): ?>
                        <option value="<?php echo htmlspecialchars($spec['id']); ?>">
                            <?php echo htmlspecialchars($spec['nom']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Status Select -->
            <div class="space-y-1">
                <label class="block text-[11px] font-semibold text-slate-600">Statut du Compte</label>
                <select name="doctor_status" id="edit_doctor_status" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white text-slate-600 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all">
                    <option value="Actif">Actif</option>
                    <option value="Désactivé">Désactivé</option>
                </select>
            </div>

            <!-- Footer Actions -->
            <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100 mt-6">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-xl text-xs transition-all">
                    Annuler
                </button>
                <button type="submit" name="submit_update" class="px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold rounded-xl text-xs transition-all shadow-sm shadow-cyan-600/10 flex items-center gap-2">
                    <i class="fa-regular fa-floppy-disk"></i> Enregistrer les modifications
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