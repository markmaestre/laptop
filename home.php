<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechMaster Pro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/home.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        header {
            background-color: #ffffff;
            padding: 10px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
        nav ul {
            list-style-type: none;
            display: flex;
            gap: 20px;
            padding: 0;
        }
        nav a {
            color: black;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            color: #007bff;
        }
        .user-actions a {
            color: black;
            margin-left: 15px;
        }
        .user-actions a:hover {
            color: #007bff;
        }
        .hero-carousel .carousel-item img {
            width: 100%;
            height: auto;
            object-fit: cover;
            max-height: 100vh; 
        }
        .laptops, .categories {
            padding: 20px 0;
        }
        .laptop-card {
            text-align: center;
            transition: transform 0.3s;
            margin-bottom: 30px;
        }
        .laptop-card:hover {
            transform: scale(1.05);
        }
        .laptop-card img {
            width: 100%;
            height: 200px; 
            object-fit: cover; 
            border-radius: 5px; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        footer {
            background-color: #007bff;
            color: white;
            padding: 20px 0;
        }
        .footer-column {
            flex: 1;
            margin: 10px;
        }
        .footer-column h5 {
            font-weight: bold;
        }
        .social-links a {
            color: white;
            margin: 0 10px;
        }
        .social-links a:hover {
            color: #f8f9fa;
        }
    </style>
</head>
<body>
<header>
    <div class="container d-flex justify-content-between align-items-center">
        <div class="logo">TechMaster Pro</div>
        <nav>
            <ul>
                <li><a href="#featured-laptops"><i class="fas fa-laptop"></i> Laptops</a></li>
                <li><a href="#categories"><i class="fas fa-th-list"></i> Categories</a></li>
                <li><a href="#learning-guides"><i class="fas fa-lightbulb"></i> Learning Guides</a></li>
            </ul>
        </nav>
        <div class="user-actions">
            <a href="#"><i class="fas fa-search"></i></a>
            <a href="#"><i class="fas fa-heart"></i></a>
            <a href="login.php"><i class="fas fa-user"></i></a>
        </div>
    </div>
</header>

<section class="hero-carousel">
    <div id="heroCarousel" class="carousel slide" data-ride="carousel" data-interval="1000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://encrypted-tbn1.gstatic.com/shopping?q=tbn:ANd9GcQdSs6nkwERBRINREert826HwRMiRBEGK8JiI_xq30_dPL4HNxCW9dzZAFATrGkhQry7O1jZ8_PQ3ZRoSBKyPLlC2_wlYNX39z5GYHbd1o&usqp=CAE" class="d-block w-100" alt="Hero Slide 1">
            </div>
            <div class="carousel-item">
                <img src="https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcTLGdy2SJdMEmQfA3zG7cq074q2eoDpmUrstTZZwnD_ppEFXEtTlSnu6QyXj11QmMqX5zFyj6_yqZyFpPu2RjUL9BE0vAkoQZ2EaanWHxoahugeWebiVt9A&usqp=CAE" class="d-block w-100" alt="Hero Slide 2">
            </div>
        </div>
        <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</section>

<section id="featured-laptops" class="laptops">
    <div class="container">
        <h2 class="text-center">Featured Laptops</h2>
        <div class="row">
            <div class="col-md-4 laptop-card">
                <img src="https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcRHly9MM9GR4XmSOmjTcuZdyDnGzsMjDpyRKiIbohZiss44PPoLeMOzsTtznI5igWfru1yz8n9LP84dMvIbobou8zwhqdi6oVMAgwcOiZTjFoGvlVRyl6AWhA&usqp=CAE" alt="Laptop 1">
                <h3 style="color:black">TechMaster X1</h3>
                <p>Powerful performance for gaming and work.</p>
                <a href="#" class="btn btn-primary">View More</a>
            </div>
            <div class="col-md-4 laptop-card">
                <img src="https://encrypted-tbn0.gstatic.com/shopping?q=tbn:ANd9GcTmHiVZ2YhWy5aVaOpKkIOO6SZsQtTS45biTbSnyQw8-EZxB9XBgtk5A51HZDY8C5AG05FOND5lBCfevgR4iYvuNjFdbqLn7GiOaIOFw4MBm51G_hP2CdMflg&usqp=CAE" alt="Laptop 2">
                <h3 style="color:black">TechMaster Pro 15</h3>
                <p>Ultimate productivity for professionals.</p>
                <a href="#" class="btn btn-primary">View More</a>
            </div>
            <div class="col-md-4 laptop-card">
                <img src="https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcRgy1kVQh9LpWs5ro-M7pTcIHV-HPQUweUhi0uBqIc9_aXrGH3uk6ElG61LrWQ4P6SpkxYGuMP2vTzdka1CtUvnRL2gE6_UOBzquNLNbzZTdPakAJdPmlxaGw&usqp=CAE" alt="Laptop 3">
                <h3 style="color:black">TechMaster Air</h3>
                <p>Sleek design with exceptional battery life.</p>
                <a href="#" class="btn btn-primary">View More</a>
            </div>
        </div>
    </div>
</section>

<section id="categories" class="categories">
   
</section>

<footer class="footer">
    <div class="container d-flex justify-content-between">
        <div class="footer-column">
            <h5>Contact Us</h5>
            <p>Email: info@techmasterpro.com</p>
            <p>Phone: (123) 456-7890</p>
        </div>
        <div class="footer-column">
            <h5>Follow Us</h5>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <div class="footer-column">
            <h5>About Us</h5>
            <p>We provide top-notch laptops and technology solutions.</p>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
