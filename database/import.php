<?php
require_once dirname(__DIR__) . '/config/database.php';

function executeSQLFile($conn, $filename) {
    $sql = file_get_contents($filename);
    
    $queries = array_filter(array_map('trim', explode(';', $sql)));
    
    foreach ($queries as $query) {
        if (!empty($query)) {
            if (!mysqli_query($conn, $query)) {
                die("Error executing query: " . mysqli_error($conn) . "\nQuery: " . $query);
            }
        }
    }
    return true;
}

echo "Importing database schema...\n";
if (executeSQLFile($conn, __DIR__ . '/init.sql')) {
    echo "Schema imported successfully!\n";
} else {
    die("Failed to import schema\n");
}

echo "Importing test data...\n";
if (executeSQLFile($conn, __DIR__ . '/test_data.sql')) {
    echo "Test data imported successfully!\n";
} else {
    die("Failed to import test data\n");
}

echo "Database setup completed successfully!\n";
?>
