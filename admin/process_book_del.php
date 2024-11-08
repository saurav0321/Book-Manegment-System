<?php
session_start();
include("../includes/connection.php");

// Check if 'id' is set and is a valid integer
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $book_id = $_GET['id'];

    // Prepare the delete statement
    $stmt = $link->prepare("DELETE FROM book WHERE b_id = ?");
    $stmt->bind_param("i", $book_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Book deleted successfully.";
    } else {
        $_SESSION['error'] = "Error deleting book: " . $stmt->error;
    }

    $stmt->close();
} else {
    $_SESSION['error'] = "Invalid book ID.";
}

// Redirect to the book view page
header("location:book_view.php");
exit();
?>
