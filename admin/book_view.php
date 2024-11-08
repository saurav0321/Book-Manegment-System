<?php
include("includes/header.php");
include("../includes/connection.php");
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">View Book</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Book List
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Book Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                // Prepare the query to retrieve books and categories
                                $book_q = "SELECT b.*, c.cat_nm FROM book b JOIN category c ON b.b_cat = c.cat_id";
                                $book_res = mysqli_query($link, $book_q);

                                $count = 1;

                                // Check for results and fetch them
                                if ($book_res && mysqli_num_rows($book_res) > 0) {
                                    while ($book_row = mysqli_fetch_assoc($book_res)) {
                                        echo '<tr class="odd gradeX">
                                                  <td>' . $count . '</td>
                                                  <td>' . htmlspecialchars($book_row['b_nm']) . '</td>
                                                  <td>' . htmlspecialchars($book_row['cat_nm']) . '</td>
                                                  <td>' . htmlspecialchars(number_format($book_row['b_price'], 2)) . '</td>
                                                  <td width="120"><center><img src="../' . htmlspecialchars($book_row['b_img']) . '" width="100" height="100" alt="Book Image"></center></td>
                                                  <td>' . date("d-M-y", $book_row['b_time']) . '</td>
                                                  <td align="center">
                                                      <a style="color: red;" href="process_book_del.php?id=' . htmlspecialchars($book_row['b_id']) . '" onclick="return confirm(\'Are you sure you want to delete this book?\');">x</a>
                                                  </td>
                                              </tr>';
                                        $count++;
                                    }
                                } else {
                                    // Handle query failure or no results
                                    echo '<tr><td colspan="7" style="color: red;">No books found or query failed.</td></tr>';
                                }

                                // Free result set
                                mysqli_free_result($book_res);
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /#page-wrapper -->
</div>

<?php
include("includes/footer.php");
?>
