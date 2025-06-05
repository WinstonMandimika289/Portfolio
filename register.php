<?php
include("includes/header.html");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('includes/connect_db.php');
    $errors = array();

    // Initialize variables
    $name = $email = $message = $domain = $hosting = '';

    // Validate and sanitize input
    if (empty($_POST['name'])) {
        $errors[] = 'Please enter your name';
    } else {
        $name = $dbc->real_escape_string(trim($_POST['name']));
    }

    if (empty($_POST['email'])) {
        $errors[] = 'Please enter your email address';
    } else {
        $email = $dbc->real_escape_string(trim($_POST['email']));
        // Additional email validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address';
        }
    }

    if (empty($_POST['message'])) {
        $errors[] = 'Please enter your message';
    } else {
        $message = $dbc->real_escape_string(trim($_POST['message']));
    }

    if (empty($_POST['domain']) || !in_array($_POST['domain'], ['yes', 'no'])) {
        $errors[] = 'Please select an option for domain';
    } else {
        $domain = $dbc->real_escape_string(trim($_POST['domain']));
    }

    if (empty($_POST['hosting']) || !in_array($_POST['hosting'], ['yes', 'no'])) {
        $errors[] = 'Please select an option for hosting';
    } else {
        $hosting = $dbc->real_escape_string(trim($_POST['hosting']));
    }

    // Check for bot submissions (the hidden botcheck field should be empty)
    if (!empty($_POST['botcheck'])) {
        $errors[] = 'Invalid submission detected';
    }

    // If no errors, proceed with processing the form
    if (empty($errors)) {
        // Since you're using Web3Forms, we'll just show a success message
        echo '<h1>Thank You!</h1><p>Your message has been submitted successfully.</p>';
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

<br><br>

<!-- Updated contact form -->
<div class="contact-container">
    <h2 class="section-title">Get In Touch</h2>
    <div class="contact-content">
        <div class="contact-info">
            <h3>Contact Information</h3>
            <p><i class="fas fa-envelope"></i> orbis.web.service@gmail.com</p>
            <p><i class="fas fa-phone"></i> 07983097946</p>
            <p><i class="fas fa-map-marker-alt"></i> Liverpool, England</p>
        </div>
        <form class="contact-form" action="your_processing_script.php" method="POST">
            <input type="hidden" name="access_key" value="f1eec908-971f-471e-bf67-3b60ec9ce43a">
            <input type="checkbox" name="botcheck" class="hidden" style="display: none;">

            <div class="form-group">
                <label for="contact-name">Name</label>
                <input type="text" id="contact-name" name="name" required 
                       value="<?php if (isset($_POST['name'])) echo htmlspecialchars($_POST['name']); ?>">
            </div>
            <div class="form-group">
                <label for="contact-email">Email</label>
                <input type="email" id="contact-email" name="email" required 
                       value="<?php if (isset($_POST['email'])) echo htmlspecialchars($_POST['email']); ?>">
            </div>
            <div class="form-group">
                <label for="contact-message">Message</label>
                <textarea id="contact-message" rows="5" name="message" required><?php 
                    if (isset($_POST['message'])) echo htmlspecialchars($_POST['message']); 
                ?></textarea>
            </div>
            <div class="form-group">
                <label for="domain">Do you need a domain?</label>
                <select id="domain" name="domain" required>
                    <option value="">Please select</option>
                    <option value="yes" <?php if (isset($_POST['domain']) && $_POST['domain'] == 'yes') echo 'selected'; ?>>Yes</option>
                    <option value="no" <?php if (isset($_POST['domain']) && $_POST['domain'] == 'no') echo 'selected'; ?>>No</option>
                </select>
            </div>
            <div class="form-group">
                <label for="hosting">Do you need hosting services?</label>
                <select id="hosting" name="hosting" required>
                    <option value="">Please select</option>
                    <option value="yes" <?php if (isset($_POST['hosting']) && $_POST['hosting'] == 'yes') echo 'selected'; ?>>Yes</option>
                    <option value="no" <?php if (isset($_POST['hosting']) && $_POST['hosting'] == 'no') echo 'selected'; ?>>No</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit Form</button>
        </form>
    </div>
</div>
<?php
include("includes/footer.html");
?>