<?php
require 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare('SELECT user_id, name, role FROM “User” WHERE email = ? AND password = ?');
        $stmt->execute([$email, $password]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            
            header("Location: browse_services.html?user_id=" . urlencode($user['user_id']));
            exit();
        } else {
            header("Location: login.html?error=Invalid credentials");
            exit();
        }
    } catch (PDOException $e) {
        $error = urlencode("Login failed: " . $e->getMessage());
        header("Location: login.html?error=$error");
        exit();
    }
}
?>
