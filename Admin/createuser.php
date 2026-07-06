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
                <h2 class="h5 no-margin-bottom">CREATE USER</h2>
            </div>
        </div>
        <section class="no-padding-top no-padding-bottom">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 col-md-12 offset-lg-3">
                        <div class="block form">
                            <div class="title"><strong class="d-block text-center">Create User Form</strong></div>
                            <div class="block-body">
                                <form method="post">
                                    <div class="form-group">
                                        <label class="form-control-label">Name</label>
                                        <input type="text" placeholder="Enter Name" class="form-control" name="name" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label">Email</label>
                                        <input type="email" placeholder="Enter Email" class="form-control" name="email" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label">Password</label>
                                        <input type="password" placeholder="Enter Password" class="form-control" name="password" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label">Membership Status</label>
                                        <select class="form-control" name="membership_status">
                                            <option value="free" selected>Free</option>
                                            <option value="premium">Premium</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" value="Create User" class="btn btn-primary btn-block" name="createbtn">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php
        if (isset($_POST['createbtn'])) {

            $name     = mysqli_real_escape_string($connection, $_POST['name']);
            $email    = mysqli_real_escape_string($connection, $_POST['email']);
            $status   = mysqli_real_escape_string($connection, $_POST['membership_status']);

            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);


            $insertQuery = "INSERT INTO `users` (`name`, `email`, `password`, `membership_status`) 
                            VALUES ('$name', '$email', '$password', '$status')";

            $data = mysqli_query($connection, $insertQuery);

            if ($data) {
                echo "<script>
                        alert('User Created Successfully');
                        window.location.href = 'viewusers.php';
                      </script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($connection) . "');</script>";
            }
        }
        ?>

        <?php include("footer.php"); ?>