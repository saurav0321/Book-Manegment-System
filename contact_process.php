<?php
session_start();

if (!empty($_POST)) {
    extract($_POST);
    $_SESSION['error'] = array();

    // Validate Full Name
    if (empty($fnm)) {
        $_SESSION['error']['fnm'] = "Please enter Full Name";
    }

    // Validate Mobile Number
    if (empty($mno)) {
        $_SESSION['error']['mno'] = "Please enter Mobile Number";
    } else if (!is_numeric($mno)) {
        $_SESSION['error']['mno'] = "Please Enter Numeric Mobile Number";
    }

    // Validate Message
    if (empty($msg)) {
        $_SESSION['error']['msg'] = "Please enter Message";
    }

    // Validate Email
    if (empty($email)) {
        $_SESSION['error']['email'] = "Please enter E-Mail ID";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error']['email'] = "Please enter a valid E-Mail ID";
    }

    // If there are errors, redirect back to the form
    if (!empty($_SESSION['error'])) {
        header("location:contact.php");
        exit(); // Ensure no further processing occurs
    } else {
        include("includes/connection.php");

        // Prepare the statement to avoid SQL Injection
        $stmt = mysqli_prepare($link, "INSERT INTO contact (c_fnm, c_mno, c_email, c_msg, c_time) VALUES (?, ?, ?, ?, ?)");
        $t = time();

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ssssi", $fnm, $mno, $email, $msg, $t);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            header("location:contact.php");
        } else {
            $_SESSION['error']['db'] = "Database error: " . mysqli_error($link);
            header("location:contact.php");
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    }
} else {
    header("location:contact.php");
}
?>
