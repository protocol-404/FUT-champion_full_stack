<?php
session_start();
require_once 'includes/language.php';

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang'] ?? 'en'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUT Champions Dashboard</title>

    <!-- Google Fonts, Font Awesome, Tailwind CSS,  Chart.js -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8fafc;
            background-image: radial-gradient(#e2e8f0 0.5px, transparent 0.5px);
            background-size: 10px 10px;
        }

        .stats-card {
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .gradient-blue {
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
        }

        .gradient-green {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        }

        .chart-container {
            transition: all 0.3s ease;
        }

        .chart-container:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .language-selector {
            position: relative;
            z-index: 50;
        }

        .language-dropdown {
            backdrop-filter: blur(8px);
            background-color: rgba(255, 255, 255, 0.95);
        }
    </style>
</head>
<body class="font-sans">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 tracking-tight"><?php echo $lang['dashboard']; ?></h1>

                <div class="flex items-center space-x-4">
                    <!-- Language selector -->
                    <div class="language-selector">
                        <button id="languageButton" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm">
                            <i class="fas fa-globe mr-2"></i>
                            <?php echo $lang['language']; ?>
                        </button>
                        <div id="languageDropdown" class="language-dropdown absolute right-0 hidden mt-2 w-48 rounded-lg shadow-lg ring-1 ring-black ring-opacity-5">
                            <ul class="py-2" role="menu">
                                <li><a class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600" href="?lang=en">English</a></li>
                                <li><a class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600" href="?lang=fr">Français</a></li>
                                <li><a class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600" href="?lang=ar">العربية</a></li>
                            </ul>
                        </div>
                    </div>
                    <a href="?logout=true" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 transition-colors">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </a>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 gap-8 mt-8 md:grid-cols-2">
                <!-- Total Players Card -->
                <div class="stats-card rounded-xl shadow-lg overflow-hidden">
                    <div class="gradient-blue p-6 text-white flex flex-col items-center">
                        <i class="fas fa-users text-6xl mb-4 opacity-90"></i>
                        <h5 class="text-lg font-semibold mb-2"><?php echo $lang['total_players']; ?></h5>
                        <h2 id="totalPlayers" class="text-4xl font-bold"></h2>
                    </div>
                </div>

                <!-- Total Teams Card -->
                <div class="stats-card rounded-xl shadow-lg overflow-hidden">
                    <div class="gradient-green p-6 text-white flex flex-col items-center">
                        <i class="fas fa-futbol text-6xl mb-4 opacity-90"></i>
                        <h5 class="text-lg font-semibold mb-2"><?php echo $lang['total_teams']; ?></h5>
                        <h2 id="totalTeams" class="text-4xl font-bold"></h2>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 gap-8 mt-8 md:grid-cols-2">
                <div class="chart-container bg-white p-6 rounded-xl shadow-lg">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-chart-pie text-2xl text-indigo-600 mr-3"></i>
                        <h3 class="text-xl font-bold text-gray-800"><?php echo $lang['nationality_distribution']; ?></h3>
                    </div>
                    <canvas id="nationalityChart"></canvas>
                </div>
                <div class="chart-container bg-white p-6 rounded-xl shadow-lg">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-chart-line text-2xl text-green-600 mr-3"></i>
                        <h3 class="text-xl font-bold text-gray-800"><?php echo $lang['team_performance']; ?></h3>
                    </div>
                    <canvas id="performanceChart"></canvas>
                </div>
            </div>
        </main>
    </div>

    <script src="assets/js/dashboard.js"></script>

    <script>
        document.getElementById('languageButton').addEventListener('click', function() {
            const dropdown = document.getElementById('languageDropdown');
            dropdown.classList.toggle('hidden');
        });

        window.addEventListener('click', function(event) {
            const dropdown = document.getElementById('languageDropdown');
            if (!event.target.matches('#languageButton') && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>