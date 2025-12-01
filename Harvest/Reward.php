<?php
session_start();  // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");  // Redirect to login page if user is not logged in
    exit();
}

// Database connection
$dbc = mysqli_connect("localhost", "root", "", "harvest_db");  // Adjust your database credentials here
$user_points = 0;
$item_total = 0;
// Fetch user points from the database
$user_points_query = "SELECT points FROM user_point WHERE user_id = ?";
$user_points_stmt = mysqli_prepare($dbc, $user_points_query);
mysqli_stmt_bind_param($user_points_stmt, 'i', $_SESSION['user_id']);
mysqli_stmt_execute($user_points_stmt);
mysqli_stmt_bind_result($user_points_stmt, $user_points);
mysqli_stmt_fetch($user_points_stmt);
mysqli_stmt_close($user_points_stmt);


// Initialize the cart if not set
if (!isset($_SESSION['cart_item'])) {
    $_SESSION['cart_item'] = array();
}

// Add to cart functionality
if (isset($_GET['action']) && $_GET['action'] == "add") {
    $item_code = $_GET['code'];
    $item_quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;
    
    // Fetch product details from database (example query, adjust to your needs)
    $dbc = mysqli_connect("localhost", "root", "", "harvest_db");
    $query = "SELECT * FROM reward WHERE code = ?";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, 's', $item_code);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    mysqli_close($dbc);
    
    // Check if item already exists in the cart
    $found = false;
    foreach ($_SESSION['cart_item'] as $key => $value) {
        if ($value['code'] == $item_code) {
            $_SESSION['cart_item'][$key]['quantity'] += $item_quantity;
            $found = true;
            break;
        }
    }
    
    // If item not found, add it
    if (!$found) {
        $item = array(
            'code' => $product['code'],
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $item_quantity
        );
        $_SESSION['cart_item'][] = $item;
    }
    
    // Redirect to refresh cart
    header("Location: Reward.php");
    exit();
}

// Remove item from cart
if (isset($_GET['action']) && $_GET['action'] == "remove") {
    $item_code = $_GET['code'];
    foreach ($_SESSION['cart_item'] as $key => $value) {
        if ($value['code'] == $item_code) {
            unset($_SESSION['cart_item'][$key]);
            break;
        }
    }
    $_SESSION['cart_item'] = array_values($_SESSION['cart_item']);
    header("Location: Reward.php");
    exit();
}

// Empty cart
if (isset($_GET['action']) && $_GET['action'] == "empty") {
    unset($_SESSION['cart_item']);
    header("Location: Reward.php");
    exit();
}

// Handle payment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pay_points'])) {
    $total_points = $_POST['total_points'];
    
    // Fetch current points
    $dbc = mysqli_connect("localhost", "root", "", "harvest_db");
    $query = "SELECT points FROM user_point WHERE user_id = ?";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, 'i', $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $user_points);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    
    // Check if user has enough points
    if ($user_points >= $total_points) {
        // Deduct points from user
        $new_points = $user_points - $total_points;
        $update_query = "UPDATE user_point SET points = ? WHERE user_id = ?";
        $stmt = mysqli_prepare($dbc, $update_query);
        mysqli_stmt_bind_param($stmt, 'ii', $new_points, $_SESSION['user_id']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        // Clear the cart after payment
        unset($_SESSION['cart_item']);
        
        echo "<div class='success-message'>Payment successful! You have used $total_points points.</div>";
        $_SESSION['item_redeemed'] = true;
    } else {
        echo "<div class='error-message'>You do not have enough points for this transaction.</div>";
    }
    
    mysqli_close($dbc);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reward Page</title>
    <link rel="stylesheet" href="rewards.css?v=1">
</head>
<body>
    <div class="reward">
        <h1>Your Reward Points</h1>
        <p>Once redeemed, all items will be donated to those in need.</p>
        <p>You currently have <strong><?php echo $user_points; ?></strong> points.</p>

        <!-- Shopping Cart -->
        <div id="shopping-cart">
            <div class="txt-heading">Shopping Cart <a id="btnEmpty" href="Reward.php?action=empty">Empty Cart</a></div>
            <?php
            if (isset($_SESSION["cart_item"])) {
                $item_total = 0;
            ?>
            <table>
                <tbody>
                    <tr>
                        <th><strong>NAME</strong></th>
                        <th><strong>Code</strong></th>
                        <th><strong>Quantity</strong></th>
                        <th><strong>Unit Price <br>(Points)</strong></th>
                        <th><strong>Action</strong></th>
                    </tr>
                    <?php 
                    foreach ($_SESSION["cart_item"] as $item) {
                    ?>
                    <tr>
                        <td><strong><?php echo $item["name"]; ?></strong></td>
                        <td><?php echo $item["code"];?></td>
                        <td align="right"><?php echo $item["quantity"];?></td>
                        <td><?php echo $item["price"];?></td>
                        <td><a href="Reward.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction">Remove Item</a></td>
                    </tr>
                    <?php 
                    $item_total += ($item["price"] * $item["quantity"]);
                    }
                    ?>
                    <tr>
                        <td colspan="5" align="right"><strong>Total:</strong> <?php echo $item_total . " points"; ?></td>
                    </tr>
                </tbody>
            </table>
            <?php
            }
            ?>
        </div>

        <!-- Pay Button -->
        <div class="pay-section">
            <?php if ($item_total <= $user_points): ?>
                <form action="Reward.php" method="post">
                    <input type="hidden" name="total_points" value="<?php echo $item_total; ?>">
                    <input type="submit" name="pay_points" value="Pay with Points" class="pay-button">
                </form>
            <?php else: ?>
                <p>You do not have enough points to complete this transaction.</p>
            <?php endif; ?>
        </div>

        <!-- Product Listings -->
        <div id="product-grid">
            <div class="txt-heading">Products</div>
            <?php
            $dbc = mysqli_connect("localhost", "root", "", "harvest_db");
            $product_array = $dbc->query("SELECT * FROM reward ORDER BY id ASC");
            if ($product_array->num_rows > 0) {
                while ($row = $product_array->fetch_assoc()) {
            ?>
            <div class="product-item">
                <form method="post" action="Reward.php?action=add&code=<?php echo $row["code"]; ?>">
                    <div class="product-image"><img class="product-image-size" src="<?php echo $row["image"]; ?>"></div>
                    <div><strong><?php echo $row["name"]; ?></strong></div>
                    <div class="product-price"><?php echo "Points: " . $row["price"]; ?></div>
                    <div><input type="text" name="quantity" value="1" size="2" /><input type="submit" value="Add to cart" class="btnAddAction" /></div>
                </form>
            </div>
            <?php
                }
            }
            ?>     
        </div>
    </div>
    
     <div>
            <a href="homepage.php">Homepage</a> 
     </div>
</body>
</html>
