<?php
ob_start();
session_start();
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_method = $_POST['payment_method'];

    if ($payment_method === 'card') {
        $card_number = trim($_POST['card_number']);
        $card_name = trim($_POST['card_name']);
        $expiry_date = trim($_POST['expiry_date']);

        if (empty($card_number) || empty($card_name) || empty($expiry_date)) {
            $error = "Please enter all card details!";
        } else {
            header("Location: success.php");
            exit();
        }
    } elseif ($payment_method === 'upi') {
        $upi_id = trim($_POST['upi_id']);
        if (empty($upi_id)) {
            $error = "Please enter your UPI ID!";
        } else {
            header("Location: success.php");
            exit();
        }
    } elseif ($payment_method === 'net_banking') {
        $bank_name = trim($_POST['bank_name']);
        if (empty($bank_name)) {
            $error = "Please select a bank!";
        } else {
            header("Location: success.php");
            exit();
        }
    } else {
        // COD
        header("Location: success.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Payment Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .payment-section {
            background-image: url('images/banner3.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .payment-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        input, select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            display: block;
        }
        .hidden {
            display: none;
        }
        .pay-btn {
            background-color: #28a745;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            width: 100%;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .pay-btn:hover {
            background-color: #218838;
        }
        .cancel-btn {
            background-color: #dc3545;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            width: 100%;
            margin-top: 10px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .cancel-btn:hover {
            background-color: #c82333;
        }
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>

<section class="payment-section">
    <div class="payment-container">
        <h2>Payment Page</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form method="POST">
            <!-- Payment Method Selection -->
            <select name="payment_method" onchange="this.form.submit()">
                <option value="card" <?= isset($_POST['payment_method']) && $_POST['payment_method'] == 'card' ? 'selected' : '' ?>>Credit/Debit Card</option>
                <option value="upi" <?= isset($_POST['payment_method']) && $_POST['payment_method'] == 'upi' ? 'selected' : '' ?>>UPI</option>
                <option value="net_banking" <?= isset($_POST['payment_method']) && $_POST['payment_method'] == 'net_banking' ? 'selected' : '' ?>>Net Banking</option>
                
            </select>

            <!-- Card Payment Fields -->
            <div class="<?= isset($_POST['payment_method']) && $_POST['payment_method'] == 'card' ? '' : 'hidden' ?>">
                <input type="text" name="card_number" placeholder="Card Number" />
                <input type="text" name="card_name" placeholder="Cardholder Name" />
                <input type="text" name="expiry_date" placeholder="Expiry Date (MM/YY)" />
            </div>

            <!-- UPI Payment Fields -->
            <div class="<?= isset($_POST['payment_method']) && $_POST['payment_method'] == 'upi' ? '' : 'hidden' ?>">
                <input type="text" name="upi_id" placeholder="Enter UPI ID" />
            </div>

            <!-- Net Banking Fields -->
            <div class="<?= isset($_POST['payment_method']) && $_POST['payment_method'] == 'net_banking' ? '' : 'hidden' ?>">
                <select name="bank_name">
                    <option value="">Select Bank</option>
                    <option value="SBI">State Bank of India</option>
                    <option value="HDFC">HDFC Bank</option>
                    <option value="ICICI">ICICI Bank</option>
                    <option value="Axis">Axis Bank</option>
                </select>
            </div>

            <!-- Coupon Code -->
            <input type="text" name="coupon_code" placeholder="Enter Coupon Code (Optional)" />

            <button type="submit" class="pay-btn">Pay Now</button>
            <button type="button" class="cancel-btn" onclick="window.location.href='checkout.php'">Cancel</button>
        </form>
    </div>
</section>

<?php include 'footer.php'; ?>
</body>
</html>
