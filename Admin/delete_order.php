<?php
session_start();
if (!isset($_SESSION['n']) || !isset($_SESSION['p'])) {
    header("Location: login.php");
    exit();
}
include("../config.php");

if (isset($_GET['id'])) {
    $deleteId = $_GET['id'];

    // Use Prepared Statements for security
    $stmt = $connection->prepare("DELETE FROM `orders` WHERE Id = ?");
    $stmt->bind_param("i", $deleteId);

    if ($stmt->execute()) {
        // Redirect back to the view page after deletion
        header("Location: vieworders.php");
        exit();
    } else {
        echo "Error deleting record: " . $connection->error;
    }
} else {
    header("Location: vieworders.php");
    exit();
}
?>