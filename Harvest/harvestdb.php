<html>
<head>
    <title>Create Harvest Database</title>
</head>
<body>
    <?php
    // Database connection details
    $dbhost = 'localhost'; 
    $dbuser = 'root'; 
    $dbpass = ''; 
    
    // Establish connection to the database server
    $dbConnection = mysqli_connect($dbhost, $dbuser, $dbpass);

    if (!$dbConnection) {
        die('Connection failed: ' . mysqli_connect_error());
    }
    echo "Connected to the server successfully<br>";

    // Check if the database already exists or create it
    $sql = "CREATE DATABASE IF NOT EXISTS harvest_db";
    if (mysqli_query($dbConnection, $sql)) {
        echo "Database 'harvest_db' created successfully<br>";
    } else {
        echo "Error creating database: " . mysqli_error($dbConnection) . "<br>";
    }

    // Close the connection
    mysqli_close($dbConnection);
    ?>
</body>
</html>
