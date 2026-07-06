<?php
require_once 'auth.php';
include("../config.php");
$books_result = mysqli_query($connection, "SELECT COUNT(*) AS total FROM books");
$total_books = mysqli_fetch_assoc($books_result)['total'];

$users_result = mysqli_query($connection, "SELECT COUNT(*) AS total FROM users");
$total_users = mysqli_fetch_assoc($users_result)['total'];

$competitions_result = mysqli_query($connection, "SELECT COUNT(*) AS total FROM competitions");
$total_competitions = mysqli_fetch_assoc($competitions_result)['total'];

// Readers Count (change table name if different)
$readers_result = mysqli_query($connection, "SELECT COUNT(*) AS total FROM orders");
$total_orders = mysqli_fetch_assoc($readers_result)['total'];
?>
<?php

// Featured Books
$featured_books = mysqli_query($connection, "
    SELECT *
    FROM books
    ORDER BY Id DESC
    LIMIT 8
");

// Competition Books
$competition_books = mysqli_query($connection, "
    SELECT *
    FROM competitions
    ORDER BY Id DESC
    LIMIT 4
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo site_logo_path(true); ?>">
    <title><?php echo page_title('Home'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="headfoot.css?v=5">
</head>

<body>
    <?php include("header.php"); ?>

    <section class="position-relative overflow-hidden mt-3" style="height: 350px;">

        <div id="slide-1" class="slider-img position-absolute top-0 start-0 w-100 h-100 opacity-100" style="z-index: 10; transition: opacity 0.5s ease;">
            <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=1600&q=80" class="w-100 h-100" style="object-fit: cover;">
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(255,255,255,0.7);"></div>
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center">
                <div class="container px-4">
                    <h1 class="display-4 fw-bold mt-4 text-dark">
                        Discover Amazing Books
                    </h1>
                    <p class="lead text-secondary">
                        Explore thousands of books from around the world.
                    </p>
                </div>
            </div>
        </div>

        <div id="slide-2" class="slider-img position-absolute top-0 start-0 w-100 h-100 opacity-0" style="z-index: 0; transition: opacity 0.5s ease;">
            <img src="https://images.unsplash.com/photo-1516979187457-637abb4f9353?auto=format&fit=crop&w=1600&q=80" class="w-100 h-100" style="object-fit: cover;">
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(255,255,255,0.7);"></div>
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center">
                <div class="container px-4">
                    <h1 class="display-4 fw-bold text-dark">
                        Learn New Skills
                    </h1>
                    <p class="lead text-secondary">
                        Technology, Design & Programming Resources.
                    </p>
                </div>
            </div>
        </div>

        <div id="slide-3" class="slider-img position-absolute top-0 start-0 w-100 h-100 opacity-0" style="z-index: 0; transition: opacity 0.5s ease;">
            <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1600&q=80" class="w-100 h-100" style="object-fit: cover;">
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(255,255,255,0.7);"></div>
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center">
                <div class="container px-4">
                    <h1 class="display-4 fw-bold text-dark">
                        Build Better Habits
                    </h1>
                    <p class="lead text-secondary">
                        Personal growth and productivity books.
                    </p>
                </div>
            </div>
        </div>

    </section>
    <!-- stats -->
    <section class="container py-5">
        <div class="row g-4 text-center">

            <div class="col-6 col-md-3">
                <div class="bg-white p-4 card-stat h-100">
                    <div class="stat-icon-wrap mx-auto d-flex align-items-center justify-content-center mb-3">
                        <i class="fa-solid fa-bag-shopping text-xl"></i>
                    </div>
                    <h2 class="fw-bold text-dark tracking-tight counter" data-target="<?php echo $total_orders; ?>">0</h2>
                    <p class="text-uppercase text-muted tracking-wider small fw-bold mt-1">Orders</p>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="bg-white p-4 card-stat h-100">
                    <div class="stat-icon-wrap mx-auto d-flex align-items-center justify-content-center mb-3">
                        <i class="fa-solid fa-book text-xl"></i>
                    </div>
                    <h2 class="fw-bold text-dark tracking-tight counter" data-target="<?php echo $total_books; ?>">0</h2>
                    <p class="text-uppercase text-muted tracking-wider small fw-bold mt-1">Books</p>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="bg-white p-4 card-stat h-100">
                    <div class="stat-icon-wrap mx-auto d-flex align-items-center justify-content-center mb-3">
                        <i class="fa-solid fa-users text-xl"></i>
                    </div>
                    <h2 class="fw-bold text-dark tracking-tight counter" data-target="<?php echo $total_users; ?>">0</h2>
                    <p class="text-uppercase text-muted tracking-wider small fw-bold mt-1">Readers</p>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="bg-white p-4 card-stat h-100">
                    <div class="stat-icon-wrap mx-auto d-flex align-items-center justify-content-center mb-3">
                        <i class="fa-solid fa-trophy text-xl"></i>
                    </div>
                    <h2 class="fw-bold text-dark tracking-tight counter" data-target="<?php echo $total_competitions; ?>">0</h2>
                    <p class="text-uppercase text-muted tracking-wider small fw-bold mt-1">Competitions</p>
                </div>
            </div>

        </div>
    </section>
    <section class="py-5 bg-light">
        <div class="container" style="max-width: 800px;">
            <form class="search-box-custom d-flex flex-column flex-md-row gap-3 p-3 bg-white shadow-sm rounded-4" method="GET">
                <div class="input-box-wrap flex-grow-1 position-relative">
                    <i class="fa fa-search position-absolute top-50 start-0 translate-middle-y text-muted ms-3"></i>
                    <input type="text" name="search" class="form-control form-control-lg ps-5 custom-input" placeholder="Search books..." value="<?php echo htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="input-box-wrap min-w-md-200 position-relative">
                    <i class="fa fa-layer-group position-absolute top-50 start-0 translate-middle-y text-muted ms-3"></i>
                    <select name="category" class="form-select form-select-lg ps-5 custom-select">
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
                <button type="submit" class="btn btn-lg px-4 custom-btn text-white fw-bold">Search</button>
            </form>
        </div>
    </section>

    <section class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="display-6 fw-bold" style="color:#99d98c;">
                    <?php echo (!empty($_GET['search']) || !empty($_GET['category'])) ? 'Search Results' : 'Featured Books'; ?>
                </h2>
                <p class="text-muted mt-1">Discover our newest additions and reader favorites.</p>
            </div>
            <a href="signup.php" class="d-none d-md-inline-block px-4 py-2 text-white fw-bold custom-btn rounded-pill" style="text-decoration: none;">
                View All
            </a>
        </div>

        <div class="row g-4">
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

            // Default query fallback if no search parameter exists to populate "Featured Books"
            if ($search == "" && $category == "") {
                $query = "SELECT * FROM books LIMIT 8";
            }

            $stmt = mysqli_prepare($connection, $query);
            if ($stmt) {
                if (!empty($params)) {
                    mysqli_stmt_bind_param($stmt, $types, ...$params);
                }
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0) {
                    while ($book = mysqli_fetch_assoc($result)) {
            ?>
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="signup.php" class="text-decoration-none d-block h-100">
                                <div class="book-card bg-white h-100 shadow-sm overflow-hidden d-flex flex-column">
                                    <div class="position-relative overflow-hidden img-hover-container">
                                        <img src="../Admin/img/books/<?php echo htmlspecialchars($book['Image']); ?>" class="w-100 book-image" style="height:320px; object-fit:cover;">
                                        <span class="position-absolute top-0 start-0 m-3 px-3 py-1 rounded-pill text-white fw-bold badge-category">
                                            <?php echo htmlspecialchars(ucfirst($book['Category'] ?? 'Latest')); ?>
                                        </span>
                                    </div>
                                    <div class="p-3 d-flex flex-column flex-grow-1 justify-content-between">
                                        <h5 class="fw-bold text-dark mb-2 text-truncate-2">
                                            <?php echo htmlspecialchars($book['Book_Title']); ?>
                                        </h5>
                                        <div class="d-flex align-items-center text-secondary small">
                                            <i class="fa-solid fa-user-pen me-2" style="color:#99d98c;"></i>
                                            <span class="text-truncate"><?php echo htmlspecialchars($book['Author']); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
            <?php
                    }
                } else {
                    echo "<div class='col-12 text-center py-5'><p class='text-muted fs-5'>No books found matching your criteria.</p></div>";
                }
                mysqli_stmt_close($stmt);
            }
            ?>
        </div>
    </section>

    <section class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color:#99d98c;">Browse Categories</h2>
            <p class="text-muted">Find books from your favorite genres.</p>
        </div>

        <div class="row g-4">
            <div class="col-6 col-md-3">
                <div class="card text-center p-4 h-100 category-card">
                    <i class="fa-solid fa-book-open fa-3x mb-3" style="color:#99d98c;"></i>
                    <h5 class="fw-bold">Fiction</h5>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card text-center p-4 h-100 category-card">
                    <i class="fa-solid fa-hourglass-half fa-3x mb-3" style="color:#99d98c;"></i>
                    <h5 class="fw-bold">History</h5>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card text-center p-4 h-100 category-card">
                    <i class="fa-solid fa-brain fa-3x mb-3" style="color:#99d98c;"></i>
                    <h5 class="fw-bold">Personal Development</h5>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card text-center p-4 h-100 category-card">
                    <i class="fa-solid fa-wand-sparkles fa-3x mb-3" style="color:#99d98c;"></i>
                    <h5 class="fw-bold">Fantasy</h5>
                </div>
            </div>
        </div>
    </section>

  <!-- COMPETITIONS -->
 <section class="container py-5">

    <div class="mb-5">
        <h2 class="fw-bold text-4xl" style="color:#99d98c;">
            <i class="fa-solid fa-trophy"></i>
            Competitions
        </h2>

        <p class="text-gray-500 mt-2">
            Participate and showcase your writing skills.
        </p>
    </div>

    <div class="row g-4">

        <?php while($book=mysqli_fetch_assoc($competition_books)){ ?>

        <div class="col-md-3">

            <a href="signup.php"
               class="text-decoration-none">

                <div class="card h-100 border-0 shadow-sm book-card">

                    <img src="../Admin/img/books/<?php echo $book['Image']; ?>"
                         class="card-img-top"
                         style="height:320px;object-fit:cover;">

                    <div class="card-body">

                        <h5 class="card-title text-dark">
                            <?php echo $book['Book_Title']; ?>
                        </h5>

                        <p class="text-secondary">
                            Competition Book
                        </p>

                    </div>

                </div>

            </a>

        </div>

        <?php } ?>

    </div>

</section>

    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold">🏆 Previous Competition Winners</h2>
            <div class="row text-center g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="winner-box">
                        <h4 class="fw-bold">🥇 1st Position</h4>
                        <p class="mb-0 text-muted">Ali Khan</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="winner-box">
                        <h4 class="fw-bold">🥈 2nd Position</h4>
                        <p class="mb-0 text-muted">Sara Ahmed</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="winner-box">
                        <h4 class="fw-bold">🥉 3rd Position</h4>
                        <p class="mb-0 text-muted">Ahmed Raza</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container text-center">
            <h2 class="fw-bold">Participate In Various Competitions</h2>
            <p class="text-muted">Essay, Story Writing Competitions</p>
            <a href="./competitions.php">
            <button class="btn btn-primary btn-lg px-4 py-2 mt-2">Join Competition</button></a>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="color:#99d98c;">Why Choose Us?</h2>
            </div>
            <div class="row text-center g-4">
                <div class="col-md-4">
                    <div class="p-3">
                        <i class="fa-solid fa-book fa-3x mb-3" style="color:#99d98c;"></i>
                        <h5 class="fw-bold">Latest Books</h5>
                        <p class="text-muted">Access thousands of books anytime.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3">
                        <i class="fa-solid fa-mobile-screen fa-3x mb-3" style="color:#99d98c;"></i>
                        <h5 class="fw-bold">Read Anywhere</h5>
                        <p class="text-muted">Mobile, tablet and desktop friendly.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3">
                        <i class="fa-solid fa-bolt fa-3x mb-3" style="color:#99d98c;"></i>
                        <h5 class="fw-bold">Fast Access</h5>
                        <p class="text-muted">Instant access to your favorite books.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
        let currentSlide = 1;
        const totalSlides = 3;

        function showSlide(index) {
            for (let i = 1; i <= totalSlides; i++) {
                const slide = document.getElementById(`slide-${i}`);
                if (i === index) {
                    slide.style.opacity = "1";
                    slide.style.zIndex = "10";
                } else {
                    slide.style.opacity = "0";
                    slide.style.zIndex = "0";
                }
            }
        }

        function nextSlide() {
            currentSlide++;
            if (currentSlide > totalSlides) {
                currentSlide = 1;
            }
            showSlide(currentSlide);
        }

        setInterval(nextSlide, 3000);

        function animateCounter(element, target, duration = 800) {
            let start = 0;
            let startTime = null;

            function step(currentTime) {
                if (!startTime) startTime = currentTime;
                const progress = currentTime - startTime;
                const percentage = Math.min(progress / duration, 1);
                const value = Math.floor(percentage * target);
                element.textContent = value;

                if (percentage < 1) {
                    requestAnimationFrame(step);
                } else {
                    element.textContent = target;
                }
            }
            requestAnimationFrame(step);
        }

        window.addEventListener("DOMContentLoaded", () => {
            const counters = document.querySelectorAll(".counter");
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute("data-target")) || 0;
                animateCounter(counter, target);
            });
        });
    </script>

    <?php include('footer.php'); ?>