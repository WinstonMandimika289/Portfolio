<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin'])) {
    header('Location: membership.html');
    exit;
}

// Check if account is approved
if (!isset($_SESSION['is_approved']) || !$_SESSION['is_approved']) {
    // You might want to handle this differently
    echo "Your account is pending approval";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
    <p>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
    <p>Role: <?php echo ucfirst($_SESSION['role']); ?></p>
    
    <!-- User-specific content here -->
    
    <a href="logout.php">Logout</a>
</body>
</html>