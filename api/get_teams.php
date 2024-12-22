<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/config/database.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php');

header('Content-Type: application/json');

try {
    $teams = getTeams($conn);
    echo json_encode($teams);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error', 'message' => $e->getMessage()]);
}

mysqli_close($conn);
?>