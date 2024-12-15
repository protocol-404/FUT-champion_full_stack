<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Simple authentication check
    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['user_id'] = $username; // Store username in session
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
    <title>Login</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8fafc;
        }
    </style>
</head>
<body>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full max-w-4xl p-8 bg-white rounded-lg shadow-md">

            <!-- Admin Login Section -->
            <div class="p-6">
                <h2 class="text-2xl font-bold text-center mb-4">Admin Login</h2>
                 <?php if (isset($error)) : ?>
                    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                        <?= $error ?>
                    </div>
                <?php endif; ?>
                <form method="POST" class="space-y-4">
                     <div>
                        <label for="username" class="block mb-2 text-sm font-medium text-gray-700">Username</label>
                        <input type="text" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="username" name="username" required>
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                        <input type="password" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="password" name="password" required>
                    </div>
                     <button type="submit" class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Login</button>
                   <div class="text-center mt-4">
                    <a href="#" class="text-sm text-blue-600 hover:underline">Forgot Password?</a>
                 </div>
                </form>
            </div>

            <!-- Normal User Section -->
            <div class="p-6 flex flex-col items-center justify-center">
               <h2 class="text-2xl font-bold mb-4 text-center">Build Your Team</h2>
                <p class="text-gray-700 mb-6 text-center">Click below to start building your FUT team.</p>
                <a href="team_build.php" class="w-full md:w-auto px-6 py-3 text-white bg-green-600 rounded-md hover:bg-green-700">Build Team</a>
            </div>

        </div>
    </div>
</body>
</html>