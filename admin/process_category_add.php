<?php
session_start();

if (!empty($_POST)) {
    $_SESSION['error'] = array();
    extract($_POST);

    if (empty($cat)) {
        $_SESSION['error']['cat'] = "Please Enter Category Name";
    }

    if (!empty($_SESSION['error']['cat'])) {
        header("location:category_add.php");
        exit(); // It's a good practice to exit after a header redirect
    } else {
        include("../includes/connection.php");

        // Use prepared statements to prevent SQL injection
        $stmt = $link->prepare("INSERT INTO category (cat_nm) VALUES (?)");
        $stmt->bind_param("s", $cat); // 's' specifies the variable type => 'string'

        if ($stmt->execute()) {
            // Successfully inserted
            header("location:category_add.php");
        } else {
            // Handle error here, e.g. set session error message
            $_SESSION['error']['db'] = "Error adding category: " . $stmt->error;
            header("location:category_add.php");
        }

        $stmt->close(); // Close the statement
    }
} else {
    header("location:category.php");
    exit(); // Exit to prevent further execution
}
?>
