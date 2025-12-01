<?php
// Simulate a session start if needed
session_start();

// Check if a query was submitted
if (isset($_GET['query'])) {
    $query = htmlspecialchars($_GET['query']); // Sanitize user input
    
    // Example: Search logic (modify this for your website's content)
    $results = []; // Initialize an empty array for results
    
    // Example static content array (replace with a database query if needed)
    $content = [
        "Homepage" => "Homepage.php",
        "About Us" => "aboutus.php",
        "Resource Hub" => "ResourcesHub.php",
        "Workshops" => "workshop.php",
        "Directory" => "FoodResourcesDirectory.php",
        "Donate" => "donation.php",
        "Contact Us" => "ContactUs.php"
    ];
    
    // Perform the search
    foreach ($content as $title => $link) {
        if (stripos($title, $query) !== false) {
            $results[$title] = $link;
        }
    }
    
    // Display the search results
    echo "<h1>Search Results for: " . $query . "</h1>";
    if (!empty($results)) {
        echo "<ul>";
        foreach ($results as $title => $link) {
            echo "<li><a href=\"$link\">$title</a></li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No results found.</p>";
    }
} else {
    echo "<p>No search query provided.</p>";
}
?>
