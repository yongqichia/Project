<?php
session_start();

// Check if the user clicked the 'Sign Out' button
if (isset($_POST['signout'])) {
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: homepage.php"); // Redirect to homepage after signing out
    exit();
}

// Connect to the database
$dbConnection = mysqli_connect('localhost', 'root', '', 'harvest_db');
if (!$dbConnection) {
    // Friendly message instead of die()
    exit('Database connection failed. Please try again later.');
}

// Fetch resources from the database
$sql = "SELECT * FROM resources_hub";
$result = mysqli_query($dbConnection, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harvest</title>
    <link rel="stylesheet" href="styles.css?v=1">
</head>

<body> <!-- Ensure the <body> tag wraps the page content -->

<header>
    <div class="logo">
        <img src="/FinalAssignment/images/harvest-logo.jpg" alt="Harvest Logo">
    </div>

    <nav>
        <ul>
            <li><a href="Homepage.php">Home</a></li>
            <li><a href="aboutus.php">About Us</a></li>
            <li><a href="ResourcesHub.php">Resource Hub</a></li>
            <li><a href="workshop.php">Workshops</a></li>
            <li><a href="FoodResourcesDirectory.php">Directory</a></li>
            <li><a href="donation.php">Donate</a></li>
            <li><a href="ContactUs.php">Contact Us</a></li>
            
            <?php if (isset($_SESSION['username'])): ?>
                <!-- Dropdown for logged-in user -->
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropbtn"><?php echo htmlspecialchars($_SESSION['username']); ?></a>
                    <div class="dropdown-content">
                        <form method="POST">
                            <button type="submit" name="signout">Sign Out</button>
                        </form>
                    </div>
                </li>

                <!-- Display Admin link if user is an admin -->
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                    <li><a href="AdminViewUser.php">Admin View Users</a></li>
                <?php endif; ?>
            <?php else: ?>
                <li><a href="?showLogin=true">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="search-notifications">
        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" placeholder="Search...">
        </div>

        <!-- Notification container (moved outside of <ul>) -->
        <div class="notification-container">
            <!-- Notification Icon -->
            <img id="notification-icon" src="/FinalAssignment/images/notification-icon.png" alt="Notifications" width="30" height="30">
            
            <!-- Notification Dropdown -->
            <div id="notification-box" class="notification-box hidden">
                <div class="notifications-header">Notifications</div>
                <div class="notifications-list">
                    <div class="notification-item">Message 1</div>
                    <div class="notification-item">Message 2</div>
                    <div class="notification-item">Message 3</div>
                    <div class="notification-item">Message 4</div>
                </div>
            </div>
        </div>
    </div>
</header>

<?php
// Show login options if the "showLogin" parameter is in the URL
if (isset($_GET['showLogin']) && $_GET['showLogin'] == 'true') {
    echo '<div style="padding: 20px; background: #f4f4f4; border: 1px solid #ccc; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <h3>Select Login Type</h3>
            <form method="post">
                <button type="submit" name="loginType" value="admin">Admin Login</button>
                <button type="submit" name="loginType" value="user">User Login</button>
            </form>
          </div>';
}

// Handle login redirection
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['loginType'])) {
    $loginType = $_POST['loginType'];
    if ($loginType == 'admin') {
        header("Location: admin.php");
        exit();
    } elseif ($loginType == 'user') {
        header("Location: Login.php");
        exit();
    }
}
?>

<script src="/FinalAssignment/Harvest/script.js?v=1"></script>

</body>
</html>
