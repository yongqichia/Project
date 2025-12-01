<?php
session_start();  // Start the session

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page with a message
    $_SESSION['message'] = 'You must be logged in to make a donation.';
    header("Location: login.php");
    exit();
}

$page_title = 'Donation & Payment';
require('mysqli_connect.php'); // Connect to the database

// Initialize the success message and errors array
$success_message = '';
$errors = array();
$donation_amount = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the user_id from the session
    $user_id = $_SESSION['user_id']; // This should work if session is correctly set during login
    
    // Validate donation amount
    if (empty($_POST['donation_amount'])) {
        $errors[] = 'You forgot to enter the donation amount.';
    } elseif (!is_numeric($_POST['donation_amount']) || $_POST['donation_amount'] <= 0) {
        $errors[] = 'The donation amount must be a positive number.';
    } else {
        $donation_amount = $_POST['donation_amount'];
    }
    
    // Validate card number
    if (empty($_POST['card_no'])) {
        $errors[] = 'You forgot to enter the card number.';
    } elseif (!preg_match('/^\d+$/', $_POST['card_no'])) {
        $errors[] = 'The card number should contain only digits (0-9).';
    }
    
    // Validate card holder name
    if (empty($_POST['card_holder'])) {
        $errors[] = 'You forgot to enter the cardholder name.';
    } elseif (!preg_match('/^[A-Za-z\s]+$/', $_POST['card_holder'])) {
        $errors[] = 'The cardholder name should contain only letters (A-Z) and spaces.';
    }
    
    // Validate CVV2
    if (empty($_POST['CVV2'])) {
        $errors[] = 'You forgot to enter the CVV2.';
    } elseif (!is_numeric($_POST['CVV2']) || strlen($_POST['CVV2']) != 3) {
        $errors[] = 'CVV2 must be a 3-digit number.';
    }
    
    // Validate expiry date
    if (empty($_POST['exp'])) {
        $errors[] = 'You forgot to enter the expiry date.';
    } elseif (!preg_match('/^(0[1-9]|1[0-2])\/\d{4}$/', $_POST['exp'])) {
        $errors[] = 'Expiry date must be in the format MM/YYYY. Example (12/2030)';
    }
    
    // If no errors, process the donation
    if (empty($errors)) {
        // Connect to the database
        $dbc = mysqli_connect("localhost", "root", "", "harvest_db");  // Connect to the database
        
        // Insert the donation into the database
        $donation_query = "INSERT INTO donation (user_id, donation_amount, card_no, card_holder, CVV2, exp)
                           VALUES (?, ?, ?, ?, ?, ?)";
        $donation_stmt = mysqli_prepare($dbc, $donation_query);
        mysqli_stmt_bind_param($donation_stmt, 'idssss', $user_id, $donation_amount, $_POST['card_no'], $_POST['card_holder'], $_POST['CVV2'], $_POST['exp']);
        mysqli_stmt_execute($donation_stmt);
        
        // Calculate points (10 points for every RM100 donated)
        $donation_points = floor($donation_amount / 100) * 10;  // Calculate points
        
        // Check if the user already has points in the user_point table
        $check_points_query = "SELECT points FROM user_point WHERE user_id = ?";
        $check_points_stmt = mysqli_prepare($dbc, $check_points_query);
        mysqli_stmt_bind_param($check_points_stmt, 'i', $user_id);
        mysqli_stmt_execute($check_points_stmt);
        mysqli_stmt_store_result($check_points_stmt);
        
        if (mysqli_stmt_num_rows($check_points_stmt) > 0) {
            // If user already has points, update them
            $update_points_query = "UPDATE user_point SET points = points + ? WHERE user_id = ?";
            $update_points_stmt = mysqli_prepare($dbc, $update_points_query);
            mysqli_stmt_bind_param($update_points_stmt, 'ii', $donation_points, $user_id);
        } else {
            // If no points exist, insert new record
            $update_points_query = "INSERT INTO user_point (user_id, points) VALUES (?, ?)";
            $update_points_stmt = mysqli_prepare($dbc, $update_points_query);
            mysqli_stmt_bind_param($update_points_stmt, 'ii', $user_id, $donation_points);
        }
        
        // Execute points update query
        if (mysqli_stmt_execute($update_points_stmt)) {
            $success_message = 'Donation successful, and your points have been updated!';
            $_SESSION['donation_success'] = true;
            $_SESSION['points_awarded'] = true;
        } else {
            $errors[] = 'Failed to update points, please try again.';
        }
        
        // Close the statements and database connection
        mysqli_stmt_close($donation_stmt);
        mysqli_stmt_close($update_points_stmt);
        mysqli_stmt_close($check_points_stmt);
        mysqli_close($dbc);
        
        // Clear form values
        $_POST = array();
    } else {
        $errors[] = 'An error occurred while processing your donation. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="donation.css">
</head>
<body>
    <div class="donation">
        <h1>Make a Donation</h1>
        <?php if (!empty($success_message)): ?>
            <div class="message-container_payment">
                <?php echo $success_message; ?>
            </div>
        <?php else: ?>
            <form action="" method="post">
                <p>Donation Amount: <input type="text" name="donation_amount" size="20" maxlength="40" value="<?php if (isset($_POST['donation_amount'])) echo $_POST['donation_amount']; ?>" /></p>
                <p>Card Number: <input type="text" name="card_no" size="20" maxlength="40" value="<?php if (isset($_POST['card_no'])) echo $_POST['card_no']; ?>" /></p>
                <p>Card Holder: <input type="text" name="card_holder" size="20" maxlength="40" value="<?php if (isset($_POST['card_holder'])) echo $_POST['card_holder']; ?>" /></p>
                <p>CVV2: <input type="text" name="CVV2" size="20" maxlength="40" value="<?php if (isset($_POST['CVV2'])) echo $_POST['CVV2']; ?>" /></p>
                <p>Expiry (MM/YYYY): <input type="text" name="exp" size="20" maxlength="40" value="<?php if (isset($_POST['exp'])) echo $_POST['exp']; ?>" /></p>
                <p><input type="submit" name="submit" value="PAY" /></p>
            </form>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="message-container_payment error">
                <?php foreach ($errors as $msg): ?>
                    <p><?php echo $msg; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="nav-links">
            <a href="homepage.php">Go Back to Homepage</a>
        </div>
    </div>
</body>
</html>
