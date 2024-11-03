<?php
session_start();
include 'config.php';

$resourceExists = true;

if (!$resourceExists) {
    header("Location: 404.php");
    exit();
}

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: home.php");
    exit();
}

$sql = "SELECT id, username, first_name, last_name, email FROM users";
$result = $conn->query($sql);

$sql_current_month = "SELECT COUNT(*) as total_users FROM users WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
$sql_last_month = "SELECT COUNT(*) as total_users FROM users WHERE MONTH(created_at) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH) AND YEAR(created_at) = YEAR(CURRENT_DATE())";

$current_month_result = $conn->query($sql_current_month);
$last_month_result = $conn->query($sql_last_month);

$current_month_users = $current_month_result->fetch_assoc()['total_users'];
$last_month_users = $last_month_result->fetch_assoc()['total_users'];

if ($last_month_users > 0) {
    $user_percentage_change = (($current_month_users - $last_month_users) / $last_month_users) * 100;
} else {
    $user_percentage_change = 100;
}

$user_percentage_sign = $user_percentage_change >= 0 ? 'up' : 'down';
$user_percentage_color = $user_percentage_change >= 0 ? 'success' : 'danger';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f6fa;
        }
        .navbar-vertical {
            background-color: #2c3e50;
        }
        .navbar-brand h3 {
            color: #ecf0f1;
            font-weight: bold;
        }
        .navbar-vertical .nav-link {
            color: #ecf0f1;
            font-size: 1.1rem;
        }
        .navbar-vertical .nav-link.active {
            background-color: #34495e;
            border-radius: 5px;
        }
        .header-title h1 {
            font-weight: bold;
            color: #2c3e50;
        }
        .card {
            border-radius: 10px;
            transition: transform 0.2s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .card-icon {
            background-color: #3498db;
            padding: 10px;
            border-radius: 50%;
            font-size: 1.5rem;
        }
        .bg-light-maroon {
            background-color: #e74c3c;
        }
        .bg-surface-secondary {
            background-color: #f5f6fa;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .table thead th {
            background-color: #2c3e50;
            color: #fff;
        }
        .btn-primary, .btn-danger {
            border-radius: 20px;
            padding: 5px 15px;
        }
        .icon-container {
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="d-flex flex-column flex-lg-row h-lg-full">
        <nav class="navbar navbar-vertical h-lg-screen navbar-expand-lg px-0 py-3" id="navbarVertical">
            <div class="container-fluid">
                <a class="navbar-brand py-lg-2 mb-lg-5 px-lg-6 me-0" href="#">
                    <h3><i class="bi bi-shield-fill-check"></i> Admin</h3>
                </a>
                <div class="collapse navbar-collapse" id="sidebarCollapse">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link active" href="products.php"><i class="bi bi-house-door me-2"></i> Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="products.php"><i class="bi bi-box me-2"></i> Product</a></li>
                        <li class="nav-item"><a class="nav-link" href=""><i class="bi bi-people me-2"></i> Users</a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-star me-2"></i> Ratings</a></li>
                    </ul>
                    <ul class="navbar-nav mt-auto">
                        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-person-square me-2"></i> Account</a></li>
                        <li class="nav-item"><a class="nav-link" href="home.php" onclick="return confirm('Are you sure you want to logout?')"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="h-screen flex-grow-1">
            <header class="bg-light py-4 shadow-sm">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="header-title h2 mb-0">TechMaster Pro Dashboard</h1>
                    </div>
                </div>
            </header>
            <main class="py-6">
                <div class="container-fluid">
                    <div class="row g-6 mb-6">
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card shadow-sm bg-light-maroon text-white">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="h6 font-semibold d-block">Ratings</span>
                                    </div>
                                    <div class="icon-container"><i class="bi bi-star"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card shadow-sm bg-light-maroon text-white">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="h6 font-semibold d-block">Future Product</span>
                                    </div>
                                    <div class="icon-container"><i class="bi bi-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card shadow-sm bg-light-maroon text-white">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="h6 font-semibold d-block">Users</span>
                                        <span class="h5 font-semibold"><?php echo $current_month_users; ?> Users</span>
                                    </div>
                                    <div class="icon-container"><i class="bi bi-people"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-sm mb-6">
                        <div class="card-header"><h5 class="mb-0">Manage Users</h5></div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr><th>ID</th><th>Username</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Actions</th></tr>
                                </thead>
                                <tbody>
                                    <?php if ($result->num_rows > 0) : ?>
                                        <?php while ($row = $result->fetch_assoc()) : ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['username']; ?></td>
                                                <td><?php echo $row['first_name']; ?></td>
                                                <td><?php echo $row['last_name']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td>
                                                    <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                                    <a href="delete_user.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else : ?>
                                        <tr><td colspan="6">No users found.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>
