<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}


$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM products WHERE name LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_param = "%" . $search . "%";
    $stmt->bind_param("s", $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #2d2d2d;
            color: #ffffff;
        }
        .card {
            background-color: #3a3a3a;
            color: #ffffff;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
            text-align: center;
            margin: 0 auto;
            height: 100%;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }
        .card-img-top {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        .product-info {
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }
        .product-info h5 {
            font-size: 1.2rem;
            font-weight: bold;
            margin-top: 10px;
        }
        .product-info .price {
            font-size: 1.5rem;
            color: #00ff99;
            font-weight: bold;
            margin: 10px 0;
        }
        .btn-container {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .btn-add-to-cart, .btn-view-details {
            border: none;
            font-weight: bold;
            padding: 8px 12px;
            border-radius: 8px;
            transition: background-color 0.3s;
            font-size: 0.9rem;
        }
        .btn-add-to-cart {
            background-color: #00ff99;
            color: #333;
        }
        .btn-add-to-cart:hover {
            background-color: #00cc7a;
        }
        .btn-view-details {
            background-color: #008cff;
            color: #ffffff;
        }
        .btn-view-details:hover {
            background-color: #0073cc;
        }
        .stock-info {
            margin-top: 10px;
        }
        .cart-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 24px;
            color: #ffffff;
            text-decoration: none;
        }
        .btn-back {
            margin-bottom: 20px;
            background-color: #007bff;
            color: #ffffff;
        }
        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">All Products</h2>
        <h4 class="mb-4">Logged in as: <?php echo htmlspecialchars($_SESSION['username']); ?></h4>
        
        <!-- Back Button -->
        <a href="user.php" class="btn btn-back">Back to User Page</a>

        <!-- Cart Icon -->
        <a href="cart.php" class="cart-icon">
            <i class="fas fa-shopping-cart"></i>
        </a>
        
        <!-- Search Bar -->
        <form method="GET" action="all_product.php" class="mb-4">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search for products" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <!-- Product Container -->
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4 col-lg-3 mb-4 d-flex">
                        <div class="card">
                            <img src="<?php echo htmlspecialchars($row['img']); ?>" class="card-img-top" alt="Product Image">
                            <div class="card-body product-info">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                                <p class="price">₱<?php echo number_format($row['price'], 2); ?></p>
                                
                                <div class="stock-info">
                                    <p>Stock: <span id="stock-<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['stock']); ?></span> available</p>
                                    <input type="number" min="1" max="<?php echo htmlspecialchars($row['stock']); ?>" value="1" class="quantity-input" id="quantity-<?php echo $row['id']; ?>">
                                </div>

                                <div class="btn-container">
                                    <button class="btn btn-add-to-cart" data-product-id="<?php echo $row['id']; ?>">Add to Cart</button>
                                    <button class="btn btn-view-details">View Details</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No products found.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.btn-add-to-cart').on('click', function () {
                var productId = $(this).data('product-id');
                var quantity = $('#quantity-' + productId).val();

                $.ajax({
                    url: 'add_to_cart.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { product_id: productId, quantity: quantity },
                    success: function (response) {
                        alert(response.message);
                    },
                    error: function () {
                        alert('Failed to add to cart');
                    }
                });
            });
        });
    </script>
</body>
</html>
