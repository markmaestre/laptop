<?php
session_start();


if (!isset($_SESSION['username'])) {
    header("Location: home.php");
    exit();
}

$username = $_SESSION['username'];
$conn = mysqli_connect('localhost', 'root', '', 'maestre') or die('Connection failed');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
    $targetDir = "img/";
    $profilePicture = $_FILES['profile_picture']['name'];
    $targetFile = $targetDir . basename($profilePicture);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

  
    if ($profilePicture) {
        $check = getimagesize($_FILES['profile_picture']['tmp_name']);
        if ($check === false) {
            $uploadOk = 0;
        }
    }

 
    if ($_FILES['profile_picture']['size'] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

  
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }


    if ($uploadOk == 1 && move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFile)) {
        
        $sql = "UPDATE users SET profile_picture='$profilePicture' WHERE username='$username'";
        mysqli_query($conn, $sql);
    }


    $newUsername = mysqli_real_escape_string($conn, $_POST['username']);
    if (!empty($newUsername) && $newUsername != $username) {
       
        $checkQuery = "SELECT * FROM users WHERE username = '$newUsername'";
        $checkResult = mysqli_query($conn, $checkQuery);
        if (mysqli_num_rows($checkResult) == 0) {
            $sql = "UPDATE users SET username='$newUsername' WHERE username='$username'";
            if (mysqli_query($conn, $sql)) {
                $_SESSION['username'] = $newUsername;
                $username = $newUsername;
            }
        } else {
            echo "Username already exists.";
        }
    }

    header("Location: user.php");
    exit();
}

mysqli_close($conn);
