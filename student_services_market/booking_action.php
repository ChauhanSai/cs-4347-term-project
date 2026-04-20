<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect listing_id and user_id from query parameters (or POST as fallback)
    $listing_id = $_GET['service_id'] ?? $_GET['listing_id'] ?? $_POST['service_id'] ?? null;
    $customer_id = $_GET['user_id'] ?? $_POST['user_id'] ?? null;
    
    $bookingDate = $_POST['bookingDate'] ?? null;
    $bookingTime = $_POST['bookingTime'] ?? null;
    
    if (!$listing_id || !$customer_id || !$bookingDate || !$bookingTime) {
        die("Missing required booking parameters. Make sure URL has user_id and service_id.");
    }
    
    // Combine Date and Time for scheduled_time TIMESTAMP
    $scheduled_time = $bookingDate . ' ' . $bookingTime . ':00';

    // Get new booking_id from MAX
    $stmt = $pdo->query('SELECT MAX(booking_id) AS max_id FROM Booking');
    $row = $stmt->fetch();
    $newBookingId = ($row['max_id'] ?? 0) + 1;

    try {
        // Insert with status pending
        $stmt = $pdo->prepare('INSERT INTO Booking (booking_id, listing_id, customer_id, booking_date, scheduled_time, status) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$newBookingId, $listing_id, $customer_id, $bookingDate, $scheduled_time, 'pending']);
        
        // Pass user_id back to browse_services
        header("Location: browse_services.html?msg=Service+booked+successfully&user_id=" . urlencode($customer_id));
        exit();
    } catch (PDOException $e) {
        $error = urlencode("Error booking service: " . $e->getMessage());
        header("Location: book_service.html?service_id=$listing_id&user_id=$customer_id&error=$error");
        exit();
    }
}
?>
