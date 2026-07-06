<?php
session_start();
include("../config.php");

if (!isset($_SESSION['n']) || !isset($_SESSION['p'])) {
    header("Location: login.php");
    exit();
}

// 1. UPDATE LOGIC: Runs when the "Update User" button is clicked
if (isset($_POST['edit_userbtn'])) {
    $id = mysqli_real_escape_string($connection, $_POST['id']);
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $membership_status = mysqli_real_escape_string($connection, $_POST['membership_status']);

    $updateQuery = "UPDATE `users` SET 
                    name='$name', 
                    email='$email', 
                    membership_status='$membership_status' 
                    WHERE id='$id'";

    if (mysqli_query($connection, $updateQuery)) {
        echo "<script>alert('User Updated Successfully'); window.location.href='viewusers.php';</script>";
        exit(); 
    } else {
        echo "Error updating record: " . mysqli_error($connection);
    }
}

// 2. FETCH LOGIC: Get current user data to show in the form
$user = []; 
if (isset($_GET['id'])) {
    $updateId = mysqli_real_escape_string($connection, $_GET['id']);
    $fetchQuery = "SELECT * FROM `users` WHERE id = '$updateId'";
    $result = mysqli_query($connection, $fetchQuery);
    
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "User not found.";
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
                <h2 class="h5 no-margin-bottom">EDIT USER</h2>
            </div>
        </div>

        <section class="no-padding-top no-padding-bottom">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 col-md-12 offset-lg-3">
                        <div class="block">
                            <div class="title"><strong class="d-block text-center">Edit User Form</strong></div>
                            <div class="block-body">
                                
                                <form method="post">
                                    <input type="hidden" name="id" value="<?php echo $user['id'] ?? ''; ?>">

                                    <div class="form-group">
                                        <label class="form-control-label">Full Name</label>
                                        <input type="text" class="form-control" name="name" value="<?php echo $user['name'] ?? ''; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label">Email Address</label>
                                        <input type="email" class="form-control" name="email" value="<?php echo $user['email'] ?? ''; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label">Membership Status</label>
                                        <select name="membership_status" class="form-control">
                                            <option value="free" <?php echo ($user['membership_status'] == 'free') ? 'selected' : ''; ?>>Free</option>
                                            <option value="premium" <?php echo ($user['membership_status'] == 'premium') ? 'selected' : ''; ?>>Premium</option>
                                            <option value="inactive" <?php echo ($user['membership_status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" value="Update User" class="btn btn-primary btn-block" name="edit_userbtn">
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php include("footer.php"); ?>