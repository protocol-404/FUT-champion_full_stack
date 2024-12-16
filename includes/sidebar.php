<?php

if (!isset($lang)) {
    $lang = [
        'dashboard' => 'Dashboard',
        'players' => 'Players',
        'teams' => 'Teams',
        'nationalities' => 'Nationalities',
        'logout' => 'Logout'
    ];
}
?>
<nav class="flex flex-col w-64 h-screen bg-gray-100 border-r border-gray-200">
    <div class="flex items-center justify-center h-16 bg-blue-600 text-white">
        <h1 class="text-lg font-bold">FUT Champions</h1>
    </div>

    <div class="flex flex-col items-center p-4 border-b border-gray-200">
        <img src="assets/img/admin.png" alt="User Profile" class="w-20 h-20 rounded-full mb-2 object-cover">
        <p class="text-gray-700 font-semibold">Admin User</p>
        <p class="text-gray-500 text-sm">admin@example.com</p>
    </div>

    <div class="flex-grow p-4">
        <ul class="space-y-2">
            <li>
                <a class="flex items-center p-2 text-gray-700 rounded-md hover:bg-blue-100 transition duration-200" href="index.php">
                    <i class="fas fa-tachometer-alt mr-2"></i>
                    <?php echo $lang['dashboard']; ?>
                </a>
            </li>
            <li>
                <a class="flex items-center p-2 text-gray-700 rounded-md hover:bg-blue-100 transition duration-200" href="players.php">
                    <i class="fas fa-users mr-2"></i>
                    <?php echo $lang['players']; ?>
                </a>
            </li>
            <li>
                <a class="flex items-center p-2 text-gray-700 rounded-md hover:bg-blue-100 transition duration-200" href="teams.php">
                    <i class="fas fa-shield-alt mr-2"></i>
                    <?php echo $lang['teams']; ?>
                </a>
            </li>
            <li>
                <a class="flex items-center p-2 text-gray-700 rounded-md hover:bg-blue-100 transition duration-200" href="nationalities.php">
                    <i class="fas fa-flag mr-2"></i>
                    <?php echo $lang['nationalities']; ?>
                </a>
            </li>
        </ul>
    </div>
</nav>