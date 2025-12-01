<?php
// Connect to the database
$dbConnection = mysqli_connect('localhost', 'root', '', 'harvest_db');

if (!$dbConnection) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Delete all existing rows from the workshops table
$delete_sql = "DELETE FROM resources_hub";
if (mysqli_query($dbConnection, $delete_sql)) {
    echo "Previous workshop data deleted successfully.<br>";
} else {
    echo "Error deleting data: " . mysqli_error($dbConnection) . "<br>";
}


// Insert sample data
$insert_sql = "INSERT INTO resources_hub (title, description, category, contact_info, link)
VALUES
('Community Library', 'A place to borrow books and study resources.', 'Education', 'contact@library.com', 'https://www.ppas.gov.my/'),
('Local Farmers Market', 'Find fresh produce and local goods.', 'Food', '012-3456789', 'https://www.facebook.com/farmersfreshmartsdnbhd'),
('City Animal Shelter', 'Animal Welfare', 'Nonprofit', '012-9876543', 'https://www.paws.org.my/')";


if (mysqli_query($dbConnection, $insert_sql)) {
    echo "Sample data inserted successfully<br>";
} else {
    echo "Error inserting data: " . mysqli_error($dbConnection) . "<br>";
}

// Close the database connection
mysqli_close($dbConnection);
?>
