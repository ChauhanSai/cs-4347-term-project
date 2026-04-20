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
            s.listing_id, 
            s.title, 
            s.price,
            c.category_name 
        FROM ServiceListing s
        LEFT JOIN Category c ON s.category_id = c.category_id
        WHERE s.provider_id = ?
    ');
    $stmt->execute([$userId]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
