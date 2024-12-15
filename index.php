<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/language.php';

// Logout logic
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch total players and teams
$totalPlayers = getTotalPlayers($conn);
$totalTeams = getTotalTeams($conn);

// Fetch nationality distribution
$nationalityDistribution = [];
$query = "SELECT n.name, COUNT(p.id) as count FROM nationalities n LEFT JOIN players p ON n.id = p.nationality_id GROUP BY n.id";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $nationalityDistribution[] = [
        'label' => $row['name'],
        'count' => (int)$row['count']
    ];
}

// Fetch team performance data
$teamPerformance = [];
$query = "SELECT t.name, AVG(p.rating) as avg_rating FROM teams t LEFT JOIN players p ON t.id = p.team_id GROUP BY t.id";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $teamPerformance[] = [
        'label' => $row['name'],
        'avg_rating' => (float)$row['avg_rating']
    ];
}
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang'] ?? 'en'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUT Champions Dashboard</title>

    <!-- <link rel="stylesheet" href="assets/css/style.css"> -->

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
     <style>
        body {
            background-color: #f8fafc; /* Light background for contrast */
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
                       <h2 id="totalPlayers" class="text-3xl font-bold"><?php echo $totalPlayers; ?></h2>
                   </div>
               </div>

                <!-- Total Teams Card -->
                <div class="md:col-span-1 flex flex-col items-center">
                    <div class="bg-green-600 text-white p-4 rounded-lg shadow w-full  flex flex-col items-center">
                        <i class="fas fa-futbol text-5xl mb-2"></i>
                        <h5 class="font-bold"><?php echo $lang['total_teams']; ?></h5>
                        <h2 id="totalTeams" class="text-3xl font-bold"><?php echo $totalTeams; ?></h2>
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

    <script>
        // Toggle language dropdown
        document.getElementById('languageButton').addEventListener('click', function() {
            const dropdown = document.getElementById('languageDropdown');
            dropdown.classList.toggle('hidden');
        });

        // Close dropdown if clicked outside
        window.addEventListener('click', function(event) {
            const dropdown = document.getElementById('languageDropdown');
            if (!event.target.matches('#languageButton') && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Nationality Distribution Chart
        const nationalityData = <?php echo json_encode($nationalityDistribution); ?>;
        const nationalityLabels = nationalityData.map(item => item.label);
        const nationalityCounts = nationalityData.map(item => item.count);

        const nationalityCtx = document.getElementById('nationalityChart').getContext('2d');
        const nationalityChart = new Chart(nationalityCtx, {
            type: 'pie',
            data: {
                labels: nationalityLabels,
                datasets: [{
                    label: 'Nationality Distribution',
                    data: nationalityCounts,
                    backgroundColor: nationalityCounts.map(() => `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.6)`),
                    borderColor: 'rgba(255, 255, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Nationality Distribution'
                    }
                }
            }
        });

        // Team Performance Chart
        const teamData = <?php echo json_encode($teamPerformance); ?>;
        const teamLabels = teamData.map(item => item.label);
        const teamRatings = teamData.map(item => item.avg_rating);

        const performanceCtx = document.getElementById('performanceChart').getContext('2d');
        const performanceChart = new Chart(performanceCtx, {
            type: 'bar',
            data: {
                labels: teamLabels,
                datasets: [{
                    label: 'Average Team Rating',
                    data: teamRatings,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Team Performance'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>