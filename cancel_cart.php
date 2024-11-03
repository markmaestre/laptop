<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];

    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        echo "Cart canceled successfully.";
    } else {
        echo "Failed to cancel cart.";
    }
    $stmt->close();
    $conn->close();
}
?>
