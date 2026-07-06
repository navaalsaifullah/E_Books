<?php
require_once 'auth.php';

/* =========================
   DATABASE CONNECTION
========================= */
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'ebooks';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

/* =========================
   FETCH COMPETITIONS (Active Only)
========================= */
// We select created_at to calculate dynamic remaining time limits per row
$books_query = "SELECT Id, Book_Title, Image, created_at FROM competitions ORDER BY created_at DESC";
$books_result = $conn->query($books_query);

$db_books = [];
$current_time = time(); // Target system execution time

if ($books_result && $books_result->num_rows > 0) {

    while ($row = $books_result->fetch_assoc()) {
        
        // Convert SQL datetime value safely into seconds
        $created_timestamp = strtotime($row['created_at']);
        
        // Maximum active lifespan threshold rule configuration: 2 hours (7200 seconds)
        $expiry_timestamp = $created_timestamp + 7200;
        
        // Remaining time available right now
        $remaining_seconds = $expiry_timestamp - $current_time;

        // CRITICAL: If 2 hours have already completed, exclude it completely from loading
        if ($remaining_seconds <= 0) {
            continue; 
        }

        $imagePath = '../Admin/img/books/' . $row['Image'];

        $db_books[] = [
            'id'   => intval($row['Id']),
            't'    => $row['Book_Title'],
            'i'    => $imagePath,
            'c'    => 'Competition',
            'time' => $remaining_seconds
        ];
    }
}
?>

