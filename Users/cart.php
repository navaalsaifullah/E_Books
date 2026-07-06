<?php
require_once 'auth.php';
$user_id = (int)$_SESSION['user_id'];

include('../config.php'); 

// 1. ADD TO CART LOGIC
// Triggered when a user clicks 'Add to Cart' from the details page
if(isset($_GET['id'])){
    $book_id = mysqli_real_escape_string($connection, $_GET['id']);
    
    // Fetch book details from the 'books' table
    $book_query = mysqli_query($connection, "SELECT * FROM books WHERE Id = '$book_id'");
    $book_data = mysqli_fetch_assoc($book_query);

    if($book_data){
        $book_name = mysqli_real_escape_string($connection, $book_data['Book_Title']);
        $book_price = $book_data['Price'];
        $book_image = $book_data['Image'];

        // Check if the book is already in the cart table for this user
        $check_cart = mysqli_query($connection, "SELECT * FROM `cart` WHERE book_id = '$book_id' AND user_id = '$user_id'");
        
        if(mysqli_num_rows($check_cart) > 0){
            // If it exists, increment the quantity
            mysqli_query($connection, "UPDATE `cart` SET quantity = quantity + 1 WHERE book_id = '$book_id' AND user_id = '$user_id'");
        } else {
            // If new, insert with default quantity of 1
            mysqli_query($connection, "INSERT INTO `cart` (user_id, book_id, book_name, price, quantity, image) VALUES ('$user_id', '$book_id', '$book_name', '$book_price', 1, '$book_image')");
        }
        
        // Redirect to clear the GET parameter and prevent duplicate entries on refresh
        header('location:cart.php');
        exit();
    }
}

// 2. UPDATE QUANTITY LOGIC
if(isset($_POST['update_cart_quantity'])){
   $update_id = $_POST['cart_id'];
   $update_qty = $_POST['cart_quantity'];
   
   mysqli_query($connection, "UPDATE `cart` SET quantity = '$update_qty' WHERE id = '$update_id' AND user_id = '$user_id'") or die('Update Failed');
   
   header('location:cart.php');
   exit();
}

// 3. REMOVE ITEM LOGIC
if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($connection, "DELETE FROM `cart` WHERE id = '$remove_id' AND user_id = '$user_id'");
   header('location:cart.php');
   exit();
}

// 4. FETCH CURRENT CART DATA
$select_cart = mysqli_query($connection, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('Query Failed');
$cart_count = mysqli_num_rows($select_cart);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo site_logo_path(true); ?>">
    <title><?php echo page_title('Cart'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="cart.css?v=4">
    <link rel="stylesheet" href="headfoot.css?v=4">
</head>

<body>
    <?php include("header.php"); ?>

<div class="cart-page">
<div class="container py-4">
   <div class="row g-4">
      <div class="col-lg-8">
         <h4 class="fw-bold mb-4">Items in Your Cart</h4>
         <?php 
         $grand_total = 0;
         if($cart_count > 0){
            while($row = mysqli_fetch_assoc($select_cart)){
               $sub_total = ($row['price'] * $row['quantity']);
               $grand_total += $sub_total;
         ?>
         <div class="cart-item-card">
            <div class="row align-items-center g-3">
               <div class="col-auto">
                  <div class="cart-img-container">
                     <img src="../Admin/img/books/<?php echo $row['image']; ?>" class="cart-img" alt="Book">
                  </div>
               </div>

               <div class="col col-md-4">
                  <h6 class="fw-bold mb-1 cart-book-title"><?php echo $row['book_name']; ?></h6>
                  <p class="cart-book-price mb-0">Rs. <?php echo number_format($row['price']); ?></p>
                  <p class="cart-subtotal text-muted small mb-0 mt-1 d-md-none">
                     Subtotal: Rs. <?php echo number_format($sub_total); ?>
                  </p>
               </div>

               <div class="col-12 col-md-4">
                  <form action="" method="POST" class="cart-qty-form">
                     <input type="hidden" name="cart_id" value="<?php echo $row['id']; ?>">
                     <div class="d-flex align-items-center justify-content-between justify-content-md-end gap-3">
                        <span class="cart-qty-label">Quantity</span>
                        <input type="number" name="cart_quantity" class="qty-input"
                               value="<?php echo $row['quantity']; ?>" min="1" max="20"
                               onchange="this.form.submit()">
                        <input type="hidden" name="update_cart_quantity">
                     </div>
                  </form>
               </div>

               <div class="col-auto ms-md-auto">
                  <a href="cart.php?remove=<?php echo $row['id']; ?>" class="remove-btn" title="Remove item" onclick="return confirm('Remove this item?');">
                     <i class="fas fa-trash-alt"></i>
                  </a>
               </div>
            </div>
         </div>
         <?php } } else { ?>
            <div class="empty-cart-card">
               <h5>Your cart is empty!</h5>
               <a href="books.php" class="text-purple">Go back to shop</a>
            </div>
         <?php } ?>
      </div>

      <div class="col-lg-4">
         <div class="checkout-sidebar shadow-sm">
            <h5 class="fw-bold mb-3 border-bottom pb-2">Summary</h5>
            <div class="d-flex justify-content-between mb-2">
               <span>Subtotal:</span>
               <span class="fw-bold">Rs. <?php echo number_format($grand_total); ?></span>
            </div>
            <div class="d-flex justify-content-between h5 fw-bold text-purple mt-3">
               <span>Total:</span>
               <span>Rs. <?php echo number_format($grand_total); ?></span>
            </div>
            <a href="./checkout.php" class="btn btn-purple w-100 py-3 mt-4 rounded-3 fw-bold <?= ($grand_total > 0)?'':'disabled'; ?>">
               PROCEED TO CHECKOUT <i class="fas fa-arrow-right ms-2"></i>
            </a>
            <div class="text-center mt-3">
                <a href="books.php" class="small text-muted" style="text-decoration:none;">Continue Shopping</a>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
<?php include("footer.php"); ?>