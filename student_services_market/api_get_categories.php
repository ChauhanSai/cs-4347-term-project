<?php
header('Content-Type: application/json');
require 'db.php';

try {
    $stmt = $pdo->query('SELECT category_id, category_name FROM Category ORDER BY category_name ASC');
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
