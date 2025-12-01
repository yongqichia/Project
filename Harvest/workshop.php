<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harvest - Workshops</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include('header.php'); ?>

    <main>
    <section class="overview">
            <h2>JOIN THE WORKSHOPS</h2>
            <p>Your gateway to workshops and resources. Learn new skills and connect with experts.</p>
            <p>If you're interested in connecting with other participants and workshop facilitators in additional spaces, feel free to join the workshops listed below.</p>
    </section>   
        
         <!-- Featured Workshops Section -->
    <section class="Hworkshops">
        <h2>Workshops</h2>
        <div class="Hworkshop-list">
            <?php
            $dbConnection = mysqli_connect('localhost', 'root', '', 'harvest_db');

            if (!$dbConnection) {
                die('Connection failed: ' . mysqli_connect_error());
            }

            $sql = "SELECT * FROM workshops";
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
                                <a href='{$row['registration_link']}' class='btn btn-secondary'>Apply Now</a>
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
    </main>

    <?php include('footer.php'); ?>

     <script src="/FinalAssignment/Harvest/script.js"></script>
</body>
</html>