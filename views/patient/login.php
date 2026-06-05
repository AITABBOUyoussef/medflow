<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';
unset($_SESSION['error'], $_SESSION['success']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['password'])) {
    require_once __DIR__ . '/../../config/DB.php';

    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    if ($email === '' || $password === '') {
        $error = 'Veuillez saisir votre email et votre mot de passe.';
    } else {
        $db = DB::connect();
        $stmt = $db->prepare(
            'SELECT u.id, u.name, u.password, r.label AS role
             FROM users u
             JOIN roles r ON r.id = u.role_id
             WHERE u.email = :email
             LIMIT 1'
        );
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = (int) $user['id'];
            $_SESSION['name']    = $user['name'];
            $_SESSION['role']    = $user['role'];
            $_SESSION['success'] = 'Connexion réussie. Bienvenue sur MedFlow !';

            header('Location: dashboard.php');
            exit;
        }

        $error = 'Adresse e-mail ou mot de passe invalide.';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | MedFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 flex items-center justify-center p-6">

<div class="w-full max-w-5xl bg-white/10 backdrop-blur-lg rounded-3xl shadow-2xl overflow-hidden grid md:grid-cols-2">

    <div class="hidden md:flex flex-col justify-center items-center p-10 text-white">
        <h1 class="text-5xl font-bold mb-4">MedFlow</h1>
        <p class="text-lg opacity-90 text-center">
            Connectez-vous à votre espace patient et accédez à la gestion de vos rendez-vous, ordonnances et consultations.
        </p>
        <img src="https://cdn-icons-png.flaticon.com/512/3785/3785531.png" alt="Medical" class="w-72 mt-10">
    </div>

    <div class="bg-white p-10">
        <?php if ($error): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded mb-6 text-center"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded mb-6 text-center"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-4xl">👨‍⚕️</span>
            </div>
            <h2 class="text-3xl font-bold text-gray-800">Connexion MedFlow</h2>
            <p class="text-gray-500 mt-2">Utilisez votre compte MedFlow ou votre compte Fonality.</p>
        </div>

        <div class="space-y-4">
            <a href="fonality_login.php"
               class="flex items-center justify-center gap-3 w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-700 font-semibold hover:bg-gray-100 transition">
                <img src="https://cdn-icons-png.flaticon.com/512/906/906334.png" alt="Fonality" class="w-6 h-6">
                Continuer avec Fonality
            </a>

            <div class="flex items-center gap-3 text-sm text-gray-400">
                <span class="h-px flex-1 bg-gray-200"></span>
                <span>ou</span>
                <span class="h-px flex-1 bg-gray-200"></span>
            </div>
        </div>

        <form method="POST" action="login.php" class="space-y-5 mt-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Adresse email</label>
                <input type="email" name="email" required placeholder="exemple@domaine.com"
                       class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input type="password" name="password" required placeholder="********"
                       class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
            </div>

            <div class="flex justify-between items-center text-sm text-gray-600">
                <label class="flex items-center gap-2">
                    <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    Se souvenir de moi
                </label>
                <a href="#" class="text-blue-600 hover:text-indigo-700">Mot de passe oublié ?</a>
            </div>

            <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-xl font-semibold text-lg hover:scale-105 transition duration-300 shadow-lg">
                Se connecter
            </button>
        </form>

        <div class="mt-8 text-center text-gray-600">
            <p>Pas encore de compte ?</p>
            <a href="register.php" class="text-blue-600 font-semibold hover:text-indigo-700">Créer un compte</a>
        </div>
    </div>

</div>

</body>
</html>
