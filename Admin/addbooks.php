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
        <h2 class="h5 no-margin-bottom">ADD BOOK</h2>
      </div>
    </div>
    <section class="no-padding-top no-padding-bottom">
      <div class="container-fluid">
        <div class="row">

          <!-- Form -->
          <div class="col-lg-6 col-md-12 offset-lg-3">
            <div class="block form">
              <div class="title"><strong class="d-block text-center">Add Book Form</strong>
                <!-- <span class="d-block text-center">Lorem ipsum dolor sit amet consectetur.</span> -->
              </div>
              <div class="block-body">
                <form method="post" enctype="multipart/form-data">

                  <div class="form-group">
                    <label class="form-control-label">Book Title</label>
                    <input type="text" class="form-control" name="title">
                  </div>

                  <div class="form-group">
                    <label class="form-control-label">Author</label>
                    <input type="text" class="form-control" name="author">
                  </div>

                  <div class="form-group">
                    <label class="form-control-label">PDF Link</label>
                    <input type="url" class="form-control" name="pdf_link">
                  </div>

                  <div class="form-group">
                    <label class="form-control-label">Price</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Rs.</span>
                      </div>
                      <input type="number" class="form-control" name="price" placeholder="0.00">
                    </div>
                  </div>

                <div class="form-group">
    <label class="form-control-label">Category</label>
    <select class="form-control" name="category" required>
        <option value="" disabled selected hidden>Select Category</option>
        <option value="fiction">Fiction</option>
        <option value="non-fiction">Non-Fiction</option>
        <option value="history">History</option>
        <option value="education">Education</option>
        <option value="fantasy">Fantasy</option>
        <option value="personal-development">Personal Development</option>
        <option value="mystery-and-thriller">Mystery & Thriller</option>
        <option value="biography">Biography</option>
    </select>
</div>

                  <div class="form-group">
                    <label class="form-control-label">Description</label>
                    <textarea class="form-control" name="description" rows="3" style="resize: none;"></textarea>
                  </div>

                  <div class="form-group">
                    <label class="form-control-label">Image</label>
                    <input type="file" placeholder="Image" class="form-control" name="image">
                  </div>

                  <div class="form-group">
                    <input type="submit" value="Add Book" class="btn btn-primary btn-block" name="addbtn">
                  </div>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <?php
if (isset($_POST['addbtn'])) {
  $title = mysqli_real_escape_string($connection, $_POST['title']);
  $author = mysqli_real_escape_string($connection, $_POST['author']);
  $pdf = mysqli_real_escape_string($connection, $_POST['pdf_link']);
  $price = mysqli_real_escape_string($connection, $_POST['price']);
  $category = mysqli_real_escape_string($connection, $_POST['category'] ?? '');
  $description = mysqli_real_escape_string($connection, $_POST['description']);
  $image = mysqli_real_escape_string($connection, $_FILES['image']['name'] ?? '');
  $tempimage = $_FILES['image']['tmp_name'] ?? '';

  move_uploaded_file($tempimage,'img/books/'.$image);
  $insertQuery = "INSERT INTO `books`(`Book_Title`, `Author`, `PDF_Link`, `Price`, `Category`, `Description`, `Image`) VALUES ('$title','$author','$pdf','$price','$category','$description','$image')";
  $data = mysqli_query($connection,$insertQuery);
  if ($data) {
     echo "<script>alert('Data Is Inserted');
            window.location.href = 'viewbooks.php'
     </script>";
  }
  else{
    echo "<script>alert('Please Check Your Fields');</script>";
  }
}
    ?>

    <?php
    include("footer.php");
    ?>