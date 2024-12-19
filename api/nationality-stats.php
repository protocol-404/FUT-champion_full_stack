<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/config/database.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php');

try {
    $data = getNationalityDistribution($conn);
    $labels = array_column($data, 'name');
    $values = array_column($data, 'count');
    echo json_encode(['labels' => $labels, 'values' => $values]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error']);
}

mysqli_close($conn);
?>