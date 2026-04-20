<?php
header('Content-Type: application/json');
require 'db.php';

$booking_id = $_GET['booking_id'] ?? null;

if (!$booking_id) {
    echo json_encode(['error' => 'Missing booking_id parameter']);
    exit;
}

try {
    $stmt = $pdo->prepare('
        SELECT 
            b.booking_id,
            s.title,
            s.price
        FROM Booking b
        JOIN ServiceListing s ON b.listing_id = s.listing_id
        WHERE b.booking_id = ?
    ');
    $stmt->execute([$booking_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        echo json_encode($result);
    } else {
        echo json_encode(['error' => 'Booking not found']);
    }

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
