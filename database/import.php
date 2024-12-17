<?php
require_once dirname(__DIR__) . '/config/database.php';

// Function to execute SQL file
function executeSQLFile($conn, $filename) {
    $sql = file_get_contents($filename);
    
    // Split SQL file into individual queries
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

// Import schema
echo "Importing database schema...\n";
if (executeSQLFile($conn, __DIR__ . '/init.sql')) {
    echo "Schema imported successfully!\n";
} else {
    die("Failed to import schema\n");
}

// Import test data
echo "Importing test data...\n";
if (executeSQLFile($conn, __DIR__ . '/test_data.sql')) {
    echo "Test data imported successfully!\n";
} else {
    die("Failed to import test data\n");
}

echo "Database setup completed successfully!\n";
?>
