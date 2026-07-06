<?php
session_start();
include("../config.php");

if (!isset($_SESSION['n']) || !isset($_SESSION['p'])) {
    header("Location: login.php");
    exit();
}

// 1. UPDATE LOGIC: Runs when the "Update Book" button is clicked
if (isset($_POST['edit_bookbtn'])) {
    $id = mysqli_real_escape_string($connection, $_POST['id']);
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $author = mysqli_real_escape_string($connection, $_POST['author']);
    $pdf = mysqli_real_escape_string($connection, $_POST['pdf_link']);
    $price = mysqli_real_escape_string($connection, $_POST['price']);
    $cat = mysqli_real_escape_string($connection, $_POST['category']);
    $desc = mysqli_real_escape_string($connection, $_POST['description']);

    // Image Handling
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp_name, "img/books/" . $image);
        
        $updateQuery = "UPDATE `books` SET Book_Title='$title', Author='$author', PDF_Link='$pdf', Price='$price', Category='$cat', Description='$desc', Image='$image' WHERE Id='$id'";
    } else {
        // Update everything except the image
        $updateQuery = "UPDATE `books` SET Book_Title='$title', Author='$author', PDF_Link='$pdf', Price='$price', Category='$cat', Description='$desc' WHERE Id='$id'";
    }

    if (mysqli_query($connection, $updateQuery)) {
        echo "<script>alert('Book Updated Successfully'); window.location.href='viewbooks.php';</script>";
        exit(); // Stop execution after redirect
    }
}

// 2. FETCH LOGIC: Get current data to show in the form
$book = []; // Initialize to prevent VS Code warnings
if (isset($_GET['id'])) {
    $updateId = mysqli_real_escape_string($connection, $_GET['id']);
    $fetchQuery = "SELECT * FROM `books` WHERE Id = '$updateId'";
    $result = mysqli_query($connection, $fetchQuery);
    
    if (mysqli_num_rows($result) > 0) {
        $book = mysqli_fetch_assoc($result);
    } else {
        echo "Book not found.";
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
                <h2 class="h5 no-margin-bottom">EDIT BOOK</h2>
            </div>
        </div>

        <section class="no-padding-top no-padding-bottom">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 col-md-12 offset-lg-3">
                        <div class="block">
                            <div class="title"><strong class="d-block text-center">Edit Book Form</strong></div>
                            <div class="block-body">
                                
                                <form method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $book['Id'] ?? ''; ?>">

                                    <div class="form-group">
                                        <label class="form-control-label">Book Title</label>
                                        <input type="text" class="form-control" name="title" value="<?php echo $book['Book_Title'] ?? ''; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label">Author</label>
                                        <input type="text" class="form-control" name="author" value="<?php echo $book['Author'] ?? ''; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label">PDF Link</label>
                                        <input type="url" class="form-control" name="pdf_link" value="<?php echo $book['PDF_Link'] ?? ''; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label">Price</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rs.</span>
                                            </div>
                                            <input type="number" class="form-control" name="price" value="<?php echo $book['Price'] ?? ''; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label">Category</label>
                                        <select class="form-control" name="category">
                                            <option value="" disabled>Select Category</option>
                                            <?php
                                            $cats = ["fiction", "non-fiction", "history", "education", "fantasy", "personal-development", "mystery-and-thriller", "biography"];
                                            foreach ($cats as $c) {
                                                $selected = (isset($book['Category']) && strtolower($book['Category']) == $c) ? "selected" : "";
                                                $label = ucwords(str_replace('-', ' ', $c));
                                                echo "<option value='$c' $selected>$label</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label">Description</label>
                                        <textarea class="form-control" name="description" rows="3" style="resize: none;"><?php echo $book['Description'] ?? ''; ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label">Image</label>
                                        <input type="file" class="form-control" name="image">
                                        <small class="text-muted">Current: <?php echo $book['Image'] ?? 'None'; ?></small>
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" value="Update Book" class="btn btn-primary btn-block" name="edit_bookbtn">
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php include("footer.php"); ?>