<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect specific parameters from GET and fallback securely to POST
    $booking_id = $_GET['booking_id'] ?? $_POST['booking_id'] ?? null;
    $reviewer_id = $_GET['user_id'] ?? $_POST['user_id'] ?? null;
    
    // Explicitly parse form values
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : null;
    $comment = $_POST['comments'] ?? null;
    
    // Explicit validation preventing silent db fail loops
    if (!$booking_id || !$reviewer_id || !$rating || !$comment) {
        $fallbackUrl = $reviewer_id ? "browse_services.html?error=Missing+parameters&user_id=" . urlencode($reviewer_id) : "browse_services.html?error=Missing+parameters";
        header("Location: " . $fallbackUrl);
        exit();
    }
    
    $review_date = date('Y-m-d');

    // Get strictly correct unique new review_id mapping user requirement
    $stmt = $pdo->query('SELECT MAX(review_id) AS max_id FROM Review');
    $row = $stmt->fetch();
    $newReviewId = ($row['max_id'] ?? 0) + 1;

    try {
        $stmt = $pdo->prepare('INSERT INTO Review (review_id, booking_id, reviewer_id, rating, comment, review_date) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$newReviewId, $booking_id, $reviewer_id, $rating, $comment, $review_date]);
        
        header("Location: browse_services.html?msg=Review+submitted+successfully&user_id=" . urlencode($reviewer_id));
        exit();
    } catch (PDOException $e) {
        $error = urlencode("Error submitting review: " . $e->getMessage());
        header("Location: leave_review.html?booking_id=$booking_id&user_id=" . urlencode($reviewer_id) . "&error=$error");
        exit();
    }
}
?>
