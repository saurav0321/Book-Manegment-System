<?php
session_start();

if (!empty($_POST)) {
    extract($_POST);
    $_SESSION['error'] = array();

    if (empty($unm) || empty($pwd)) {
        $_SESSION['error'][] = "Please enter User Name or Password";
        header("location:login.php");
        exit();
    } else {
        include("includes/connection.php"); // Ensure this contains your mysqli connection

        // Use mysqli_real_escape_string to prevent SQL injection
        $unm = mysqli_real_escape_string($link, $unm);
        $pwd = mysqli_real_escape_string($link, $pwd); // Ideally, you should hash this password for storage

        // Query to check the user credentials
        $q = "SELECT * FROM register WHERE r_unm='$unm' AND r_pwd='$pwd'";
        $res = mysqli_query($link, $q);

        if ($res) {
            $row = mysqli_fetch_assoc($res);

            if (!empty($row)) {
                $_SESSION['client']['unm'] = $row['r_fnm'];
                $_SESSION['client']['id'] = $row['r_id'];
                $_SESSION['client']['status'] = true;

                header("location:index.php");
                exit(); // Always exit after a header redirect
            } else {
                $_SESSION['error'][] = "Wrong Username or Password";
                header("location:login.php");
                exit();
            }
        } else {
            $_SESSION['error'][] = "Database query failed: " . mysqli_error($link);
            header("location:login.php");
            exit();
        }
    }
} else {
    header("location:login.php");
    exit();
}
?>
