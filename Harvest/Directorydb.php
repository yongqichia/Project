<?php
// Connect to the database
$dbConnection = mysqli_connect('localhost', 'root', '', 'harvest_db');

if (!$dbConnection) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Drop the 'workshops' table if it exists
$drop_sql = "DROP TABLE IF EXISTS directory";
if (mysqli_query($dbConnection, $drop_sql)) {
    echo "Table 'workshops' dropped successfully (if it existed)<br>";
} else {
    echo "Error dropping table: " . mysqli_error($dbConnection) . "<br>";
}

// SQL to create the 'directory' table
$table_sql = "CREATE TABLE IF NOT EXISTS directory (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        address TEXT NOT NULL,
        operation_time VARCHAR(100) NOT NULL,
        contact_number VARCHAR(15) NOT NULL,
        type VARCHAR(100) NOT NULL,
        details_link VARCHAR(255)
    )";

if (mysqli_query($dbConnection, $table_sql)) {
    echo "Table 'resources_hub' created successfully<br>";
} else {
    echo "Error creating table: " . mysqli_error($dbConnection) . "<br>";
}

// Close the database connection
mysqli_close($dbConnection);
?>






