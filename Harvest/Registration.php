<?php
// This script performs an INSERT query to add a record to the users table.

session_start();
$page_title = 'Register';

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    require ('mysqli_connect.php'); // Connect to the db.
    
    $errors = array(); // Initialize an error array.
    
    // Validate username
    if (empty($_POST['username'])) {
        $errors[] = 'You forgot to enter your username.';
    } elseif (!preg_match('/^[A-Za-z0-9]{5,10}$/', $_POST['username'])) {
        $errors[] = 'The username should only contain letters and numbers (A-Z , 0-9) and be between 5 to 10 characters long.';
    } else {
        $user = mysqli_real_escape_string($dbc, trim($_POST['username']));
    }
    
    // Check for an email address:
    
    if (empty($_POST['email'])) {
        $errors[] = 'You forgot to enter your email.';
    } else {
        // Remove extra spaces and escape special characters to prevent SQL injection
        $e = mysqli_real_escape_string($dbc, trim($_POST['email']));
        
        // Email validation pattern
        $email_pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
        
        // Check if the email matches the pattern
        if (preg_match($email_pattern, $e)) {
            echo "Valid email format.";
        } else {
            $errors[] = "Invalid email format. Please enter a valid email address. Example : Test@gmail.com ";
        }
    }
    
    // Check for a password and match against the confirmed password:
    
    if (!empty($_POST['pass1'])) {
        if ($_POST['pass1'] != $_POST['pass2']) {
            $errors[] = 'Your password did not match the confirmed password.';
        } else {
            $p = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
        }
    } else {
        $errors[] = 'you forgot to enter your password.';
    }
    
    
    if (empty($errors)) { // If everything's OK.
        
        // Register the user in the database...
        
        // Make the query: (SHA1 is to change email to symbol form in phpfile.
        $q = "INSERT INTO users (username, email, pass, registration_date) VALUES ('$user','$e', SHA1('$p'),NOW() )";
        $r = @mysqli_query ($dbc, $q); // Run the query.
        
        if ($r) {
            // Registration successful
            $_SESSION['message'] = 'Registration successful! You can now log in.';
            $_SESSION['user_registered'] = true;
            header('Location: Login.php'); // Redirect to login page
            exit();
        } else { // If it did not run OK.
            
            // Public message:
            echo '<h1>System Error</h1>
			<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
            
            // Debugging message:
            echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
            
        } // End of if ($r) IF.
        
        mysqli_close($dbc); // Close the database connection.
        
        exit();
        
        
        
    } // End of if (empty($errors)) IF.
    
    mysqli_close($dbc); // Close the database connection.
    
} // End of the main Submit conditional.
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

<div class =" section-three">
<h1> Sign up a new Harvest account</h1>
<form action="registration.php" method="post">
	<p>Username: <input type="text" name="username" size="15" maxlength="20" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>" /></p>
	<p>Email Address: <input type="text" name="email" size="20" maxlength="40" value="<?php  if (isset($_POST['email'])) echo $_POST['email'];?>"  /></p>
	<p>Password: <input type="password" name="pass1" size="10" maxlength="40" value="<?php  if (isset($_POST['pass'])) echo $_POST['pass'];?>"  /></p>
	<p>Confirm Password: <input type="password" name="pass2" size="10" maxlength="20" value="<?php  if (isset($_POST['pass'])) echo $_POST['pass'];?>"  /></p>
	<p><input type="submit" name="submit" value="Register" /></p>
</form>

		<div class="nav-links">
            <a href="homepage.php">Go Back to Homepage</a> | 
            <a href="login.php">Already Have an Account? Log In Now</a>
        </div>
</div>
<!-- Display success or error message -->
    <?php if (isset($success)) { ?>
        <div class="success"><?php echo $success; ?></div>
    <?php } ?>
    
    <?php if (!empty($errors)) { ?>
        <div class="error">
            <?php foreach ($errors as $msg) {
                echo "<p>$msg</p>";
            } ?>
        </div>
    <?php } ?>
