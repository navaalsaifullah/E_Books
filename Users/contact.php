<?php
require_once 'auth.php';

$formSuccess = false;
$formErrors = [];
$formData = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'subject' => '',
    'message' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData['name'] = trim($_POST['name'] ?? '');
    $formData['email'] = trim($_POST['email'] ?? '');
    $formData['phone'] = trim($_POST['phone'] ?? '');
    $formData['subject'] = trim($_POST['subject'] ?? '');
    $formData['message'] = trim($_POST['message'] ?? '');

    if ($formData['name'] === '') {
        $formErrors['name'] = 'Name is required.';
    } elseif (strlen($formData['name']) < 2) {
        $formErrors['name'] = 'Name must be at least 2 characters.';
    } elseif (!preg_match("/^[a-zA-Z\s.'-]+$/u", $formData['name'])) {
        $formErrors['name'] = 'Name can only contain letters and spaces.';
    }

    if ($formData['email'] === '') {
        $formErrors['email'] = 'Email is required.';
    } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $formErrors['email'] = 'Please enter a valid email address.';
    }

    if ($formData['phone'] !== '' && !preg_match('/^[0-9+\-\s()]{7,20}$/', $formData['phone'])) {
        $formErrors['phone'] = 'Please enter a valid phone number.';
    }

    if ($formData['subject'] === '') {
        $formErrors['subject'] = 'Subject is required.';
    } elseif (strlen($formData['subject']) < 3) {
        $formErrors['subject'] = 'Subject must be at least 3 characters.';
    }

    if ($formData['message'] === '') {
        $formErrors['message'] = 'Message is required.';
    } elseif (strlen($formData['message']) < 10) {
        $formErrors['message'] = 'Message must be at least 10 characters.';
    } elseif (strlen($formData['message']) > 500) {
        $formErrors['message'] = 'Message cannot exceed 500 characters.';
    }

    if (empty($formErrors)) {
        $formSuccess = true;
        $formData = ['name' => '', 'email' => '', 'phone' => '', 'subject' => '', 'message' => ''];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo site_logo_path(true); ?>">
    <title><?php echo page_title('Contact'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="contact.css?v=2">
    <link rel="stylesheet" href="headfoot.css?v=5">
</head>

<body>
    <?php include("header.php"); ?>

    <div class="contact-page">

        <section class="contact-hero">
            <div class="container">
                <h1>Contact Us</h1>
                <p>Have a question about books, orders, or competitions? We are here to help.</p>
            </div>
        </section>

        <section class="container py-5">
            <div class="row g-4 mb-4">
                <div class="col-md-6 col-lg-3">
                    <div class="info-card">
                        <div class="info-icon"><i class="fas fa-location-dot"></i></div>
                        <div>
                            <h6>Our Location</h6>
                            <p>Saddar, Karachi, Sindh, Pakistan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="info-card">
                        <div class="info-icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <h6>Email Us</h6>
                            <p>support@ebooks.com</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="info-card">
                        <div class="info-icon"><i class="fas fa-phone"></i></div>
                        <div>
                            <h6>Call Us</h6>
                            <p>+92 300 1234567</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="info-card">
                        <div class="info-icon"><i class="fas fa-clock"></i></div>
                        <div>
                            <h6>Working Hours</h6>
                            <p>Mon – Sat: 9:00 AM – 6:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="contact-form-box">
                        <h4><i class="fas fa-paper-plane me-2" style="color:#99d98c;"></i>Send a Message</h4>

                        <?php if ($formSuccess): ?>
                            <div class="alert-success-custom mb-4">
                                <i class="fas fa-check-circle me-2"></i>
                                Thank you! Your message has been sent successfully. We will get back to you soon.
                            </div>
                        <?php endif; ?>

                        <form class="contact-form needs-validation" method="POST" action="contact.php" novalidate id="contactForm">
                            <div class="mb-3">
                                <label class="form-label" for="name">Full Name *</label>
                                <input type="text" class="form-control <?php echo isset($formErrors['name']) ? 'is-invalid' : (($_SERVER['REQUEST_METHOD'] === 'POST' && $formData['name'] !== '') ? 'is-valid' : ''); ?>"
                                    id="name" name="name" placeholder="Enter your full name"
                                    value="<?php echo htmlspecialchars($formData['name']); ?>"
                                    minlength="2" maxlength="60" required
                                    pattern="[A-Za-z\s.'-]+">
                                <div class="invalid-feedback"><?php echo $formErrors['name'] ?? 'Please enter a valid name (letters only, min 2 characters).'; ?></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="email">Email Address *</label>
                                <input type="email" class="form-control <?php echo isset($formErrors['email']) ? 'is-invalid' : (($_SERVER['REQUEST_METHOD'] === 'POST' && $formData['email'] !== '') ? 'is-valid' : ''); ?>"
                                    id="email" name="email" placeholder="you@example.com"
                                    value="<?php echo htmlspecialchars($formData['email']); ?>" required>
                                <div class="invalid-feedback"><?php echo $formErrors['email'] ?? 'Please enter a valid email address.'; ?></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="phone">Phone Number <span class="text-muted">(Optional)</span></label>
                                <input type="tel" class="form-control <?php echo isset($formErrors['phone']) ? 'is-invalid' : ''; ?>"
                                    id="phone" name="phone" placeholder="+92 300 1234567"
                                    value="<?php echo htmlspecialchars($formData['phone']); ?>"
                                    pattern="[0-9+\-\s()]{7,20}">
                                <div class="invalid-feedback"><?php echo $formErrors['phone'] ?? 'Please enter a valid phone number.'; ?></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="subject">Subject *</label>
                                <input type="text" class="form-control <?php echo isset($formErrors['subject']) ? 'is-invalid' : (($_SERVER['REQUEST_METHOD'] === 'POST' && $formData['subject'] !== '') ? 'is-valid' : ''); ?>"
                                    id="subject" name="subject" placeholder="How can we help you?"
                                    value="<?php echo htmlspecialchars($formData['subject']); ?>"
                                    minlength="3" maxlength="100" required>
                                <div class="invalid-feedback"><?php echo $formErrors['subject'] ?? 'Subject must be at least 3 characters.'; ?></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="message">Your Message *</label>
                                <textarea class="form-control <?php echo isset($formErrors['message']) ? 'is-invalid' : (($_SERVER['REQUEST_METHOD'] === 'POST' && $formData['message'] !== '') ? 'is-valid' : ''); ?>"
                                    id="message" name="message" rows="5"
                                    placeholder="Write your message here..."
                                    minlength="10" maxlength="500" required><?php echo htmlspecialchars($formData['message']); ?></textarea>
                                <div class="d-flex justify-content-between">
                                    <div class="invalid-feedback d-block"><?php echo $formErrors['message'] ?? 'Message must be between 10 and 500 characters.'; ?></div>
                                    <small class="text-muted ms-auto"><span id="charCount">0</span>/500</small>
                                </div>
                            </div>

                            <button type="submit" class="contact-btn" id="submitBtn">
                                <i class="fas fa-paper-plane me-2"></i>Send Message
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-6 d-flex flex-column">
                    <h4 class="contact-heading fs-4 mb-2">
                        <i class="fas fa-map-location-dot me-2"></i>Find Us on Map
                    </h4>
                    <p class="text-muted small mb-3">Live location — Saddar, Karachi, Pakistan</p>
                    <div id="contactMap"></div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        // Leaflet live map — OpenStreetMap (Karachi, Saddar)
        const storeLat = 24.8572;
        const storeLng = 67.0011;

        const map = L.map('contactMap').setView([storeLat, storeLng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        const storeIcon = L.divIcon({
            className: 'custom-map-marker',
            html: '<div style="background:#99d98c;width:36px;height:36px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);border:3px solid #fff;box-shadow:0 3px 10px rgba(0,0,0,0.3);"></div>',
            iconSize: [36, 36],
            iconAnchor: [18, 36],
            popupAnchor: [0, -36]
        });

        L.marker([storeLat, storeLng], { icon: storeIcon })
            .addTo(map)
            .bindPopup('<strong><?php echo SITE_NAME; ?></strong><br>Saddar, Karachi, Pakistan<br><small>Click &amp; drag map to explore</small>')
            .openPopup();

        setTimeout(() => map.invalidateSize(), 300);

        // Form validation
        const form = document.getElementById('contactForm');
        const messageField = document.getElementById('message');
        const charCount = document.getElementById('charCount');

        function updateCharCount() {
            charCount.textContent = messageField.value.length;
        }
        messageField.addEventListener('input', updateCharCount);
        updateCharCount();

        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });

        // Real-time validation on blur
        form.querySelectorAll('input, textarea').forEach(field => {
            field.addEventListener('blur', () => {
                if (field.value.trim() !== '' || field.hasAttribute('required')) {
                    field.classList.toggle('is-valid', field.checkValidity());
                    field.classList.toggle('is-invalid', !field.checkValidity());
                }
            });
        });
    </script>

<?php include("footer.php"); ?>
