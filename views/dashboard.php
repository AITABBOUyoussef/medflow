<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedFlow - Tableau de Bord</title>
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
                <a href="dashboard.php" class="text-blue-600 font-medium border-b-2 border-blue-600 pb-1">Accueil</a>
                <a href="search.php" class="text-gray-500 hover:text-blue-600 font-medium transition-colors">Rechercher un médecin</a>
                <a href="mesRendesVous.php" class="text-gray-500 hover:text-blue-600 font-medium transition-colors">Mes Rendez-vous</a>
                <div class="h-6 w-px bg-gray-200"></div>
                <a href="#" class="text-red-500 hover:text-red-700 font-medium transition-colors">Déconnexion</a>
            </div>
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Welcome Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800" id="welcomeMessage">Bonjour, Patient 👋</h1>
        <p class="text-gray-500 mt-2">Bienvenue sur votre espace personnel. Que souhaitez-vous faire aujourd'hui ?</p>
    </div>

    <!-- Statistiques / Résumé -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Card 1 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 border-l-4 border-l-blue-500">
            <h3 class="text-gray-500 text-sm font-medium">Prochain Rendez-vous</h3>
            <p class="text-2xl font-bold text-gray-800 mt-2" id="nextRdvDate">04 Juin, 09:00</p>
            <p class="text-sm text-blue-600 mt-1" id="nextRdvDoctor">Avec Dr. Alami</p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 border-l-4 border-l-yellow-500">
            <h3 class="text-gray-500 text-sm font-medium">En attente de confirmation</h3>
            <p class="text-2xl font-bold text-gray-800 mt-2" id="pendingCount">1</p>
            <p class="text-sm text-gray-400 mt-1">Rendez-vous</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 border-l-4 border-l-green-500">
            <h3 class="text-gray-500 text-sm font-medium">Consultations terminées</h3>
            <p class="text-2xl font-bold text-gray-800 mt-2" id="completedCount">3</p>
            <p class="text-sm text-gray-400 mt-1">Historique global</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <h2 class="text-xl font-bold text-gray-800 mb-4">Actions Rapides</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="search.php" class="group bg-gradient-to-r from-blue-600 to-blue-700 p-6 rounded-2xl shadow-md hover:shadow-lg transition-all flex items-center justify-between">
            <div>
                <h3 class="text-white font-bold text-lg">Prendre un nouveau rendez-vous</h3>
                <p class="text-blue-100 text-sm mt-1">Recherchez un spécialiste et réservez votre créneau.</p>
            </div>
            <div class="bg-white/20 p-3 rounded-full group-hover:bg-white/30 transition-colors">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </a>

        <a href="mesRendesVous.php" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all flex items-center justify-between">
            <div>
                <h3 class="text-gray-800 font-bold text-lg">Consulter mes ordonnances</h3>
                <p class="text-gray-500 text-sm mt-1">Accédez à votre historique et téléchargez vos documents.</p>
            </div>
            <div class="bg-gray-50 p-3 rounded-full group-hover:bg-gray-100 transition-colors">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        </a>
    </div>
</main>

<script>

</script>
</body>
</html>