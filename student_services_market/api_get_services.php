<?php
header('Content-Type: application/json');
require 'db.php';

$keyword = $_GET['keyword'] ?? '';
$categoryName = $_GET['category'] ?? '';

$sql = '
    SELECT 
        s.listing_id, 
        s.title, 
        s.description, 
        s.price, 
        s.availability,
        c.category_name,
        u.name AS provider_name
    FROM ServiceListing s
    LEFT JOIN Category c ON s.category_id = c.category_id
    LEFT JOIN “User” u ON s.provider_id = u.user_id
    WHERE 1=1
';

$params = [];

if ($keyword !== '') {
    $sql .= ' AND (s.title LIKE ? OR s.description LIKE ?)';
    $params[] = '%' . $keyword . '%';
    $params[] = '%' . $keyword . '%';
}

if ($categoryName !== '') {
    // Strict match on category_id mapped dynamically from DB
    $sql .= ' AND s.category_id = ?';
    $params[] = $categoryName;
}

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
