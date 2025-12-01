<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harvest - Resource Hub</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <?php include('header.php'); ?>

   <main>
    <section class="overview">
    <h2>Resource Hub</h2>
    <p>Our Resource Hub Webpage is designed to help users identify the physical locations that provide these services. We understand that many people may not be familiar with where these resources are located, which is why we aim to make this information more accessible.</p>
    
</section>
        
        <!-- Featured Workshops Section -->
    <section class="Hworkshops">
        <h2>Hubs</h2>
        <div class="Hworkshop-list">
            <?php
            $dbConnection = mysqli_connect('localhost', 'root', '', 'harvest_db');

            if (!$dbConnection) {
                die('Connection failed: ' . mysqli_connect_error());
            }

            $sql = "SELECT * FROM resources_hub";
            $result = mysqli_query($dbConnection, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='Hworkshop-card'>
                            <div class='card-content'>
                                <h3>{$row['title']}</h3>
                                <p><strong>{$row['description']}</strong></p>
                                <p><em>{$row['category']}</em></p>
                                <p><strong>Contact:</strong> {$row['contact_info']}</p>
                                <a href='{$row['link']}' class='btn btn-secondary'>Visit Here</a>
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
