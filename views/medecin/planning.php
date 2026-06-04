<?php
 
$rendezVous = $rendezVous ?? [];

 
if (!function_exists('getStatusStyle')) {
    function getStatusStyle($status) {
        return match ($status) {
            'EN_ATTENTE' => ['bg' => 'bg-amber-50 text-amber-900 border-amber-200',  'dot' => 'bg-amber-400', 'label' => 'En attente'],
            'CONFIRME'  => ['bg' => 'bg-green-50 text-green-900 border-green-200',  'dot' => 'bg-green-600', 'label' => 'Confirmé'],
            'TERMINE'   => ['bg' => 'bg-blue-50 text-blue-900 border-blue-200',   'dot' => 'bg-blue-400',  'label' => 'Terminé'],
            'ANNULE'    => ['bg' => 'bg-rose-50 text-rose-900 border-rose-200 opacity-60', 'dot' => 'bg-rose-400', 'label' => 'Annulé'],
            default     => ['bg' => 'bg-gray-50 text-gray-700 border-gray-200', 'dot' => 'bg-gray-400',  'label' => $status],
        };
    }
}

 
$referenceDate = null;
foreach ($rendezVous as $r) {
    if (!empty($r->date_rdv)) {
        try {
            $referenceDate = new DateTime($r->date_rdv);
            break;
        } catch (Exception $e) {}
    }
}
$today = $referenceDate ? clone $referenceDate : new DateTime();
$monday = (clone $today)->modify('-' . ((int)$today->format('N') - 1) . ' days');

$dayNamesText = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
$hoursRange = ['08:00', '09:00', '10:00', '11:00', '12:00', '14:00', '15:00', '16:00', '17:00', '18:00'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning Hebdomadaire - MedClinic</title>
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
                <h1 class="font-serif text-2xl text-gray-900">Planning de la Semaine</h1>
                <p class="text-sm text-gray-400 mt-1">Du <?= $monday->format('d F') ?> au <?= (clone $monday)->modify('+6 days')->format('d F Y') ?></p>
            </div>
            <div class="inline-flex gap-1.5 bg-white border border-gray-200 p-1 rounded-lg text-xs font-medium text-gray-500">
                <span class="flex items-center gap-1 px-2.5 py-1 rounded bg-amber-50 text-amber-800 border border-amber-200"><span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span> En attente</span>
                <span class="flex items-center gap-1 px-2.5 py-1 rounded bg-green-50 text-green-800 border border-green-200"><span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Confirmés</span>
                <span class="flex items-center gap-1 px-2.5 py-1 rounded bg-blue-50 text-blue-800 border border-blue-200"><span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span> Terminés</span>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse table-fixed min-w-[900px]">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="w-[80px] p-3 text-[10px] font-bold uppercase tracking-widest text-gray-400 border-r border-gray-100 text-center bg-gray-50/70">Heure</th>
                            <?php for ($i = 0; $i < 7; $i++): 
                                $dayDate = (clone $monday)->modify("+{$i} days");
                                $isToday = $dayDate->format('Y-m-d') === (new DateTime())->format('Y-m-d');
                            ?>
                                <th class="p-3 border-r border-gray-100 text-center <?= $isToday ? 'bg-blue-50/40' : '' ?>">
                                    <div class="text-[10px] font-bold uppercase tracking-wider text-gray-400"><?= $dayNamesText[$i] ?></div>
                                    <div class="text-base font-semibold mt-0.5 <?= $isToday ? 'text-blue-600' : 'text-gray-800' ?>">
                                        <?= $dayDate->format('d') ?>
                                    </div>
                                </th>
                            <?php endfor; ?>
                        </tr>
                    </thead>
                    
                    <tbody class="divide-y divide-gray-100 text-xs">
                        <?php foreach ($hoursRange as $hour): ?>
                            <tr class="h-[75px]">
                                <td class="p-2 font-semibold text-gray-400 text-center bg-gray-50/30 border-r border-gray-100 align-top pt-3">
                                    <?= $hour ?>
                                </td>
                                
                                <?php for ($i = 0; $i < 7; $i++): 
                                    $currentDayDate = (clone $monday)->modify("+{$i} days")->format('Y-m-d');
                                    
                                  
                                    $matchedRdvs = array_filter($rendezVous, function ($r) use ($currentDayDate, $hour) {
                                        if (empty($r->date_rdv)) return false;
                                        try {
                                            $dt = new DateTime($r->date_rdv);
                                            return $dt->format('Y-m-d') === $currentDayDate && $dt->format('H') === substr($hour, 0, 2);
                                        } catch (Exception $e) { return false; }
                                    });
                                ?>
                                    <td class="p-1.5 border-r border-gray-100 bg-white align-top relative hover:bg-gray-50/40 transition-colors">
                                        <div class="space-y-1">
                                            <?php foreach ($matchedRdvs as $rdv): 
                                                $style = getStatusStyle($rdv->status);
                                                $rdvTime = (new DateTime($rdv->date_rdv))->format('H:i');
                                                
                                                
                                             ?>
                                                <div   class="<?= $style['bg'] ?> border p-1.5 rounded-lg shadow-2xs cursor-pointer transition-all hover:scale-[1.01] hover:shadow-xs">
                                                    <div class="flex items-center justify-between font-bold text-[10px] mb-0.5">
                                                        <span><?= $rdvTime ?></span>
                                                        <span class="w-1.5 h-1.5 rounded-full <?= $style['dot'] ?>"></span>
                                                    </div>
                                                    <div class="font-medium text-gray-900 truncate"><?= htmlspecialchars($rdv->patient_name ?? 'Patient') ?></div>
                                                    <div class="text-[10px] opacity-75 truncate mt-0.5"><?= htmlspecialchars($rdv->motif ?? 'Consultation') ?></div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                <?php endfor; ?>
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

   
</body>

</html>