<?php
require 'db.php';

$listing_id = $_GET['id'] ?? null;
$provider_id = $_GET['user_id'] ?? null;

if (!$listing_id || !$provider_id) {
    // Redirect cleanly without user_id if we genuinely don't have it
    $fallbackUrl = $provider_id ? "post_service.html?error=Missing+parameters&user_id=" . urlencode($provider_id) : "post_service.html?error=Missing+parameters";
    header("Location: " . $fallbackUrl);
    exit();
}

try {
    // Ensure the user owns the listing before deleting
    $stmt = $pdo->prepare('DELETE FROM ServiceListing WHERE listing_id = ? AND provider_id = ?');
    $stmt->execute([$listing_id, $provider_id]);
    
    header("Location: post_service.html?msg=Service+deleted+successfully&user_id=" . urlencode($provider_id));
    exit();
} catch (PDOException $e) {
    $error = urlencode("Error deleting service: " . $e->getMessage());
    header("Location: post_service.html?error=$error&user_id=" . urlencode($provider_id));
    exit();
}
?>
