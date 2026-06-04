<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedFlow - Trouver un Médecin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen p-8 font-sans">

<div class="max-w-4xl mx-auto">
    <!-- En-tête de recherche -->
    <div class="bg-white/80 backdrop-blur-md border border-gray-100 shadow-sm rounded-2xl p-6 mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Trouver un Médecin</h2>
        <form id="searchForm" class="flex gap-4">
            <input
                    type="text"
                    id="searchInput"
                    name="search"
                    placeholder="Nom du médecin ou spécialité..."
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white transition-all"
            >
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-medium transition-colors cursor-pointer">
                Rechercher
            </button>
        </form>
    </div>

    <!-- Liste des résultats -->
    <div id="resultsContainer" class="grid gap-4">
     </div>
</div>

<script>
    const mockDoctors = [
        { id: 1, name: 'Dr. Alami', specialty: 'Cardiologue', slots: ['09:00', '10:30'] },
        { id: 2, name: 'Dr. Tazi', specialty: 'Généraliste', slots: ['14:00', '15:00'] }
    ];

    function renderDoctors(doctors) {
        const container = document.getElementById('resultsContainer');
        container.innerHTML = '';

        if(doctors.length === 0) {
            container.innerHTML = '<p class="text-gray-500 text-center py-8">Aucun médecin trouvé.</p>';
            return;
        }

        doctors.forEach(doc => {
            const card = `
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex justify-between items-center hover:shadow-md transition-shadow">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">${doc.name}</h3>
                            <span class="inline-block bg-blue-50 text-blue-600 text-sm px-3 py-1 rounded-full mt-1">${doc.specialty}</span>
                        </div>
                        <div class="flex gap-2">
                            ${doc.slots.map(slot => `
                                <button onclick="reserver(${doc.id}, '${slot}')" class="border border-blue-600 text-blue-600 hover:bg-blue-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors cursor-pointer">
                                    ${slot}
                                </button>
                            `).join('')}
                        </div>
                    </div>
                `;
            container.innerHTML += card;
        });
    }

    // Afficher les données initiales
    renderDoctors(mockDoctors);

    // Simulation dyal la recherche
    document.getElementById('searchForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const filtered = mockDoctors.filter(doc =>
            doc.name.toLowerCase().includes(searchTerm) ||
            doc.specialty.toLowerCase().includes(searchTerm)
        );
        renderDoctors(filtered);
    });

    function reserver(doctorId, slot) {
        alert("Redirection vers la confirmation du créneau: " + slot);
        }
</script>
</body>
</html>