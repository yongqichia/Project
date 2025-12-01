<?php
session_start();

$page_title = 'Admin Login';

// Hardcoded admin credentials
$admin_username = 'admin';
$admin_password = 'admin123';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture the entered username and password
    $username = trim($_POST['username']);
    $password = trim($_POST['pass1']);
    
    // Check if the entered credentials match the hardcoded admin account
    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['username'] = $admin_username;
        $_SESSION['role'] = 'admin'; // Set role to admin
        header('Location: Homepage.php'); // Redirect to the admin homepage
        exit();
    } else {
        // If the login fails, display an access denied message
        $error_message = 'Access Denied: Incorrect username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <!-- Link to external CSS -->
    <link rel="stylesheet" href="register.css">
</head>
<body>

<div class="section-three">
    <h1>Log in as Admin</h1>
    <form action="" method="post">
        <p>Username: <input type="text" name="username" size="20" maxlength="40" value="<?php if (isset($_POST['username'])) echo htmlspecialchars($_POST['username']); ?>" /></p>
        <p>Password: <input type="password" name="pass1" size="20" maxlength="40" value="<?php if (isset($_POST['pass1'])) echo htmlspecialchars($_POST['pass1']); ?>" /></p>
        <p><input type="submit" name="submit" value="Login" /></p>
    </form>
    <div class="nav-links">
        <a href="homepage.php">Go Back to Homepage</a>
    </div>
</div>

<div class="message-container">
    <?php if (!empty($error_message)): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>
</div>

</body>
</html>
