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
                <h2 class="h5 no-margin-bottom">VIEW COMPETITIONS</h2>
            </div>
        </div>

        <section class="no-padding-top no-padding-bottom">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="block margin-bottom-sm table">
                            <div class="title"><strong>Competitions Table</strong></div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Book Title</th>
                                            <th>Image</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $selectQuery = "SELECT * FROM competitions";
                                        $data = mysqli_query($connection, $selectQuery);
                                        foreach ($data as $row) {
                                        ?>
                                            <tr>
                                                <td><?php echo $row['Id'] ?></td>
                                                <td><?php echo $row['Book_Title'] ?></td>
                                                <td>
                                                    <img src="img/books/<?php echo $row['Image'] ?>" width="50" alt="Book Cover">
                                                </td>
                                                <td>
                                                    <a href="./edit_competition.php?id=<?php echo $row['Id'] ?>" class="btn btn-sm btn-success">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <a href="./delete_competition.php?id=<?php echo $row['Id'] ?>"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this competition?');">
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
            </div>
        </section>

        <?php include("footer.php"); ?>
    </div>
</div>