<?php
session_start();
require_once 'includes/language.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'config/database.php';
require_once 'includes/functions.php';

?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang'] ?? 'en'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang['nationalities']; ?> - FUT Champions</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.all.min.js"></script>
    <style>
        body {
            background-color: #f8fafc;
        }
    </style>
</head>
<body>
    <div class="flex">
        <?php include 'includes/sidebar.php'; ?>
        <main class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800"><?php echo $lang['nationalities']; ?></h1>
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
            
            <div class="mt-4 mb-6">
                <button onclick="showModal('addNationalityModal')" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Add Nationality</button>
            </div>

            <?php include 'includes/modals.php'; ?>

            <div id="nationalities-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <!-- Nationality cards will be loaded here -->
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
        loadNationalities();
    </script>
</body>
</html>