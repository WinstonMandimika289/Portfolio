<?php
require 'config.php';

// Process form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $planType = $_POST['plan_type'];
    $planAmount = $_POST['plan_amount'];
    
    // Check if user exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if (!$user) {
        // Create new user
        $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        $stmt->execute([$name, $email]);
        $userId = $pdo->lastInsertId();
    } else {
        $userId = $user['id'];
    }
    
    // Record the plan purchase
    $stmt = $pdo->prepare("INSERT INTO user_plans (user_id, plan_type, amount) VALUES (?, ?, ?)");
    $stmt->execute([$userId, $planType, $planAmount]);
    
    // Redirect to payment success page with user ID
    header("Location: payment_success.php?user_id=$userId");
    exit();
}
?>