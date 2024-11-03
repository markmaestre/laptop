<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id']; 
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

   
    $stmt = $conn->prepare("SELECT stock FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $stmt->bind_result($stock);
    $stmt->fetch();
    $stmt->close();

    
    if ($quantity > $stock) {
        echo json_encode(['status' => 'error', 'message' => 'Not enough stock available']);
        exit();
    }


    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();
    $existing = $stmt->get_result()->fetch_assoc();

    if ($existing) {
      
        $newQuantity = $existing['quantity'] + $quantity;
        
      
        if ($newQuantity > $stock) {
            echo json_encode(['status' => 'error', 'message' => 'Not enough stock available']);
            exit();
        }
        
        $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("iii", $newQuantity, $userId, $productId);
    } else {
        
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $userId, $productId, $quantity);
    }

    if ($stmt->execute()) {
        // Reduce stock in the products table
        $newStock = $stock - $quantity;
        $stmt = $conn->prepare("UPDATE products SET stock = ? WHERE id = ?");
        $stmt->bind_param("ii", $newStock, $productId);
        $stmt->execute();
        
        echo json_encode(['status' => 'success', 'message' => 'Added to cart']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add to cart']);
    }

    $stmt->close();
    $conn->close();
}
?>
