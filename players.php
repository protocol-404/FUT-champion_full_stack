<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}

$positions = [
    'GK' => 'Goalkeeper',
    'LB' => 'Left Back',
    'CB' => 'Center Back',
    'RB' => 'Right Back',
    'LWB' => 'Left Wing Back',
    'RWB' => 'Right Wing Back',
    'CDM' => 'Central Defensive Midfielder',
    'CM' => 'Central Midfielder',
    'CAM' => 'Central Attacking Midfielder',
    'LM' => 'Left Midfielder',
    'RM' => 'Right Midfielder',
    'LW' => 'Left Winger',
    'RW' => 'Right Winger',
    'CF' => 'Center Forward',
    'ST' => 'Striker'
];

?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Players</title>
    <!-- Tailwind CSS, SweetAlert2, Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                <h1 class="text-2xl font-bold text-gray-800">Manage Players</h1>
                <div class="flex items-center space-x-4">
                    <a href="?logout=true" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">Logout</a>
                </div>
            </div>

            <div class="mt-4 mb-6">
                <button class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700" data-modal-toggle="addPlayerModal">Add Player</button>
            </div>

            <!-- Modals (Add and Update) -->
            <?php include 'includes/modals.php'; ?>

            <!-- Player Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                    <thead>
                        <tr class="bg-blue-600 text-white">
                            <th class="px-4 py-2">Player photo</th>
                            <th class="px-4 py-2">First Name</th>
                            <th class="px-4 py-2">Last Name</th>
                            <th class="px-4 py-2">Nationality</th>
                            <th class="px-4 py-2">Team</th>
                            <th class="px-4 py-2">Position</th>
                            <th class="px-4 py-2">Rating</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <!-- Data will be loaded here by JavaScript -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="assets/js/dashboard.js"></script>
</body>
</html>