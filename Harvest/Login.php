<?php
session_start(); // Start the session

$page_title = 'Login';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('mysqli_connect.php'); // Connect to the database
    
    $errors = []; // Initialize an error array
    
    // Validate username
    if (empty($_POST['username'])) {
        $errors[] = 'You forgot to enter your username.';
    } elseif (!preg_match('/^[A-Za-z0-9]{5,10}$/', $_POST['username'])) {
        $errors[] = 'The username should only contain letters and numbers (A-Z , 0-9) and be between 5 to 10 characters long.';
    } else {
        $user = mysqli_real_escape_string($dbc, trim($_POST['username']));
    }
    
    // Validate password
    if (empty($_POST['pass1'])) {
        $errors[] = 'You forgot to enter your password.';
    } else {
        $p = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
    }
    
    // If no errors, query the database
    if (empty($errors)) {
        $q = "SELECT user_id, username FROM users WHERE username='$user' AND pass=SHA1('$p')";
        $r = @mysqli_query($dbc, $q);
        
        if (mysqli_num_rows($r) == 1) { // Match found
            $row = mysqli_fetch_assoc($r); // Fetch user details
            $_SESSION['user_id'] = $row['user_id']; // Store user ID in session
            $_SESSION['username'] = $row['username']; // Store username in session
                  
            // Redirect to homepage
            header("Location: homepage.php");
            exit();
        } else { // No match found
            $errors[] = 'Access Denied: Incorrect username or password.';
        }
    }
    
    
    mysqli_close($dbc); // Close the database connection
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="section-three">
        <h1>HARVEST Login Page</h1>
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $msg): ?>
                    <p><?php echo $msg; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="login.php" method="post">
            <p>Username: <input type="text" name="username" size="20" maxlength="40" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>" /></p>
            <p>Password: <input type="password" name="pass1" size="20" maxlength="40" /></p>
            <p><input type="submit" name="submit" value="Login" /></p>
        </form>
        <div class="nav-links">
            <a href="homepage.php">Go Back to Homepage</a> |
            <a href="Registration.php">New User? Sign Up Now</a>
        </div>
    </div>
</body>
</html>