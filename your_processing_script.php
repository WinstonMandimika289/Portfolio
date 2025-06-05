<?php
// ─── BOOTSTRAP ─────────────────────────────────────────────────────────────
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'Cashew78!');
define('DB_NAME', 'gwc_db');

// Email configuration
define('EMAIL_TO',   'orbis.web.service@gmail.com');
define('EMAIL_FROM', 'noreply@yourdomain.com');

// Load PHPMailer
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ─── FORM PROCESSING ──────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $formData = [
        'name'      => trim($_POST['name']      ?? ''),
        'email'     => trim($_POST['email']     ?? ''),
        'phone'     => trim($_POST['phone']     ?? ''),
        'message'   => trim($_POST['message']   ?? ''),
        'domain'    =>    $_POST['domain']      ?? '',
        'hosting'   =>    $_POST['hosting']     ?? '',
        'plan_type' =>    $_POST['plan_type']   ?? ''
    ];

    // Validate
    if (empty($formData['name'])) {
        $errors[] = 'Please enter your name.';
    }
    if (empty($formData['email'])) {
        $errors[] = 'Please enter your email address.';
    } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    // phone is optional, but if provided, basic cleanup:
    if ($formData['phone'] !== '' && !preg_match('/^[\d\-\+\s\(\)]+$/', $formData['phone'])) {
        $errors[] = 'Please enter a valid phone number.';
    }
    if (empty($formData['message'])) {
        $errors[] = 'Please enter your message.';
    }
    if (!in_array($formData['domain'], ['yes','no'], true)) {
        $errors[] = 'Please select whether you need a domain.';
    }
    if (!in_array($formData['hosting'], ['yes','no'], true)) {
        $errors[] = 'Please select whether you need hosting.';
    }
    // plan_type is optional; if provided, ensure it's one of your dropdown options
    $allowedPlans = ['basic','professional','premium',''];
    if (!in_array($formData['plan_type'], $allowedPlans, true)) {
        $errors[] = 'Invalid plan type selected.';
    }
    // Anti-spam
    if (!empty($_POST['botcheck'])) {
        $errors[] = 'Bot detection triggered.';
    }

    // If no errors, save & email
    if (empty($errors)) {
        try {
            // DB connection
            $dbc = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($dbc->connect_error) {
                throw new Exception('Database connection failed: ' . $dbc->connect_error);
            }

            // Insert
            $stmt = $dbc->prepare("
                INSERT INTO contact_submissions
                  (name, email, phone, message, needs_domain, needs_hosting, plan_type, submitted_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
            ");
            $stmt->bind_param(
                'sssssss',
                $formData['name'],
                $formData['email'],
                $formData['phone'],
                $formData['message'],
                $formData['domain'],
                $formData['hosting'],
                $formData['plan_type']
            );
            if (!$stmt->execute()) {
                throw new Exception('Database error: ' . $stmt->error);
            }
            $stmt->close();

            // Send notification email
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'orbis.web.service@gmail.com';
            $mail->Password   = 'paku zoen hfkx mycy';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom($formData['email'], $formData['name']);
            $mail->addAddress(EMAIL_TO);
            $mail->addReplyTo($formData['email'], $formData['name']);

            $mail->isHTML(true);
            $mail->Subject = 'New Contact Form Submission';
            $mail->Body    = "
                <h2>New Contact Submission</h2>
                <p><strong>Name:</strong>    {$formData['name']}</p>
                <p><strong>Email:</strong>   {$formData['email']}</p>
                <p><strong>Phone:</strong>   {$formData['phone']}</p>
                <p><strong>Message:</strong><br>" . nl2br($formData['message']) . "</p>
                <p><strong>Needs Domain?</strong>  {$formData['domain']}</p>
                <p><strong>Needs Hosting?</strong> {$formData['hosting']}</p>
                <p><strong>Plan Type:</strong>     {$formData['plan_type']}</p>
                <p><strong>Received:</strong>      " . date('Y-m-d H:i:s') . "</p>
            ";
            $mail->send();

            // Success: clear session and redirect
            unset($_SESSION['form_errors'], $_SESSION['form_data']);
            header('Location: thank_you.php');
            exit;
        }
        catch (Exception $e) {
            error_log('Contact form error: ' . $e->getMessage());
            $errors[] = 'An error occurred while processing your submission. Please try again later.';
        }
        finally {
            $dbc->close();
        }
    }

    // On error: store and redirect back
    $_SESSION['form_errors'] = $errors;
    $_SESSION['form_data']   = $formData;
    header('Location: index1.php?submit_error=true');
    exit;
}

// If not POST, just go back to form
header('Location: index1.php');
exit;
