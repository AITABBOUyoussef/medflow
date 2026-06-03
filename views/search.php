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

    <div class="bg-white/80 backdrop-blur-md border border-gray-100 shadow-sm rounded-2xl p-6 mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            Trouver un Médecin
        </h2>

        <form method="GET" class="flex gap-4">
            <input
                type="text"
                name="search"
                placeholder="Nom du médecin ou spécialité..."
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white transition-all"
            >

            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-medium transition-colors"
            >
                Rechercher
            </button>
        </form>
    </div>

    <div class="grid gap-4">

        <?php if (!empty($doctors)): ?>

            <?php foreach ($doctors as $doctor): ?>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex justify-between items-center">

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">
                            <?= htmlspecialchars($doctor['name']) ?>
                        </h3>

                        <span class="inline-block bg-blue-50 text-blue-600 text-sm px-3 py-1 rounded-full mt-1">
                            <?= htmlspecialchars($doctor['nom']) ?>
                        </span>
                    </div>

                    <div>
                        <button
                            class="border border-blue-600 text-blue-600 px-4 py-2 rounded-lg"
                        >
                            Voir disponibilités
                        </button>
                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="bg-white p-6 rounded-2xl text-center">
                Aucun médecin trouvé.
            </div>

        <?php endif; ?>

    </div>

</div>

</body>
</html>



