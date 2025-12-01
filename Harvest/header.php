<?php
session_start();

// Set the session timeout duration (in seconds) — Here, 15 minutes
$session_timeout_duration = 90 * 60 ; // 90 minutes in seconds

// Check if the last activity timestamp is set
if (isset($_SESSION['last_activity'])) {
    // Check if the current time - last activity time is greater than the timeout duration
    if (time() - $_SESSION['last_activity'] > $session_timeout_duration) {
        // Session has expired, so destroy it and redirect to the login page
        session_unset();
        session_destroy();
        header("Location: homepage.php?session_expired=true");
        exit();
    }
}

// Update the last activity timestamp to the current time
$_SESSION['last_activity'] = time();

// Check if the user clicked the 'Sign Out' button
if (isset($_POST['signout'])) {
    session_unset();
    session_destroy();
    header("Location: homepage.php");
    exit();
}


$pdo = new PDO('mysql:host=localhost;dbname=harvest_db', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Assume $user_id is the currently logged-in user's ID
$user_id = $_SESSION['user_id'] ?? null;

$notifications = [];

// Function to save a notification to the database
function saveNotification($pdo, $user_id, $message) {
    $stmt = $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (:user_id, :message)");
    $stmt->execute([
        ':user_id' => $user_id,
        ':message' => $message
    ]);
}

// Check if user registration was successful
if (isset($_SESSION['user_registered']) && $_SESSION['user_registered'] === true) {
    $message = "Registration completed successfully!";
    $notifications[] = $message;
    if ($user_id) {
        saveNotification($pdo, $user_id, $message);
    }
    unset($_SESSION['user_registered']);  // Remove session flag
}

// Check if a donation was successful
if (isset($_SESSION['donation_success']) && $_SESSION['donation_success'] === true) {
    $message = "Your donation was successfully completed!";
    $notifications[] = $message;
    if ($user_id) {
        saveNotification($pdo, $user_id, $message);
    }
    unset($_SESSION['donation_success']);  // Remove session flag
}

// Check if points were awarded
if (isset($_SESSION['points_awarded']) && $_SESSION['points_awarded'] === true) {
    $message = "You have received new points!";
    $notifications[] = $message;
    if ($user_id) {
        saveNotification($pdo, $user_id, $message);
    }
    unset($_SESSION['points_awarded']);  // Remove session flag
}

// Check if an item was redeemed
if (isset($_SESSION['item_redeemed']) && $_SESSION['item_redeemed'] === true) {
    $message = "You have redeemed an item!";
    $notifications[] = $message;
    if ($user_id) {
        saveNotification($pdo, $user_id, $message);
    }
    unset($_SESSION['item_redeemed']);  // Remove session flag
}

// Retrieve all past notifications for the user from the database
if ($user_id) {
    $stmt = $pdo->prepare("SELECT message, created_at FROM notifications WHERE user_id = :user_id ORDER BY created_at DESC");
    $stmt->execute([':user_id' => $user_id]);
    $past_notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Merge the past notifications with the current session notifications
    foreach ($past_notifications as $notification) {
        $notifications[] = $notification['message'] . ' (' . $notification['created_at'] . ')';
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="header.css?v=1">
    <script src="/FinalAssignment/Harvest/script.js?v=2"></script>
</head>

<body>

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
            <li><a href="Reward.php">Reward</a></li>
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
                
                <!-- Notification Icon beside login -->
                <li class="notification-container">
                    <div class="notification-icon" id="notification-icon">
                        <img src="/FinalAssignment/images/notification-icon.png" alt="Notifications">
                        <span class="notification-count" id="notification-count"><?php echo count($notifications); ?></span>
                    </div>
                </li>
            <?php else: ?>
                <li><a href="?showLogin=true">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Notification Popup -->
    <?php if (isset($_SESSION['username'])): ?>
        <div id="notification-popup" class="notification-popup">
            <div class="popup-header">
                <span>Notifications</span>
                <button id="close-popup">X</button>
            </div>
            <div class="popup-body">
                <?php foreach ($notifications as $notification): ?>
                    <div class="notification-item">
                        <?php echo $notification; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>



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



</body>
</html>
