<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['user_id'] = $username; 
        header('Location: index.php');
        exit();
    } else {
        $error = 'Invalid username or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUT Team Builder - Login</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body class="min-h-screen flex items-center justify-center px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full max-w-4xl login-container overflow-hidden">
        <!-- Admin Login Section -->
        <div class="p-8 flex flex-col justify-center">
            <h2 class="text-3xl font-bold text-center mb-6 text-gray-800">Admin Login</h2>
            <?php if (isset($error)) : ?>
                <div class="p-4 mb-6 text-sm text-red-700 bg-red-100 rounded-lg text-center" role="alert">
                    <?= $error ?>
                </div>
            <?php endif; ?>
            <form method="POST" class="space-y-5">
                <div>
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-700">Username</label>
                    <input type="text" class="form-input block w-full p-3 rounded-lg" id="username" name="username" required placeholder="Enter your username">
                </div>
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                    <input type="password" class="form-input block w-full p-3 rounded-lg" id="password" name="password" required placeholder="Enter your password">
                </div>
                <button type="submit" class="login-btn w-full px-4 py-3 text-white rounded-lg text-lg font-semibold">Sign In</button>
            </form>
        </div>
        
        <!-- User Section -->
        <div class="p-8 flex flex-col items-center justify-center build-team-section">
            <div class="text-center">
                <h2 class="text-3xl font-bold mb-4 text-gray-800">Build Your Team</h2>
                <p class="text-gray-600 mb-6 text-lg">Start creating your ultimate FUT team now!</p>
                <a href="team_build.php" class="inline-block px-8 py-3 text-white bg-green-500 rounded-lg hover:bg-green-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                    Build Team
                </a>
            </div>
        </div>
    </div>
</body>
</html>