<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Fonality | MedFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 flex items-center justify-center p-6">

<div class="w-full max-w-3xl bg-white/95 rounded-3xl shadow-2xl p-10">
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-slate-900">Connexion Fonality</h1>
        <p class="text-slate-600 mt-3">Utilisez votre compte Fonality pour accéder à MedFlow.</p>
    </div>

    <div class="bg-slate-50 rounded-3xl p-8 border border-slate-200">
        <p class="text-slate-700 mb-6">Cette page est prête à recevoir l’intégration Fonality. Une fois votre fournisseur Fonality configuré, vous pourrez rediriger les utilisateurs vers votre serveur d’authentification externe.</p>

        <div class="space-y-4">
            <a href="#"
               class="flex items-center justify-center gap-3 w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-3 text-slate-700 font-semibold hover:bg-slate-200 transition">
                <img src="https://cdn-icons-png.flaticon.com/512/906/906334.png" alt="Fonality" class="w-6 h-6">
                Se connecter avec Fonality
            </a>
            <a href="login.php" class="block text-center text-blue-600 font-semibold hover:text-blue-800">Retour à la connexion MedFlow</a>
        </div>
    </div>
</div>

</body>
</html>
