<?php
include("includes/header.php");
?>

<div id="content">
    <div class="post">
        <h2 class="title"><a href="#">Search: <?php echo htmlspecialchars($_GET['s']); ?></a></h2>
        <p class="meta"></p>
        <div class="entry">

            <?php
            include("includes/connection.php");

            $s = $_GET['s'];

            // Prepared statement to prevent SQL injection
            $stmt = mysqli_prepare($link, "SELECT * FROM book WHERE b_nm LIKE ?");
            $searchTerm = "%" . $s . "%";
            mysqli_stmt_bind_param($stmt, "s", $searchTerm);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while ($blrow = mysqli_fetch_assoc($result)) {
                echo '<div class="book_box">
                        <a href="book_detail.php?id=' . $blrow['b_id'] . '">
                            <img src="' . $blrow['b_img'] . '">
                            <h2>' . $blrow['b_nm'] . '</h2>
                            <p>Rs. ' . $blrow['b_price'] . '</p>
                        </a>
                    </div>';
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
