<?php
// This script retrieves all the records from the users table.

$page_title = 'View the Current Users';

require ('mysqli_connect.php'); // Connect to the db.
//

// Number of records to show per page:
$display = 10;

// Determine how many pages there are...
if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
    $pages = $_GET['p'];
} else { // Need to determine.
    // Count the number of records:
    $q = "SELECT COUNT(user_id) FROM users";
    $r = @mysqli_query ($dbc, $q);
    $row = @mysqli_fetch_array ($r, MYSQLI_NUM);
    $records = $row[0];
    // Calculate the number of pages...
    if ($records > $display) { // More than 1 page.
        $pages = ceil ($records/$display);
    } else {
        $pages = 1;
    }
} // End of p IF.

// Determine where in the database to start returning results...
if (isset($_GET['s']) && is_numeric($_GET['s'])) {
    $start = $_GET['s'];
} else {
    $start = 0;
}

// Determine the sort...
// Default is by registration date.
$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'rd';

// Determine the sorting order:
switch ($sort) {
    case 'ln':
        $order_by = 'username ASC';
        break;
    case 'fn':
        $order_by = 'email ASC';
        break;
    case 'rd':
        $order_by = 'registration_date ASC';
        break;
    default:
        $order_by = 'registration_date ASC';
        $sort = 'rd';
        break;
}

// Define the query:
$q = "SELECT username, email, DATE_FORMAT(registration_date, '%M %d, %Y') AS dr, user_id FROM users ORDER BY $order_by LIMIT $start, $display";
$r = @mysqli_query ($dbc, $q); // Run the query.

// Table header:
echo '<table align="center" cellspacing="0" cellpadding="5" width="75%">
<tr>
	<td align="left"><b>Edit</b></td>
	<td align="left"><b>Delete</b></td>
	<td align="left"><b><a href="AdminViewUser.php?sort=ln">Username</a></b></td>
	<td align="left"><b><a href="AdminViewUser.php?sort=fn">Email</a></b></td>
	<td align="left"><b><a href="AdminViewUser.php?sort=rd">Date Registered</a></b></td>
</tr>
';

// Fetch and print all the records....
$bg = '#eeeeee';
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
    $bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
    echo '<tr bgcolor="' . $bg . '">
		<td align="left"><a href="edit_user.php?id=' . $row['user_id'] . '">Edit</a></td>
		<td align="left"><a href="delete_user.php?id=' . $row['user_id'] . '">Delete</a></td>
		<td align="left">' . $row['username'] . '</td>
		<td align="left">' . $row['email'] . '</td>
		<td align="left">' . $row['dr'] . '</td>
	</tr>
	';
} // End of WHILE loop.

echo '</table>';
mysqli_free_result ($r);
mysqli_close($dbc);

// Make the links to other pages, if necessary.
if ($pages > 1) {
    
    echo '<br /><p>';
    $current_page = ($start/$display) + 1;
    
    // If it's not the first page, make a Previous button:
    if ($current_page != 1) {
        echo '<a href="AdminViewUser.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
    }
    
    // Make all the numbered pages:
    for ($i = 1; $i <= $pages; $i++) {
        if ($i != $current_page) {
            echo '<a href="AdminViewUser.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
        } else {
            echo $i . ' ';
        }
    } // End of FOR loop.
    
    // If it's not the last page, make a Next button:
    if ($current_page != $pages) {
        echo '<a href="AdminViewUser.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Next</a>';
    }
    
    echo '</p>'; // Close the paragraph.
    
} // End of links section.

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
            <a href="homepage.php">Go Back to Homepage</a> 
        </div>
          
</body>
</html>