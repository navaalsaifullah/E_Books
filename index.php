<?php
session_start();

// Logged-in users go straight to the main website
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    header('Location: ./Users/index.php');
    exit();
}

include("config.php");
require_once __DIR__ . '/site_settings.php';

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
  <link rel="shortcut icon" href="<?php echo site_logo_path(false); ?>">
  <title><?php echo page_title(); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./style.css">
  
</head>

<body>

<!-- NAVBAR -->
<nav class="bg-[#99d98c] shadow-sm sticky top-0 z-50 border-bottom">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">

        <a href="index.php" class="flex items-center gap-3 text-decoration-none">
            <img src="<?php echo site_logo_path(false); ?>" class="w-10 h-10" alt="<?php echo SITE_NAME; ?> Logo">
            <span class="text-dark fw-bold text-xl">
                <?php echo SITE_NAME; ?>
            </span>
        </a>

        <div class="flex items-center gap-3">

            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="text-white fw-semibold me-2 d-none d-sm-inline">
                    Hi, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?>
                </span>
                
                <a href="./Users/index.php"
                   class="text-decoration-none text-white fw-semibold rounded-lg px-4 py-2 login-btn"
                   style="border: 2px solid white;">
                    Dashboard
                </a>

                <a href="./Users/logout.php"
                   class="px-4 py-2 rounded fw-semibold text-decoration-none register-btn"
                   style="color:#99d98c; background-color: white;border: 2px solid white;">
                    Logout
                </a>
            <?php else: ?>
                <a href="./Users/login.php"
                   class="text-decoration-none text-white fw-semibold rounded-lg px-4 py-2 login-btn"
                   style="border: 2px solid white;">
                    Login
                </a>

                <a href="./Users/signup.php"
                   class="px-4 py-2 rounded fw-semibold text-decoration-none register-btn"
                   style="color:#99d98c; background-color: white;border: 2px solid white;">
                    Register
                </a>
            <?php endif; ?>

        </div>

    </div>
</nav>

<div id="signupAlert" class="signup-alert">
  <div class="alert-content">
    <span>📚 Join now and get access to free eBooks & latest updates!</span>
    
    <div class="alert-actions">
      <a href="./Users/signup.php" class="btn-signup">Sign Up</a>
      <button class="btn-close" onclick="closeAlert()">✖</button>
    </div>
  </div>
</div>

<section class="hero-section text-center d-flex align-items-center">
    <div class="container">
        <h1 class="display-4 fw-bold">Welcome to <?php echo SITE_FOOTER_NAME; ?></h1>
        <p class="lead">Discover, Read & Download Your Favorite Books Anytime, Anywhere.</p>
        <a href="./Users/signup.php" class="custom-btn mt-3">Explore Books</a>
    </div>
</section>




<!-- FEATURED BOOKS -->
<section class="max-w-7xl mx-auto px-4 py-12">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-4xl font-bold" style="color:#99d98c;">
                Featured Books
            </h2>
            <p class="text-gray-500 mt-2">
                Discover our newest additions and reader favorites.
            </p>
        </div>

        <a href="./Users/signup.php"
           class="hidden md:block px-3 py-2 rounded-xl text-white font-semibold transition hover:scale-105"
           style="background:#99d98c;">
            View All
        </a>
    </div>

    <div class="row g-4">

        <?php while($book=mysqli_fetch_assoc($featured_books)){ ?>

        <div class="col-6 col-md-4 col-lg-3">

        <a href="./Users/signup.php" class="text-decoration-none">
 

                <div class="book-card bg-white overflow-hidden h-100">

                    <!-- IMAGE -->
                    <div class="position-relative overflow-hidden">

                        <img src="./Admin/img/books/<?php echo $book['Image']; ?>"
                             class="w-100 book-image"
                             style="height:340px;object-fit:cover;">

                        <!-- NEW BADGE -->
                        <span class="position-absolute top-0 start-0 m-3 px-3 py-1 rounded-pill text-white fw-bold small"
                              style="background:#99d98c;">
                            Latest Collection
                        </span>

                    

                    </div>

                    <!-- CONTENT -->
                    <div class="p-4">

                        <h5 class="fw-bold text-dark mb-2">
                            <?php echo $book['Book_Title']; ?>
                        </h5>

                        <div class="d-flex align-items-center text-secondary">

                            <i class="fa-solid fa-user-pen me-2"
                               style="color:#99d98c;"></i>

                            <span>
                                <?php echo $book['Author']; ?>
                            </span>

                        </div>

                    </div>

                </div>

            </a>

        </div>

        <?php } ?>

    </div>

</section>



