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
    <title><?php echo $lang['teams']; ?> - FUT Champions</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.all.min.js"></script>
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

        .language-selector {
            position: relative;
            z-index: 50;
        }

        .language-dropdown {
            backdrop-filter: blur(8px);
            background-color: rgba(255, 255, 255, 0.95);
        }

        .gradient-blue {
        background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
    }
    

    .stats-card img {
        filter: drop-shadow(0 0 8px rgba(255,255,255,0.3));
        transition: all 0.3s ease;
    }

    .stats-card:hover img {
        filter: drop-shadow(0 0 12px rgba(255,255,255,0.4));
        transform: scale(1.05);
    }
    </style>
</head>
<body class="font-sans">
    <div class="flex min-h-screen">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 tracking-tight"><?php echo $lang['teams']; ?></h1>

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

            <!-- Add Team Button -->
            <div class="mb-8">
                <button onclick="showModal('addTeamModal')" 
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Add Team
                </button>
            </div>

            <?php include 'includes/team_modals.php'; ?>

            <!-- Teams Grid -->
            <div id="teams-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <!-- Team cards will be loaded here -->
            </div>
        </main>
    </div>

    <script src="assets/js/dashboard.js"></script>
    <script>
        // Language dropdown functionality
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
        loadTeams();
    </script>
</body>
</html>