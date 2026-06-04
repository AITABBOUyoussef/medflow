<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../../config/DB.php';

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $birth_date = $_POST['birth_date'] ?? '';

    // Validation
    if ($name === '' || $email === '' || $password === '' || $password_confirm === '' || $birth_date === '') {
        $error = 'Tous les champs sont obligatoires.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Veuillez saisir une adresse email valide.';
    } elseif (strlen($password) < 8) {
        $error = 'Le mot de passe doit contenir au moins 8 caractères.';
    } elseif ($password !== $password_confirm) {
        $error = 'Les mots de passe ne correspondent pas.';
    } else {
        try {
            $db = DB::connect();

            // Check if email already exists
            $stmt = $db->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
            $stmt->execute([':email' => $email]);
            if ($stmt->fetch()) {
                $error = 'Cette adresse email est déjà utilisée.';
            } else {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // Insert user with PATIENT role (role_id = 3)
                $stmt = $db->prepare(
                    'INSERT INTO users (name, email, password, role_id)
                     VALUES (:name, :email, :password, :role_id)'
                );
                $stmt->execute([
                    ':name' => $name,
                    ':email' => $email,
                    ':password' => $hashed_password,
                    ':role_id' => 3, // PATIENT
                ]);

                $user_id = (int) $db->lastInsertId();

                // Insert patient record
                $stmt = $db->prepare(
                    'INSERT INTO patients (user_id, birth_date)
                     VALUES (:user_id, :birth_date)'
                );
                $stmt->execute([
                    ':user_id' => $user_id,
                    ':birth_date' => $birth_date,
                ]);

                $_SESSION['success'] = 'Compte créé avec succès. Veuillez vous connecter.';
                header('Location: login.php');
                exit;
            }
        } catch (PDOException $e) {
            $error = 'Erreur lors de la création du compte. Veuillez réessayer.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte | MedFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 flex items-center justify-center p-6">

<div class="w-full max-w-5xl bg-white/10 backdrop-blur-lg rounded-3xl shadow-2xl overflow-hidden grid md:grid-cols-2">

    <div class="hidden md:flex flex-col justify-center items-center p-10 text-white">
        <h1 class="text-5xl font-bold mb-4">MedFlow</h1>
        <p class="text-lg opacity-90 text-center">
            Rejoignez notre plateforme de gestion santé. Créez votre compte en quelques minutes et accédez à tous vos services médicaux.
        </p>
        <img src="https://cdn-icons-png.flaticon.com/512/3062/3062634.png" alt="Register" class="w-72 mt-10">
    </div>

    <div class="bg-white p-10">
        <?php if ($error): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded mb-6 text-center"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-4xl">✍️</span>
            </div>
            <h2 class="text-3xl font-bold text-gray-800">Créer un compte</h2>
            <p class="text-gray-500 mt-2">Inscrivez-vous pour accéder à MedFlow</p>
        </div>

        <form method="POST" action="register.php" class="space-y-5">

            <div>
                <label class="block text-sm font-medium text-gray-700">Nom complet</label>
                <input
                    type="text"
                    name="name"
                    required
                    placeholder="Jean Dupont"
                    value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                    class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Adresse email</label>
                <input
                    type="email"
                    name="email"
                    required
                    placeholder="exemple@domaine.com"
                    value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                    class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Date de naissance</label>
                <input
                    type="date"
                    name="birth_date"
                    required
                    class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input
                    type="password"
                    name="password"
                    required
                    placeholder="Minimum 8 caractères"
                    class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
                <p class="text-xs text-gray-500 mt-1">Le mot de passe doit contenir au moins 8 caractères.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                <input
                    type="password"
                    name="password_confirm"
                    required
                    placeholder="Confirmez votre mot de passe"
                    class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
            </div>

            <button
                type="submit"
                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-xl font-semibold text-lg hover:scale-105 transition duration-300 shadow-lg">
                Créer un compte
            </button>

        </form>

        <div class="mt-8 text-center">
            <p class="text-gray-600">
                Vous avez déjà un compte ?
            </p>
            <a
                href="login.php"
                class="text-blue-600 font-semibold hover:text-indigo-700">
                Se connecter
            </a>
        </div>

    </div>

</div>

</body>
</html>
