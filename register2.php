<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'maestre') or die('Connection failed');


$resourceExists = true;

if (!$resourceExists) {
    header("Location: 404.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['address'] = $_POST['address'];
    $_SESSION['zip_code'] = $_POST['zip_code'];
    $_SESSION['district'] = $_POST['district'];
    $_SESSION['province'] = $_POST['province'];

    header("Location: register3.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration - Step 2</title>
    <style>
      body {
    margin: 0;
    font-family: 'Arial', sans-serif;
    background: linear-gradient(to bottom, #ffffff, #a8d9f2);
    height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.header {
    display: flex;
    align-items: center;
    padding: 20px;
    width: 100%;
    background: linear-gradient(to right, #ffffff, #a8d9f2);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    position: fixed;
    top: 0;
    left: 0;
}

.header img {
    height: 60px;
    margin-right: 20px;
}

.header h1 {
    margin: 0;
    font-size: 24px;
    color: #333;
}

.module-title {
    text-align: center;
    margin: 80px 0 30px;
    font-size: 28px;
    color: #333;
    font-weight: 600;
}

.register-container {
    width: 100%;
    max-width: 500px;
    padding: 30px;
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.register-container h3 {
    margin-bottom: 20px;
    font-size: 22px;
    color: #333;
}

.register-container hr {
    border: none;
    border-top: 1px solid #ddd;
    margin: 20px 0;
}

.register-container label {
    display: block;
    margin: 15px 0 5px;
    font-size: 16px;
    color: #555;
    text-align: left;
}

.register-container input[type="text"],
.register-container input[type="submit"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 6px;
    box-sizing: border-box;
    font-size: 16px;
}

.register-container input[type="text"] {
    border: 1px solid #ddd;
}

.register-container input[type="text"]:focus {
    border-color: #a8d9f2;
    outline: none;
}

.register-container input[type="submit"] {
    background-color: #a8d9f2;
    border: none;
    color: white;
    font-weight: bold;
    cursor: pointer;
}

.register-container input[type="submit"]:hover {
    background-color: #87c7e2;
}

.error-message {
    color: red;
    font-size: 14px;
    margin-bottom: 15px;
}

    </style>
</head>
<body>


    <h2 class="module-title">User Registration - Step 2</h2>

    <div class="register-container">
        <h3>Permanent Address</h3>
        <hr>
        <form action="" method="POST">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" placeholder="Address" required>
            
            <label for="zip_code">Zip Code:</label>
            <input type="text" id="zip_code" name="zip_code" placeholder="Zip Code" required>
            
            <label for="district">Congressional District:</label>
            <input type="text" id="district" name="district" placeholder="Congressional District" required>
            
            <label for="province">Province:</label>
            <input type="text" id="province" name="province" placeholder="Province" required>
            
            <input type="submit" value="Next">
        </form>
    </div>
</body>
</html>
