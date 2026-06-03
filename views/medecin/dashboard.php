<!DOCTYPE html>
<html>
<head>
    <title>Medecin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="container mx-auto p-8">

    <h1 class="text-3xl font-bold mb-6">
        Welcome Dr. <?= $_SESSION['user']['name'] ?>
    </h1>

    <div class="bg-white shadow rounded-lg p-6">

        <h2 class="text-xl font-semibold mb-4">
            Rendez-vous
        </h2>

        <table class="w-full border">

            <thead class="bg-blue-600 text-white">

            <tr>
                <th class="p-3">ID</th>
                <th class="p-3">Date</th>
                <th class="p-3">Status</th>
                <th class="p-3">Actions</th>
            </tr>

            </thead>

            <tbody>

            <?php foreach($rendezVous as $rdv): ?>

                <tr class="border-b">

                    <td class="p-3">
                        <?= $rdv->id ?>
                    </td>

                    <td class="p-3">
                        <?= $rdv->date_rdv ?>
                    </td>

                    <td class="p-3">

                        <?php if($rdv->status == 'EN_ATTENTE'): ?>

                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded">
                                En attente
                            </span>

                        <?php elseif($rdv->status == 'CONFIRME'): ?>

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded">
                                Confirmé
                            </span>

                        <?php elseif($rdv->status == 'ANNULE'): ?>

                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded">
                                Annulé
                            </span>

                        <?php endif; ?>

                    </td>

                    <td class="p-3 flex gap-2">

                        <a
                            href="index.php?action=confirm_rdv&id=<?= $rdv->id ?>"
                            class="bg-green-600 text-white px-3 py-1 rounded">

                            Confirm
                        </a>

                        <a
                            href="index.php?action=cancel_rdv&id=<?= $rdv->id ?>"
                            class="bg-red-600 text-white px-3 py-1 rounded">

                            Cancel
                        </a>

                        <a
                            href="index.php?action=show_complete_rdv&id=<?= $rdv->id ?>"
                            class="bg-blue-600 text-white px-3 py-1 rounded">

                            Complete
                        </a>

                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>