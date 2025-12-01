<?php
// Connect to the database
$dbConnection = mysqli_connect('localhost', 'root', '', 'harvest_db');

if (!$dbConnection) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Delete all existing rows from the workshops table
$delete_sql = "DELETE FROM workshops";
if (mysqli_query($dbConnection, $delete_sql)) {
    echo "Previous workshop data deleted successfully.<br>";
} else {
    echo "Error deleting data: " . mysqli_error($dbConnection) . "<br>";
}

// Insert new workshop data
$insert_sql = "INSERT INTO workshops (title, description, type, location, date, start_time, end_time, registration_link, capacity, current_attendees)
VALUES
('Urban Gardening Workshop', 'Hands-on training for urban gardening.', 'Physical', '123 Garden Lane, KL', '2024-12-20', '20:00', '22:00', 'https://youngurbanfarmers.com/gardening-services/workshops/', 50, 13),
('Seed Starting', 'learn how to select the appropriate seeds for their garden.', 'Online', 'Zoom Meeting', '2024-12-15', '14:00', '16:00', 'https://youngurbanfarmers.com/gardening-services/workshops/', 50, 20),
('Worm and Backyard Composting', 'learn the basics when it comes to setting up and managing a backyard outdoor composter or indoor worm compost system.', 'Online', 'Microsoft Teams', '2024-12-18', '10:00', '12:00', 'https://youngurbanfarmers.com/gardening-services/workshops/', 40, 25),
('Cold Frame and Season Extension', 'learn how to grow delicious edibles all year round with season extension techniques..', 'Physical', 'Herb Haven, 456 Green Street, KL', '2024-12-22', '15:00', '17:00', 'https://youngurbanfarmers.com/gardening-services/workshops/', 30, 10),
('Lacto-Fermentation', 'Learn eco-friendly ways to manage pests in your garden.', 'Online', 'Google Meet', '2024-12-17', '11:00', '13:00', 'https://youngurbanfarmers.com/gardening-services/workshops/', 35, 15),
('Vertical Gardening Techniques', 'experience hands on how to cook and prepare a variety of lacto-fermented products s.', 'Physical', '789 Skyview Gardens, KL', '2024-12-19', '14:30', '16:30', 'https://youngurbanfarmers.com/gardening-services/workshops/', 50, 18),
('Aquaponics for Beginners', 'Introduction to aquaponics and sustainable farming.', 'Online', 'Zoom Meeting', '2024-12-21', '19:00', '21:00', 'https://youngurbanfarmers.com/gardening-services/workshops/', 45, 12),
('Winter Garden Planning', 'Prepare your garden for the winter season.', 'Online', 'Zoom Meeting', '2024-12-16', '09:00', '11:00', 'https://youngurbanfarmers.com/gardening-services/workshops/', 22, 22),
('Fruit Tree Pruning', 'Learn the techniques of pruning for healthy fruit trees.', 'Physical', 'Orchard Park, 987 Bloom Blvd, KL', '2024-12-23', '08:30', '10:30', 'https://youngurbanfarmers.com/gardening-services/workshops/', 40, 8),
('Water Conservation in Gardening', 'Tips and techniques for saving water while gardening.', 'Online', 'Google Meet', '2024-12-18', '13:00', '15:00', 'https://sdgacademy.org/goal/zero-hunger/', 25, 25),
('Garden Landscaping Basics', 'Introduction to designing beautiful garden landscapes.', 'Physical', 'Dream Gardens, 654 Design Street, KL', '2024-12-24', '16:00', '18:00', 'https://sdgacademy.org/goal/zero-hunger/', 50, 20),
('Seed Saving and Storage', 'Learn how to save and store seeds for future planting.', 'Online', 'Microsoft Teams', '2024-12-20', '17:00', '19:00', 'https://alison.com/tag/sdg-2-zero-hunger?utm_source=google&utm_medium=cpc&utm_campaign=Performance-Max_Tier-3_Workplace-Personality-Assessment&gad_source=1&gclid=Cj0KCQiApNW6BhD5ARIsACmEbkVdaCTYkrY3hOjxjDTVjEjildWdCMvSKQ2GG0XSHjBhPWi3EnsM7dMaAlkrEALw_wcB', 20, 15)";

if (mysqli_query($dbConnection, $insert_sql)) {
    echo "Sample workshop data inserted successfully.<br>";
} else {
    echo "Error inserting data: " . mysqli_error($dbConnection) . "<br>";
}

// Close the connection
mysqli_close($dbConnection);
?>


<!-- https://alison.com/tag/sdg-2-zero-hunger?utm_source=google&utm_medium=cpc&utm_campaign=Performance-Max_Tier-3_Workplace-Personality-Assessment&gad_source=1&gclid=Cj0KCQiApNW6BhD5ARIsACmEbkVdaCTYkrY3hOjxjDTVjEjildWdCMvSKQ2GG0XSHjBhPWi3EnsM7dMaAlkrEALw_wcB -->