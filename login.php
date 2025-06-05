<?php
include("includes/header.html");
require 'config.php';

// Start session at the beginning
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('includes/connect_db.php');
    $errors = array();

    // Get and sanitize input
    $identifier = $dbc->real_escape_string(trim($_POST['username_or_email']));
    $password = trim($_POST['password']); // Don't escape passwords

    // Find user by username or email
    $stmt = $dbc->prepare("SELECT user_id, username, password, role FROM login_info 
                          WHERE username = ? OR email = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $dbc->error);
    }
    
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        // Verify the password against the stored hash
        if (password_verify($password, $row['password'])) {
            // Password is correct - set session variables
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            
            // Regenerate session ID for security
            session_regenerate_id(true);
            
            // Redirect to dashboard or home page
            header("Location: membership.html");
            exit();
        } else {
            $errors[] = 'Invalid password';
        }
    } else {
        $errors[] = 'User not found';
    }

    // Close statement and connection
    $stmt->close();
    $dbc->close();

    // Display errors if any
    if (!empty($errors)) {
        echo '<h1>Error!</h1><p id="err_msg">The following error(s) occurred:<br>';
        foreach ($errors as $msg) {
            echo " - $msg<br>";
        }
        echo 'Please try again.</p>';
        
    }
    
}


$db = new mysqli('localhost', 'root', 'Cashew78!', 'gwc_db');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $db->real_escape_string($_POST['email']);
    $password = $db->real_escape_string($_POST['password']);
    
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = $db->query($query);
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            header("Location: dashboard.php");
            exit();
        }
    }
    
    $error = "Invalid email or password";
}
?>


<br><br>



<!-- Login Form -->
<form action="login.php" method="post" class="form-signin" role="form">
    <h2 class="form-signin-heading">Login</h2>
    <input type="text" name="username_or_email" required 
           value="<?php if (isset($_POST['username_or_email'])) echo htmlspecialchars($_POST['username_or_email']); ?>" 
           placeholder="Username or Email">
    <input type="password" name="password" required placeholder="Password">
    <p>
        <button class="btn btn-primary" name="submit" type="submit">Login</button>
        <a href="register.php" class="btn btn-link">Create an account</a>
    </p>
    <p><a href="forgot_password.php">Forgot password?</a></p>

    <h1>---------------------------------------------------</h1>



     <h1>Login</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST">
        <div>
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
</form>

<?php
include("includes/footer.html");
?>