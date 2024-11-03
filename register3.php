<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'maestre') or die('Connection failed');


$resourceExists = true;

if (!$resourceExists) {
    header("Location: 404.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $address = $_SESSION['address'];
    $zip_code = $_SESSION['zip_code'];
    $district = $_SESSION['district'];
    $province = $_SESSION['province'];

    $username = $_SESSION['username'];
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $password = password_hash($_SESSION['password'], PASSWORD_DEFAULT);
    $birthday = $_SESSION['birthday'];
    $gender = $_SESSION['gender'];

    $profile_picture = $_FILES['profile_picture']['name'];
    $target_dir = "img/";
    $target_file = $target_dir . basename($profile_picture);

    if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
   
        $register_query = "INSERT INTO users (username, first_name, last_name, email, password, birthday, gender, address, zip_code, district, province, profile_picture, role) 
                           VALUES ('$username', '$first_name', '$last_name', '$email', '$password', '$birthday', '$gender', '$address', '$zip_code', '$district', '$province', '$profile_picture', 'student')";

        if (mysqli_query($conn, $register_query)) {
            $_SESSION = array(); 
            header("Location: login.php");
            exit();
        } else {
            $error_message = "Registration failed. Please try again.";
        }
    } else {
        $error_message = "Failed to upload the profile picture. Please try again.";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration - Step 3</title>
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

.register-container input[type="file"] {
    width: 100%;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 6px;
}

.register-container input[type="file"]:focus {
    border-color: #a8d9f2;
    outline: none;
}

.register-container input[type="submit"] {
    padding: 12px 25px;
    background-color: #a8d9f2;
    border: none;
    border-radius: 6px;
    color: white;
    font-size: 16px;
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

   

    <h2 class="module-title">User Registration - Step 3</h2>

    <div class="register-container">
        <h3>Profile Picture</h3>
        <hr>
        <?php if (isset($error_message)) : ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="profile_picture">Upload Profile Picture:</label>
            <input type="file" id="profile_picture" name="profile_picture" required>
            
            <input type="submit" value="Complete Registration">
        </form>
    </div>

</body>
</html>
