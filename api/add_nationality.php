<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/config/database.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nationality_name = sanitize($conn, $_POST['name']);
    $nationality_code = sanitize($conn, $_POST['code']);
    $nationality_flag_url = sanitize($conn, $_POST['flag_url']);

    $query = "INSERT INTO nationalities (name, code, flag_url) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sss', $nationality_name, $nationality_code, $nationality_flag_url);

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