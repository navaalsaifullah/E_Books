<?php
require_once 'auth.php';
include('connection.php');

// 1. Get Book ID securely
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$id) {
    die("Invalid Request.");
}

// 2. Fetch the file target from the database
$query = "SELECT Book_Title, PDF_Link FROM books WHERE Id = ?";
$stmt = mysqli_prepare($connection, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) == 0) {
        die("Book not found in database.");
    }

    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    $fileLink = $row['PDF_Link'];
    $bookTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', $row['Book_Title']); // Clean name for file savings

    // 3. Handle REMOTE URL links (Like your Archive.org / Scribd links)
    if (filter_var($fileLink, FILTER_VALIDATE_URL)) {
        
        // Grab headers from remote file to detect file size and format types
        $headers = @get_headers($fileLink, 1);
        $contentType = isset($headers['Content-Type']) ? $headers['Content-Type'] : 'application/pdf';
        
        // Clean up content type arrays if server returns multiple values
        if (is_array($contentType)) {
            $contentType = end($contentType);
        }

        // Send headers forcing an invisible binary file stream transfer 
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $contentType);
        header('Content-Disposition: attachment; filename="' . $bookTitle . '.pdf"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        
        // Output file data cleanly without changing visible user windows
        readfile($fileLink);
        exit;

    } else {
        // 4. Handle LOCAL files (stored inside your local uploads folder)
        $file = basename($fileLink);
        $filepath = "uploads/" . $file;

        if (file_exists($filepath) && !is_dir($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $file . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            
            flush();
            readfile($filepath);
            exit;
        } else {
            die("Error: File configuration error or file does not exist locally.");
        }
    }
} else {
    die("Database Query Failure.");
}
?>