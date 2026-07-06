<?php
require_once 'auth.php';
$user_id = (int)$_SESSION['user_id'];

include('../config.php'); 

// --- 1. ADD TO WISHLIST LOGIC (From Details Page) ---
if(isset($_GET['id'])){
    $book_id = mysqli_real_escape_string($connection, $_GET['id']);
    
    // Fetch book details
    $book_query = mysqli_query($connection, "SELECT * FROM books WHERE Id = '$book_id'");
    $book_data = mysqli_fetch_assoc($book_query);

    if($book_data){
        $book_name = mysqli_real_escape_string($connection, $book_data['Book_Title']);
        $book_price = $book_data['Price'];
        $book_image = $book_data['Image'];

        // Check if already in wishlist for this user
        $check_wishlist = mysqli_query($connection, "SELECT * FROM `wishlist` WHERE book_name = '$book_name' AND user_id = '$user_id'");
        
        if(mysqli_num_rows($check_wishlist) == 0){
            mysqli_query($connection, "INSERT INTO `wishlist` (user_id, book_name, price, image) VALUES ('$user_id', '$book_name', '$book_price', '$book_image')");
        }
        header('location:wishlist.php');
        exit();
    }
}

// --- 2. ADD TO CART LOGIC (From Wishlist) ---
if(isset($_POST['add_to_cart'])){
   $book_name = mysqli_real_escape_string($connection, $_POST['book_name']);
   $book_price = $_POST['book_price'];
   $book_image = $_POST['book_image'];

   // Find the book ID from name
   $book_info_query = mysqli_query($connection, "SELECT Id FROM books WHERE Book_Title = '$book_name'");
   $book_info = mysqli_fetch_assoc($book_info_query);
   $book_id = $book_info ? (int)$book_info['Id'] : 0;

   $check_cart = mysqli_query($connection, "SELECT * FROM `cart` WHERE book_id = '$book_id' AND user_id = '$user_id'");

   if(mysqli_num_rows($check_cart) > 0){
      mysqli_query($connection, "UPDATE `cart` SET quantity = quantity + 1 WHERE book_id = '$book_id' AND user_id = '$user_id'");
   }else{
      mysqli_query($connection, "INSERT INTO `cart`(user_id, book_id, book_name, price, quantity, image) VALUES('$user_id', '$book_id', '$book_name', '$book_price', 1, '$book_image')");
   }
   header('location:cart.php');
   exit();
}

// --- 3. REMOVE FROM WISHLIST ---
if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   // Protect: make sure user can only delete their own wishlist item
   mysqli_query($connection, "DELETE FROM `wishlist` WHERE id = '$remove_id' AND user_id = '$user_id'");
   header('location:wishlist.php');
   exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="shortcut icon" href="<?php echo site_logo_path(true); ?>">
   <title><?php echo page_title('Wishlist'); ?></title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="style.css">
   <link rel="stylesheet" href="./wishlist.css?v=2">
   <link rel="stylesheet" href="headfoot.css?v=4">
</head>
<body>

<?php include("header.php"); ?>

<div class="wishlist-page">
<div class="container py-4">
   <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="fw-bold page-heading">Saved Books</h3>
      <a href="books.php" class="btn btn-sm shop-btn">Back to Shop</a>
   </div>

   <div class="row g-4">
      <?php
         $select_wishlist = mysqli_query($connection, "SELECT * FROM `wishlist` WHERE user_id = '$user_id' ORDER BY id DESC");
         if(mysqli_num_rows($select_wishlist) > 0){
            while($fetch_wishlist = mysqli_fetch_assoc($select_wishlist)){
      ?>
      <div class="col-md-6 col-lg-3">
         <div class="card wish-card h-100 position-relative">
            <a href="wishlist.php?remove=<?php echo $fetch_wishlist['id']; ?>" class="remove-btn" onclick="return confirm('Remove from wishlist?')">
               <i class="fas fa-times"></i>
            </a>

            <img src="../Admin/img/books/<?php echo $fetch_wishlist['image']; ?>" class="card-img-top book-img" alt="book">

            <div class="card-body text-center d-flex flex-column">
               <h6 class="fw-bold mb-1"><?php echo $fetch_wishlist['book_name']; ?></h6>
               <p class="text-purple fw-bold mb-3">Rs. <?php echo number_format($fetch_wishlist['price']); ?></p>
               
               <form action="" method="post" class="mt-auto">
                  <input type="hidden" name="book_name" value="<?php echo $fetch_wishlist['book_name']; ?>">
                  <input type="hidden" name="book_price" value="<?php echo $fetch_wishlist['price']; ?>">
                  <input type="hidden" name="book_image" value="<?php echo $fetch_wishlist['image']; ?>">
                  <button type="submit" name="add_to_cart" class="btn btn-purple w-100">
                     <i class="fas fa-shopping-basket me-2"></i>Add to Cart
                  </button>
               </form>
            </div>
         </div>
      </div>
      <?php
            }
         } else {
            echo '<div class="col-12 text-center py-5 empty-wishlist">
                    <i class="far fa-heart fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Your wishlist is empty!</h5>
                    <a href="books.php" class="btn btn-purple mt-3 px-4 rounded-pill">Start Shopping</a>
                  </div>';
         }
      ?>
   </div>
</div>
</div>
<?php include("footer.php"); ?>