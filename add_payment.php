<?php
require 'config.php';

$data = json_decode(file_get_contents('php://input'), true);
$userId = $data['userId'] ?? 0;
$cardNumber = $data['cardNumber'] ?? '';
$cardName = $data['cardName'] ?? '';
$cardExpiry = $data['cardExpiry'] ?? '';
$cardCvv = $data['cardCvv'] ?? '';
$isDefault = $data['isDefault'] ?? false;

try {
    // In a real application, you would tokenize the card with a payment processor
    // Here we just store the last 4 digits for display
    
    // Parse expiry date
    $expParts = explode('/', $cardExpiry);
    $expMonth = trim($expParts[0]);
    $expYear = trim($expParts[1] ?? '');
    
    // If this is set as default, first unset any existing defaults
    if ($isDefault) {
        $stmt = $pdo->prepare("UPDATE payment_methods SET is_default = FALSE WHERE user_id = ?");
        $stmt->execute([$userId]);
    }
    
    // Add new payment method
    $last4 = substr(str_replace(' ', '', $cardNumber), -4);
    $cardType = determineCardType($cardNumber); // You'd implement this function
    
    $stmt = $pdo->prepare("INSERT INTO payment_methods 
                          (user_id, card_type, last4, exp_month, exp_year, is_default)
                          VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$userId, $cardType, $last4, $expMonth, $expYear, $isDefault ? 1 : 0]);
    
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    die(json_encode(['error' => 'Database error: ' . $e->getMessage()]));
}

function determineCardType($number) {
    // Simplified card type detection
    $number = str_replace(' ', '', $number);
    if (preg_match('/^4/', $number)) return 'visa';
    if (preg_match('/^5[1-5]/', $number)) return 'mastercard';
    if (preg_match('/^3[47]/', $number)) return 'amex';
    if (preg_match('/^6(?:011|5)/', $number)) return 'discover';
    return 'unknown';
}

?>

<section id="payment-modal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Complete Your Purchase</h2>
        <form id="payment-form" action="process_payment.php" method="POST">
            <input type="hidden" id="plan-type" name="plan_type">
            <input type="hidden" id="plan-amount" name="plan_amount">
            
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="plan">Selected Plan</label>
                <input type="text" id="plan" name="plan_name" readonly>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="text" id="amount" name="amount_display" readonly>
            </div>
            
            <div class="paypal-container">
                <!-- PayPal form with dynamic amount -->
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                    <input type="hidden" name="cmd" value="_xclick" />
                    <input type="hidden" name="business" value="your-paypal-email@example.com" />
                    <input type="hidden" name="item_name" id="paypal-item-name" value="" />
                    <input type="hidden" name="amount" id="paypal-amount" value="" />
                    <input type="hidden" name="currency_code" value="GBP" />
                    <input type="hidden" name="return" value="https://yourdomain.com/payment_success.php" />
                    <input type="hidden" name="cancel_return" value="https://yourdomain.com/payment_canceled.php" />
                    <input type="hidden" name="custom" id="paypal-custom" value="" />
                    <button type="submit" class="paypal-button">
                        <img src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" alt="Buy Now with PayPal" style="width: 250px;"/>
                    </button>
                </form>
            </div>
            
            <p class="secure-notice"><i class="fas fa-lock"></i> Secure payment processed by PayPal</p>
        </form>
    </div>
</section>

