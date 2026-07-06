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
    <!-- Sidebar Navigation-->
    <?php
    include("sidebar.php")
    ?>
    <!-- Sidebar Navigation end-->
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h2 class="h5 no-margin-bottom">VIEW BOOKS</h2>
            </div>
        </div>
        <section class="no-padding-top no-padding-bottom">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="block margin-bottom-sm table">
                            <div class="title"><strong>Books Table</strong></div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Book Title</th>
                                            <th>Author</th>
                                            <th>PDF Link</th>
                                            <th>Price</th>
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th>Image</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $selectQuery = "SELECT * FROM books";
                                        $data = mysqli_query($connection, $selectQuery);
                                        foreach ($data as $row) {
                                        ?>
                                            <tr>
                                                <td><?php echo $row['Id'] ?></td>
                                                <td><?php echo $row['Book_Title'] ?></td>
                                                <td><?php echo $row['Author'] ?></td>
                                                <td>
                                                    <a href="<?php echo $row['PDF_Link'] ?>" target="_blank" class="btn btn-sm pdf-btn ">View PDF</a>
                                                </td>
                                                <td><?php echo $row['Price'] ?></td>
                                                <td><?php echo $row['Category'] ?></td>
                                                <td><?php echo $row['Description'] ?></td>
                                                <td>
                                                    <img src="img/books/<?php echo $row['Image'] ?>" width="50" alt="">
                                                </td>
                                               <td style="display: flex; gap: 4px;">
                                                    <a href="./edit_book.php?id=<?php echo $row['Id'] ?>" class="btn btn-sm btn-success">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <a href="./delete_book.php?id=<?php echo $row['Id'] ?>"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this book?');">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
        </section>


        <?php
        include("footer.php");
        ?>