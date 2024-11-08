<?php
include("includes/header.php");
include("../includes/connection.php");
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">View Contact</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Contact List
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Mobile No</th>
                                    <th>E-Mail Address</th>
                                    <th>Message</th>
                                    <th>Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                // Prepare the query to retrieve contacts
                                $contact_q = "SELECT * FROM contact";
                                $contact_res = mysqli_query($link, $contact_q);

                                $count = 1;

                                // Check for results and fetch them
                                if ($contact_res) {
                                    while ($contact_row = mysqli_fetch_assoc($contact_res)) {
                                        echo '<tr class="odd gradeX">
                                                  <td>' . $count . '</td>
                                                  <td>' . htmlspecialchars($contact_row['c_fnm']) . '</td>
                                                  <td>' . htmlspecialchars($contact_row['c_mno']) . '</td>
                                                  <td>' . htmlspecialchars($contact_row['c_email']) . '</td>
                                                  <td>' . htmlspecialchars($contact_row['c_msg']) . '</td>
                                                  <td>' . date("d-M-y", $contact_row['c_time']) . '</td>
                                                  <td align="center"><a style="color: red;" href="process_contact_del.php?id=' . $contact_row['c_id'] . '">x</a></td>
                                              </tr>';
                                        $count++;
                                    }
                                } else {
                                    // Handle query failure
                                    echo '<tr><td colspan="7" style="color: red;">No contacts found or query failed.</td></tr>';
                                }
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
