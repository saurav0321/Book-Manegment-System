<?php
// Replace 'localhost', 'root', 'your_password', with actual values if necessary
$link = new mysqli('localhost', 'root', '', 'bms');

// Check connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

// Set character set to utf8 (optional, but recommended for handling multi-byte characters)
if (!$link->set_charset("utf8")) {
    die("Error loading character set utf8: " . $link->error);
}
?>
