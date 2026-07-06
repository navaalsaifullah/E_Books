<?php
require_once 'auth.php';
include('connection.php');

// Get Book ID Securely
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$id) {
    die("Invalid Request");
}

// Prepared Statement
$query = "SELECT * FROM books WHERE Id = ?";
$stmt = mysqli_prepare($connection, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) == 0) {
        die("Book Not Found");
    }

    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
} else {
    die("Database Query Error");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo page_title(htmlspecialchars($row['Book_Title'], ENT_QUOTES, 'UTF-8')); ?></title>
    <link rel="shortcut icon" href="<?php echo site_logo_path(true); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bookdetails.css">
    <link rel="stylesheet" href="headfoot.css?v=4">
</head>
<body>
<?php include("header.php"); ?>

    <div class="bookdetails-page">
        <div class="breadcrumb">
            <a href="books.php">← Back to Ebooks Collection</a>
        </div>

        <div class="container">
            <div class="book-box">

                <div class="left">
                    <?php $imagePath = '../Admin/img/books/' . $row['Image']; ?>
                    <img src="<?php echo htmlspecialchars($imagePath, ENT_QUOTES, 'UTF-8'); ?>" alt="Book Cover">
                </div>

                <div class="right">
                    <h1><?php echo htmlspecialchars($row['Book_Title'], ENT_QUOTES, 'UTF-8'); ?></h1>

                    <div class="rating">
                        ⭐⭐⭐⭐☆ <span>(4.0)</span>
                    </div>

                    <p class="author">
                        <i class="fa-solid fa-user"></i>
                        <?php echo htmlspecialchars($row['Author'] ?? $row['author'], ENT_QUOTES, 'UTF-8'); ?>
                    </p>

                    <p class="category">
                        <i class="fa-solid fa-layer-group"></i>
                        <?php echo htmlspecialchars($row['Category'] ?? $row['category'], ENT_QUOTES, 'UTF-8'); ?>
                    </p>

                    <p class="desc">
                        <span class="description">Description:</span>
                        <?php echo htmlspecialchars($row['Description'] ?? $row['description'], ENT_QUOTES, 'UTF-8'); ?>
                    </p>

                    <p class="price">
                        <i class="fa-solid fa-tag"></i> PKR
                        <?php echo htmlspecialchars($row['Price'] ?? $row['price'], ENT_QUOTES, 'UTF-8'); ?>
                    </p>

                    <div class="meta">
                        <span><i class="fa-solid fa-file"></i> Ebook</span>
                        <span><i class="fa-solid fa-language"></i> English</span>
                        <span><i class="fa-solid fa-shield-halved"></i> Verified</span>
                    </div>

                    <div class="buttons">
                        <?php 
                        $fileLink = $row['PDF_Link'];
                        if (filter_var($fileLink, FILTER_VALIDATE_URL)): 
                        ?>
                            <a href="<?php echo htmlspecialchars($fileLink, ENT_QUOTES, 'UTF-8'); ?>" class="online" target="_blank" rel="noopener noreferrer">
                                <i class="fa-solid fa-book"></i> Read Online
                            </a>
                        <?php endif; ?>

                        <a href="download.php?id=<?php echo urlencode($row['Id']); ?>" class="download" download>
                            <i class="fa-solid fa-download"></i> Download
                        </a>

                        <a href="cart.php?id=<?php echo urlencode($row['Id']); ?>" class="cart-btn">
                            <i class="fa-solid fa-cart-shopping"></i> Add To Cart
                        </a>

                        <a href="wishlist.php?id=<?php echo urlencode($row['Id']); ?>" class="wishlist-btn">
                            <i class="fa-regular fa-heart"></i> Wishlist
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php include("footer.php"); ?>