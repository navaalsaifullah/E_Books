<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../site_settings.php';
?>
<nav class="navbar navbar-expand-lg custom-navbar py-0">
    <div class="container">

        <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
            <img src="<?php echo site_logo_path(true); ?>" alt="<?php echo SITE_NAME; ?> Logo" class="site-logo">
            <span><?php echo SITE_NAME; ?></span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <i class="fas fa-house me-1"></i> Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="about.php">
                        <i class="fas fa-circle-info me-1"></i> About
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="contact.php">
                        <i class="fas fa-envelope me-1"></i> Contact
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="books.php">
                        <i class="fas fa-book me-1"></i> Books
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="competitions.php">
                        <i class="fas fa-trophy me-1"></i> Competitions
                    </a>
                </li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="wishlist.php">
                            <i class="fas fa-heart me-1"></i> Wishlist
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">
                            <i class="fas fa-cart-shopping me-1"></i> Cart
                        </a>
                    </li>
                    <li class="nav-item ms-2">
                        <span class="navbar-text text-white fw-semibold me-2">
                            Hi, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-sm btn-outline-light ms-2 px-3 rounded-pill" href="logout.php">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-sm btn-light text-success fw-bold ms-2 px-3 rounded-pill" href="signup.php" style="color:#99d98c !important;">
                            Register
                        </a>
                    </li>
                <?php endif; ?>

            </ul>

        </div>

    </div>
</nav>