<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: home.php");
    exit();
}

$username = $_SESSION['username'];
$conn = mysqli_connect('localhost', 'root', '', 'maestre') or die('Connection failed');

if (isset($_POST['confirm_delete'])) {
    $sql = "DELETE FROM users WHERE username='$username'";
    if (mysqli_query($conn, $sql)) {
        session_destroy();
        header("Location: home.php");
        exit();
    } else {
        echo "Error deleting account.";
    }
}

if (isset($_POST['cancel'])) {
    header("Location: user.php");
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <link rel="stylesheet" href="css/delete.css"> 
</head>
<body>
    <div class="container">
        <div class="delete-box">
            <h1>Confirm Account Deletion</h1>
            <p class="warning">Are you sure you want to delete your account? This action cannot be undone.</p>
            <form action="account_delete.php" method="POST">
                <button type="submit" name="confirm_delete" class="btn btn-danger">Yes, Delete My Account</button>
                <button type="submit" name="cancel" class="btn btn-cancel">No, Cancel</button>
            </form>
        </div>
    </div>
</body>
</html>
