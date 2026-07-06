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
    <!-- Sidebar Navigation-->
    <?php
    include("sidebar.php")
    ?>
    <!-- Sidebar Navigation end-->
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h2 class="h5 no-margin-bottom">CREATE COMPETITION</h2>
            </div>
        </div>
        <section class="no-padding-top no-padding-bottom">
            <div class="container-fluid">
                <div class="row">

                    <!-- Form -->
                    <div class="col-lg-6 col-md-12 offset-lg-3">
                        <div class="block form">
                            <div class="title"><strong class="d-block text-center">Create Competition Form</strong>
                                <!-- <span class="d-block text-center">Lorem ipsum dolor sit amet consectetur.</span> -->
                            </div>
                            <div class="block-body">
                                <form method="post" enctype="multipart/form-data">

                                    <div class="form-group">
                                        <label class="form-control-label">Book Title</label>
                                        <input type="text" class="form-control" name="title">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label">Image</label>
                                        <input type="file" placeholder="Image" class="form-control" name="image">
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" value="Create Competition" class="btn btn-primary btn-block" name="createtn">
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php
        if (isset($_POST['createtn'])) {
            $title = mysqli_real_escape_string($connection, $_POST['title']);
            $image = mysqli_real_escape_string($connection, $_FILES['image']['name'] ?? '');
            $tempimage = $_FILES['image']['tmp_name'] ?? '';

            move_uploaded_file($tempimage, 'img/books/' . $image);
            $insertQuery = "INSERT INTO `competitions`(`Book_Title`, `Image`) VALUES ('$title','$image')";
            $data = mysqli_query($connection, $insertQuery);
            if ($data) {
                echo "<script>alert('Competition is Created');
            window.location.href = 'viewcompetitions.php'
     </script>";
            } else {
                echo "<script>alert('Please Check Your Fields');</script>";
            }
        }
        ?>

        <?php
        include("footer.php");
        ?>