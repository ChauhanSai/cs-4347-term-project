<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_GET['booking_id'] ?? $_POST['booking_id'] ?? null;
    $amount = $_POST['amount'] ?? null;
    $user_id = $_GET['user_id'] ?? $_POST['user_id'] ?? null;
    
    if (!$booking_id || !$amount) {
        $fallbackUrl = $user_id ? "browse_services.html?error=Missing+parameters&user_id=" . urlencode($user_id) : "browse_services.html?error=Missing+parameters";
        header("Location: " . $fallbackUrl);
        exit();
    }

    $payment_date = date('Y-m-d');

    // Get new payment_id
    $stmt = $pdo->query('SELECT MAX(payment_id) AS max_id FROM Payment');
    $row = $stmt->fetch();
    $newPaymentId = ($row['max_id'] ?? 0) + 1;

    try {
        $pdo->beginTransaction();
        
        $stmt = $pdo->prepare('INSERT INTO Payment (payment_id, booking_id, payment_date, amount, payment_status) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$newPaymentId, $booking_id, $payment_date, $amount, 'completed']);
        
        // Update booking status
        $updateStmt = $pdo->prepare("UPDATE Booking SET status = 'completed' WHERE booking_id = ?");
        $updateStmt->execute([$booking_id]);
        
        $pdo->commit();

        header("Location: browse_services.html?msg=Payment+successful&user_id=" . urlencode($user_id));
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        $error = urlencode("Error processing payment: " . $e->getMessage());
        header("Location: payment.html?booking_id=$booking_id&user_id=" . urlencode($user_id) . "&error=$error");
        exit();
    }
}
?>
