<?php
session_start();
include 'config.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_product'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
      
        $img = $_FILES['img']['name'];
        $img_temp = $_FILES['img']['tmp_name'];
        $img_folder = "uploads/" . $img; 

        if (move_uploaded_file($img_temp, $img_folder)) {
            $sql = "INSERT INTO products (name, description, price, stock, img) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdis", $name, $description, $price, $stock, $img_folder);

            if ($stmt->execute()) {
                header("Location: products.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Failed to upload image.";
        }
    } elseif (isset($_POST['update_product'])) {
        
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];

        
        if ($_FILES['img']['name']) { 
            $img = $_FILES['img']['name'];
            $img_temp = $_FILES['img']['tmp_name'];
            $img_folder = "uploads/" . $img; 

            move_uploaded_file($img_temp, $img_folder);
            $sql = "UPDATE products SET name = ?, description = ?, price = ?, stock = ?, img = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdisi", $name, $description, $price, $stock, $img_folder, $id);
        } else {
            $sql = "UPDATE products SET name = ?, description = ?, price = ?, stock = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssisi", $name, $description, $price, $stock, $id);
        }

        if ($stmt->execute()) {
            header("Location: products.php"); 
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}


if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: products.php"); 
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch Products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h2, h3 {
            color: #333;
            margin-bottom: 10px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        form {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 5px;
            background: #f9f9f9;
            border: 1px solid #e0e0e0;
        }
        input[type="text"], input[type="number"], textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        img {
            width: 50px;
            height: auto;
            border-radius: 5px;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .edit-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
        }
        .edit-button:hover {
            background-color: #0056b3;
        }
        .delete-button {
            color: red;
            cursor: pointer;
        }
        .delete-button:hover {
            text-decoration: underline;
        }
      
        .modal {
            display: none; 
            position: fixed;
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto;
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Products Management</h2>
        
        <h3>Add New Product</h3>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Product Name" required>
            <textarea name="description" placeholder="Product Description" required></textarea>
            <input type="number" name="price" placeholder="Price" required step="0.01">
            <input type="number" name="stock" placeholder="Stock Quantity" required>
            <input type="file" name="img" required>
            <button type="submit" name="add_product">Add Product</button>
        </form>

        
        <h3>All Products</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo number_format($row['price'], 2); ?></td>
                        <td><?php echo $row['stock']; ?></td>
                        <td><img src="<?php echo $row['img']; ?>" alt="Product Image"></td>
                        <td class="actions">
                            <button class="edit-button" onclick="openModal(<?php echo $row['id']; ?>, '<?php echo $row['name']; ?>', '<?php echo $row['description']; ?>', <?php echo $row['price']; ?>, <?php echo $row['stock']; ?>)">Edit</button>
                            <a href="?delete_id=<?php echo $row['id']; ?>" class="delete-button" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7">No products found.</td></tr>
            <?php endif; ?>
        </table>
    </div>

   
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Edit Product</h3>
            <form id="editForm" method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="id" id="edit_id">
                <input type="text" name="name" id="edit_name" placeholder="Product Name" required>
                <textarea name="description" id="edit_description" placeholder="Product Description" required></textarea>
                <input type="number" name="price" id="edit_price" placeholder="Price" required step="0.01">
                <input type="number" name="stock" id="edit_stock" placeholder="Stock Quantity" required>
                <input type="file" name="img" id="edit_img">
                <button type="submit" name="update_product">Update Product</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(id, name, description, price, stock) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_description').value = description;
            document.getElementById('edit_price').value = price;
            document.getElementById('edit_stock').value = stock;

            document.getElementById('editModal').style.display = "block";
        }

        function closeModal() {
            document.getElementById('editModal').style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('editModal')) {
                closeModal();
            }
        }
    </script>
</body>
</html>
