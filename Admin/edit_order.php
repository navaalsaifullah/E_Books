<?php
session_start();
include("../config.php");

if (!isset($_SESSION['n']) || !isset($_SESSION['p'])) {
    header("Location: login.php");
    exit();
}

// 1. UPDATE LOGIC: Runs when the "Update Order" button is clicked
if (isset($_POST['edit_orderbtn'])) {
    $id = mysqli_real_escape_string($connection, $_POST['id']);
    $user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
    $book_id = mysqli_real_escape_string($connection, $_POST['book_id']);
    $payment_status = mysqli_real_escape_string($connection, $_POST['payment_status']);
    $delivery_mode = mysqli_real_escape_string($connection, $_POST['delivery_mode']);

    $updateQuery = "UPDATE `orders` SET 
                    user_id='$user_id', 
                    book_id='$book_id', 
                    payment_status='$payment_status', 
                    delivery_mode='$delivery_mode' 
                    WHERE id='$id'";

    if (mysqli_query($connection, $updateQuery)) {
        echo "<script>alert('Order Updated Successfully'); window.location.href='vieworders.php';</script>";
        exit(); 
    } else {
        echo "Error updating record: " . mysqli_error($connection);
    }
}

// 2. FETCH LOGIC: Get current order data to show in the form
$order = []; 
if (isset($_GET['id'])) {
    $updateId = mysqli_real_escape_string($connection, $_GET['id']);
    $fetchQuery = "SELECT * FROM `orders` WHERE id = '$updateId'";
    $result = mysqli_query($connection, $fetchQuery);
    
    if (mysqli_num_rows($result) > 0) {
        $order = mysqli_fetch_assoc($result);
    } else {
        echo "Order not found.";
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
                <h2 class="h5 no-margin-bottom">EDIT ORDER</h2>
            </div>
        </div>

        <section class="no-padding-top no-padding-bottom">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 col-md-12 offset-lg-3">
                        <div class="block">
                            <div class="title"><strong class="d-block text-center">Edit Order Form</strong></div>
                            <div class="block-body">
                                
                                <form method="post">
                                    <input type="hidden" name="id" value="<?php echo $order['id'] ?? ''; ?>">

                                    <div class="form-group">
                                        <label class="form-control-label">User</label>
                                        <select name="user_id" class="form-control">
                                            <?php
                                            $users = mysqli_query($connection, "SELECT id, name FROM users");
                                            while($u = mysqli_fetch_assoc($users)) {
                                                $selected = ($u['id'] == $order['user_id']) ? "selected" : "";
                                                echo "<option value='".$u['id']."' $selected>".$u['name']."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label">Book</label>
                                        <select name="book_id" class="form-control">
                                            <?php
                                            $books = mysqli_query($connection, "SELECT Id, Book_Title FROM books");
                                            while($b = mysqli_fetch_assoc($books)) {
                                                $selected = ($b['Id'] == $order['book_id']) ? "selected" : "";
                                                echo "<option value='".$b['Id']."' $selected>".$b['Book_Title']."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label">Payment Status</label>
                                        <select name="payment_status" class="form-control">
                                            <option value="pending" <?php echo ($order['payment_status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                            <option value="paid" <?php echo ($order['payment_status'] == 'paid') ? 'selected' : ''; ?>>Paid</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label">Delivery Mode</label>
                                        <select name="delivery_mode" class="form-control">
                                            <option value="standard" <?php echo ($order['delivery_mode'] == 'standard') ? 'selected' : ''; ?>>Standard</option>
                                            <option value="express" <?php echo ($order['delivery_mode'] == 'express') ? 'selected' : ''; ?>>Express</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" value="Update Order" class="btn btn-primary btn-block" name="edit_orderbtn">
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php include("footer.php"); ?>