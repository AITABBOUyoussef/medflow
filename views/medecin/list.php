<?php

$rendezVous = $rendezVous ?? [];

if (!function_exists('getStatusStyle')) {
    function getStatusStyle($status) {
        return match ($status) {
            'EN_ATTENTE' => ['bg' => 'bg-amber-50 text-amber-900',  'dot' => 'bg-amber-400', 'badge' => 'bg-amber-50 text-amber-800',  'label' => 'En attente'],
            'CONFIRME'  => ['bg' => 'bg-green-50 text-green-900',  'dot' => 'bg-green-600', 'badge' => 'bg-green-50 text-green-800',  'label' => 'Confirmé'],
            'TERMINE'   => ['bg' => 'bg-blue-50 text-blue-900',   'dot' => 'bg-blue-400',  'badge' => 'bg-blue-50 text-blue-800',   'label' => 'Terminé'],
            'ANNULE'    => ['bg' => 'bg-rose-50 text-rose-900 opacity-75', 'dot' => 'bg-rose-400',  'badge' => 'bg-rose-50 text-rose-800',   'label' => 'Annulé'],
            default     => ['bg' => 'bg-gray-100 text-gray-700', 'dot' => 'bg-gray-400',  'badge' => 'bg-gray-100 text-gray-600',  'label' => $status],
        };
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Rendez-vous - MedClinic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                        serif: ['DM Serif Display', 'serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-[#F4F3EF] font-sans min-h-screen text-gray-800">

   <?php include 'views/layouts/nav.php'; ?>

    <main class="ml-[220px] p-8 pb-16">
        
        <div class="flex items-start justify-between mb-7">
            <div>
                <h1 class="font-serif text-2xl text-gray-900">Gestion des Rendez-vous</h1>
                <p class="text-sm text-gray-400 mt-1">Liste globale et suivi des consultations</p>
            </div>
 
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-between items-center mb-6 bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
            <div class="relative w-full sm:w-72">
                <i class="ti ti-search absolute left-3 top-2.5 text-gray-400 text-base"></i>
                <input type="text" id="search-input" onkeyup="filterTable()" placeholder="Rechercher un patient ou un motif..." class="w-full bg-[#F4F3EF]/50 border border-gray-200 focus:border-blue-400 focus:bg-white rounded-lg pl-9 pr-4 py-2 text-sm outline-none transition-all">
            </div>
            
            <div class="flex gap-1.5 w-full sm:w-auto overflow-x-auto">
                <button onclick="filterStatus('ALL')" class="status-tab-btn px-4 py-1.5 rounded-lg text-xs font-medium bg-blue-50 text-blue-700 border-none cursor-pointer transition-all">Tous (<?= count($rendezVous) ?>)</button>
                <button onclick="filterStatus('EN_ATTENTE')" class="status-tab-btn px-4 py-1.5 rounded-lg text-xs font-medium text-gray-500 bg-transparent hover:bg-gray-50 border-none cursor-pointer transition-all">En attente</button>
                <button onclick="filterStatus('CONFIRME')" class="status-tab-btn px-4 py-1.5 rounded-lg text-xs font-medium text-gray-500 bg-transparent hover:bg-gray-50 border-none cursor-pointer transition-all">Confirmés</button>
                <button onclick="filterStatus('TERMINE')" class="status-tab-btn px-4 py-1.5 rounded-lg text-xs font-medium text-gray-500 bg-transparent hover:bg-gray-50 border-none cursor-pointer transition-all">Terminés</button>
                <button onclick="filterStatus('ANNULE')" class="status-tab-btn px-4 py-1.5 rounded-lg text-xs font-medium text-gray-500 bg-transparent hover:bg-gray-50 border-none cursor-pointer transition-all">Annulés</button>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
            <table class="w-full text-sm border-collapse" id="rdv-table">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr class="text-[10px] font-bold uppercase tracking-widest text-gray-400 text-left">
                        <th class="px-5 py-3">Patient / Motif</th>
                        <th class="px-5 py-3">Date & Heure</th>
                        <th class="px-5 py-3">Statut</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($rendezVous)): ?>
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-gray-400 italic bg-gray-50/50">
                                <i class="ti ti-folder-off text-2xl block mb-1"></i> Aucun rendez-vous trouvé
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rendezVous as $rdv): 
                            $dt = new DateTime($rdv->date_rdv);
                            $style = getStatusStyle($rdv->status);
                        ?>
                            <tr class="table-row-item hover:bg-gray-50/50 transition-colors" data-status="<?= $rdv->status ?>">
                                <td class="px-5 py-3.5 search-target">
                                    <div class="font-medium text-gray-900 name-field"><?= htmlspecialchars($rdv->patient_name ?? 'Patient') ?></div>
                                    <div class="text-xs text-gray-400 mt-0.5 motif-field"><?= htmlspecialchars($rdv->motif ?? 'Aucun motif') ?></div>
                                </td>
                                <td class="px-5 py-3.5 text-gray-600">
                                    <div><?= $dt->format('d/m/Y') ?></div>
                                    <div class="text-xs text-gray-400 mt-0.5"><?= $dt->format('H:i') ?></div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium <?= $style['badge'] ?>">
                                        <span class="w-1.5 h-1.5 rounded-full <?= $style['dot'] ?>"></span>
                                        <?= $style['label'] ?>
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <?php if ($rdv->status === 'EN_ATTENTE'): ?>
                                            <a href="index.php?action=confirm_rdv&id=<?= $rdv->id ?>" onclick="return confirm('Confirmer ce rendez-vous ?')" class="border border-green-600 text-green-700 hover:bg-green-50 px-2.5 py-1 rounded-md text-xs font-medium no-underline transition-colors">Valider</a>
                                            <a href="index.php?action=cancel_rdv&id=<?= $rdv->id ?>" onclick="return confirm('Annuler ce rendez-vous ?')" class="border border-red-500 text-red-600 hover:bg-rose-50 px-2.5 py-1 rounded-md text-xs font-medium no-underline transition-colors">Annuler</a>
                                        <?php elseif ($rdv->status === 'CONFIRME'): ?>
                                            <button onclick="openComplete(<?= $rdv->id ?>, '<?= addslashes($rdv->patient_name) ?>', '<?= $dt->format('d/m/Y H:i') ?>', '<?= addslashes($rdv->motif ?? '') ?>')" class="bg-blue-600 hover:bg-blue-700 text-white border-none px-2.5 py-1 rounded-md text-xs font-medium cursor-pointer transition-colors">Terminer</button>
                                            <a href="index.php?action=cancel_rdv&id=<?= $rdv->id ?>" onclick="return confirm('Annuler ce rendez-vous ?')" class="border border-red-500 text-red-600 hover:bg-rose-50 px-2.5 py-1 rounded-md text-xs font-medium no-underline transition-colors">Annuler</a>
                                        <?php else: ?>
                                            <span class="text-xs text-gray-400 italic flex items-center gap-1"><i class="ti ti-archive"></i> Archivé</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <div id="modal-overlay" class="hidden fixed inset-0 bg-black/40 z-[200] items-center justify-center">
        <div class="bg-white rounded-xl p-6 w-[460px] max-w-[95vw] shadow-xl border border-gray-100">
            <h2 class="font-serif text-xl text-gray-900 mb-4">Clôturer la consultation</h2>

            <div class="grid grid-cols-3 gap-2 mb-4 text-xs bg-gray-50 p-2.5 rounded-lg border border-gray-100">
                <div><span class="block text-gray-400">Patient</span><span id="modal-patient" class="font-medium text-gray-800 truncate block"></span></div>
                <div><span class="block text-gray-400">Heure</span><span id="modal-date" class="font-medium text-gray-800 block"></span></div>
                <div><span class="block text-gray-400">Motif</span><span id="modal-motif" class="font-medium text-gray-800 truncate block"></span></div>
            </div>

            <form method="POST" action="index.php?action=show_complete_rdv">
                <input type="hidden" name="rdv_id" id="modal-rdv-id">
                <input type="hidden" name="statut" value="TERMINE">

                <label for="ordonnance-text" class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Ordonnance</label>
                <textarea id="ordonnance-text" name="ordonnance" rows="4" placeholder="Rédigez ici les médicaments ou consignes..." class="w-full border border-gray-300 focus:border-blue-500 rounded-lg p-2.5 text-sm resize-none outline-none focus:ring-2 focus:ring-blue-50"></textarea>

                <div class="flex justify-end gap-2 mt-4 text-sm">
                    <button type="button" onclick="closeModal()" class="border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg font-medium cursor-pointer transition-all">Annuler</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white border-none px-4 py-2 rounded-lg font-medium cursor-pointer transition-all">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <div id="toast" class="hidden fixed bottom-6 right-6 bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm items-center gap-2 shadow-md z-[300]">
        <i class="ti ti-check text-green-600 text-base"></i> <span id="toast-msg"></span>
    </div>

    <script>
        let currentFilterStatus = 'ALL';

       
        function filterTable() {
            const query = document.getElementById('search-input').value.toLowerCase();
            const rows = document.querySelectorAll('.table-row-item');

            rows.forEach(row => {
                const name = row.querySelector('.name-field').textContent.toLowerCase();
                const motif = row.querySelector('.motif-field').textContent.toLowerCase();
                const status = row.getAttribute('data-status');

                const matchesSearch = name.includes(query) || motif.includes(query);
                const matchesStatus = currentFilterStatus === 'ALL' || status === currentFilterStatus;

                if (matchesSearch && matchesStatus) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
        }

       
        function filterStatus(status) {
            currentFilterStatus = status;
            
         
            const buttons = document.querySelectorAll('.status-tab-btn');
            buttons.forEach(btn => {
                const isCurrent = btn.getAttribute('onclick').includes(`'${status}'`);
                btn.className = `status-tab-btn px-4 py-1.5 rounded-lg text-xs font-medium border-none cursor-pointer transition-all ${isCurrent ? 'bg-blue-50 text-blue-700' : 'bg-transparent text-gray-500 hover:bg-gray-50'}`;
            });

            filterTable();  
        }

       
        function openComplete(id, patient, date, motif) {
            document.getElementById('modal-rdv-id').value = id;
            document.getElementById('modal-patient').textContent = patient || '—';
            document.getElementById('modal-date').textContent = date || '—';
            document.getElementById('modal-motif').textContent = motif || '—';
            document.getElementById('ordonnance-text').value = '';

            const overlay = document.getElementById('modal-overlay');
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
        }

        function closeModal() {
            const overlay = document.getElementById('modal-overlay');
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
        }

        document.getElementById('modal-overlay').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

       
        (function() {
            const msg = new URLSearchParams(window.location.search).get('msg');
            if (msg) {
                const t = document.getElementById('toast');
                document.getElementById('toast-msg').textContent = decodeURIComponent(msg);
                t.classList.remove('hidden');
                t.classList.add('flex');
                setTimeout(() => { t.classList.add('hidden'); }, 3000);
            }
        })();
    </script>
</body>

</html>