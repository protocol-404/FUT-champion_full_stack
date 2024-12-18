<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nationality_id = sanitize($conn, $_POST['id']);
    $nationality_name = sanitize($conn, $_POST['name']);
    $nationality_code = sanitize($conn, $_POST['code']);
    $nationality_flag_url = sanitize($conn, $_POST['flag_url']);

    $query = "UPDATE nationalities SET name = ?, code = ?, flag_url = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sssi', $nationality_name, $nationality_code, $nationality_flag_url, $nationality_id);

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