<?php
require_once 'auth.php';
include("../config.php");

$books_result = mysqli_query($connection, "SELECT COUNT(*) AS total FROM books");
$total_books = mysqli_fetch_assoc($books_result)['total'];

$users_result = mysqli_query($connection, "SELECT COUNT(*) AS total FROM users");
$total_users = mysqli_fetch_assoc($users_result)['total'];

$competitions_result = mysqli_query($connection, "SELECT COUNT(*) AS total FROM competitions");
$total_competitions = mysqli_fetch_assoc($competitions_result)['total'];

$readers_result = mysqli_query($connection, "SELECT COUNT(*) AS total FROM orders");
$total_orders = mysqli_fetch_assoc($readers_result)['total'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo site_logo_path(true); ?>">
    <title><?php echo page_title('About'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="about.css?v=2">
    <link rel="stylesheet" href="headfoot.css?v=5">
</head>

<body>
    <?php include("header.php"); ?>

    <div class="about-page about-section">

        <!-- Page Header -->
        <section class="page-header">
            <div class="container">
                <h1 class="about-heading">About <?php echo SITE_NAME; ?></h1>
                <p class="about-text">Your digital gateway to knowledge — read, learn, and grow with thousands of e-books at your fingertips.</p>
            </div>
        </section>

        <!-- Intro -->
        <section class="container pb-5">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=1200&auto=format&fit=crop"
                        class="about-intro-img" alt="Reading e-books">
                </div>
                <div class="col-lg-6">
                    <span class="about-badge"><i class="fas fa-book-open me-1"></i> Who We Are</span>
                    <h2 class="section-title">Our E-Books Store</h2>
                    <p class="about-text">
                        <?php echo SITE_FOOTER_NAME; ?> is built for students, professionals, and book lovers who want instant access to quality digital content. From fiction to educational resources, we bring the library to your screen.
                    </p>
                    <p class="about-text">
                        Browse our collection, save favorites to your wishlist, join writing competitions, and download books anytime — all in one seamless experience.
                    </p>
                    <a href="books.php" class="about-btn">Explore Library</a>
                    <a href="competitions.php" class="about-btn about-btn-outline">Join Competitions</a>
                </div>
            </div>
        </section>

        <!-- Mission / Vision / Values -->
        <section class="container pb-5">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="mv-card">
                        <h4><i class="fas fa-bullseye me-2" style="color:#99d98c;"></i> Our Mission</h4>
                        <p>To make reading affordable, accessible, and enjoyable for everyone through a smart and user-friendly e-books platform.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mv-card">
                        <h4><i class="fas fa-eye me-2" style="color:#99d98c;"></i> Our Vision</h4>
                        <p>To become the most trusted digital reading community where learners and writers connect, grow, and share knowledge.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mv-card">
                        <h4><i class="fas fa-heart me-2" style="color:#99d98c;"></i> Our Values</h4>
                        <p>Quality content, secure access, reader-first design, and continuous innovation in digital publishing and education.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features -->
        <section class="container pb-5">
            <div class="text-center mb-5">
                <h2 class="section-title">Why Readers Love Us</h2>
                <p class="section-subtitle mx-auto" style="max-width:600px;">Everything you need for a complete digital reading experience.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-book"></i></div>
                        <h5>Huge Collection</h5>
                        <p>Thousands of e-books across fiction, education, history, and more categories.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-download"></i></div>
                        <h5>Easy Downloads</h5>
                        <p>Download and read your favorite books instantly on any device, anywhere.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-trophy"></i></div>
                        <h5>Competitions</h5>
                        <p>Participate in writing contests, showcase your talent, and win recognition.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-shield-halved"></i></div>
                        <h5>Secure Access</h5>
                        <p>Your account, orders, and personal data are protected with secure login.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats -->
        <section class="container pb-5">
            <div class="row g-4 text-center">
                <div class="col-6 col-md-3">
                    <div class="bg-white p-4 card-stat h-100">
                        <div class="stat-icon-wrap mx-auto d-flex align-items-center justify-content-center mb-3">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </div>
                        <h2 class="fw-bold text-dark counter" data-target="<?php echo $total_orders; ?>">0</h2>
                        <p class="text-uppercase text-muted small fw-bold mt-1">Orders</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="bg-white p-4 card-stat h-100">
                        <div class="stat-icon-wrap mx-auto d-flex align-items-center justify-content-center mb-3">
                            <i class="fa-solid fa-book"></i>
                        </div>
                        <h2 class="fw-bold text-dark counter" data-target="<?php echo $total_books; ?>">0</h2>
                        <p class="text-uppercase text-muted small fw-bold mt-1">Books</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="bg-white p-4 card-stat h-100">
                        <div class="stat-icon-wrap mx-auto d-flex align-items-center justify-content-center mb-3">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <h2 class="fw-bold text-dark counter" data-target="<?php echo $total_users; ?>">0</h2>
                        <p class="text-uppercase text-muted small fw-bold mt-1">Readers</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="bg-white p-4 card-stat h-100">
                        <div class="stat-icon-wrap mx-auto d-flex align-items-center justify-content-center mb-3">
                            <i class="fa-solid fa-trophy"></i>
                        </div>
                        <h2 class="fw-bold text-dark counter" data-target="<?php echo $total_competitions; ?>">0</h2>
                        <p class="text-uppercase text-muted small fw-bold mt-1">Competitions</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="container pb-5">
            <div class="about-cta">
                <h3>Start Your Reading Journey Today</h3>
                <p>Discover new books, build your wishlist, and join our growing community of readers.</p>
                <a href="books.php" class="about-btn">Browse Books Now</a>
            </div>
        </section>

    </div>

    <script>
        function animateCounter(element, target, duration = 800) {
            let startTime = null;
            function step(currentTime) {
                if (!startTime) startTime = currentTime;
                const percentage = Math.min((currentTime - startTime) / duration, 1);
                element.textContent = Math.floor(percentage * target);
                if (percentage < 1) requestAnimationFrame(step);
                else element.textContent = target;
            }
            requestAnimationFrame(step);
        }
        window.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll(".counter").forEach(counter => {
                animateCounter(counter, parseInt(counter.getAttribute("data-target")) || 0);
            });
        });
    </script>

<?php include("footer.php"); ?>
