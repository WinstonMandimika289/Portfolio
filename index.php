<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MyTravels</title>
    <!-- Link to external CSS with versioning to avoid cache issues -->
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-villa-agency.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="/styles.css">
  </head>
  
  <!-- Navigation Section -->
  <nav class="navbar">
    <div class="navbar__container">
      <!-- Hamburger menu for mobile devices -->
      <div class="navbar__toggle" id="mobile-menu">
        <span class="bar"></span> <span class="bar"></span> <span class="bar"></span>
      </div>
      
      <!-- Navbar links -->
      <ul class="navbar__menu">
        
        <li class="navbar__item">
          <a href="index.php" class="navbar__links">Login</a>
        </li>
      </ul>
    </div>
  </nav>

  <?php
// Start session for user authentication
session_start();

// Database connection parameters
$server = "localhost";
$username = "root";
$password = "Cashew78!";
$database = "gwc_db";

// Establish database connection
$conn = new mysqli($server, $username, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$error = null;

// Handle login logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Prepare SQL query to check credentials
    $sql = "SELECT * FROM login_info WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    
    // Check if prepare was successful
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    
    $stmt->bind_param("ss", $inputUsername, $inputPassword);
    
    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }
    
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Login successful
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $inputUsername;
        // Redirect to another page or show success message
        header("Location: admin.html");
        exit();
    } else {
        // Error message for invalid credentials
        $error = "Invalid username or password.";
    }
    
    $stmt->close();
}

$conn->close();
?>

  <!-- Login Form Section -->
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - glow_with_chlo</title>
   
  </head>
  <body>
    <div class="login-form">
      <h1>Admin - </h1>
      
      <!-- Display error message if login fails -->
      <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
      
      <!-- Login form -->
      <form method="POST" action="">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit" name="login">Log In</button>
        
        <!-- Register link -->
        <li class="navbar__item">
          <button type="submit"> <a href="/api/register.php" >Register</a></button>
        </li>
      </form>
    </div>
  </body>
  </html>
</html>
