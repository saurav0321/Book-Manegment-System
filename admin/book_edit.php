<?php
include("includes/header.php");
include("../includes/connection.php");

// Fetch the book details using prepared statements
$stmt = $link->prepare("SELECT * FROM book WHERE b_id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$res = $stmt->get_result();

$crow = $res->fetch_assoc();
$stmt->close();
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Update Book</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Book
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">

                            <form role="form" action="process_book_edit.php" method="post" enctype="multipart/form-data">

                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($crow['b_id']); ?>" />

                                <div class="form-group">
                                    <label>Book Name</label>
                                    <?php
                                    if (isset($_SESSION['error']['bnm'])) {
                                        echo '<p class="error">' . $_SESSION['error']['bnm'] . '</p>';
                                    }
                                    ?>
                                    <input type="text" name="bnm" value="<?php echo htmlspecialchars($crow['b_nm']); ?>" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Book Category</label>
                                    <select name="cat" class="form-control" required>
                                        <?php
                                        $cq = "SELECT * FROM category";
                                        $cres = mysqli_query($link, $cq);

                                        while ($crow_cat = mysqli_fetch_assoc($cres)) {
                                            // Check if the current category is the one assigned to the book
                                            $selected = ($crow_cat['cat_id'] == $crow['b_cat_id']) ? 'selected' : '';
                                            echo '<option value="' . htmlspecialchars($crow_cat['cat_id']) . '" ' . $selected . '>' . htmlspecialchars($crow_cat['cat_nm']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <?php
                                    if (isset($_SESSION['error']['desc'])) {
                                        echo '<p class="error">' . $_SESSION['error']['desc'] . '</p>';
                                    }
                                    ?>
                                    <textarea name="desc" rows="3" class="form-control" required><?php echo htmlspecialchars($crow['b_desc']); ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Price</label>
                                    <?php
                                    if (isset($_SESSION['error']['price'])) {
                                        echo '<p class="error">' . $_SESSION['error']['price'] . '</p>';
                                    }
                                    ?>
                                    <input type="number" name="price" value="<?php echo htmlspecialchars($crow['b_price']); ?>" class="form-control" step="0.01" required>
                                </div>

                                <div class="form-group">
                                    <label>Book Image</label>
                                    <?php
                                    if (isset($_SESSION['error']['b_img'])) {
                                        echo '<p class="error">' . $_SESSION['error']['b_img'] . '</p>';
                                    }
                                    ?>
                                    <input type="file" name="b_img" class="form-control" accept="image/*">
                                    <p>Current Image: 
                                        <img src="../<?php echo htmlspecialchars($crow['b_img']); ?>" alt="Current Book Image" style="width: 100px; height: auto;">
                                    </p>
                                </div>

                                <button type="submit" class="btn btn-default">Update Book</button>
                                <a href="book_view.php" class="btn btn-default">Exit</a>

                            </form>

                            <?php
                            unset($_SESSION['error']);
                            ?>

                        </div>
                        <!-- /.col-lg-6 (nested) -->

                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<?php
include("includes/footer.php");
?>
