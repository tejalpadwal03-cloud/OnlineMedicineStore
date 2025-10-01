<?php
session_start();
include 'config.php';

// ✅ Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ✅ Handle adding items to cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['medicine_id'])) {
    $medicine_id = intval($_POST['medicine_id']);

    // ✅ Fetch medicine details from the database
    $query = "SELECT * FROM medicines WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $medicine_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $medicine = $result->fetch_assoc();

    if ($medicine) {
        if (!isset($_SESSION['cart'][$medicine_id])) {
            $_SESSION['cart'][$medicine_id] = [
                'id' => $medicine['id'],
                'name' => $medicine['name'],
                'price' => floatval($medicine['price']),
                'quantity' => 1
            ];
        } else {
            $_SESSION['cart'][$medicine_id]['quantity'] += 1;
        }
    }
}

// ✅ Handle updating quantity via AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_quantity'])) {
    $medicine_id = intval($_POST['medicine_id']);
    $new_quantity = intval($_POST['new_quantity']);

    if ($new_quantity > 0) {
        $_SESSION['cart'][$medicine_id]['quantity'] = $new_quantity;
    } else {
        unset($_SESSION['cart'][$medicine_id]);
    }

    // ✅ Return updated total and subtotal dynamically
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    $subtotal = isset($_SESSION['cart'][$medicine_id]) ? $_SESSION['cart'][$medicine_id]['quantity'] * $_SESSION['cart'][$medicine_id]['price'] : 0;

    echo json_encode(["total" => number_format($total, 2), "subtotal" => number_format($subtotal, 2)]);
    exit;
}

// ✅ Handle removing an item
if (isset($_GET['remove'])) {
    $medicine_id = intval($_GET['remove']);
    unset($_SESSION['cart'][$medicine_id]);
    header("Location: cart.php");
    exit;
}

// ✅ Handle clearing the cart
if (isset($_GET['clear'])) {
    $_SESSION['cart'] = [];
    header("Location: cart.php");
    exit;
}

include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* ✅ Background section */
        .cart-section {
            background: url('images/banner3.jpg') no-repeat center center/cover;
            color: white;
            text-align: center;
            padding: 40px 20px;
            min-height: auto;
        }

        /* ✅ Cart container */
        .cart-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 10px;
            width: 70%;
            margin: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        h2 {
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        /* ✅ Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            color: black;
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
        }

        th {
            background-color: #1d5636;
            color: white;
            padding: 12px;
            font-size: 16px;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* ✅ Input styling */
        input[type="number"] {
            width: 60px;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            text-align: center;
            font-size: 14px;
        }

        /* ✅ Button styling */
        button, .btn-clear, .btn-remove {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            display: inline-block;
            text-decoration: none;
            margin-top: 10px;
        }

        button:hover, .btn-clear:hover, .btn-remove:hover {
            background-color: #218838;
        }

        .btn-clear {
            background-color: red;
        }

        .btn-clear:hover {
            background-color: darkred;
        }

        /* ✅ Link styling */
        a {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            color: darkred;
        }

        .empty-cart {
            font-size: 18px;
            color: red;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="cart-section">
    <div class="cart-container">
        <?php if (!empty($_SESSION['cart'])): ?>
            <h2>Your Shopping Cart</h2>
            <table>
                <tr>
                    <th>Medicine</th>
                    <th>Price (₹)</th>
                    <th>Quantity</th>
                    <th>Total (₹)</th>
                    <th>Action</th>
                </tr>
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $item):
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td>₹<?php echo number_format($item['price'], 2); ?></td>
                        <td>
                            <input type="number" class="update-quantity" data-id="<?php echo $item['id']; ?>" value="<?php echo $item['quantity']; ?>" min="1">
                        </td>
                        <td class="subtotal" data-id="<?php echo $item['id']; ?>">₹<?php echo number_format($subtotal, 2); ?></td>
                        <td>
                            <a href="cart.php?remove=<?php echo $item['id']; ?>" class="btn-remove">Remove</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Total:</strong></td>
                    <td id="cart-total"><strong>₹<?php echo number_format($total, 2); ?></strong></td>
                    <td><a href="cart.php?clear=true" class="btn-clear">Clear Cart</a></td>
                </tr>
            </table>
            <br>
            <a href="checkout.php"><button>Proceed to Checkout</button></a>
        <?php else: ?>
            <p class="empty-cart">Your cart is empty.</p>
        <?php endif; ?>
    </div>
</div>

<script>
    $(".update-quantity").on("input", function() {
        let id = $(this).data('id');
        let newQuantity = $(this).val();

        $.post("cart.php", { update_quantity: true, medicine_id: id, new_quantity: newQuantity }, function(response) {
            let data = JSON.parse(response);
            $(`.subtotal[data-id='${id}']`).text(`₹${data.subtotal}`);
            $("#cart-total").text(`₹${data.total}`);
        });
    });
</script>

</body>
</html>

<?php include 'footer.php'; ?>
