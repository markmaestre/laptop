-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2024 at 09:20 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maestre`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$PQ/apYsza01rrJc4CyPkwO3wuAqGypqcc/Doyr7Nftt.oFaWZQSAm', '2024-09-02 10:04:54');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `payment_method` enum('COD','GCash') NOT NULL,
  `status` enum('Processing','Completed','Cancelled') DEFAULT 'Processing',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `quantity`, `total_price`, `name`, `address`, `payment_method`, `status`, `created_at`) VALUES
(1, 3, 4, 1, 1000.00, 'Acer', 'mark', 'GCash', 'Processing', '2024-11-03 06:56:08'),
(2, 3, 4, 1, 1000.00, 'phoneflex', 'mark', 'GCash', 'Processing', '2024-11-03 06:59:37'),
(3, 3, 4, 1, 1000.00, 'phoneflex', 'mark', 'GCash', 'Processing', '2024-11-03 07:06:12'),
(4, 3, 5, 2, 2046.00, 'mark', '212', 'GCash', 'Processing', '2024-11-03 07:09:11'),
(5, 3, 5, 1, 1023.00, 'phoneflex', 'mark', 'GCash', 'Processing', '2024-11-03 07:39:16'),
(6, 3, 5, 1, 1023.00, 'phoneflex', '12', 'GCash', 'Processing', '2024-11-03 07:45:25'),
(7, 3, 5, 1, 25995.00, 'mark', '12', 'GCash', 'Processing', '2024-11-03 08:14:06');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `price` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `img`, `description`, `stock`, `created_at`, `price`) VALUES
(4, 'Lenovo IdeaPad 3 ', 'uploads/lenovo.png', '81WA00NKPH Platinum ', 1, '2024-11-03 02:00:48', 21998.00),
(5, 'ASUS VivoBook 14 ', 'uploads/asus.png', 'X1400EP-EK382WS ', 4, '2024-11-03 02:01:19', 25995.00),
(6, 'Acer Aspire ', 'uploads/acer.png', '35XW Silver', 10, '2024-11-03 02:01:42', 26999.00),
(7, 'Lenovo Factory 2023 ', 'uploads/lenovos.png', 'Core I7 10510U 15.6-Inch ', 5, '2024-11-03 02:07:49', 22599.00),
(8, 'Laptop i7', 'uploads/ipad.png', '16GB / 8GB 4GB Memory ', 2, '2024-11-03 02:08:12', 13914.00),
(9, 'Samsung 16 ', 'uploads/samsung.png', 'Galaxy Book4 Ultra ', 4, '2024-11-03 08:07:29', 168792.75),
(10, 'Apple 13.3', 'uploads/macbook.png', 'MacBook Pro', 2, '2024-11-03 08:08:35', 31351.03),
(11, 'Apple MacBook Air ', 'uploads/apple.png', '(M2, 2022) MLXY3PP/A', 5, '2024-11-03 08:09:40', 52450.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `address` varchar(255) NOT NULL,
  `zip_code` varchar(20) NOT NULL,
  `district` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `role` enum('student','professor') DEFAULT 'student',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `password`, `birthday`, `gender`, `address`, `zip_code`, `district`, `province`, `profile_picture`, `role`, `created_at`) VALUES
(3, 'maestre', 'maestre', 'maestre', 'maestre@gmail.com', '$2y$10$PQ/apYsza01rrJc4CyPkwO3wuAqGypqcc/Doyr7Nftt.oFaWZQSAm', '2024-10-17', 'Male', '12', '121212', '12121', '121221', '462545738_462572163037517_4674004378000987542_n (1).jpg', 'student', '2024-10-23 09:38:50'),
(6, 'kram', '12', '1212', 'maestre12@gmail.com', '$2y$10$Uixdqhajva4968aGW/5v4efS3AjeJ7y26h1TSPUZULA584RZnHs/S', '2024-10-20', 'Female', '12', '121212', '12121', '121221', 'logos.jpg', 'student', '2024-10-23 10:03:12'),
(8, 'user', 'mark', 'maestre', 'markranier@gmail.com', '$2y$10$SRhxqkWClGZmTWzBwzxVxO4PdZS3fK3xIyHqFG5XNXu5iEx5qVT6O', '2024-10-08', 'Male', '12', '121212', '12121', '121221', 'logos.png', 'student', '2024-10-28 01:14:11'),
(10, 'marky', 'mark', 'maestre', 'markranier23322@gmail.com', '$2y$10$FKw94AGrNCNDisWX8i.SieohHy0.ntxViwMlEjDj0.MZ7z6gHnVnW', '2024-11-15', 'Male', 'mark', '121212', '12121', '121221', 'apple.png', 'student', '2024-11-03 08:15:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
