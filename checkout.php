<?php
session_start();
include 'config.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
}

$userId = $_SESSION['user_id'];
$cartData = []; 


$stmt = $conn->prepare("SELECT c.product_id, c.quantity, p.price 
                        FROM cart c 
                        JOIN products p ON c.product_id = p.id 
                        WHERE c.user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $cartData[] = $row; 
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];
    $status = 'Processing'; 

    foreach ($cartData as $item) {
        $productId = $item['product_id'];
        $quantity = $item['quantity'];
        $totalPrice = $item['price'] * $quantity;

      
        $stmt = $conn->prepare("INSERT INTO orders (user_id, product_id, quantity, total_price, name, address, payment_method, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiidssss", $userId, $productId, $quantity, $totalPrice, $name, $address, $payment_method, $status); // Bind parameters including status

        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;  
            exit();
        }
    }

  
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    if (!$stmt->execute()) {
        echo "Error deleting from cart: " . $stmt->error; 
        exit();
    }

    header("Location: confirmation.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .checkout-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        form {
            display: flex;
            flex-direction: column; 
            margin-bottom: 30px;
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
            color: #34495e;
        }

        input[type="text"],
        select {
            width: 95%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #dcdcdc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="text"]:focus,
        select:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }

        button {
            background-color: #3498db;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-top: 30px;
            margin-bottom: 10px;
        }

        .cart-items {
            list-style-type: none;
            padding: 0;
        }

        .cart-item {
            display: flex;
            justify-content: space-between; 
            background-color: #f9f9f9;
            padding: 15px;
            margin: 10px 0;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .cart-item span {
            display: block;
            color: #7f8c8d;
            margin-left: 10px;
        }

        .total-price {
            font-weight: bold;
            color: #e74c3c;
            text-align: center; 
        }

        .back-button {
            background-color: #e67e22; 
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            margin-bottom: 20px; 
            transition: background-color 0.3s ease;
            
        }

        .back-button:hover {
            background-color: #d35400; 
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <h1>Checkout</h1>
        <form method="POST" action="">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>
            
            <label for="payment_method">Payment Method:</label>
            <select id="payment_method" name="payment_method" required>
                <option value="COD">Cash on Delivery</option>
                <option value="GCash">GCash</option>
            </select>
            
            <button type="submit">Place Order</button>
        </form>

        <h2>Cart Items:</h2>
        <ul class="cart-items">
            <?php 
            $totalAmount = 0; 
            foreach ($cartData as $item): 
                $totalPrice = $item['price'] * $item['quantity'];
                $totalAmount += $totalPrice; 
            ?>
                <li class="cart-item">
                    <div>
                        <strong>Product ID:</strong> <?= $item['product_id'] ?>
                    </div>
                    <div>
                        <span>Quantity: <?= $item['quantity'] ?></span>
                        <span>Price: <?= number_format($totalPrice, 2) ?> PHP</span>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <h2 class="total-price">Total Amount: <?= number_format($totalAmount, 2) ?> PHP</h2>

       
        <a href="cart.php" class="back-button">Back to Cart</a>
    </div>
</body>
</html>
