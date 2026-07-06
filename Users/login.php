<?php
require_once 'guest.php';
include_once('./connection.php');
$message = "";
$messageType = "";

if (isset($_REQUEST['login'])) {
    $user_email = $_REQUEST['uemail'];
    $user_password = $_REQUEST['upassword'];

    $checkEmail = "SELECT * FROM `users` WHERE email = '$user_email'";
    $result = mysqli_query($connection, $checkEmail);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $passwordVerify = password_verify($user_password, $row['password']);
        if ($passwordVerify) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_name'] = $row['name'];

            $message = 'Login Successfully';
            $messageType = 'success';
            echo "<script>
                setTimeout(() => {
                    window.location.href = './index.php';
                }, 2000);
            </script>";
        } else {
            $message = 'Email Or Password Are Incorrect';
            $messageType = 'danger';
            echo "<script>
                setTimeout(() => {
                    window.location.href = 'login.php';
                }, 2000);
            </script>";
        }
    } else {
        $message = 'No Record Found In The Database';
        $messageType = 'danger';
        echo "<script>
            setTimeout(() => {
                window.location.href = '../index.php';
            }, 2000);
        </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo page_title('Login'); ?></title>
    <link rel="shortcut icon" href="<?php echo site_logo_path(true); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./login_signup.css">
</head>

<body>

    <div class="main_container">
        <div class="form_container">
            <h3 class="text-center fw-bold">Login Form</h3>
            <?php if ($message) { ?>
                <hr>
                <div class="alert alert-<?php echo $messageType ?> alert-dismissible fade show" role="alert">
                    <strong><?php echo $message ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>

            <form action="" method="post" class="needs-validation" novalidate>
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
                    <input type="submit" value="Login" class="button" name="login">
                </div>

                <div class="mt-3 text-center">
                    Don't Have An Account?
                    <a href="signup.php" class="text-dark fw-bold">
                         SignUp
                    </a>
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
