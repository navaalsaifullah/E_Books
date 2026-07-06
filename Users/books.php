<?php
require_once 'auth.php';
include('connection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo site_logo_path(true); ?>">
    <title><?php echo page_title('Books'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="books.css">
    <link rel="stylesheet" href="headfoot.css?v=4">
</head>

<body>
    <?php include("header.php"); ?>

    <div class="books-page">
        <div class="hero">
            <h1 class="page-title">Ebooks Collection</h1>
            <p class="subtitle">Read, learn and explore thousands of ebooks online</p>
        </div>

        <div class="myContainer">
            <form class="search-box" method="GET">
                <div class="input-box">
                    <i class="fa fa-search"></i>
                    <input type="text" name="search" placeholder="Search books..." value="<?php echo htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="input-box">
                    <i class="fa fa-layer-group"></i>
                    <select name="category">
                        <option value="" <?php echo empty($_GET['category']) ? 'selected' : ''; ?>>All Categories</option>
                        <option value="fiction" <?php echo ($_GET['category'] ?? '') === 'fiction' ? 'selected' : ''; ?>>Fiction</option>
                        <option value="non-fiction" <?php echo ($_GET['category'] ?? '') === 'non-fiction' ? 'selected' : ''; ?>>Non-Fiction</option>
                        <option value="history" <?php echo ($_GET['category'] ?? '') === 'history' ? 'selected' : ''; ?>>History</option>
                        <option value="education" <?php echo ($_GET['category'] ?? '') === 'education' ? 'selected' : ''; ?>>Education</option>
                        <option value="fantasy" <?php echo ($_GET['category'] ?? '') === 'fantasy' ? 'selected' : ''; ?>>Fantasy</option>
                        <option value="personal-development" <?php echo ($_GET['category'] ?? '') === 'personal-development' ? 'selected' : ''; ?>>Personal Development</option>
                        <option value="mystery-and-thriller" <?php echo ($_GET['category'] ?? '') === 'mystery-and-thriller' ? 'selected' : ''; ?>>Mystery & Thriller</option>
                        <option value="biography" <?php echo ($_GET['category'] ?? '') === 'biography' ? 'selected' : ''; ?>>Biography</option>
                    </select>
                </div>
                <button type="submit">Search</button>
            </form>

            <div class="books">
                <?php
                $search = $_GET['search'] ?? '';
                $category = $_GET['category'] ?? '';

                $query = "SELECT * FROM books WHERE 1=1";
                $params = [];
                $types = "";

                if ($search != "") {
                    $query .= " AND Book_Title LIKE ?";
                    $params[] = "%" . $search . "%";
                    $types .= "s";
                }
                if ($category != "") {
                    $query .= " AND Category = ?";
                    $params[] = $category;
                    $types .= "s";
                }

                $stmt = mysqli_prepare($connection, $query);
                if ($stmt) {
                    if (!empty($params)) {
                        mysqli_stmt_bind_param($stmt, $types, ...$params);
                    }
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $imagePath = '../Admin/img/books/' . $row['Image'];
                ?>
                        <div class="card">
                            <span class="badge"><?php echo htmlspecialchars($row['Category'] ?? $row['category']); ?></span>
                            <div class="image-box">
                                <img src="<?php echo htmlspecialchars($imagePath, ENT_QUOTES, 'UTF-8'); ?>" alt="Book Cover">
                            </div>
                            <div class="card-body">
                                <h3><?php echo htmlspecialchars($row['Book_Title']); ?></h3>
                                <p class="author"><i class="fa fa-user"></i> <?php echo htmlspecialchars($row['Author'] ?? $row['author']); ?></p>
                                <p class="price"><i class="fa-solid fa-tag"></i> Rs <?php echo htmlspecialchars($row['Price'] ?? $row['price']); ?></p>
                                <p class="description">
                                    <?php 
                                    $desc = $row['Description'] ?? $row['description'];
                                    echo htmlspecialchars(substr($desc, 0, 75)) . '...'; 
                                    ?>
                                </p>
                                <div class="card-buttons">
                                    <a href="bookdetails.php?id=<?php echo urlencode($row['Id']); ?>" class="btn">View Details</a>
                                    <a href="cart.php?id=<?php echo urlencode($row['Id']); ?>" class="cart-btn">🛒 Add To Cart</a>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                    mysqli_stmt_close($stmt);
                }
                ?>
            </div>
        </div>
    </div>
    <?php include("footer.php"); ?>