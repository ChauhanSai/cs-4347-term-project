<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'] ?? null;
    $password = $_POST['password']; // In a real app, use password_hash()
    $role = $_POST['role'];
    
    // We need a unique user_id since it's INT PRIMARY KEY without auto_increment in the schema
    // Let's get the max user_id and add 1
    $stmt = $pdo->query('SELECT MAX(user_id) AS max_id FROM “User”');
    $row = $stmt->fetch();
    $newUserId = ($row['max_id'] ?? 0) + 1;

    try {
        $stmt = $pdo->prepare('INSERT INTO “User” (user_id, name, email, phone_number, password, role) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$newUserId, $fullName, $email, $phone_number, $password, $role]);
        
        $_SESSION['user_id'] = $newUserId;
        $_SESSION['name'] = $fullName;
        $_SESSION['role'] = $role;
        
        // Redirect based on role or to browse
        header("Location: browse_services.html?msg=Registration+successful&user_id=" . urlencode($newUserId));
        exit();
    } catch (PDOException $e) {
        $error = urlencode("Registration failed: " . $e->getMessage());
        header("Location: register.html?error=$error");
        exit();
    }
}
?>
