<?php
// Page title
$page_title = 'Edit User';
echo '<h1>Edit User</h1>';

// Check if a valid user ID is passed via GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];  // Get the user_id from the URL
    
    // Debugging: Check if user_id is being passed correctly
    echo "User ID: " . $id . "<br>";
    
    // Connect to the database
    require('mysqli_connect.php');
    
    // Query to fetch the user info
    $query = "SELECT user_id, username, email FROM users WHERE user_id = $id";
    $result = mysqli_query($dbc, $query);
    
    // Debugging: Check if query returned results
    if (mysqli_num_rows($result) == 1) {
        // Get the user's data
        $row = mysqli_fetch_assoc($result);
        
        // Check if form was submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get the form data
            $username = $_POST['username'];
            $email = $_POST['email'];
            
            // Validate the data (optional, for security)
            if (!empty($username) && !empty($email)) {
                // Update the user data
                $update_query = "UPDATE users SET username = '$username', email = '$email' WHERE user_id = $id"; // Use $id instead of $user_id
                $update_result = mysqli_query($dbc, $update_query);
                
                if ($update_result) {
                    echo 'User information updated successfully.' . "<br>";
                    echo 'Updated Username:' . $username . "<br>" ;
                    echo 'Updated Email:' . $email . "<br>" ;
                } else {
                    echo 'Error updating user.';
                }
            } else {
                echo 'All fields are required.';
            }
        }
        
        // Display the form to edit user info
        echo '<form action="edit_user.php?id=' . $id . '" method="post">'; // Use the correct URL parameter (id)
        echo '<p>Username: <input type="text" name="username" value="' . $row['username'] . '" required /></p>';
        echo '<p>Email: <input type="email" name="email" value="' . $row['email'] . '" required /></p>';
        echo '<p><input type="submit" value="Update User" /></p>';
        echo '<input type="hidden" name="user_id" value="' . $row['user_id'] . '" />';
        echo '</form>';
    } else {
        echo 'No user found with that ID.';
    }
    
    // Close the database connection
    mysqli_free_result($result);
    mysqli_close($dbc);
} else {
    echo 'Invalid user ID!';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="adminstyles.css?v=1">
    
</head>
<body>
	
      	<div class="nav-links">
            <a href="AdminViewUser.php">Go Back to View Users</a> 
        </div>
          
        
        </body>
        </html>

