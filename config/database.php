<?php
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$conn = mysqli_connect(
    $_ENV['DB_HOST'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS']
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "CREATE DATABASE IF NOT EXISTS " . $_ENV['DB_NAME'];
if (mysqli_query($conn, $sql)) {
    mysqli_select_db($conn, $_ENV['DB_NAME']);
} else {
    die("Error creating database: " . mysqli_error($conn));
}

mysqli_set_charset($conn, "utf8mb4");
?>
