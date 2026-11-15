-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2026 at 05:55 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopease`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(120) DEFAULT NULL,
  `email` varchar(190) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` varchar(40) NOT NULL DEFAULT 'Placed',
  `customer_name` varchar(120) DEFAULT NULL,
  `phone` varchar(40) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `payment_method` varchar(60) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `status`, `customer_name`, `phone`, `address`, `payment_method`, `created_at`) VALUES
(1, 1, 2499.00, 'Delivered', 'Chavi Bansal', '9079362335', 'haat road', 'Cash on Delivery', '2026-11-15 06:09:16'),
(2, 1, 4398.00, 'Shipped', 'Chavi Bansal', '9079362335', 'haat road', 'Cash on Delivery', '2026-11-15 06:26:16'),
(3, 5, 2499.00, 'Placed', 'Radhika Trivedi', '9079362335', 'jaipur', 'Cash on Delivery', '2026-11-15 16:46:56');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(180) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`) VALUES
(1, 1, 3, 'Wireless Headphones', 2499.00, 1),
(2, 2, 4, 'Classic Everyday Sneakers', 2199.00, 2),
(3, 3, 3, 'Wireless Headphones', 2499.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(180) NOT NULL,
  `category` varchar(80) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 20,
  `status` enum('active','draft') NOT NULL DEFAULT 'active',
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `badge` varchar(60) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `description`, `price`, `old_price`, `image`, `stock`, `status`, `featured`, `badge`, `created_at`) VALUES
(1, 'Everyday Carry Backpack', 'Accessories', 'A clean, versatile backpack with practical storage for daily plans.', 1499.00, 1999.00, 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=900', 24, 'active', 1, 'BESTSELLER', '2026-11-15 06:02:38'),
(2, 'Minimal Ceramic Table Lamp', 'Home', 'Warm light and a sculptural silhouette for your favourite corner.', 1899.00, 2299.00, 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=900', 18, 'active', 1, 'HOME PICK', '2026-11-15 06:02:38'),
(3, 'Wireless Headphones', 'Electronics', 'Comfortable over-ear listening for work, travel and downtime.', 2499.00, 2999.00, 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=900', 28, 'active', 1, 'TRENDING', '2026-11-15 06:02:38'),
(4, 'Classic Everyday Sneakers', 'Fashion', 'Easy-to-style sneakers made for everyday movement.', 2199.00, 2799.00, 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=900', 14, 'active', 1, 'POPULAR', '2026-11-15 06:02:38'),
(5, 'Insulated Travel Bottle', 'Lifestyle', 'A reusable bottle to keep your daily hydration close at hand.', 699.00, 899.00, 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=900', 42, 'active', 0, 'GOOD FIND', '2026-11-15 06:02:38'),
(6, 'Soft Knit Throw', 'Home', 'A cosy textured throw for slow evenings and relaxed spaces.', 1299.00, 1599.00, 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?w=900', 12, 'active', 0, 'COMFORT PICK', '2026-11-15 06:02:38'),
(7, 'Modern Analog Watch', 'Accessories', 'A timeless everyday watch with a refined, minimal profile.', 1799.00, 2299.00, 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=900', 20, 'active', 0, 'NEW', '2026-11-15 06:02:38'),
(8, 'Desk Organizer Set', 'Home', 'A neat desk companion to make room for clearer thinking.', 549.00, 749.00, 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=900', 35, 'active', 0, 'SMART PICK', '2026-11-15 06:02:38'),
(9, 'Organizer Box', 'Lifestyle', 'Useful Product to Organize your items', 3000.00, 5000.00, 'https://i5.walmartimages.com/seo/Desk-Organizer-Large-Shelf-Multi-Compartments-Units-Wood-Desktop-Storage-Board-Organizer-White_da102804-8935-487e-b58b-5c1a43807813.24f8a53895e412179b2dbe7b24f6c980.png', 20, 'active', 0, '', '2026-11-15 07:05:28'),
(10, 'Earrings', 'Accessories', 'Beautiful Gold colour earrings', 200.00, 500.00, '/ShopEase_Fresh/admin/uploads/c090403c4314ff6969b389609a0b5110.webp', 15, 'active', 0, '', '2026-11-15 07:12:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(190) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','admin') NOT NULL DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Chavi Bansal', '2025kucp1021@iiitkota.ac.in', '$2y$10$o3Q1pQ3y8tYMD4n9bASNh.jf8qFqEuXpYRzcc77tBqOr4m.PIW.eC', 'admin', '2026-11-15 06:06:54'),
(2, 'kavita bansal', 'chhavibansal19082006@gmail.com', '$2y$10$DPlcEHtDxE1nMKB/YnqOwuOU8Nv77L8ayccsqqqRg4dc3By5dpbwi', 'customer', '2026-11-15 16:25:47'),
(3, 'ravi bansal', 'bansalchavii15@gmail.com', '$2y$10$vrZUT5MrR.IjxmyoeaMeYOb16jfZQ4oOyzuP7XLGGSHdDPUCvrzBC', 'customer', '2026-11-15 16:27:31'),
(4, 'Varshita Jain', 'bansalkavita@gmail.com', '$2y$10$64cLkVqRPhu/yo0.3EIY9.aMkadf5DaeIy0aGkpir46eTO7zMcsba', 'customer', '2026-11-15 16:32:48'),
(5, 'Radhika Trivedi', 'radhika@gmail.com', '$2y$10$lqKk8U4gNKvG.KuV8gCEAuiCHUeSWStqKdidStitRx2pl97U0yip6', 'customer', '2026-11-15 16:36:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

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
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
