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

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
     <style>
        body {
            background-color: #f8fafc;
        }
    </style>
</head>
<body>
    <div class="flex">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main content -->
        <main class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800"><?php echo $lang['dashboard']; ?></h1>
                <div class="flex items-center space-x-4">
                    <!-- Language selector -->
                    <div class="relative">
                        <button id="languageButton" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <?php echo $lang['language']; ?>
                        </button>
                        <div id="languageDropdown" class="absolute right-0 z-10 hidden mt-2 w-48 bg-white rounded-md shadow-lg">
                            <ul class="py-1" role="menu">
                                <li><a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="?lang=en">English</a></li>
                                <li><a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="?lang=fr">Français</a></li>
                                <li><a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="?lang=es">Español</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Logout Button -->
                    <a href="?logout=true" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">Logout</a>
                </div>
            </div>

             <!-- Statistics Cards -->
             <div class="grid grid-cols-1 gap-6 mt-6 md:grid-cols-2">
                <!-- Total Players Card -->
               <div class="md:col-span-1 flex flex-col items-center">
                   <div class="bg-blue-600 text-white p-4 rounded-lg shadow w-full flex flex-col items-center">
                           <i class="fas fa-users text-5xl mb-2"></i>
                       <h5 class="font-bold"><?php echo $lang['total_players']; ?></h5>
                       <h2 id="totalPlayers" class="text-3xl font-bold"></h2>
                   </div>
               </div>

                <!-- Total Teams Card -->
                <div class="md:col-span-1 flex flex-col items-center">
                    <div class="bg-green-600 text-white p-4 rounded-lg shadow w-full  flex flex-col items-center">
                        <i class="fas fa-futbol text-5xl mb-2"></i>
                        <h5 class="font-bold"><?php echo $lang['total_teams']; ?></h5>
                        <h2 id="totalTeams" class="text-3xl font-bold"></h2>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 gap-6 mt-6 md:grid-cols-2">
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-chart-pie mr-2 text-gray-600"></i>
                        <h3 class="font-bold"><?php echo $lang['nationality_distribution']; ?></h3>
                    </div>
                    <canvas id="nationalityChart"></canvas>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-chart-line mr-2 text-gray-600"></i>
                        <h3 class="font-bold"><?php echo $lang['team_performance']; ?></h3>
                    </div>
                    <canvas id="performanceChart"></canvas>
                </div>
            </div>
        </main>
    </div>

    <!-- Include dashboard.js -->
    <script src="assets/js/dashboard.js"></script>

    <script>
        // Add event listener for language button
        document.getElementById('languageButton').addEventListener('click', function() {
            const dropdown = document.getElementById('languageDropdown');
            dropdown.classList.toggle('hidden');
        });

        // Hide language dropdown on outside click
        window.addEventListener('click', function(event) {
            const dropdown = document.getElementById('languageDropdown');
            if (!event.target.matches('#languageButton') && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>