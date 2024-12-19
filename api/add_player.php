<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/config/database.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = sanitize($conn, $_POST['first_name']);
    $last_name = sanitize($conn, $_POST['last_name']);
    $flag_url = sanitize($conn, $_POST['flag_url']);
    $nationality_id = (int)$_POST['nationality_id'];
    $team_id = (int)$_POST['team_id'];
    $position = sanitize($conn, $_POST['position']);
    $rating = (int)$_POST['rating'];
    $pace = (int)$_POST['pace'];
    $shooting = (int)$_POST['shooting'];
    $passing = (int)$_POST['passing'];
    $dribbling = (int)$_POST['dribbling'];
    $defending = (int)$_POST['defending'];
    $physical = (int)$_POST['physical'];

    $query = "INSERT INTO players (first_name, last_name, nationality_id, team_id, position, rating, pace, shooting, passing, dribbling, defending, physical, flag_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssiisiiiiiiis', $first_name, $last_name, $nationality_id, $team_id, $position, $rating, $pace, $shooting, $passing, $dribbling, $defending, $physical, $flag_url);

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