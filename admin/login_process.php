<?php
session_start();

include("../includes/connection.php"); // Ensure connection.php contains MySQLi connection

if (!empty($_POST)) {
    $_SESSION['error'] = array();
    extract($_POST);

    // Check for empty username or password
    if (empty($unm) || empty($pwd)) {
        $_SESSION['error'][] = "Required User Name & Password";
        header("location:login.php");
        exit(); // Always exit after header redirects
    } else {
        // Use prepared statements to prevent SQL injection
        $stmt = $link->prepare("SELECT * FROM admin WHERE a_unm = ? AND a_pwd = ?");
        $stmt->bind_param("ss", $unm, $pwd); // "ss" denotes two string parameters
        $stmt->execute();
        $res = $stmt->get_result();

        // Fetch associative array of the result
        if ($row = $res->fetch_assoc()) {
            // If login successful
            $_SESSION['admin']['unm'] = $row['a_unm'];
            $_SESSION['admin']['status'] = true;
            header("location:index.php");
            exit();
        } else {
            // Wrong username or password
            $_SESSION['error'][] = "Wrong User Name or Password";
            header("location:login.php");
            exit();
        }
        $stmt->close(); // Close the prepared statement
    }
} else {
    header("location:login.php");
    exit();
}
?>
