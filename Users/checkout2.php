<?php
require_once 'auth.php';
include('../config.php');

$user_id = (int)$_SESSION['user_id'];

/* =========================================================================
   2. CAPTURE BOOK ID VIA URL STRING
========================================================================= */$book_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

/* =========================================================================
   3. PROCESS SUBMITTED CHECKOUT TRANSACTION
========================================================================= */
if (isset($_POST['submit'])) {
    $payment_status = mysqli_real_escape_string($connection, $_POST['payment_status']);
    $delivery_mode  = mysqli_real_escape_string($connection, $_POST['delivery_mode']);
    $quantity       = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;
    $address        = mysqli_real_escape_string($connection, $_POST['address']);

    /* SAFE DYNAMIC SQL STATEMENT (Inserts 0 if guest, or the real user_id if logged in) */
    $insertQuery = "
        INSERT INTO orders 
        (user_id, book_id, payment_status, delivery_mode, quantity, address, order_date)
        VALUES 
        ('$user_id', '$book_id', '$payment_status', '$delivery_mode', '$quantity', '$address', NOW())
    ";

    if (mysqli_query($connection, $insertQuery)) {
        echo "
        <script>
            alert('Order Placed Successfully!');
            window.location.href='index.php';
        </script>
        ";
        exit();
    } else {
        echo "
        <script>
            alert('Order Failed: " . mysqli_real_escape_string($connection, mysqli_error($connection)) . "');
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo site_logo_path(true); ?>">
    <title><?php echo page_title('Place Order'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="checkout.css">
    <link rel="stylesheet" href="headfoot.css?v=4">
</head>
<body>
    <?php include("header.php"); ?>

    <div class="checkout-page">
        <div class="checkout-container">
            <div class="order-box">

            <h2>
                <i class="fa-solid fa-cart-shopping"></i>
                Place Your Order
            </h2>

            <form method="POST">

                <div class="input-group mb-3">
                    <label class="form-label fw-bold">Payment Status</label>
                    <select name="payment_status" class="form-control" required>
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                    </select>
                </div>

                <div class="input-group mb-3">
                    <label class="form-label fw-bold">Delivery Mode</label>
                    <select name="delivery_mode" class="form-control" required>
                        <option value="standard">Standard</option>
                        <option value="express">Express</option>
                        <option value="pickup">Store Pickup</option>
                        <option value="cod">Cash On Delivery</option>
                    </select>
                </div>
                <div class="input-group mb-3">
                    <label class="form-label fw-bold">Quantity</label>
                    <input
                        type="number"
                        name="quantity"
                        class="form-control"
                        min="1"
                        max="20"
                        value="1"
                        required>
                    <small class="text-muted">Enter quantity between 1–20</small>
                </div>

                <div class="input-group mb-3">
                    <label class="form-label fw-bold">Delivery Address</label>
                    <textarea
                        name="address"
                        class="form-control"
                        placeholder="Enter delivery address"
                        minlength="10"
                        required></textarea>
                    <small class="text-muted">Minimum 10 characters required</small>
                </div>

                <button type="submit" name="submit" class="btn btn-success w-100 mt-2">
                    <i class="fa-solid fa-check"></i> Place Order
                </button>

            </form>
            </div>
        </div>
    </div>

<?php include("footer.php"); ?>