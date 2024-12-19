<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/config/database.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team_name = sanitize($conn, $_POST['name']);
    $team_rating = (int)sanitize($conn, $_POST['rating']);
    $team_flag_url = sanitize($conn, $_POST['flag_url']);

    $query = "INSERT INTO teams (name, rating, flag_url) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sis', $team_name, $team_rating, $team_flag_url);

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