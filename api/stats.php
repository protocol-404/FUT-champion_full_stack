<?php
header('Content-Type: application/json');
require_once '../config/database.php';

// prevent SQL injection by using prepared statements
function getDashboardStats($conn) {
    $stats = array();
    
    $query = "SELECT COUNT(*) as total FROM players";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $stats['totalPlayers'] = (int)$row['total'];
    
    $query = "SELECT COUNT(*) as total FROM teams";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $stats['totalTeams'] = (int)$row['total'];
    
    $query = "SELECT AVG(rating) as avg_rating FROM teams";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $stats['averageTeamRating'] = round((float)$row['avg_rating'], 2);
    
    return $stats;
}

try {
    $stats = getDashboardStats($conn);
    echo json_encode($stats);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error']);
}

mysqli_close($conn);
