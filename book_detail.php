<?php
include("includes/header.php");
include("includes/connection.php");

// Ensure the 'id' parameter is an integer to prevent SQL injection
$bid = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Prepare the SQL statement
$book_query = "SELECT book.*, category.cat_nm FROM book 
                JOIN category ON b_cat = cat_id 
                WHERE b_id = ?";
$stmt = mysqli_prepare($link, $book_query);

// Bind the parameter
mysqli_stmt_bind_param($stmt, "i", $bid);

// Execute the statement
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);

// Fetch the book details
$book_row = mysqli_fetch_assoc($result);

// Check if the book exists
if (!$book_row) {
    echo '<p>Book not found.</p>';
    exit;
}
?>

<div id="content">
    <div class="post">
        <h2 class="title"><a href="#"><?php echo htmlspecialchars($book_row['cat_nm']); ?></a></h2>
        <p class="meta"></p>
        <div class="entry">

            <table class="book_detail" width="100%" border="0px">
                <tr valign="top">
                    <td width="48%">
                        <img class="book_img" src="<?php echo htmlspecialchars($book_row['b_img']); ?>" width="280px" height="350px">
                    </td>

                    <td>
                        <h1><?php echo htmlspecialchars($book_row['b_nm']); ?></h1>
                        <p class="desc"><?php echo htmlspecialchars($book_row['b_desc']); ?></p>

                        <p class="price">Rs. <?php echo htmlspecialchars($book_row['b_price']); ?></p>

                        <?php
                        $is_cart = 0;

                        if (isset($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] as $id => $val) {
                                if ($val['img'] == $book_row['b_img']) {
                                    $is_cart = 1;
                                    break;
                                }
                            }
                        }

                        if (isset($_SESSION['client']['status'])) {
                            if ($is_cart == 0) {
                                echo '<a href="addtocart.php?bcid=' . htmlspecialchars($book_row['b_id']) . '" class="cart_btn">Add to Cart</a>';
                            } else {
                                echo "Already in Cart";
                            }
                        } else {
                            echo '<a href="#" class="cart_btn">Add to Cart</a><a style="text-decoration: none" href="login.php"><h2>Click here to Login..</h2></a>';
                        }
                        ?>

                    </td>
                </tr>
            </table>

        </div>
    </div>
</div><!-- end #content -->

<?php
include("includes/footer.php");
?>
