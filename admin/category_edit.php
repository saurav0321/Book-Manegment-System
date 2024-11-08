<?php
    include("includes/header.php");
    include("../includes/connection.php");

    // Get the category ID from the URL
    $id = $_GET['id'];

    // Prepare the query to select the category with the given ID
    $q = "SELECT * FROM category WHERE cat_id='$id'";

    // Execute the query using mysqli_query() with the correct argument order
    $res = mysqli_query($link, $q);

    // Fetch the result as an associative array
    $row = mysqli_fetch_assoc($res);
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Update Category</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Category
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">

                            <?php
                                // Display success message
                                if (isset($_SESSION['done'])) {
                                    echo '<div class="msg msg-ok"><p><strong>' . $_SESSION['done'] . '</strong></p></div>';
                                    unset($_SESSION['done']);
                                }

                                // Display error messages
                                if (!empty($_SESSION['error'])) {
                                    foreach ($_SESSION['error'] as $er) {
                                        echo '<div class="msg msg-error error"><p><strong>' . $er . '</strong></p></div>';
                                    }
                                    unset($_SESSION['error']);
                                }
                            ?>

                            <form role="form" action="process_category_edit.php" method="post">

                                <div class="form-group">
                                    <label>New Name for Category</label>
                                    <input type="text" name="cat" value="<?php echo $row['cat_nm']; ?>" class="form-control" required>
                                </div>

                                <?php
                                    // Display specific error for category name
                                    if (isset($_SESSION['error']['cat'])) {
                                        echo '<p class="error">' . $_SESSION['error']['cat'] . '</p>';
                                    }
                                ?>

                                <!-- Hidden field to pass the category ID -->
                                <input type="hidden" name="id" value="<?php echo $row['cat_id']; ?>" /> 

                                <button type="submit" class="btn btn-default">Update Category</button>
                                <button type="reset" class="btn btn-default">Reset</button>

                            </form>

                            <?php
                                unset($_SESSION['error']);
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    include("includes/footer.php");
?>
