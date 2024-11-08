<?php
session_start();

if (isset($_GET['bcid'])) {
    include("includes/connection.php");

    // Prepare the SQL statement
    $bid = (int)$_GET['bcid'];
    $stmt = mysqli_prepare($link, "SELECT * FROM book WHERE b_id = ?");
    
    // Bind the parameter
    mysqli_stmt_bind_param($stmt, "i", $bid);
    
    // Execute the statement
    mysqli_stmt_execute($stmt);
    
    // Get the result
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    // Check if the book exists
    if ($row) {
        $_SESSION['cart'][] = array(
            "nm" => $row['b_nm'],
            "img" => $row['b_img'],
            "price" => $row['b_price'],
            "qty" => 1
        );
    }

} else if (!empty($_POST)) {
    // Update quantities based on user input
    foreach ($_POST as $id => $qty) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty'] = (int)$qty; // Ensure quantity is an integer
        }
    }

} else if (isset($_GET['id'])) {
    // Remove item from cart
    $id = (int)$_GET['id'];
    unset($_SESSION['cart'][$id]);
}

// Redirect to cart page
header("Location: cart.php");
exit();
?>
