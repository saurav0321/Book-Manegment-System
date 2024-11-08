<?php
session_start();
include("includes/connection.php");

if (!empty($_POST)) {
    extract($_POST);
    extract($_SESSION);

    $_SESSION['error'] = array();

    // Validate inputs
    if (empty($fnm)) {
        $_SESSION['error'][] = "Enter Full Name";
    }

    if (empty($add)) {
        $_SESSION['error'][] = "Enter Full Address";
    }

    if (empty($pc)) {
        $_SESSION['error'][] = "Enter City Pincode";
    }

    if (empty($city)) {
        $_SESSION['error'][] = "Enter City";
    }

    if (empty($state)) {
        $_SESSION['error']['state'] = "Enter State";
    }

    if (empty($mno)) {
        $_SESSION['error'][] = "Enter Mobile Number";
    } else if (!is_numeric($mno)) {
        $_SESSION['error'][] = "Enter Mobile Number in Numbers";
    }

    // If errors exist, redirect back to order page
    if (!empty($_SESSION['error'])) {
        header("Location: order.php");
        exit();
    } else {
        // Process the order and insert it into the database using prepared statements
        $rid = $_SESSION['client']['id'];

        $stmt = mysqli_prepare($link, "INSERT INTO `order` (o_name, o_address, o_pincode, o_city, o_state, o_mobile, o_rid) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?)");

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ssisssi", $fnm, $add, $pc, $city, $state, $mno, $rid);

        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            header("Location: order.php?order");
            exit();
        } else {
            $_SESSION['error'][] = "Failed to place the order. Please try again.";
            header("Location: order.php");
            exit();
        }
    }
} else {
    header("Location: order.php");
    exit();
}
?>
