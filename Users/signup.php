<?php
require_once 'guest.php';
include_once('./connection.php');
$message = "";
$messageType = "";

if (isset($_POST['signup'])) {
    $uname = $_POST['uname'];
    $uemail = $_POST['uemail'];
    $upassword = $_POST['upassword'];
    $ucpassword = $_POST['ucpassword'];

    if ($upassword != $ucpassword) {
        $message = "Password And Confirm Password Doesn't Match";
        $messageType = "danger";
    } else {
        $checkEmail = "SELECT * FROM users WHERE email='$uemail'";
        $confirmemail = mysqli_query($connection, $checkEmail);

        if (mysqli_num_rows($confirmemail) > 0) {
            $message = "Email Already Exist!";
            $messageType = "danger";
        } else {
            $encryptedPassword = password_hash($upassword, PASSWORD_DEFAULT);
            $InsertQuery = "INSERT INTO users(name, email, password) VALUES('$uname', '$uemail', '$encryptedPassword')";
            $result = mysqli_query($connection, $InsertQuery);

            if ($result) {
                header('location:login.php');
                exit();
            } else {
                $message = "Something Went Wrong";
                $messageType = "danger";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo page_title('Sign Up'); ?></title>
    <link rel="shortcut icon" href="<?php echo site_logo_path(true); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./login_signup.css">
</head>

<body>

    <div class="main_container">
        <div class="form_container">
            <h3 class="text-center fw-bold">Sign Up</h3>
            <hr>

            <form action="" method="post" class="needs-validation" novalidate>
                <?php if ($message) { ?>
                    <div class="alert alert-<?php echo $messageType ?> alert-dismissible fade show" role="alert">
                        <strong><?php echo $message ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <div class="form-group mt-4">
                    <label class="form-label">Enter Your Name</label>
                    <input type="text" placeholder="Enter Your Name" class="form-control" name="uname" required>
                    <div class="invalid-feedback">Please Enter Your Name</div>
                </div>

                <div class="form-group mt-4">
                    <label class="form-label">Enter Your Email</label>
                    <input type="email" placeholder="Enter Your Email" class="form-control" name="uemail" required>
                    <div class="invalid-feedback">Please Enter Your Email</div>
                </div>

                <div class="form-group mt-4">
                    <label class="form-label">Enter Your Password</label>
                    <input type="password" placeholder="Enter Your Password" class="form-control" name="upassword" required>
                    <div class="invalid-feedback">Please Enter Your Password</div>
                </div>

                <div class="form-group mt-4">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" placeholder="Confirm Password" class="form-control" name="ucpassword" required>
                    <div class="invalid-feedback">Please Enter Your Confirm Password</div>
                </div>

                <div class="form-group mt-4">
                    <input type="submit" value="SignUp" class="button" name="signup">
                </div>

                <div class="form-group">
                    <p>Already Have An Account? <a href="login.php" class="text-dark fw-bold">Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function() {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
