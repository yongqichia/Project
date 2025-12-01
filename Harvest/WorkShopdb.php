<?php
// Connect to the database
$dbConnection = mysqli_connect('localhost', 'root', '', 'harvest_db');

if (!$dbConnection) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Drop the 'workshops' table if it exists
$drop_sql = "DROP TABLE IF EXISTS workshops";
if (mysqli_query($dbConnection, $drop_sql)) {
    echo "Table 'workshops' dropped successfully (if it existed)<br>";
} else {
    echo "Error dropping table: " . mysqli_error($dbConnection) . "<br>";
}

// Create the 'workshops' table
$table_sql = "CREATE TABLE IF NOT EXISTS workshops (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    type ENUM('Online', 'Physical') NOT NULL,
    location VARCHAR(255),
    date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    registration_link VARCHAR(255),
    capacity INT NOT NULL,
    current_attendees INT DEFAULT 0
)";


if (mysqli_query($dbConnection, $table_sql)) {
    echo "Workshops table created successfully<br>";
} else {
    echo "Error creating table: " . mysqli_error($dbConnection) . "<br>";
}

// Close the connection
mysqli_close($dbConnection);
?>
