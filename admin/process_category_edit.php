<?php
    session_start();

    if (!empty($_POST)) {
        // Extract the form data
        extract($_POST);
        $_SESSION['error'] = array();

        // Check if the category name is empty
        if (empty($cat)) {
            $_SESSION['error'][] = "Please enter Category Name";
            header("location: category_edit.php?id=$id");
            exit();
        } else {
            // Include the database connection
            include("../includes/connection.php");

            // Sanitize the category name to prevent SQL injection
            $cat = mysqli_real_escape_string($link, $cat);

            // Prepare the SQL query to update the category
            $q = "UPDATE category SET cat_nm='$cat' WHERE cat_id=$id";

            // Execute the query using MySQLi
            if (mysqli_query($link, $q)) {
                // Redirect to the category view page if the update is successful
                header("location: category_view.php");
                exit();
            } else {
                // If the query fails, store an error message
                $_SESSION['error'][] = "Failed to update the category. Please try again.";
                header("location: category_edit.php?id=$id");
                exit();
            }
        }
    } else {
        // If the form is not submitted, redirect to the category view page
        header("location: category_view.php");
        exit();
    }
?>
