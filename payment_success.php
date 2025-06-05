<?php
require 'config.php';

$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

if ($userId === 0) {
    header("Location: index.php");
    exit();
}

// Get user and plan information
$stmt = $pdo->prepare("SELECT u.name, u.email, up.plan_type, up.amount 
                      FROM users u 
                      JOIN user_plans up ON u.id = up.user_id 
                      WHERE u.id = ? 
                      ORDER BY up.purchase_date DESC LIMIT 1");
$stmt->execute([$userId]);
$userData = $stmt->fetch();

if (!$userData) {
    die("User or plan not found");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Successful</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="payment-success-container">
        <h1>Payment Successful!</h1>
        <p>Thank you, <?php echo htmlspecialchars($userData['name']); ?>, for your purchase.</p>
        
        <div class="plan-details">
            <h2>Your Plan Details:</h2>
            <ul>
                <li>Plan: <?php echo htmlspecialchars(ucfirst($userData['plan_type'])); ?></li>
                <li>Amount: £<?php echo htmlspecialchars($userData['amount']); ?></li>
                <li>Email: <?php echo htmlspecialchars($userData['email']); ?></li>
            </ul>
        </div>
        
        <p>You can now access your dashboard to manage your website.</p>
        <a href="dashboard.php" class="btn btn-primary">Go to Dashboard</a>
    </div>
</body>
</html>