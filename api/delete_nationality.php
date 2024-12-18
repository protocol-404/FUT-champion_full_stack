<?php
require_once '../config/database.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $nationality_id = (int)$_POST['id'];

    $query = "DELETE FROM nationalities WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $nationality_id);
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