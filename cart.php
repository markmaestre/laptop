<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quantities'])) {
    foreach ($_POST['quantities'] as $cart_id => $quantity) {
        $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
        $stmt->bind_param("ii", $quantity, $cart_id);
        $stmt->execute();
    }
}


if (isset($_GET['delete'])) {
    $cart_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->bind_param("i", $cart_id);
    $stmt->execute();
    header("Location: cart.php");
    exit();
}


$sql = "SELECT cart.id AS cart_id, products.name, products.img, products.price, cart.quantity
        FROM cart
        JOIN products ON cart.product_id = products.id
        WHERE cart.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #2d2d2d;
            color: #ffffff;
        }
        .container {
            margin-top: 30px;
            border-radius: 10px;
            padding: 20px;
            background-color: #3a3a3a;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .table {
            background-color: #4a4a4a;
            color: #ffffff;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-danger {
            background-color: #e74c3c;
            border: none;
        }
        .btn-danger:hover {
            background-color: #c0392b;
        }
        .btn-primary {
            background-color: #3498db;
            border: none;
        }
        .btn-primary:hover {
            background-color: #2980b9;
        }
        .btn-success {
            background-color: #2ecc71;
            border: none;
        }
        .btn-success:hover {
            background-color: #27ae60;
        }
        input[type="number"] {
            width: 60px;
            margin: auto;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>My Cart</h2>
        <a href="user.php" class="btn btn-secondary mb-3">Back to User Page</a>
        <form method="POST" action="cart.php">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): 
                        $item_total = $row['price'] * $row['quantity'];
                        $total += $item_total;
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td>₱<?php echo number_format($row['price'], 2); ?></td>
                            <td>
                                <input type="number" name="quantities[<?php echo $row['cart_id']; ?>]" 
                                       value="<?php echo $row['quantity']; ?>" min="1">
                            </td>
                            <td>₱<?php echo number_format($item_total, 2); ?></td>
                            <td>
                                <a href="cart.php?delete=<?php echo $row['cart_id']; ?>" class="btn btn-danger">Remove</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <h4>Total: ₱<?php echo number_format($total, 2); ?></h4>
                <button type="submit" class="btn btn-primary">Update Cart</button>
            </div>
        </form>
        <a href="checkout.php" class="btn btn-success mt-3">Proceed to Checkout</a>
    </div>
</body>
</html>
