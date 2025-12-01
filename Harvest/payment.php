<?php
session_start(); // Start session to keep the donation data

$page_title = 'Donation';

require ('mysqli_connect.php'); // Connect to the database

// Initialize the success message and errors array
$success_message = '';
$donation_amount = '';
$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connect to the database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    // Validate card holder name
    if (empty($_POST['card_holder'])) {
        $errors[] = 'You forgot to enter the cardholder name.';
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
        $errors[] = 'Expiry date must be in the format MM/YYYY.';
    }
    
    // If no errors, process the donation and payment
    if (empty($errors)) {
        // Insert donation into the donations table
        $donation_amount = $_POST['donation_amount'];
        $donation_query = "INSERT INTO donation (donation_amount) VALUES (?)";
        $donation_stmt = mysqli_prepare($dbc, $donation_query);
        mysqli_stmt_bind_param($donation_stmt, 'd', $donation_amount);
        mysqli_stmt_execute($donation_stmt);
        
        // Get the last inserted donation ID
        $donation_id = mysqli_insert_id($dbc);
        
        // Insert payment into the payments table
        $card_no = $_POST['card_no'];
        $card_holder = $_POST['card_holder'];
        $cvv2 = $_POST['CVV2'];
        $expiry = $_POST['exp'];
        
        $payment_query = "INSERT INTO payment (donation_id, card_number, card_holder, CVV2, expiry_date, donation_amount)
                          VALUES (?, ?, ?, ?, ?, ?)";
        $payment_stmt = mysqli_prepare($dbc, $payment_query);
        mysqli_stmt_bind_param($payment_stmt, 'isssss', $donation_id, $card_no, $card_holder, $cvv2, $expiry, $donation_amount);
        mysqli_stmt_execute($payment_stmt);
        
        // Success message
        $success_message = '<div class="message-container_payment success">';
        $success_message .= '<h1>Payment Complete!</h1>';
        $success_message .= '<p>Your generosity helps us make a difference!</p>';
        $success_message .= '</div>';
        
        // Clear session data after payment
        unset($_SESSION['donation_amount']);
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
       <form action="payment.php" method="post">
    <input type="hidden" name="donation_amount" value="<?php echo htmlspecialchars($donation_amount); ?>" />
    <!-- Other form fields -->
    <p>Amount: <input type="text" name="donation_amount" value="<?php echo htmlspecialchars($donation_amount); ?>" /></p>

            <p>Card Number: <input type="text" name="card_no" size="20" maxlength="40" value="<?php if (isset($_POST['card_no'])) echo $_POST['card_no']; ?>" /></p>
            <p>Card Holder: <input type="text" name="card_holder" size="20" maxlength="40" value="<?php if (isset($_POST['card_holder'])) echo $_POST['card_holder']; ?>" /></p>
            <p>CVV2: <input type="text" name="CVV2" size="20" maxlength="40" value="<?php if (isset($_POST['CVV2'])) echo $_POST['CVV2']; ?>" /></p>
            <p>Expiry (mm/yyyy): <input type="text" name="exp" size="20" maxlength="40" value="<?php if (isset($_POST['exp'])) echo $_POST['exp']; ?>" /></p>
            <p><input type="submit" name="submit" value="PAY" /></p>
            
            <div class="nav-links">
                <a href="homepage.php">Go Back to Homepage</a> 
            </div>
        </form>
    </div>

    <!-- Display Success Message or Errors -->
    <?php if (!empty($success_message)): ?>
        <div class="message-container_payment">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="message-container_payment error">
            <?php foreach ($errors as $msg): ?>
                <p><?php echo $msg; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</body>
</html>
