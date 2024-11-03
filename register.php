<?php
session_start();

$resourceExists = true;

if (!$resourceExists) {
    header("Location: 404.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['first_name'] = $_POST['first_name'];
    $_SESSION['last_name'] = $_POST['last_name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['birthday'] = $_POST['birthday'];
    $_SESSION['gender'] = $_POST['gender'];

    header("Location: register2.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration - Step 1</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, white, skyblue);
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
            background: linear-gradient(to right, white, skyblue);
            position: absolute;
            top: 0;
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
            margin: 80px 0 20px;
            font-size: 32px;
            color: #333;
        }
        .register-container {
            width: 450px;
            padding: 50px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .register-container h3 {
            margin-bottom: 20px;
            font-size: 20px;
            color: #333;
        }
        .register-container hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }
        .register-container label {
            display: block;
            margin: 5px 0;
            font-size: 14px;
            color: #333;
            text-align: left;
        }
        .register-container input[type="text"],
        .register-container input[type="email"],
        .register-container input[type="password"],
        .register-container input[type="date"],
        .register-container select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .register-container input[type="submit"] {
            padding: 10px;
            background-color: skyblue;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }
        .register-container input[type="submit"]:hover {
            background-color: deepskyblue;
        }
    </style>
</head>
<body>

 
    <h2 class="module-title">User Registration - Step 1</h2>

    <div class="register-container">
        <h3>Personal Details</h3>
        <hr>
        <form action="" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Username" required>
            
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" placeholder="First Name" required>
            
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" placeholder="Last Name" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Password" required>
            
            <label for="birthday">Birthday:</label>
            <input type="date" id="birthday" name="birthday" required>
            
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
            
            <input type="submit" value="Next">
        </form>
    </div>

</body>
</html>
