<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Harvest - Food Resource Directory</title>
</head>
<body>

    <?php include('header.php'); ?>

    <main>
    <section class="overview">
            <h2> Resource Directory</h2>
    		<p>These directory helps users understand where their donations are directed and provides an opportunity to apply as volunteers at these locations.</p>
            <p>By exploring the resource directory, you can see how your generous donations support various causes and contribute to making a positive impact in communities.</p>
            <p>Additionally, if you are interested in volunteering your time or skills, this directory offers you the chance to apply and get involved with these organizations that are doing amazing work.</p>
            <p>Whether you're looking to donate or volunteer, this directory serves as a guide to connect with organizations that align with your values and passions.</p>
    </section>
    
        
     <!-- Featured Workshops Section -->
    <section class="Hworkshops">
        <h2>Directory</h2>
        <div class="Hworkshop-list">
            <?php
            $dbConnection = mysqli_connect('localhost', 'root', '', 'harvest_db');

            if (!$dbConnection) {
                die('Connection failed: ' . mysqli_connect_error());
            }

            $sql = "SELECT * FROM directory";
            $result = mysqli_query($dbConnection, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='Hworkshop-card'>
                            <div class='card-content'>
                                <h3>{$row['name']}</h3>
                                <p><strong>Location:</strong> {$row['address']}</p>
                                <p><strong>Time:</strong> {$row['operation_time']}
                                <p><strong>Contact:</strong> {$row['contact_number']}</p>                             
                                <p><em>{$row['type']}</em></p>
                                <a href='{$row['details_link']}' class='btn btn-secondary'>Visit Here</a>
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
