
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Patient</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 flex items-center justify-center p-6">

<div class="w-full max-w-5xl bg-white/10 backdrop-blur-lg rounded-3xl shadow-2xl overflow-hidden grid md:grid-cols-2">

    <!-- Left Side -->
    <div class="hidden md:flex flex-col justify-center items-center p-10 text-white">

        <div class="text-center">
            <h1 class="text-5xl font-bold mb-4">
                MedFlow
            </h1>

            <p class="text-lg opacity-90">
                Your healthcare management platform
            </p>

            <img
                src="https://cdn-icons-png.flaticon.com/512/2966/2966486.png"
                class="w-64 mx-auto mt-8"
                alt="">
        </div>

    </div>

    <!-- Right Side -->
    <div class="bg-white p-10">

        <div class="text-center mb-8">

            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-4xl">👨‍⚕️</span>
            </div>

            <h2 class="text-3xl font-bold text-gray-800">
                Create Account
            </h2>

            <p class="text-gray-500 mt-2">
                Register as a Patient
            </p>

        </div>

        <form method="POST" action="index.php?action=store_register" class="space-y-5">

            <div>
                <label class="text-sm font-medium text-gray-700">
                    Full Name
                </label>

                <input
                    type="text"
                    name="name"
                    required
                    placeholder="Enter your full name"
                    class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">
                    Email Address
                </label>

                <input
                    type="email"
                    name="email"
                    required
                    placeholder="example@gmail.com"
                    class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">
                    Birth Date
                </label>

                <input
                    type="date"
                    name="birth_date"
                    required
                    class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    required
                    placeholder="********"
                    class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
            </div>

            <button
                type="submit"
                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-xl font-semibold text-lg hover:scale-105 transition duration-300 shadow-lg">

                Register
            </button>

        </form>

        <div class="mt-6 text-center">

            <p class="text-gray-600">
                Already have an account?
            </p>

            <a
                href="index.php?action=login"
                class="text-blue-600 font-semibold hover:text-indigo-700">

                Sign In
            </a>

        </div>

    </div>

</div>

</body>

</html>