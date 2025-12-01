<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must log in to apply for a workshop.'); window.location.href = 'login.php';</script>";
    exit();
}

// Connect to the database
$dbConnection = mysqli_connect('localhost', 'root', '', 'harvest_db');

if (!$dbConnection) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Get the workshop ID from the POST request
$workshop_id = $_POST['workshop_id'];

// Get the user's ID from session
$user_id = $_SESSION['user_id'];

// Check the current number of attendees and capacity
$sql = "SELECT capacity, current_attendees FROM workshops WHERE id = $workshop_id";
$result = mysqli_query($dbConnection, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $workshop = mysqli_fetch_assoc($result);
    if ($workshop['current_attendees'] < $workshop['capacity']) {
        // Apply successfully: Add to workshop history and update the number of attendees
        $insert_history_sql = "INSERT INTO workshop_history (user_id, workshop_id) VALUES ($user_id, $workshop_id)";
        $update_attendees_sql = "UPDATE workshops SET current_attendees = current_attendees + 1 WHERE id = $workshop_id";
        
        if (mysqli_query($dbConnection, $insert_history_sql) && mysqli_query($dbConnection, $update_attendees_sql)) {
            echo "<script>alert('Application successful! You have been added to the workshop.'); window.location.href = 'workshop_history.php';</script>";
        } else {
            echo "<script>alert('There was an error processing your application. Please try again later.'); window.location.href = 'workshops.php';</script>";
        }
    } else {
        echo "<script>alert('Sorry, this workshop is already full.'); window.location.href = 'workshops.php';</script>";
    }
} else {
    echo "<script>alert('Invalid workshop.'); window.location.href = 'workshops.php';</script>";
}

// Close the connection
mysqli_close($dbConnection);
?>