<?php include('connection.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo site_logo_path(true); ?>">
    <title><?php echo page_title('Competitions'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="competitions.css">
    <link rel="stylesheet" href="headfoot.css?v=4">
</head>

<body>
    <?php include("header.php"); ?>

    <?php if (isset($_POST['story_content']) && !empty($_POST['story_content'])): ?>
        <?php
        // Form Processing Execution Block
        $competition_id   = intval($_POST['competition_id']);
        $competition_name = $conn->real_escape_string(trim($_POST['book_title']));
        $essay_story      = $conn->real_escape_string(trim($_POST['story_content']));
        $participant_id   = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

        $insert_query = "INSERT INTO participants (participant_id, competition_id, competition_name, essay_story) 
                         VALUES ('$participant_id', '$competition_id', '$competition_name', '$essay_story')";
        
        $conn->query($insert_query);
        ?>
        
        <div class="success-screen d-flex align-items-center justify-content-center" style="height: 100vh; background-color: #f8f9fa;">
            <div class="text-center">
                <h1 class="text-success fw-bold display-3">Submitted Successfully</h1>
                <p class="text-muted">Returning to Home Page shortly...</p>
            </div>
        </div>

        <script>
            setTimeout(function() {
                window.location.href = 'competitions.php';
            }, 3000);
        </script>

    <?php else: ?>

        <div class="hero fw-bold text-center py-5">
            <h1><i class="fa fa-trophy text-warning me-2"></i> International Writing Competition</h1>
            <p>Select your competition and start writing before the countdown runs dry.</p>
        </div>

        <div class="container mb-5 mt-5">

            <div id="selection-zone">
                <h2 class="text-center mb-5 fw-bold text-dark">Select Your Competition</h2>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="books-container"></div>
            </div>

            <div id="competition-zone" class="competition-zone" style="display:none;">
                <div class="row">

                    <div class="col-lg-4">
                        <div class="text-center">
                            <img id="display-img" src="" class="img-fluid rounded shadow mb-3" style="max-height:350px;width:100%;object-fit:cover;">
                            <h3 id="display-title" class="text-primary mb-3"></h3>
                            <p class="text-danger fw-bold mt-3"><i class="fa-solid fa-triangle-exclamation"></i> Do not refresh the page!</p>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <form id="storyForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="bg-white p-4 rounded shadow">

                            <input type="hidden" name="competition_id" id="hidden-competition-id">
                            <input type="hidden" name="book_title" id="hidden-title">

                            <div class="mb-4">
                                <label class="form-label fw-bold">Competition Title:</label>
                                <input type="text" id="book-title-display" class="form-control form-control-lg" readonly>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Essay / Story:</label>
                                <textarea name="story_content" id="storyContent" rows="18" class="form-control" placeholder="Start writing here..." required></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-lg fw-bold font-weight-bold" style="background-color: #76c893;">SUBMIT STORY</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>

        </div>

        <script>
            const books = <?php echo json_encode($db_books); ?>;
            let globalTimerInterval;
            let activeBookId = null;
            let submittedCleanExit = false;

            /* =========================
                RENDER SELECTION CARDS
            ========================= */
            function renderBooks() {
                const container = document.getElementById('books-container');
                
                if (books.length === 0) {
                    container.innerHTML = `
                        <div class="col-12 text-center py-5">
                            <h4 class="text-muted"><i class="fa-solid fa-hourglass-end me-2"></i> No active competitions available at the moment.</h4>
                        </div>`;
                    return;
                }

                let html = '';
                books.forEach(book => {
                    const escapedTitle = book.t.replace(/'/g, "\\'");
                    html += `
                    <div class="col" id="card-holder-${book.id}">
                        <div class="card book-card shadow-sm h-100" onclick="startCompetition(${book.id}, '${escapedTitle}', '${book.i}')">
                            <span class="badge-category">${book.c}</span>
                            <img src="${book.i}" class="card-img-top" alt="Book Cover" onerror="this.src='https://via.placeholder.com/400x300?text=No+Image+Available'">
                            <div class="card-body text-center d-flex flex-column justify-content-between align-items-center">
                                <h5 class="card-title fw-semibold text-dark my-2">${book.t}</h5>
                                <div>
                                    <div id="card-timer-${book.id}" class="custom-timer-container">--:--:--</div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                });
                container.innerHTML = html;
            }

            /* =========================
                REALTIME TIMING MONITOR
            ========================= */
            function initCardTimers() {
                if (books.length === 0) return;

                globalTimerInterval = setInterval(() => {
                    books.forEach((book, index) => {
                        // Ticks down either global collection or current focused user prompt
                        if (activeBookId === null || book.id === activeBookId) {
                            if (book.time > 0) {
                                book.time--;
                            }

                            // Dynamic Disappearance Processing
                            if (book.time <= 0) {
                                // 1. Smoothly fade out item from display grid
                                const uiCard = document.getElementById(`card-holder-${book.id}`);
                                if (uiCard) {
                                    uiCard.style.transition = "all 0.5s ease";
                                    uiCard.style.opacity = "0";
                                    uiCard.style.transform = "scale(0.9)";
                                    setTimeout(() => {
                                        uiCard.remove();
                                        // Splice out element from global tracked dictionary array map
                                        books.splice(index, 1);
                                        if(books.length === 0 && activeBookId === null) renderBooks();
                                    }, 500);
                                }

                                // 2. If user is inside writing form loop, auto submit progress instantly
                                if (activeBookId !== null && book.id === activeBookId) {
                                    clearInterval(globalTimerInterval);
                                    submittedCleanExit = true;
                                    alert("Time has completely expired for this event! Saving work now.");
                                    document.getElementById('storyForm').submit();
                                }
                                return;
                            }

                            // Rendering structural metrics string
                            let hours = Math.floor(book.time / 3600);
                            let minutes = Math.floor((book.time % 3600) / 60);
                            let seconds = book.time % 60;

                            hours = hours < 10 ? '0' + hours : hours;
                            minutes = minutes < 10 ? '0' + minutes : minutes;
                            seconds = seconds < 10 ? '0' + seconds : seconds;

                            const elementBox = document.getElementById(`card-timer-${book.id}`);
                            if (elementBox) {
                                elementBox.innerHTML = `${hours}:${minutes}:${seconds}`;
                            }
                        }
                    });
                }, 1000);
            }

            renderBooks();
            initCardTimers();

            /* =========================
                START COMPETITION WRITER
            ========================= */
            function startCompetition(bookId, title, imgSrc) {
                const selectedBook = books.find(b => b.id === bookId);
                if (!selectedBook) return;

                if (confirm(`Are you ready to start writing for "${title}"?\nThe countdown will continue synchronously.`)) {
                    activeBookId = bookId;

                    document.getElementById('selection-zone').style.display = 'none';
                    document.getElementById('competition-zone').style.display = 'block';

                    document.getElementById('display-title').innerText = title;
                    document.getElementById('display-img').src = imgSrc;
                    document.getElementById('hidden-title').value = title;
                    document.getElementById('hidden-competition-id').value = bookId;
                    document.getElementById('book-title-display').value = title;

                    window.scrollTo(0, 0);
                }
            }

            // Form Submit tracking
            document.getElementById('storyForm').addEventListener('submit', function() {
                submittedCleanExit = true;
            });

            // Prevent Cheating Hook
            document.getElementById('storyContent').onpaste = function(e) {
                alert("Manual validation active: Copy pasting contents is disabled!");
                return false;
            };

            // Warning prompt if user attempts navigating away mid-timer execution
            window.onbeforeunload = function() {
                if (!submittedCleanExit && document.getElementById('competition-zone').style.display === 'block') {
                    return "Warning: If you leave this viewport your writing changes will be lost permanently!";
                }
            };
        </script>
    <?php endif; ?>
<?php include("footer.php"); ?>