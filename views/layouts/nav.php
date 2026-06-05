<?php

$currentAction = $_GET['action'] ?? '';

?>

<aside class="fixed top-0 left-0 w-[220px] min-h-screen bg-white border-r border-gray-200 flex flex-col gap-1 p-4 z-50">

    <div class="font-serif text-xl text-blue-900 mb-6 px-2">
        Med<span class="text-blue-400">Clinic</span>
    </div>

    <a href="index.php?action=medecin_dashboard"
       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium transition-colors <?= ($currentAction === 'medecin_dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-[#F4F3EF] hover:text-gray-800' ?>">
        <i class="ti ti-layout-dashboard text-lg"></i>
        Tableau de bord
    </a>

    <a href="index.php?action=planning"
       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium transition-colors <?= ($currentAction === 'planning') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-[#F4F3EF] hover:text-gray-800' ?>">
        <i class="ti ti-calendar text-lg"></i>
        Planning
    </a>

    <a href="index.php?action=list_rdv"
       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium transition-colors <?= ($currentAction === 'list_rdv') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-[#F4F3EF] hover:text-gray-800' ?>">
        <i class="ti ti-users text-lg"></i>
        Patients & RDV
    </a>

    <a href="index.php?action=disponibilites"
       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium transition-colors <?= ($currentAction === 'disponibilites') ? 'bg-blue-50 text-blue-700' : 'text-gray-500 hover:bg-[#F4F3EF] hover:text-gray-800' ?>">
        <i class="ti ti-calendar-plus text-lg"></i>
        Mes disponibilités
    </a>


    <hr class="my-2 border-gray-200">

    <a href="index.php?action=logoutAction"
       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium text-gray-500 hover:bg-[#F4F3EF] hover:text-gray-800 transition-colors">
        <i class="ti ti-settings text-lg"></i>
        Logout
    </a>

    <div class="mt-auto">
        <div class="flex items-center gap-2.5 p-3 rounded-xl bg-[#F4F3EF]">

            <div class="w-9 h-9 rounded-full bg-blue-600 text-blue-50 flex items-center justify-center text-sm font-semibold shrink-0">
                <?= strtoupper(substr($_SESSION['user']['name'] ?? 'DM', 0, 2)) ?>
            </div>

            <div>
                <div class="text-sm font-medium text-gray-800">
                    Dr. <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Martin') ?>
                </div>
                <div class="text-xs text-gray-400">
                    Médecin généraliste
                </div>
            </div>

        </div>
    </div>

</aside>