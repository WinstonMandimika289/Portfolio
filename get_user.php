<?php
header("Content-Type: application/json");
require_once __DIR__ . '/includes/connect_clb.php';

// Enable detailed error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Validate and sanitize user ID
$userId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$userId || $userId <= 0) {
    http_response_code(400);
    die(json_encode([
        'success' => false,
        'error' => 'Invalid user ID provided',
        'received_id' => $_GET['id'] ?? null
    ]));
}

try {
    // 1. Fetch basic user info
    $userQuery = $pdo->prepare("
        SELECT 
            user_id,
            username,
            email,
            first_name,
            last_name,
            reg_date,
            COALESCE(plan_type, 'basic') as plan,
            COALESCE(billing_cycle, 'monthly') as billing_cycle,
            COALESCE(next_billing_date, DATE_ADD(NOW(), INTERVAL 1 MONTH)) as billing_date
        FROM login_info 
        WHERE user_id = ?
    ");
    $userQuery->execute([$userId]);
    $user = $userQuery->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(404);
        die(json_encode([
            'success' => false,
            'error' => 'User not found',
            'searched_id' => $userId
        ]));
    }

    // 2. Fetch billing history
    $billingQuery = $pdo->prepare("
        SELECT 
            transaction_id,
            amount,
            transaction_date,
            COALESCE(status, 'completed') as status,
            COALESCE(description, 'Website service') as description,
            CONCAT('INV-', UPPER(SUBSTRING(MD5(RAND()), 1, 8))) as invoice_number
        FROM billing_history 
        WHERE user_id = ?
        ORDER BY transaction_date DESC
    ");
    $billingQuery->execute([$userId]);
    $billingHistory = $billingQuery->fetchAll(PDO::FETCH_ASSOC);

    // 3. Build final response
    $response = [
        'success' => true,
        'data' => [
            'user' => $user,
            'billingHistory' => $billingHistory,
            'paymentMethods' => getPlaceholderPaymentMethods($userId) // Temporary placeholder
        ],
        'meta' => [
            'timestamp' => date('c'),
            'api_version' => '1.0'
        ]
    ];

    echo json_encode($response, JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    http_response_code(500);
    die(json_encode([
        'success' => false,
        'error' => 'Database operation failed',
        'technical_details' => $e->getMessage(),
        'advice' => 'Please contact support with this error code: DB-' . time()
    ]));
}

// Temporary function until payment methods are implemented
function getPlaceholderPaymentMethods($userId) {
    return [
        [
            'id' => 1,
            'user_id' => $userId,
            'card_type' => 'visa',
            'last4' => '4242',
            'exp_month' => '12',
            'exp_year' => '2025',
            'is_default' => true
        ]
    ];
}