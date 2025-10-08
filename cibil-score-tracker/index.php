<?php
// No PHP needed here, but renamed to .php for consistency
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CIBIL Score Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-indigo-50 to-purple-100 min-h-screen font-['Inter']">
    <header class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-4 shadow-lg sticky top-0 z-10 backdrop-blur-md bg-opacity-80">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center">
                <img src="./assets/img/1.png" alt="Logo" class="h-10 mr-3">
                <h1 class="text-3xl font-bold tracking-tight">CIBIL Score Tracker</h1>
            </div>
            <nav>
                <ul class="flex space-x-8">
                    <li><a href="index.php" class="hover:text-indigo-200 transition">Home</a></li>
                    <li><a href="pages/user/login.php" class="hover:text-indigo-200 transition">Login</a></li>
                    <li><a href="pages/user/dashboard.php" class="hover:text-indigo-200 transition">Dashboard</a></li>
                    <li><a href="pages/admin/admin-login.php" class="hover:text-indigo-200 transition">Admin</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="hero bg-gradient-to-br from-indigo-700 to-purple-700 text-white min-h-[600px] flex items-center justify-center">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-5xl font-bold mb-6 tracking-tight">Master Your Credit Journey</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Track, improve, and manage your CIBIL score with our cutting-edge tools designed for financial empowerment.</p>
            <div class="space-x-4">
                <a href="pages/user/login.php" class="bg-white text-indigo-700 py-3 px-8 rounded-full shadow-lg hover:bg-indigo-100 transition-transform transform hover:scale-105">Get Started</a>
                <a href="pages/user/register.php" class="bg-transparent border-2 border-white py-3 px-8 rounded-full hover:bg-white hover:text-indigo-700 transition-transform transform hover:scale-105">Sign Up</a>
            </div>
        </div>
    </section>

    <section class="features py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Why Choose CIBIL Score Tracker?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white bg-opacity-80 backdrop-blur-md p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow">
                    <h3 class="text-xl font-semibold mb-4 text-indigo-600">Real-Time Score Tracking</h3>
                    <p class="text-gray-600">Monitor your CIBIL score with instant updates and detailed history.</p>
                </div>
                <div class="bg-white bg-opacity-80 backdrop-blur-md p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow">
                    <h3 class="text-xl font-semibold mb-4 text-indigo-600">Personalized Goals</h3>
                    <p class="text-gray-600">Set and track credit goals to achieve your financial dreams.</p>
                </div>
                <div class="bg-white bg-opacity-80 backdrop-blur-md p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow">
                    <h3 class="text-xl font-semibold mb-4 text-indigo-600">Expert Recommendations</h3>
                    <p class="text-gray-600">Get tailored tips to boost your credit score.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonials py-16 bg-gradient-to-br from-indigo-50 to-purple-50">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">What Our Users Say</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white bg-opacity-80 backdrop-blur-md p-6 rounded-2xl shadow-xl">
                    <p class="text-gray-600 italic">"This app made tracking my credit score so easy! The tips helped me improve my score by 50 points!"</p>
                    <p class="mt-4 font-semibold text-indigo-600">- Priya S.</p>
                </div>
                <div class="bg-white bg-opacity-80 backdrop-blur-md p-6 rounded-2xl shadow-xl">
                    <p class="text-gray-600 italic">"The dashboard is intuitive, and the goal-setting feature keeps me motivated."</p>
                    <p class="mt-4 font-semibold text-indigo-600">- Rohan K.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-semibold mb-4">CIBIL Score Tracker</h3>
                    <p class="text-gray-400">Empowering you to take control of your financial future.</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-4">Links</h3>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-gray-400 hover:text-indigo-300 transition">Home</a></li>
                        <li><a href="pages/user/login.php" class="text-gray-400 hover:text-indigo-300 transition">Login</a></li>
                        <li><a href="pages/user/register.php" class="text-gray-400 hover:text-indigo-300 transition">Register</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-4">Contact</h3>
                    <p class="text-gray-400">Email: support@cibiltracker.com</p>
                    <p class="text-gray-400">Phone: +91 123-456-7890</p>
                </div>
            </div>
            <p class="text-center text-gray-400 mt-8">&copy; 2025 CIBIL Score Tracker. All rights reserved.</p>
        </div>
    </footer>

    <script src="assets/js/script.js"></script>
</body>
</html>