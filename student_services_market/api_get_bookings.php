<?php
header('Content-Type: application/json');
require 'db.php';

$userId = $_GET['user_id'] ?? null;
if (!$userId) {
    echo json_encode([]);
    exit;
}

try {
    $stmt = $pdo->prepare('
        SELECT 
            b.booking_id, 
            s.title AS service_title, 
            b.scheduled_time, 
            u.name AS provider_name, 
            b.status,
            p.payment_id,
            r.review_id
        FROM Booking b
        JOIN ServiceListing s ON b.listing_id = s.listing_id
        JOIN “User” u ON s.provider_id = u.user_id
        LEFT JOIN Payment p ON b.booking_id = p.booking_id
        LEFT JOIN Review r ON b.booking_id = r.booking_id
        WHERE b.customer_id = ?
    ');
    $stmt->execute([$userId]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
