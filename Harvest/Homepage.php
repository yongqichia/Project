<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Harvest</title>
<link rel="stylesheet" href="styles.css?v=1">
</head>
<body>
<?php include('header.php'); ?>

<main>
    <section class="harvest-banner">
        <div class="harvest-content">
            <h1>Welcome to Harvest</h1>
            <p>Together, we can create a world where no one goes hungry.</p>
        </div>
    </section>
    
    <!-- Overview Section -->
    <section class="overview">
        <h2>About Harvest</h2>
        <p>Harvest is a platform that connects communities with local resources to promote sustainability, reduce food waste, and foster a better future for everyone. Through workshops, events, and partnerships, we aim to make a lasting impact in the fight against hunger and food insecurity.</p>
    </section>
    
     <!-- Overview Section -->
    <section class="overview">
        <h2>Our Mission</h2>
        <p>Our mission is to eliminate hunger and food insecurity by creating a world where nutritious and sustainable food is accessible to all. We strive to achieve this by connecting local farmers with communities, ensuring that fresh, healthy produce reaches those who need it most. Through educational programs, we empower individuals and families to adopt sustainable practices that not only benefit their health but also nurture the environment.</p>
    </section>
    
    <!-- Featured Workshops Section -->
    <section class="Hworkshops">
        <h2>Featured Workshops</h2>
        <div class="Hworkshop-list">
            <?php
            $dbConnection = mysqli_connect('localhost', 'root', '', 'harvest_db');

            if (!$dbConnection) {
                die('Connection failed: ' . mysqli_connect_error());
            }

            $sql = "SELECT * FROM workshops LIMIT 4";
            $result = mysqli_query($dbConnection, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='Hworkshop-card'>
                            <div class='card-content'>
                                <h3>{$row['title']}</h3>
                                <p><strong>{$row['description']}</strong></p>
                                <p><em>{$row['type']}</em></p>
                                <p><strong>Location:</strong> {$row['location']}</p>
                                <p><strong>Date:</strong> {$row['date']} </p>
                                <p><strong>Time:</strong> {$row['start_time']} - {$row['end_time']}</p>
                                <p><strong>Attendees:</strong> {$row['current_attendees']}/{$row['capacity']}</p>
                                <a href='workshop.php' class='btn btn-secondary'>Apply Now</a>
                            </div>
                        </div>";
                }
            } else {
                echo "<p>No workshops available at the moment.</p>";
            }
            mysqli_close($dbConnection);
            ?>
        </div>
    </section>
    
    <!-- SDG Images Section -->
    <section class="sdg-images">
        <h2>Sustainable Development Goals</h2>
        <div class="sdg-gallery">
            <div class="sdg-item">
                <img src="/FinalAssignment/images/nopoverty.png" alt="SDG 1">
                <p>No Poverty</p>
            </div>
            <div class="sdg-item">
                <img src="/FinalAssignment/images/zerohunger.png" alt="SDG 2">
                <p>Zero Hunger</p>
            </div>
            <div class="sdg-item">
                <img src="/FinalAssignment/images/goodhealth.png" alt="SDG 3">
                <p>Good Health and Well-being</p>
            </div>
            <div class="sdg-item">
                <img src="/FinalAssignment/images/qualityeducation.png" alt="SDG 4">
                <p>Quality Education</p>
            </div>
        </div>
    </section>
</main>

<?php include('footer.php'); ?>

<script src="/FinalAssignment/Harvest/script.js?v=1"></script>
</body>
</html>
