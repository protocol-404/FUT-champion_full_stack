<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

try {
    $players = getPlayersWithDetails($conn);
    echo json_encode($players);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error', 'message' => $e->getMessage()]);
}

mysqli_close($conn);
?>