<!-- COMPETITIONS -->
<section class="max-w-7xl mx-auto px-4 py-5">

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

            <a href="./Users/signup.php"
               class="text-decoration-none">

                <div class="card h-100 border-0 shadow-sm book-card">

                    <img src="./Admin/img/books/<?php echo $book['Image']; ?>"
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
        <h2 class="text-center mb-5 fw-bold text-4xl">Why Choose Us?</h2>

        <div class="row g-4 text-center">

            <div class="col-md-3">
                <div class="feature-box h-100">
                    <div class="feature-icon mb-3">📚</div>
                    <h5 class="fw-bold">Huge Collection</h5>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-box h-100">
                    <div class="feature-icon mb-3">⬇️</div>
                    <h5 class="fw-bold">Easy Downloads</h5>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-box h-100">
                    <div class="feature-icon mb-3">🏆</div>
                    <h5 class="fw-bold">Competitions</h5>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-box h-100">
                    <div class="feature-icon mb-3">🔒</div>
                    <h5 class="fw-bold">Secure Access</h5>
                </div>
            </div>

        </div>
    </div>
</section>



<!-- FOOTER -->
<footer class="bg-[#99d98c] border-top mt-5">

    <div class="container py-2">

        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <div>
                <strong>
                  <a href="./index.php">
                    <img src="<?php echo site_logo_path(false); ?>" alt="<?php echo SITE_NAME; ?>" width="70">
                    </a>
                </strong>
            </div>

            <div class="text-white">
                © <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All Rights Reserved.
            </div>

        </div>

    </div>

</footer>

<script>




function showSignupPrompt() {

    if (document.getElementById('signup-toast')) return;

    const toast = document.createElement('div');
    toast.id = 'signup-toast';

    toast.className =
        "fixed bottom-20 right-2 z-50 w-[380px] bg-white rounded-3xl shadow-2xl border border-[#99d98c]/30 overflow-hidden transition-all duration-500 transform translate-y-20 opacity-0";

    toast.innerHTML = `
    
    <!-- Progress Bar -->
    <div class="h-1 bg-gray-100">
        <div id="toast-progress"
             class="h-full bg-[#99d98c] transition-all duration-[7000ms] ease-linear"
             style="width:100%">
        </div>
    </div>

    <div class="p-5">

        <!-- Close -->
        <button
            onclick="closeSignupToast()"
            class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <!-- Icon -->
        <div class="flex items-center gap-4">

            <div class="w-14 h-14 rounded-2xl bg-[#99d98c]/15 flex items-center justify-center">

                <i class="fa-solid fa-book-open text-[#99d98c] text-2xl"></i>

            </div>

            <div>

                <h4 class="font-bold text-gray-800 text-lg">
                    Welcome to E-Books
                </h4>

                <p class="text-xs text-gray-500">
                    Your digital reading companion
                </p>

            </div>

        </div>

        <!-- Content -->
        <div class="mt-4">

            <p class="text-sm text-gray-600 leading-relaxed">
                Discover thousands of books, join competitions,
                save favorites and track your reading journey.
            </p>

        </div>

        <!-- Features -->
        <div class="mt-4 grid grid-cols-2 gap-2">

            <div class="bg-gray-50 rounded-xl p-2 text-xs">
                📚 Unlimited Books
            </div>

            <div class="bg-gray-50 rounded-xl p-2 text-xs">
                🏆 Competitions
            </div>

            <div class="bg-gray-50 rounded-xl p-2 text-xs">
                ❤️ Favorites
            </div>

            <div class="bg-gray-50 rounded-xl p-2 text-xs">
                ☁️ Sync Progress
            </div>

        </div>

        <!-- Buttons -->
        <div class="mt-5 flex gap-3">

            <a href="./Users/signup.php"
               class="flex-1 text-center py-3 rounded-xl font-semibold text-white bg-[#99d98c] hover:scale-105 transition">

                Create Account

            </a>

            <button
                onclick="closeSignupToast()"
                class="px-4 py-3 rounded-xl bg-gray-100 text-gray-700 hover:bg-gray-200 transition">

                Later

            </button>

        </div>

    </div>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.remove('translate-y-20', 'opacity-0');
    }, 100);

    setTimeout(() => {
        const progress = document.getElementById('toast-progress');
        if (progress) {
            progress.style.width = '0%';
        }
    }, 100);

    setTimeout(() => {
        closeSignupToast();
    }, 7000);
}

function closeSignupToast() {

    const toast = document.getElementById('signup-toast');

    if (!toast) return;

    toast.classList.add('translate-y-20', 'opacity-0');

    setTimeout(() => {
        toast.remove();
    }, 500);
}

setTimeout(() => {
    showSignupPrompt();
}, 1000);

function closeAlert() {
  document.getElementById("signupAlert").style.display = "none";
}

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


</body>

</html>