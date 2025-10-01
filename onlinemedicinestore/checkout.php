<?php
ob_start();
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';
include 'header.php';

// ✅ Clear cart action
if (isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']);
    header("Location: checkout.php");
    exit();
}
?>

<style>
/* ✅ Checkout Banner Section */
.checkout-section {
    background: url('images/banner3.jpg') no-repeat center center/cover;
    min-height: 60vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

/* ✅ Checkout Page Styling */
.checkout-container {
    max-width: 800px;
    width: 100%;
    background: white;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    padding: 20px;
}

/* ✅ Table Styling */
.checkout-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.checkout-table th,
.checkout-table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}

.checkout-table th {
    background-color: #155724;
    color: white;
}

/* ✅ Total Amount */
.total-amount {
    font-size: 20px;
    font-weight: bold;
    color: #28a745;
    margin-top: 15px;
}

/* ✅ Confirm Order & Clear Cart Buttons */
.confirm-btn,
.clear-btn {
    display: inline-block;
    margin-top: 20px;
    padding: 12px 20px;
    font-size: 16px;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

.confirm-btn {
    background: #28a745;
}

.confirm-btn:hover {
    background: #218838;
}

.clear-btn {
    background: #dc3545;
}

.clear-btn:hover {
    background: #c82333;
}

/* ✅ Empty Cart Message */
.empty-cart {
    font-size: 18px;
    color: red;
    margin-top: 20px;
}

/* ✅ Footer Fix */
.footer {
    text-align: center;
    background: #007bff;
    color: white;
    padding: 15px;
    margin-top: 30px;
    width: 100%;
}
</style>

<div class="checkout-section">
    <div class="checkout-container">
        <h2>Checkout Page</h2>

        <?php
        // ✅ Ensure cart exists
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            echo "<p class='empty-cart'>Your cart is empty. <a href='index.php'>Go back to shopping</a></p>";
            echo "</div></div>";
            include 'footer.php';
            exit();
        }

        // ✅ Extract cart item IDs safely
        $cart_ids = array_keys($_SESSION['cart']);
        $cart_ids_string = implode(",", array_map('intval', $cart_ids));

        // ✅ Fetch medicines from the database
        $query = "SELECT * FROM medicines WHERE id IN ($cart_ids_string)";
        $result = $conn->query($query);

        echo "<table class='checkout-table'>";
        echo "<tr><th>Medicine</th><th>Price (₹)</th><th>Quantity</th><th>Subtotal (₹)</th></tr>";

        $total = 0;
        $items = [];

        while ($row = $result->fetch_assoc()) {
            $medicine_id = $row['id'];
            $price = floatval($row['price']);
            $quantity = intval($_SESSION['cart'][$medicine_id]['quantity']);
            $subtotal = $price * $quantity;
            $total += $subtotal;

            echo "<tr>
                    <td>{$row['name']}</td>
                    <td>₹{$price}</td>
                    <td>{$quantity}</td>
                    <td>₹{$subtotal}</td>
                  </tr>";

            // ✅ Store items for stock update later
            $items[] = ['id' => $medicine_id, 'quantity' => $quantity, 'price' => $price];
        }

        echo "</table>";
        echo "<p class='total-amount'>Total Amount: ₹$total</p>";

        // ✅ Payment/Order confirmation logic
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_order'])) {
            $address = $_POST['address'];
            $payment_method = $_POST['payment_method'];

            if ($payment_method == "COD") {
                $status = "Pending (COD)";
            } else {
                $_SESSION['total_amount'] = $total;
                header("Location: payment.php?amount=$total"); // ✅ Redirect with amount
                exit();
            }

            $conn->begin_transaction();
            try {
                $user_id = $_SESSION['user_id'];

                // ✅ Insert order into the orders table
                $insert_order = $conn->prepare("INSERT INTO orders (user_id, address, amount, payment_method, status) VALUES (?, ?, ?, ?, ?)");
                $insert_order->bind_param("isdss", $user_id, $address, $total, $payment_method, $status);
                $insert_order->execute();
                $order_id = $conn->insert_id;

                // ✅ Insert order items and update stock
                foreach ($items as $item) {
                    $medicine_id = $item['id'];
                    $quantity = $item['quantity'];
                    $price = $item['price'];

                    $insert_item = $conn->prepare("INSERT INTO order_items (order_id, medicine_id, quantity, price) VALUES (?, ?, ?, ?)");
                    $insert_item->bind_param("iiid", $order_id, $medicine_id, $quantity, $price);
                    $insert_item->execute();

                    $update_stock = $conn->prepare("UPDATE medicines SET stock = stock - ? WHERE id = ? AND stock >= ?");
                    $update_stock->bind_param("iii", $quantity, $medicine_id, $quantity);
                    $update_stock->execute();

                    if ($update_stock->affected_rows == 0) {
                        throw new Exception("Stock insufficient for item ID: $medicine_id");
                    }
                }

                $conn->commit();
                unset($_SESSION['cart']);

                echo "<p><strong>Checkout successful!</strong> Your order has been placed.</p>";
                echo "<p><a href='index.php'>Continue Shopping</a></p>";

            } catch (Exception $e) {
                $conn->rollback();
                echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<form method='POST'>
                    <input type='text' name='address' placeholder='Enter your address' required><br>
                    <select name='payment_method' required>
                        <option value='COD'>Cash on Delivery</option>
                        <option value='Online'>Online Payment</option>
                    </select><br>
                    <button type='submit' name='confirm_order' class='confirm-btn'>Confirm Order</button>
                    <button type='submit' name='clear_cart' class='clear-btn'>Clear Cart</button>
                  </form>";
        }
        ?>

    </div>
</div>

<?php include 'footer.php'; ?>
