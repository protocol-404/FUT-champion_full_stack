<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set default language if not set
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

// Handle language change
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Include language file
$langFile = dirname(__DIR__) . '/lang/' . $_SESSION['lang'] . '.php';
if (file_exists($langFile)) {
    require_once $langFile;
} else {
    // Fallback to English if language file doesn't exist
    require_once dirname(__DIR__) . '/lang/en.php';
}
?>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/path/to/your/custom.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>