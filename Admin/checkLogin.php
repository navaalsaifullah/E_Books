<?php
session_start();
include_once('../config.php');
if (isset($_REQUEST['btnlogin'])) {

    $username = $_REQUEST['aname'];
    $password = $_REQUEST['apass'];
    // Correct  query using variables
    $selectQuery = "SELECT * FROM `admin` 
                    WHERE username = '$username' 
                    AND password = '$password'";

    $result = mysqli_query($connection, $selectQuery);
    $data = mysqli_fetch_assoc($result);
    if($data) {
        

        $_SESSION['n'] = $data['username'];
        $_SESSION['p'] = $data['password'];

        echo "<script>
                window.location.href='dashboard.php';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Please Check Your Fields');
                window.location.href='login.php';
              </script>";
    }
}
