<?php
session_start();
include 'config.php';


$resourceExists = true; 
if (!$resourceExists) {
    header("Location: 404.php");
    exit();
}

$conn = mysqli_connect('localhost', 'root', '', 'maestre');
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $admin_query = "SELECT * FROM admins WHERE username = ?";
    $stmt = mysqli_prepare($conn, $admin_query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $admin_result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($admin_result) > 0) {
        $admin = mysqli_fetch_assoc($admin_result);
        if (password_verify($password, $admin['password'])) {
            session_regenerate_id(true);
            $_SESSION['username'] = $admin['username'];
            $_SESSION['role'] = 'admin';
            header("Location: dashboard.php");
            exit();
        } else {
            $error_message = "Invalid username or password.";
        }
    } else {
        // Check if user is a regular user
        $user_query = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $user_query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $user_result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($user_result) > 0) {
            $user = mysqli_fetch_assoc($user_result);
            if (password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                header("Location: user.php");
                exit();
            } else {
                $error_message = "Invalid username or password.";
            }
        } else {
            $error_message = "Invalid username or password.";
        }
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechMaster Pro</title>
    <style>
       
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, white, skyblue);
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .header {
            display: flex;
            align-items: center;
            padding: 20px;
            width: 100%;
            background: linear-gradient(to right, white, skyblue);
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
        .login-container {
            width: 400px;
            padding: 40px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .login-container h3 {
            margin-bottom: 20px;
            font-size: 20px;
            color: #333;
        }
        .login-container hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }
        .login-container label {
            display: block;
            margin: 10px 0 5px;
            font-size: 14px;
            color: #333;
            text-align: left;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .login-container .actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .login-container .actions a {
            font-size: 14px;
            color: black;
            text-decoration: none;
            padding-top: 8px;
        }
        .login-container input[type="submit"] {
            padding: 10px 20px;
            background-color: skyblue;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .login-container input[type="submit"]:hover {
            background-color: deepskyblue;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .contact-info {
            margin-top: 20px;
            text-align: center;
        }
        .contact-info hr {
            border: none;
            margin: 10px 0;
        }
        .contact-info p {
            margin: 10px 0;
            font-size: 16px;
            color: #333;
        }
    </style>
</head>
<body>

    <div class="header">
      
        <h1>TechMaster Pro</h1>
    </div>

    <div class="login-container">
        <h3>User Authentication</h3>
        <hr>
        <?php if (!empty($error_message)) : ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Password" required>
            
            <div class="actions">
                <a href="register.php">Register</a>
                <input type="submit" value="Login">
            </div>
        </form>
        <br>
        <a>Forgot your password? </a> <a href="forgot.php">Click here</a>
    </div>

    <br><br><br>
    <div class="contact-info">
        <hr>
        <p>For questions and comments, email us at <a href="mailto:TechMaster Pro@gmail.com">TechMaster Pro@gmail.com</a></p>
    </div>

</body>
</html>
