<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedFlow - Mes Rendez-vous</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen p-8 font-sans">

<div class="max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Mes Rendez-vous</h1>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="p-4 text-sm font-semibold text-gray-600">Médecin</th>
                <th class="p-4 text-sm font-semibold text-gray-600">Date & Heure</th>
                <th class="p-4 text-sm font-semibold text-gray-600">Statut</th>
                <th class="p-4 text-sm font-semibold text-gray-600">Action</th>
            </tr>
            </thead>
            <tbody id="appointmentsBody" class="divide-y divide-gray-100">
            </tbody>
        </table>
    </div>
</div>

<script>
     const appointments = [
        { id: 1, doctor: 'Dr. Alami', date: '04 Juin 2026', time: '09:00', status: 'EN_ATTENTE', hasPrescription: false },
        { id: 2, doctor: 'Dr. Bennani', date: '20 Mai 2026', time: '11:00', status: 'TERMINE', hasPrescription: true },
        { id: 3, doctor: 'Dr. Tazi', date: '15 Mai 2026', time: '15:00', status: 'ANNULE', hasPrescription: false }
    ];

    function getStatusBadge(status) {
        switch(status) {
            case 'EN_ATTENTE':
                return '<span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">EN ATTENTE</span>';
            case 'CONFIRME':
                return '<span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">CONFIRMÉ</span>';
            case 'TERMINE':
                return '<span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">TERMINÉ</span>';
            case 'ANNULE':
                return '<span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">ANNULÉ</span>';
            default:
                return '';
        }
    }

    function renderAppointments() {
        const tbody = document.getElementById('appointmentsBody');
        tbody.innerHTML = '';

        appointments.forEach(apt => {
            let actionHtml = '-';
            if (apt.status === 'TERMINE' && apt.hasPrescription) {
                actionHtml = `
                        <button onclick="downloadOrdonnance(${apt.id})" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center gap-1 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Ordonnance
                        </button>
                    `;
            }

            const row = `
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 font-medium text-gray-900">${apt.doctor}</td>
                        <td class="p-4 text-gray-600">${apt.date} à ${apt.time}</td>
                        <td class="p-4">${getStatusBadge(apt.status)}</td>
                        <td class="p-4 text-gray-400">${actionHtml}</td>
                    </tr>
                `;
            tbody.innerHTML += row;
        });
    }

    renderAppointments();

    function downloadOrdonnance(id) {
        alert("Téléchargement de l'ordonnance pour le RDV ID: " + id);
      }
</script>
</body>
</html>