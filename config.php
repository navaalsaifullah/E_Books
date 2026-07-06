<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "ebooks";
$connection = mysqli_connect($hostname,$username,$password,$database);
if (!$connection) {
    echo "<script>alert('Database is not conneted');</script>";
}
?>