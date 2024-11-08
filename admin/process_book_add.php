<?php
session_start();
include("../includes/connection.php");

if (!empty($_POST)) {
    $_SESSION['error'] = array();
    extract($_POST);

    // Validate Book Name
    if (empty($bnm)) {
        $_SESSION['error']['bnm'] = "Enter Book Name";
    }

    // Validate Book Description
    if (empty($desc)) {
        $_SESSION['error']['desc'] = "Enter Book Description";
    }

    // Validate Book Price
    if (empty($price)) {
        $_SESSION['error']['price'] = "Enter Book Price";
    } else if (!is_numeric($price)) {
        $_SESSION['error']['price'] = "Enter Book Price in Numbers";
    }

    // Validate Book Image
    if (empty($_FILES['b_img']['name'])) {
        $_SESSION['error']['b_img'] = "Please provide a file";
    } else if ($_FILES['b_img']['error'] > 0) {
        $_SESSION['error']['b_img'] = "Error uploading file";
    } else if (!(strtoupper(pathinfo($_FILES['b_img']['name'], PATHINFO_EXTENSION)) == "JPG" ||
                strtoupper(pathinfo($_FILES['b_img']['name'], PATHINFO_EXTENSION)) == "JPEG" ||
                strtoupper(pathinfo($_FILES['b_img']['name'], PATHINFO_EXTENSION)) == "GIF")) {
        $_SESSION['error']['b_img'] = "Wrong file type";
    }

    if (!empty($_SESSION['error'])) {
        header("location:book_add.php");
        exit();
    } else {
        // Prepare to insert the book details
        $t = time();
        $b_img = "book_img/" . basename($_FILES['b_img']['name']);

        // Move the uploaded file
        if (move_uploaded_file($_FILES['b_img']['tmp_name'], "../" . $b_img)) {
            // Insert book details into the database
            $stmt = $link->prepare("INSERT INTO book (b_nm, b_cat, b_desc, b_price, b_img, b_time) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("siisii", $bnm, $cat, $desc, $price, $b_img, $t);
            $stmt->execute();
            $stmt->close();
            header("location:book_add.php");
        } else {
            $_SESSION['error']['b_img'] = "Error moving uploaded file.";
            header("location:book_add.php");
        }
    }
} else {
    header("location:book_add.php");
}
?>
