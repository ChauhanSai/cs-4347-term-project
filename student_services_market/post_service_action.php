<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get provider_id (user_id) from GET/POST parameter as user instructed
    $provider_id = $_GET['user_id'] ?? $_POST['user_id'] ?? null;
    
    // Get form data
    $title = $_POST['title'] ?? null;
    $category_id = $_POST['category'] ?? null;
    $description = $_POST['description'] ?? null;
    
    // Cast price to double and restrict to two decimal places
    $price = isset($_POST['price']) ? round((double)$_POST['price'], 2) : null;
    
    $availability = $_POST['availability'] ?? null;
    
    if (!$provider_id || !$title || !$category_id || $price === null) {
        die("Missing required service listing parameters. Make sure URL has user_id.");
    }
    
    // Generate new listing_id
    $stmt = $pdo->query('SELECT MAX(listing_id) AS max_id FROM ServiceListing');
    $row = $stmt->fetch();
    $newListingId = ($row['max_id'] ?? 0) + 1;
    
    try {
        $stmt = $pdo->prepare('INSERT INTO ServiceListing (listing_id, provider_id, category_id, title, description, price, availability) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $newListingId,
            $provider_id,
            $category_id,
            $title,
            $description,
            $price,
            $availability
        ]);
        
        // Redirect back directly matching the persistent user_id handling logic
        header("Location: post_service.html?msg=Service+posted+successfully&user_id=" . urlencode($provider_id));
        exit();
    } catch (PDOException $e) {
        $error = urlencode("Error posting service: " . $e->getMessage());
        header("Location: post_service.html?error=$error&user_id=" . urlencode($provider_id));
        exit();
    }
}
?>
