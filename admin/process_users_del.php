<?php
session_start();
include("../includes/connection.php");

// Check if 'id' is set and is a valid integer
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $user_id = $_GET['id'];

    // Prepare the delete statement
    $stmt = $link->prepare("DELETE FROM register WHERE r_id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "User deleted successfully.";
    } else {
        $_SESSION['error'] = "Error deleting user: " . $stmt->error;
    }

    $stmt->close();
} else {
    $_SESSION['error'] = "Invalid user ID.";
}

// Redirect to the users view page
header("location:users_view.php");
exit();
?>
