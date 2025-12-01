<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harvest - Contact Us</title>
    <!-- Link to external CSS -->
    <link rel="stylesheet" href="contactus.css?v=1">
    <link rel="stylesheet" href="styles.css?v=1">
</head>
<body>
    <?php include('header.php'); ?>
    
    <!-- FAQ Section -->
    <section class="overview">
    <h2>Frequently Asked Questions</h2>
    </section>
    
    <section class="overview">
        <h2>What is Harvest?</h2>
        <p>Harvest is a platform to connect people with local sustainable goods and services.</p>
    </section>
    
    <section class="overview">
        <h2>How can I contact customer support?</h2>
        <p>You can reach us via the email or call us directly at the number provided below.</p>
    </section>
      
    <section class="overview">
        <h2>What are your operating hours?</h2>
        <p>Our operating hours are Monday to Friday, 9 AM to 6 PM.</p>
  	</section>
  
  <section class="overview">
    <!-- Company Details Section -->
        <h2>Contact Information</h2>
        <p><strong>We are:</strong> Harvest </p>
        <p><strong>Address:</strong> 26, Jalan Universiti, Bandar Sunway, 47500 Petaling Jaya, Selangor</p>
        <p><strong>Contact Number:</strong> +018-4567890</p>
        <p><strong>Email:</strong> contact@harvest.com</p>
        <p>Operating Hours: Monday to Friday, 9 AM to 6 PM</p>
</section>
    
  

    <?php
// Initialize the message variable
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if comment and rating are set and not empty
    if (isset($_POST['comment']) && !empty(trim($_POST['comment'])) && isset($_POST['rating']) && !empty(trim($_POST['rating']))) {
        $comment = htmlspecialchars(trim($_POST['comment']));
        $rating = htmlspecialchars(trim($_POST['rating']));
        
        // Include your database connection
        require('mysqli_connect.php'); 
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // Prepare the insert query
        $q = "INSERT INTO reviews (comment, rating) VALUES ('$comment', '$rating')";
        $r = mysqli_query($dbc, $q);

        if ($r) {
            $message = 'Thank you for your review!';
        } else {
            $message = 'An error occurred while saving your review. Please try again later: ' . mysqli_error($dbc);
        }
        
        // Close the database connection
        mysqli_close($dbc);
    } else {
        // If fields are empty, set an error message
        $message = 'Please fill in both the comment and the rating.';
    }
    
    
}
?>
	<section class="overview">
	<h2>Leave a Review</h2>
<form action="ContactUs.php" method="POST" class="review-form">
    <label for="comment">Comment:</label>
    <textarea id="comment" name="comment" rows="5" required></textarea>
    
    <label for="rating">Rating:</label>
    <div class="rating-stars">
        <input type="radio" id="star5" name="rating" value="5">
        <label for="star5" title="5 stars">5</label>
        
        <input type="radio" id="star4" name="rating" value="4">
        <label for="star4" title="4 stars">4</label>
        
        <input type="radio" id="star3" name="rating" value="3">
        <label for="star3" title="3 stars">3</label>
        
        <input type="radio" id="star2" name="rating" value="2">
        <label for="star2" title="2 stars">2</label>
        
        <input type="radio" id="star1" name="rating" value="1">
        <label for="star1" title="1 star">1</label>
    </div>
    
    <button class="submit-btn" type="submit">Submit Review</button>
</form>
</section>
	
	<!-- Map Section -->
    <section class="overview">
        <h2>Our Location</h2>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.1071990473392!2d101.60186547472992!3d3.0660100969097193!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc4c857d6607d1%3A0x85c991d218bf7707!2s26%2C%20Jalan%20Universiti%2C%20Bandar%20Sunway%2C%2047500%20Petaling%20Jaya%2C%20Selangor!5e0!3m2!1sen!2smy!4v1733770781859!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>
	
	
    <?php include('footer.php'); ?>
    <script src="/FinalAssignment/Harvest/script.js?v=1"></script>
</body>
</html>
