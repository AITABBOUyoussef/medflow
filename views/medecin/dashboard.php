<?php 
 
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Médecin</title>
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
                <h1 class="font-serif text-2xl text-gray-900">
                    Bonjour, Dr. <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Martin') ?>
                </h1>
                <p class="text-sm text-gray-400 mt-1"><?= date('l d F Y') ?></p>
            </div>

        </div>

        <?php

        function getStatusStyle($status)
        {
            return match ($status) {
                'EN_ATTENTE' => ['bg' => 'bg-amber-50 text-amber-900',  'dot' => 'bg-amber-400', 'badge' => 'bg-amber-50 text-amber-800',  'label' => 'En attente'],
                'CONFIRME'  => ['bg' => 'bg-green-50 text-green-900',  'dot' => 'bg-green-600', 'badge' => 'bg-green-50 text-green-800',  'label' => 'Confirmé'],
                'TERMINE'   => ['bg' => 'bg-blue-50 text-blue-900',   'dot' => 'bg-blue-400',  'badge' => 'bg-blue-50 text-blue-800',   'label' => 'Terminé'],
                'ANNULE'    => ['bg' => 'bg-rose-50 text-rose-900 opacity-75', 'dot' => 'bg-rose-400',  'badge' => 'bg-rose-50 text-rose-800',   'label' => 'Annulé'],
                default     => ['bg' => 'bg-gray-100 text-gray-700', 'dot' => 'bg-gray-400',  'badge' => 'bg-gray-100 text-gray-600',  'label' => $status],
            };
        }
        ?>

        <div class="grid grid-cols-4 gap-3 mb-7">
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <div class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-widest text-gray-400 mb-1"><span class="w-2 h-2 rounded-full bg-amber-400"></span> En attente</div>
                <div class="text-3xl font-semibold text-gray-900"><?= $EN_ATTENTE_rdv ?></div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <div class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-widest text-gray-400 mb-1"><span class="w-2 h-2 rounded-full bg-green-600"></span> Confirmés</div>
                <div class="text-3xl font-semibold text-gray-900"><?= $CONFIRME_rdv ?></div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <div class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-widest text-gray-400 mb-1"><span class="w-2 h-2 rounded-full bg-blue-400"></span> Terminés</div>
                <div class="text-3xl font-semibold text-gray-900"><?= $TERMINE_rdv ?></div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <div class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-widest text-gray-400 mb-1"><span class="w-2 h-2 rounded-full bg-rose-400"></span> Annulés</div>
                <div class="text-3xl font-semibold text-gray-900"><?= $ANNULE_rdv ?></div>
            </div>
        </div>

        <div class="inline-flex gap-1 bg-white border border-gray-200 rounded-xl p-1 mb-6">
            <button id="tab-semaine" onclick="showView('semaine')" class="flex items-center gap-1 px-5 py-1.5 rounded-lg text-sm font-medium border-none cursor-pointer bg-blue-50 text-blue-700 transition-all">
                <i class="ti ti-calendar-week"></i> Semaine
            </button>
            <button id="tab-liste" onclick="showView('liste')" class="flex items-center gap-1 px-5 py-1.5 rounded-lg text-sm font-medium border-none cursor-pointer bg-transparent text-gray-500 hover:bg-gray-50 transition-all">
                <i class="ti ti-list"></i> Liste
            </button>
        </div>

        <div id="view-semaine" class="block">
            <?php
            $rendezVous = $rendezVous ?? [];
            $referenceDate = null;
            foreach ($rendezVous as $r) {
                if (!isset($r->date_rdv) || $r->date_rdv === null || $r->date_rdv === '') {
                    continue;
                }

                try {
                    $referenceDate = new DateTime($r->date_rdv);
                    break;
                } catch (Exception $e) {
                    continue;
                }
            }

            $today = $referenceDate ? clone $referenceDate : new DateTime();
            $monday = (clone $today)->modify('-' . ((int)$today->format('N') - 1) . ' days');
            $dayNames = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
            ?>

            <div class="grid grid-cols-7 gap-2">
                <?php for ($i = 0; $i < 7; $i++):
                    $currentDay = (clone $monday)->modify("+{$i} days");
                    $dayDate = $currentDay->format('Y-m-d');
                    $isToday = $dayDate === $today->format('Y-m-d');
                    
                    $dayRdvs = array_filter($rendezVous, function ($r) use ($dayDate) {
                        if (!isset($r->date_rdv) || $r->date_rdv === null || $r->date_rdv === '') {
                            return false;
                        }

                        try {
                            $dt = new DateTime($r->date_rdv);
                        } catch (Exception $e) {
                            return false;
                        }

                        return $dt->format('Y-m-d') === $dayDate;
                    });
                ?>
                    <div class="bg-white border <?= $isToday ? 'border-blue-500 ring-1 ring-blue-100' : 'border-gray-200' ?> rounded-xl p-2.5 min-h-[220px]">
                        <div class="text-[10px] font-bold uppercase tracking-widest text-gray-400 text-center mb-0.5"><?= $dayNames[$i] ?></div>
                        <div class="text-lg font-semibold text-center mb-3 <?= $isToday ? 'text-blue-600' : 'text-gray-800' ?>"><?= $currentDay->format('d') ?></div>

                        <div class="space-y-1">
                            <?php foreach ($dayRdvs as $rdv):
                                $style = getStatusStyle($rdv->status);
                                $rdvDate = new DateTime($rdv->date_rdv);
                                $heure = $rdvDate->format('H:i');
                                $shortName = explode(' ', $rdv->patient_name ?? '')[0] ?? 'Patient';
                                $actionClick = $rdv->status === 'CONFIRME' ? "onclick=\"openComplete({$rdv->id}, '" . addslashes($rdv->patient_name) . "', '{$heure}', '" . addslashes($rdv->motif ?? '') . "')\" style='cursor:pointer;'" : "";
                            ?>
                                <div class="<?= $style['bg'] ?> rounded-md p-1.5 text-[10px] leading-tight hover:opacity-80 transition-all" <?= $actionClick ?>>
                                    <span class="block font-bold"><?= $heure ?></span>
                                    <span class="block truncate font-medium"><?= htmlspecialchars($shortName) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>

        <div id="view-liste" class="hidden">
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                <table class="w-full text-sm border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr class="text-[10px] font-bold uppercase tracking-widest text-gray-400 text-left">
                            <th class="px-5 py-3">Patient / Motif</th>
                            <th class="px-5 py-3">Date & Heure</th>
                            <th class="px-5 py-3">Statut</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($rendezVous as $rdv):
                            $dt = new DateTime($rdv->date_rdv);
                            $style = getStatusStyle($rdv->status);
                        ?>
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-5 py-3.5">
                                    <div class="font-medium text-gray-900"><?= htmlspecialchars($rdv->patient_name ?? 'Patient') ?></div>
                                    <div class="text-xs text-gray-400 mt-0.5"><?= htmlspecialchars($rdv->motif ?? 'Aucun motif') ?></div>
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
                                            <a href="index.php?action=confirm_rdv&id=<?= $rdv->id ?>" onclick="return confirm('Confirmer ?')" class="border border-green-600 text-green-700 hover:bg-green-50 px-2.5 py-1 rounded-md text-xs font-medium no-underline transition-colors">Valider</a>
                                            <a href="index.php?action=cancel_rdv&id=<?= $rdv->id ?>" onclick="return confirm('Annuler ?')" class="border border-red-500 text-red-600 hover:bg-rose-50 px-2.5 py-1 rounded-md text-xs font-medium no-underline transition-colors">Annuler</a>
                                        <?php elseif ($rdv->status === 'CONFIRME'): ?>
                                            <button onclick="openComplete(<?= $rdv->id ?>, '<?= addslashes($rdv->patient_name) ?>', '<?= $dt->format('d/m/Y H:i') ?>', '<?= addslashes($rdv->motif ?? '') ?>')" class="bg-blue-600 hover:bg-blue-700 text-white border-none px-2.5 py-1 rounded-md text-xs font-medium cursor-pointer transition-colors">Terminer</button>
                                            <a href="index.php?action=cancel_rdv&id=<?= $rdv->id ?>" onclick="return confirm('Annuler ?')" class="border border-red-500 text-red-600 hover:bg-rose-50 px-2.5 py-1 rounded-md text-xs font-medium no-underline transition-colors">Annuler</a>
                                        <?php else: ?>
                                            <span class="text-xs text-gray-400 italic">Aucune action</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
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
        <i class="ti ti-check text-green-600 text-base"></i> <span id="toast-msg">jvgjgjgj</span>
    </div>

    <script>
        function showView(view) {
            const isSemaine = view === 'semaine';
            document.getElementById('view-semaine').classList.toggle('hidden', !isSemaine);
            document.getElementById('view-liste').classList.toggle('hidden', isSemaine);

            // Toggle Styles boutons actifs/inactifs
            const sBtn = document.getElementById('tab-semaine');
            const lBtn = document.getElementById('tab-liste');

            sBtn.className = `flex items-center gap-1 px-5 py-1.5 rounded-lg text-sm font-medium border-none cursor-pointer transition-all ${isSemaine ? 'bg-blue-50 text-blue-700' : 'bg-transparent text-gray-500 hover:bg-gray-50'}`;
            lBtn.className = `flex items-center gap-1 px-5 py-1.5 rounded-lg text-sm font-medium border-none cursor-pointer transition-all ${!isSemaine ? 'bg-blue-50 text-blue-700' : 'bg-transparent text-gray-500 hover:bg-gray-50'}`;
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
                setTimeout(() => {
                    t.classList.add('hidden');
                }, 3000);
            }
        })();
    </script>

</body>

</html>