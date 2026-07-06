<?php
session_start();
include("../config.php");

if (!isset($_SESSION['n']) || !isset($_SESSION['p'])) {
    header("Location: login.php");
    exit();
}

// 1. UPDATE LOGIC: Runs when the "Update Competition" button is clicked
if (isset($_POST['edit_competitionbtn'])) {
    $id = mysqli_real_escape_string($connection, $_POST['id']);
    $title = mysqli_real_escape_string($connection, $_POST['title']);

    // Image Handling
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        // Ensure this path matches where you store competition images
        move_uploaded_file($tmp_name, "img/books/" . $image);
        
        $updateQuery = "UPDATE `competitions` SET Book_Title='$title', Image='$image' WHERE Id='$id'";
    } else {
        // Update only the title if no new image is uploaded
        $updateQuery = "UPDATE `competitions` SET Book_Title='$title' WHERE Id='$id'";
    }

    if (mysqli_query($connection, $updateQuery)) {
        echo "<script>alert('Competition Updated Successfully'); window.location.href='viewcompetitions.php';</script>";
        exit(); 
    } else {
        echo "Error updating record: " . mysqli_error($connection);
    }
}

// 2. FETCH LOGIC: Get current data to show in the form
$comp = []; 
if (isset($_GET['id'])) {
    $updateId = mysqli_real_escape_string($connection, $_GET['id']);
    $fetchQuery = "SELECT * FROM `competitions` WHERE Id = '$updateId'";
    $result = mysqli_query($connection, $fetchQuery);
    
    if (mysqli_num_rows($result) > 0) {
        $comp = mysqli_fetch_assoc($result);
    } else {
        echo "Competition not found.";
        exit();
    }
} else {
    echo "No ID provided.";
    exit();
}

include("header.php");
?>

<div class="d-flex align-items-stretch">
    <?php include("sidebar.php"); ?>
    
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h2 class="h5 no-margin-bottom">EDIT COMPETITION</h2>
            </div>
        </div>

        <section class="no-padding-top no-padding-bottom">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 col-md-12 offset-lg-3">
                        <div class="block">
                            <div class="title"><strong class="d-block text-center">Edit Competition Form</strong></div>
                            <div class="block-body">
                                
                                <form method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $comp['Id'] ?? ''; ?>">

                                    <div class="form-group">
                                        <label class="form-control-label">Book Title</label>
                                        <input type="text" class="form-control" name="title" value="<?php echo $comp['Book_Title'] ?? ''; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label">Image</label>
                                        <input type="file" class="form-control" name="image">
                                        <div class="mt-2">
                                            <small class="text-muted d-block">Current Image:</small>
                                            <img src="img/books/<?php echo $comp['Image']; ?>" width="100" class="mt-1 border" alt="current">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" value="Update Competition" class="btn btn-primary btn-block" name="edit_competitionbtn">
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php include("footer.php"); ?>