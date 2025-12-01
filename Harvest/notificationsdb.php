<?php
// Connect to the database
$dbConnection = mysqli_connect('localhost', 'root', '', 'harvest_db');

if (!$dbConnection) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Drop the 'workshops' table if it exists
$drop_sql = "DROP TABLE IF EXISTS notifications";
if (mysqli_query($dbConnection, $drop_sql)) {
    echo "Table 'workshops' dropped successfully (if it existed)<br>";
} else {
    echo "Error dropping table: " . mysqli_error($dbConnection) . "<br>";
}

// Create a new table for Resource Hub
$table_sql = "CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

if (mysqli_query($dbConnection, $table_sql)) {
    echo "Table 'notifications' created successfully<br>";
} else {
    echo "Error creating table: " . mysqli_error($dbConnection) . "<br>";
}

// Close the database connection
mysqli_close($dbConnection);
?>
