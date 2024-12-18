<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team_id = sanitize($conn, $_POST['id']);
    $team_name = sanitize($conn, $_POST['name']);
    $team_rating = sanitize($conn, $_POST['rating']);
    $team_flag_url = sanitize($conn, $_POST['flag_url']);

    $query = "UPDATE teams SET name = ?, rating = ?, flag_url = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sisi', $team_name, $team_rating, $team_flag_url, $team_id);

    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

mysqli_close($conn);
?>