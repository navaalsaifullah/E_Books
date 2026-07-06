<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../site_settings.php';
}
?>

<footer class="footer-section text-center text-white mt-5">

    <div class="container">

        <h3 class="mb-3"><?php echo SITE_FOOTER_NAME; ?></h3>

        <p>
            Read your favorite books anytime anywhere.
            Explore knowledge with our modern E-Books platform.
        </p>

        <div class="social-icons mt-4">

            <a href="#"><i class="fab fa-facebook-f"></i></a>

            <a href="#"><i class="fab fa-instagram"></i></a>

            <a href="#"><i class="fab fa-twitter"></i></a>

            <a href="#"><i class="fab fa-linkedin-in"></i></a>

        </div>

        <hr class="bg-light mt-4">

        <p class="mb-0">
            © <?php echo date('Y'); ?> <?php echo SITE_FOOTER_NAME; ?> | All Rights Reserved
        </p>

    </div>

</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>