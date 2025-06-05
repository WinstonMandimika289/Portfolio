<?php
include("includes/header.html");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('includes/connect_db.php');
    $errors = array();

    // Validate and sanitize input
    if (empty($_POST['first_name'])) {
        $errors[] = 'Enter your first name';
    } else {
        $fn = $dbc->real_escape_string(trim($_POST['first_name']));
    }

    if (empty($_POST['last_name'])) {
        $errors[] = 'Enter your last name'; 
    } else {
        $ln = $dbc->real_escape_string(trim($_POST['last_name']));
    }

    if (empty($_POST['email'])) {
        $errors[] = 'Enter your email address'; 
    } else {
        $e = $dbc->real_escape_string(trim($_POST['email']));
    }

    if (empty($_POST['username'])) {
        $errors[] = 'Enter a username'; 
    } else {
        $un = $dbc->real_escape_string(trim($_POST['username']));
    }

    if (!empty($_POST['pass1'])) {
        if ($_POST['pass1'] != $_POST['pass2']) { 
            $errors[] = 'Passwords do not match.'; 
        } else { 
            $p = trim($_POST['pass1']); // Don't escape before hashing
        }
    } else {
        $errors[] = 'Enter your password.';
    }

    // Check for existing email
    if (empty($errors)) {
        $q = "SELECT user_id FROM login_info WHERE email='$e'";
        $r = $dbc->query($q);
        if ($r === false) {
            die("Query failed: " . $dbc->error);
        }
        if ($r->num_rows != 0) {
            $errors[] = 'Email address already registered. <a href="login.php">Login</a>';
        } 
    }

    // Insert new user if no errors
    if (empty($errors)) {
        $p_hashed = password_hash($p, PASSWORD_DEFAULT);
        
        // Fixed prepared statement
        $stmt = $dbc->prepare("INSERT INTO login_info 
            (username, password, role, is_approved, created_at, first_name, last_name, email) 
            VALUES (?, ?, 'user', 0, NOW(), ?, ?, ?)");
        
        if ($stmt === false) {
            die("Prepare failed: " . $dbc->error);
        }
        
        $stmt->bind_param("sssss", $un, $p_hashed, $fn, $ln, $e);
        
        if ($stmt->execute()) { 
            echo '<h1>Registered!</h1><p>You are now registered.</p><p><a href="login.php">Login</a></p>'; 
        } else {
            echo '<h1>Error!</h1><p>Could not register due to a system error: ' . $stmt->error . '</p>';
        }
        $dbc->close();
        include('includes/footer.html'); 
        exit();
    } else {
        echo '<h1>Error!</h1><p id="err_msg">The following error(s) occurred:<br>';
        foreach ($errors as $msg) {
            echo " - $msg <br />";
        }
        echo "Please try again</p>";
        $dbc->close();
    }
}
?>

<br> <br>




<!-- Form remains the same -->
<form action="register.php" method="post" class="form-signin" role="form">
    <h2 class="form-signin-heading">Create an Account</h2>
    <input type="text" name="first_name" size="20" required 
           value="<?php if (isset($_POST['first_name'])) echo htmlspecialchars($_POST['first_name']); ?>" 
           placeholder="First Name">   
    <input type="text" name="last_name" size="20" required 
           value="<?php if (isset($_POST['last_name'])) echo htmlspecialchars($_POST['last_name']); ?>" 
           placeholder="Last Name">
    <input type="text" name="username" size="20" required 
           value="<?php if (isset($_POST['username'])) echo htmlspecialchars($_POST['username']); ?>" 
           placeholder="Username"> 
    <input type="email" name="email" size="50" required 
           value="<?php if (isset($_POST['email'])) echo htmlspecialchars($_POST['email']); ?>" 
           placeholder="Email Address">
    <input type="password" name="pass1" size="20" required placeholder="Password">
    <input type="password" name="pass2" size="20" required placeholder="Confirm Password">
    <p><button class="btn btn-primary" name="submit" type="submit">Register</button></p>
</form>

<?php
include("includes/footer.html");
?>