<?php
require_once 'auth.php';
include('../config.php');

$user_id = (int) $_SESSION['user_id'];

/* =========================================================================
   2. FETCH BOOK TITLE DYNAMICALLY VIA ID URL STRING OR FROM USER CART
========================================================================= */
$display_title = "";
$book_id = 0;
$is_valid_book = false;
$is_cart_checkout = false;
$cart_items = [];

if (isset($_GET['id'])) {
    $book_id = (int) $_GET['id'];

    $query = "SELECT * FROM books WHERE Id = $book_id";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $book = mysqli_fetch_assoc($result);
        $display_title = $book['Book_Title'];
        $is_valid_book = true; // Book exists in database
    }
} else {
    // Cart checkout
    $is_cart_checkout = true;
    $cart_query = mysqli_query($connection, "SELECT * FROM `cart` WHERE user_id = '$user_id'");
    if ($cart_query && mysqli_num_rows($cart_query) > 0) {
        $titles = [];
        while ($item = mysqli_fetch_assoc($cart_query)) {
            $cart_items[] = $item;
            $titles[] = $item['book_name'] . " (Qty: " . $item['quantity'] . ")";
        }
        $display_title = implode(", ", $titles);
        $is_valid_book = true;
    }
}

/* =========================================================================
   3. PROCESS SUBMITTED CHECKOUT TRANSACTION
========================================================================= */
if (isset($_POST['submit'])) {
    // Block execution if checkout is invalid to prevent crash
    if (!$is_valid_book) {
        echo "
        <script>
            alert('Error: Invalid Selection. Please select a book or add items to your cart first.');
            window.location.href='../index.php';
        </script>
        ";
        exit();
    }

    $payment_status = mysqli_real_escape_string($connection, $_POST['payment_status']);
    $delivery_mode  = mysqli_real_escape_string($connection, $_POST['delivery_mode']);
    $address        = mysqli_real_escape_string($connection, $_POST['address']);

    if ($is_cart_checkout) {
        $success = true;
        foreach ($cart_items as $item) {
            $book_name = mysqli_real_escape_string($connection, $item['book_name']);
            $qty = (int)$item['quantity'];
            
            // Get book_id matching book_name
            $b_query = mysqli_query($connection, "SELECT Id FROM books WHERE Book_Title = '$book_name'");
            if ($b_row = mysqli_fetch_assoc($b_query)) {
                $b_id = $b_row['Id'];
            } else {
                $b_id = 0; 
            }

            $insertQuery = "
                INSERT INTO orders 
                (user_id, book_id, payment_status, delivery_mode, quantity, address, order_date)
                VALUES 
                ('$user_id', '$b_id', '$payment_status', '$delivery_mode', '$qty', '$address', NOW())
            ";
            if (!mysqli_query($connection, $insertQuery)) {
                $success = false;
            }
        }
        if ($success) {
            // Clear cart
            mysqli_query($connection, "DELETE FROM `cart` WHERE user_id = '$user_id'");
            echo "
            <script>
                alert('Order Placed Successfully!');
                window.location.href='../index.php';
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
    } else {
        // Single book checkout
        $insertQuery = "
            INSERT INTO orders 
            (user_id, book_id, payment_status, delivery_mode, quantity, address, order_date)
            VALUES 
            ('$user_id', '$book_id', '$payment_status', '$delivery_mode', '1', '$address', NOW())
        ";

        if (mysqli_query($connection, $insertQuery)) {
            echo "
            <script>
                alert('Order Placed Successfully!');
                window.location.href='../index.php';
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
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo site_logo_path(true); ?>">
    <title><?php echo page_title('Checkout'); ?></title>
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

                <?php if ($is_valid_book): ?>
                    <div class="alert alert-info text-center">
                        Ordering: <strong><?php echo htmlspecialchars($display_title, ENT_QUOTES, 'UTF-8'); ?></strong>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger text-center">
                        <strong>Warning:</strong> <?php echo $is_cart_checkout ? 'Your cart is empty. Please add books to your cart first.' : 'No valid book selected. Please go back to the catalog.'; ?>
                    </div>
                <?php endif; ?>

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
                        <label class="form-label fw-bold">Delivery Address</label>
                        <textarea
                            name="address"
                            class="form-control"
                            placeholder="Enter delivery address"
                            minlength="10"
                            required></textarea>
                        <small class="text-muted">Minimum 10 characters required</small>
                    </div>

                    <button type="submit" name="submit" class="btn btn-success w-100 mt-2" <?php echo !$is_valid_book ? 'disabled' : ''; ?>>
                        <i class="fa-solid fa-check"></i> Place Order
                    </button>

                </form>
            </div>
        </div>
    </div>
<?php include("footer.php"); ?>