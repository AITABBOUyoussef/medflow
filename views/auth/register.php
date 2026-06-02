

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Patient</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-blue-500 to-indigo-600 min-h-screen flex items-center justify-center">

<div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-8">

    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            Create Account
        </h1>

        <p class="text-gray-500 mt-2">
            Register as Patient
        </p>
    </div>

    <form method="POST" class="space-y-5" action="index.php?action=store_register">

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Full Name
            </label>

            <input
                type="text"
                name="name"
                required
                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Email
            </label>

            <input
                type="email"
                name="email"
                required
                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Birth Date
            </label>

            <input
                type="date"
                name="birth_date"
                required
                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Password
            </label>

            <input
                type="password"
                name="password"
                required
                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <button
            type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition">

            Register
        </button>

    </form>

    <div class="text-center mt-6">
        <a
            href="login.php"
            class="text-blue-600 hover:text-blue-800 font-medium">

            Already have an account?
        </a>
    </div>

</div>

</body>

</html>