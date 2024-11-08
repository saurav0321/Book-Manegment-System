<?php
include("includes/header.php");
?>

<div id="content">
    <div class="post">
        <h2 class="title"><a href="#"><?php echo htmlspecialchars($_GET['cat']); ?></a></h2>
        <p class="meta"></p>
        <div class="entry">

            <?php
            include("includes/connection.php");

            // Ensure the 'id' parameter is an integer to prevent SQL injection
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

            // Prepare the SQL statement
            $blq = "SELECT * FROM book WHERE b_cat = ?";
            $stmt = mysqli_prepare($link, $blq);

            // Bind the parameter
            mysqli_stmt_bind_param($stmt, "i", $id);

            // Execute the statement
            mysqli_stmt_execute($stmt);

            // Get the result
            $result = mysqli_stmt_get_result($stmt);

            // Check if any books are found
            if (mysqli_num_rows($result) > 0) {
                while ($blrow = mysqli_fetch_assoc($result)) {
                    echo '<div class="book_box">
                            <a href="book_detail.php?id=' . htmlspecialchars($blrow['b_id']) . '">
                                <img src="' . htmlspecialchars($blrow['b_img']) . '">
                                <h2>' . htmlspecialchars($blrow['b_nm']) . '</h2>
                                <p>Rs. ' . htmlspecialchars($blrow['b_price']) . '</p>
                            </a>
                          </div>';
                }
            } else {
                echo '<p>No books found in this category.</p>';
            }

            // Close the statement
            mysqli_stmt_close($stmt);
            ?>

            <div style="clear:both;"></div>

        </div>
    </div>
</div><!-- end #content -->

<?php
include("includes/footer.php");
?>
