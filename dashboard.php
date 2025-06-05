<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Get user information
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

// Get user's current plan
$stmt = $pdo->prepare("SELECT * FROM user_plans WHERE user_id = ? ORDER BY purchase_date DESC LIMIT 1");
$stmt->execute([$userId]);
$currentPlan = $stmt->fetch();
$hasPlan = $currentPlan !== false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?></h1>
        <nav>
            <a href="#profile">Profile</a>
            <a href="#website">Website</a>
            <a href="#billing">Billing</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    
    <main>
        <section id="profile">
            <h2>Your Profile</h2>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
            <p>Member since: <?php echo date('F j, Y', strtotime($user['created_at'])); ?></p>
        </section>
        
        <section id="plan">
            <h2>Your Current Plan</h2>
            <?php if ($hasPlan): ?>
                <div class="plan-card">
                    <h3><?php echo htmlspecialchars(ucfirst($currentPlan['plan_type'])); ?> Plan</h3>
                    <p>Amount: £<?php echo htmlspecialchars($currentPlan['amount']); ?></p>
                    <p>Status: <?php echo htmlspecialchars($currentPlan['payment_status']); ?></p>
                    <p>Purchased on: <?php echo date('F j, Y', strtotime($currentPlan['purchase_date'])); ?></p>
                    <?php if ($currentPlan['expiry_date']): ?>
                        <p>Expires on: <?php echo date('F j, Y', strtotime($currentPlan['expiry_date'])); ?></p>
                    <?php endif; ?>
                    
                    <div class="plan-features">
                        <?php if ($currentPlan['plan_type'] === 'basic'): ?>
                            <ul>
                                <li>1 Page Website</li>
                                <li>Mobile Responsive</li>
                                <li>Contact Form</li>
                                <li>1 Revision Round</li>
                            </ul>
                        <?php elseif ($currentPlan['plan_type'] === 'professional'): ?>
                            <ul>
                                <li>6 Page Website</li>
                                <li>Mobile Responsive</li>
                                <li>Basic SEO</li>
                                <li>CMS Integration</li>
                                <li>3 Revision Rounds</li>
                                <li>Basic Analytics</li>
                                <li>1 Month Web Support</li>
                            </ul>
                        <?php elseif ($currentPlan['plan_type'] === 'premium'): ?>
                            <ul>
                                <li>Unlimited Pages</li>
                                <li>Mobile Responsive</li>
                                <li>Advanced SEO</li>
                                <li>E-commerce Functionality</li>
                                <li>5 Revision Rounds</li>
                                <li>Advanced Analytics</li>
                                <li>Priority Support</li>
                            </ul>
                        <?php endif; ?>
                    </div>
                    
                    <a href="#pricing" class="btn btn-primary">Upgrade Plan</a>
                </div>
            <?php else: ?>
                <p>You don't have an active plan. <a href="index.php#pricing">Choose a plan</a> to get started.</p>
            <?php endif; ?>
        </section>
        
        <section id="website">
            <h2>Your Website</h2>
            <?php if ($hasPlan): ?>
                <p>Your website is being prepared. You'll receive an email when it's ready.</p>
                <div class="progress-tracker">
                    <!-- Add progress tracking for website development -->
                </div>
            <?php else: ?>
                <p>Please purchase a plan to start building your website.</p>
            <?php endif; ?>
        </section>
    </main>
    
    <footer>
        <p>&copy; 2024 Orbis Web Solutions. All rights reserved.</p>
    </footer>
</body>
</html>