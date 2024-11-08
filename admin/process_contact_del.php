<?php
session_start();

include("../includes/connection.php");

// Check if the ID is set and is a valid number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']); // Cast to integer for safety

    // Prepare the query to delete the contact
    $query = "DELETE FROM contact WHERE c_id = $id";

    // Execute the query
    if (mysqli_query($link, $query)) {
        // Successfully deleted
        $_SESSION['success'] = "Contact deleted successfully.";
    } else {
        // Query failed
        $_SESSION['error'] = "Error deleting contact: " . mysqli_error($link);
    }
} else {
    $_SESSION['error'] = "Invalid contact ID.";
}

// Redirect back to the contact view page
header("location:contact_view.php");
exit(); // Always exit after a header redirect
?>
