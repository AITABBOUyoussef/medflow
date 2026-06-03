<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | MedFlow</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 flex items-center justify-center p-6">

<div class="w-full max-w-5xl bg-white/10 backdrop-blur-lg rounded-3xl shadow-2xl overflow-hidden grid md:grid-cols-2">

    <!-- Left Side -->
    <div class="hidden md:flex flex-col justify-center items-center p-10 text-white">

        <h1 class="text-5xl font-bold mb-4">
            MedFlow
        </h1>

        <p class="text-lg opacity-90 text-center">
            Welcome back to your healthcare management platform
        </p>

        <img
            src="https://cdn-icons-png.flaticon.com/512/2785/2785482.png"
            alt="Doctor"
            class="w-72 mt-10">
    </div>

    <!-- Right Side -->
    <div class="bg-white p-10">

        <div class="text-center mb-8">

            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-4xl">🔐</span>
            </div>

            <h2 class="text-3xl font-bold text-gray-800">
                Welcome Back
            </h2>

            <p class="text-gray-500 mt-2">
                Login to your account
            </p>

        </div>

        <form method="POST" action="index.php?action=store_login" class="space-y-5">

            <div>
                <label class="block text-sm font-medium text-gray-700">
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
                <label class="block text-sm font-medium text-gray-700">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    required
                    placeholder="********"
                    class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
            </div>

            <div class="flex justify-between items-center text-sm">

                <label class="flex items-center gap-2 text-gray-600">
                    <input type="checkbox">
                    Remember me
                </label>

                <a href="#" class="text-blue-600 hover:text-indigo-700">
                    Forgot Password?
                </a>

            </div>

            <button
                type="submit"
                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-xl font-semibold text-lg hover:scale-105 transition duration-300 shadow-lg">

                Sign In
            </button>

        </form>

        <div class="mt-8 text-center">

            <p class="text-gray-600">
                Don't have an account?
            </p>

            <a
                href="index.php?action=register"
                class="text-blue-600 font-semibold hover:text-indigo-700">

                Create Account
            </a>

        </div>

    </div>

</div>

</body>

</html>