<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $player_id = (int)$_GET['id'];

    $query = "DELETE FROM players WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $player_id);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);


    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method or missing ID.']);
}

mysqli_close($conn);
?>