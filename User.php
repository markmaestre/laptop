<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: home.php");
    exit();
}

$username = $_SESSION['username'];
$userImage = 'img/default-image.svg';
$userId = $_SESSION['user_id']; 

$conn = mysqli_connect('localhost', 'root', '', 'maestre') or die('Connection failed');


$query = "SELECT id, profile_picture FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $userImage = 'img/' . $row['profile_picture'];
    $_SESSION['user_id'] = $row['id']; 
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Dashboard</title>
    <link rel="stylesheet" href="css/style.css" />
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet" />
    <style>
        .bg-surface-secondary {
            background-color: skyblue !important;
        }
        .navbar-vertical .nav-link {
            padding: 1rem 1.5rem;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }
        .navbar-vertical .nav-link i {
            font-size: 1.5rem;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 100%;
        }

        .navbar-vertical {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .header-title {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-align: center;
        }
        header.bg-surface-primary {
            background: linear-gradient(to bottom, white, white 35%, skyblue 100%);
        }
        .header-title img {
            width: 40px;
        }
        .bg-light-maroon {
            background-color: #d96b7c;
        }
        .text-light-maroon {
            color: #d96b7c;
        }
        .card-icon {
            background-color: #d96b7c;
        }
    </style>
</head>
<body>
    <div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
        <nav class="navbar show navbar-vertical h-lg-screen navbar-expand-lg px-0 py-3 navbar-light border-bottom border-bottom-lg-0 border-end-lg" id="navbarVertical">
            <div class="container-fluid">
                <button class="navbar-toggler ms-n2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand py-lg-2 mb-lg-5 px-lg-6 me-0" href="#">
                    <h3 class="text-success">
                        <img src="<?php echo $userImage; ?>" width="40" class="rounded-circle" />
                        <span class="text-info"><?php echo $username; ?> ID: <?php echo $userId; ?></span> <!-- Display user ID -->
                    </h3>
                </a>
                <div class="navbar-user d-lg-none">
                    <div class="dropdown">
                        <a href="#" id="sidebarAvatar" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="avatar-parent-child">
                                <img alt="User Image" src="<?php echo $userImage; ?>" class="avatar avatar- rounded-circle" />
                                <span class="avatar-child avatar-badge bg-success"></span>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarAvatar">
                            <a href="#" class="dropdown-item">Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <a href="#" class="dropdown-item">Billing</a>
                            <hr class="dropdown-divider" />
                            <a href="login.php" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </div>
                <div class="collapse navbar-collapse" id="sidebarCollapse">
                    <ul class="navbar-nav">
                    <li class="nav-item">
    <a class="nav-link" href="All_product.php">
        <i class="bi bi-box"></i> Product
    </a>
</li>
<br>

<li class="nav-item">
    <a class="nav-link" href="cart.php">
        <i class="bi bi-cart"></i> Cart
    </a>
</li>
<br>

<li class="nav-item">
    <a class="nav-link" href="checkout.php">
        <i class="bi bi-journal-check"></i> Transaction
    </a>
</li>
<br>

<li class="nav-item">
    <a class="nav-link" href="order_history.php">
        <i class="bi bi-clock-history"></i> Product History
    </a>
</li>

                        <br>
                    
                    </ul>
                    <hr class="navbar-divider my-5 opacity-20" />
                    <div class="mt-auto">
                        <ul class="navbar-nav">
                        <li class="nav-item">
    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#accountModal">
        <i class="bi bi-person-square"></i> Account
    </a>
</li>
                            <li class="nav-item">
                                <a class="nav-link" href="login.php" onclick="return confirm('Are you sure you want to logout?')">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div class="h-screen flex-grow-1 overflow-y-lg-auto">
            <header class="bg-surface-primary border-bottom pt-6">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <div class="header-title">
                                <h1 class="h2 mb-0 ls-tight">TechMaster Pro</h1>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs mt-4 overflow-x border-0">
                        <li class="nav-item">
                            <a href="#" class="nav-link active">All</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link font-regular">Events</a>
                        </li>
                    </ul>
                </div>
            </header>
            <main class="py-6 bg-surface-secondary">
                <div class="container-fluid">
                    <div class="row g-6 mb-6">
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card shadow border-0 bg-light-maroon" data-bs-toggle="modal" data-bs-target="#memoryModal">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <span class="h6 font-semibold text-muted text-sm d-block mb-2">Product</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape card-icon text-white text-lg rounded-circle">
                                                <i class="bi bi-box"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2 mb-0 text-sm"></div>
                                </div>
                            </div>
                        </div>

  
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card shadow border-0 bg-light-maroon" data-bs-toggle="modal" data-bs-target="#reasoningModal">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <span class="h6 font-semibold text-muted text-sm d-block mb-2">Cart</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape card-icon text-white text-lg rounded-circle">
                                                <i class="bi bi-cart"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2 mb-0 text-sm"></div>
                                </div>
                            </div>
                        </div>

               
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card shadow border-0 bg-light-maroon" data-bs-toggle="modal" data-bs-target="#attentionModal">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <span class="h6 font-semibold text-muted text-sm d-block mb-2">Transaction</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape card-icon text-white text-lg rounded-circle">
                                                <i class="bi bi-journal-check"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2 mb-0 text-sm"></div>
                                </div>
                            </div>
                        </div>

                    
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card shadow border-0 bg-light-maroon" data-bs-toggle="modal" data-bs-target="#coordinationModal">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <span class="h6 font-semibold text-muted text-sm d-block mb-2">Product History</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape card-icon text-white text-lg rounded-circle">
                                                <i class="bi bi-clock-history"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2 mb-0 text-sm"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <div class="modal fade" id="memoryModal" tabindex="-1" aria-labelledby="memoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="memoryModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
               
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="reasoningModal" tabindex="-1" aria-labelledby="reasoningModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reasoningModalLabel" style = text-align:center></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
             
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="attentionModal" tabindex="-1" aria-labelledby="attentionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="attentionModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
              
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

  
    <div class="modal fade" id="coordinationModal" tabindex="-1" aria-labelledby="coordinationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="coordinationModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountModalLabel">Manage Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img src="<?php echo $userImage; ?>" width="80" class="rounded-circle mb-3" alt="User Image">
                        <h6><?php echo $username; ?></h6>
                    </div>
                    <form action="account_update.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="profilePicture" class="form-label">Change Profile Picture</label>
                            <input class="form-control" type="file" id="profilePicture" name="profile_picture">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                    <hr>
                    <form action="account_delete.php" method="POST">
                        <button type="submit" class="btn btn-danger w-100">Delete Account</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
