<?php
session_start();
include("../config.php");
if (!isset($_SESSION['n']) || !isset($_SESSION['p'])) {
    header("Location: login.php");
    exit();
}
include("header.php");
?>
<div class="d-flex align-items-stretch">
    <?php include("sidebar.php"); ?>
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h2 class="h5 no-margin-bottom">VIEW USERS</h2>
            </div>
        </div>
        
        <section class="no-padding-top no-padding-bottom">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="block margin-bottom-sm table">
                            <div class="title"><strong>Users Table</strong></div>
                            <div class="table-responsive"> 
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Membership Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $selectQuery = "SELECT * FROM users";
                                        $data = mysqli_query($connection, $selectQuery);
                                        foreach ($data as $row) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row['id'] ?></td>
                                            <td><?php echo $row['name'] ?></td>
                                            <td><?php echo $row['email'] ?></td>
                                           <td><?php echo $row['membership_status']; ?></td>
                                            <td><?php echo $row['created_at'] ?></td>
                                            <td>
                                                <a href="./edit_user.php?id=<?php echo $row['id'] ?>" class="btn btn-sm btn-success">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <a href="./delete_user.php?id=<?php echo $row['id'] ?>" 
                                                   class="btn btn-sm btn-danger" 
                                                   onclick="return confirm('Are you sure you want to delete this user?');">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php include("footer.php"); ?>