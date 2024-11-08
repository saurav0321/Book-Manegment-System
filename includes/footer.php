<div id="sidebar">

    <?php
    if (isset($_SESSION['client']['status'])) {
        echo '<ul>
                <li>
                    <h2>Hi : ' . htmlspecialchars($_SESSION['client']['unm']) . '</h2>
                    <ul>
                        <li><a href="logout.php">Log Out</a></li>
                    </ul>
                </li>
              </ul>';
    }
    ?>

    <ul>
        <li>
            <h2>Category</h2>
            <ul>
                <?php
                include("includes/connection.php");

                $cat_q = "SELECT * FROM category ORDER BY cat_nm ASC";
                $cat_res = mysqli_query($link, $cat_q);

                // Check for query errors
                if (!$cat_res) {
                    echo "<li>Error fetching categories: " . mysqli_error($link) . "</li>";
                } else {
                    while ($cat_row = mysqli_fetch_assoc($cat_res)) {
                        echo '<li><a href="book_list.php?id=' . $cat_row['cat_id'] . '&cat=' . urlencode($cat_row['cat_nm']) . '">' . htmlspecialchars($cat_row['cat_nm']) . '</a></li>';
                    }
                }
                ?>
            </ul>
        </li>
    </ul>
</div>
<!-- end #sidebar -->
<div style="clear: both;">&nbsp;</div>
</div>
<!-- end #page -->
<div id="footer">
    <p>&copy; 2024. All rights reserved. Project Made By <a href="index.php" rel="nofollow">Saurav & Kumar</a>.</p>
</div>
<!-- end #footer -->
</body>
</html>
