<?php
// Connect to the database
$dbConnection = mysqli_connect('localhost', 'root', '', 'harvest_db');

if (!$dbConnection) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Drop the 'workshops' table if it exists
$drop_sql = "DROP TABLE IF EXISTS resources_hub";
if (mysqli_query($dbConnection, $drop_sql)) {
    echo "Table 'workshops' dropped successfully (if it existed)<br>";
} else {
    echo "Error dropping table: " . mysqli_error($dbConnection) . "<br>";
}

// Create a new table for Resource Hub
$table_sql = "CREATE TABLE IF NOT EXISTS resources_hub (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(100) NOT NULL,
    contact_info VARCHAR(100) NOT NULL,
    link VARCHAR(255)
)";

if (mysqli_query($dbConnection, $table_sql)) {
    echo "Table 'resources_hub' created successfully<br>";
} else {
    echo "Error creating table: " . mysqli_error($dbConnection) . "<br>";
}

// Close the database connection
mysqli_close($dbConnection);
?>
