<?php
$disponibilites = $disponibilites ?? [];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Disponibilités</title>

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

<body class="bg-[#F4F3EF] font-sans min-h-screen">

  <?php include 'views/layouts/nav.php'; ?>

<main class="ml-[220px] p-8">

    <div class="mb-8">
        <h1 class="font-serif text-3xl text-gray-900">
            Mes Disponibilités
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Gérez vos créneaux disponibles pour les patients.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- FORM -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6">

            <h2 class="text-lg font-semibold mb-4">
                Ajouter une disponibilité
            </h2>

            <form method="POST"
                  action="index.php?action=add_disponibilite"
                  class="space-y-4">

                <div>
                    <label class="block text-sm text-gray-600 mb-1">
                        Date
                    </label>

                    <input type="date"
                           name="date"
                           required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-1">
                        Heure début
                    </label>

                    <input type="time"
                           name="heure_debut"
                           required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-1">
                        Heure fin
                    </label>

                    <input type="time"
                           name="heure_fin"
                           required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg">
                    Ajouter
                </button>

            </form>
        </div>

        <!-- LIST -->
        <div class="lg:col-span-2 bg-white border border-gray-200 rounded-2xl overflow-hidden">

            <div class="p-5 border-b border-gray-200">
                <h2 class="font-semibold text-lg">
                    Liste des disponibilités
                </h2>
            </div>

            <?php if (empty($disponibilites)): ?>

                <div class="p-8 text-center text-gray-400">
                    Aucune disponibilité trouvée.
                </div>

            <?php else: ?>

                <table class="w-full text-sm">

                    <thead class="bg-gray-50">

                        <tr>
                            <th class="px-4 py-3 text-left">
                                Date
                            </th>

                            <th class="px-4 py-3 text-left">
                                Début
                            </th>

                            <th class="px-4 py-3 text-left">
                                Fin
                            </th>

                            <th class="px-4 py-3 text-left">
                                Statut
                            </th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php foreach ($disponibilites as $d): ?>

                        <tr class="border-t">

                            <td class="px-4 py-3">
                                <?= date('d/m/Y', strtotime($d->date)) ?>
                            </td>

                            <td class="px-4 py-3">
                                <?= substr($d->heure_debut, 0, 5) ?>
                            </td>

                            <td class="px-4 py-3">
                                <?= substr($d->heure_fin, 0, 5) ?>
                            </td>

                            <td class="px-4 py-3">

                                <?php if ($d->disponible): ?>

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                        Disponible
                                    </span>

                                <?php else: ?>

                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                                        Réservé
                                    </span>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            <?php endif; ?>

        </div>

    </div>

</main>

</body>
</html>