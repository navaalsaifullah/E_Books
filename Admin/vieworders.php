<?php
session_start();
include("../config.php");
if (!isset($_SESSION['n']) || !isset($_SESSION['p'])) {
    header("Location: login.php");
    exit();
}
include("header.php");
?>
<div class="d-flex align-items-stretch">
    <?php include("sidebar.php"); ?>
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h2 class="h5 no-margin-bottom">VIEW ORDERS</h2>
            </div>
        </div>

        <section class="no-padding-top no-padding-bottom">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="block margin-bottom-sm table">
                            <div class="title"><strong>Orders Table</strong></div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>User Name</th>
                                            <th>Book Title</th>
                                            <th>Payment Status</th>
                                            <th>Delivery Mode</th>
                                            <th>Order Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $selectQuery = "SELECT 
                                            orders.id, 
                                            users.name AS user_name, 
                                            books.Book_Title AS book_name, 
                                            orders.payment_status, 
                                            orders.delivery_mode, 
                                            orders.order_date 
                                        FROM orders
                                        JOIN users ON orders.user_id = users.id
                                        JOIN books ON orders.book_id = books.Id";

                                        $data = mysqli_query($connection, $selectQuery);

                                        if ($data && mysqli_num_rows($data) > 0) {
                                            foreach ($data as $row) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $row['id']; ?></td>
                                                    <td><?php echo $row['user_name']; ?></td>
                                                    <td><?php echo $row['book_name']; ?></td>
                                                    <td><?php echo $row['payment_status']; ?></td>
                                                    <td><?php echo $row['delivery_mode']; ?></td>
                                                    <td><?php echo $row['order_date']; ?></td>
                                                    <td>
                                                        <a href="./edit_order.php?id=<?php echo $row['id'] ?>" class="btn btn-sm btn-success">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>

                                                        <a href="./delete_order.php?id=<?php echo $row['id'] ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this?');">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='6' class='text-center'>No orders found.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php include("footer.php"); ?>
    </div>
</div>