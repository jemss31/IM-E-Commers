-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2025 at 03:10 PM
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
-- Database: `jemss`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `guest_name` varchar(255) DEFAULT NULL,
  `guest_phone` varchar(50) DEFAULT NULL,
  `guest_address` text DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `guest_name`, `guest_phone`, `guest_address`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, NULL, 11.00, '2025-05-20 21:55:52', '2025-05-20 21:55:52'),
(2, 1, NULL, NULL, NULL, 15.00, '2025-05-20 21:57:06', '2025-05-20 21:57:06'),
(3, 1, NULL, NULL, NULL, 900.00, '2025-05-20 21:59:12', '2025-05-20 21:59:12'),
(4, 7, NULL, NULL, NULL, 21.00, '2025-05-23 08:38:48', '2025-05-23 08:38:48'),
(5, 7, NULL, NULL, NULL, 1000.00, '2025-05-23 08:49:45', '2025-05-23 08:49:45');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `slug`, `image_path`, `category_id`, `created_at`, `updated_at`) VALUES
(13, 'IPHONE 14 CARLO limited edition', 'PINAKA GAHI NGA CELLPHONE SA KALIBUTAN', 10000.00, 'iphone-14-carlo-limited-edition', 'uploads/iphone-14-pro-max-space-black.jpg', 7, '2025-05-23 08:38:22', '2025-05-23 02:38:22'),
(15, 'Dress ni carlo', 'Pina ka pumped nga dress', 1000.00, 'dress-ni-carlo', 'uploads/51KjW4LG0-L._AC_UL1500_.jpg', 8, '2025-05-23 09:48:29', '2025-05-23 03:48:29'),
(16, 'Nikkis', 'James ansali limited edition shoes', 350.00, 'nikkis', 'uploads/cms8x.jpg', 8, '2025-05-23 09:50:01', '2025-05-23 03:50:01'),
(17, 'Steel toe shoes', 'Andre solo sako bra', 999.00, 'steel-toe-shoes', 'uploads/5e5c72a27230c.jpeg', 8, '2025-05-23 09:51:19', '2025-05-23 03:51:19'),
(18, 'hello kitty', 'haha', 50.00, 'hello-kitty', 'uploads/sanrio-children-hello-kitty-panties-3-in-1-kt50246--1.webp', 8, '2025-05-23 09:53:10', '2025-05-23 03:53:10'),
(19, 'Washing Machine', 'Effiecient and Strong', 8999.00, 'washing-machine', 'uploads/3_MIDEA_PS_MARK_9KG_TWIN_TUB_WASHING_MACHINE.webp', 7, '2025-05-23 09:54:21', '2025-05-23 03:54:21');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(6, 'Toys', NULL, '2025-05-20 21:06:58', '2025-05-20 21:06:58'),
(7, 'Electronics', NULL, '2025-05-20 21:06:58', '2025-05-20 21:06:58'),
(8, 'Clothing', NULL, '2025-05-20 21:06:58', '2025-05-20 21:06:58'),
(9, 'Books', NULL, '2025-05-20 21:06:58', '2025-05-20 21:06:58'),
(10, 'Home & Kitchen', NULL, '2025-05-20 21:06:58', '2025-05-20 21:06:58');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `password`, `address`, `phone`, `birthdate`, `created_at`, `updated_at`) VALUES
(1, 2, 'markj', 'markj@gmail.com', '$2y$10$5pdyC4dNMKwXfxqZOTLmv.45PGG7TmMKMKdKOc5TthONR7GkhQfs.', NULL, NULL, NULL, '2025-05-20 21:01:51', '2025-05-20 21:41:04'),
(3, 2, 'axci', 'axci@gmail.com', '$2y$10$S9w3Py3sWzBDfqQuZPfsG.nbjaDTJzBs.3VmTFp9e1V.zo9KMH3U2', NULL, NULL, NULL, '2025-05-20 22:01:24', '2025-05-20 22:01:24'),
(4, 2, 'charles', 'malacastec123@gmail.com', '$2y$10$0DM1gizNd5iT2RGY1adQh.ZMJOtHD8yssNUyMV7NGqgWLyf0/qoDK', NULL, NULL, NULL, '2025-05-23 06:15:48', '2025-05-23 06:15:48'),
(7, 2, 'charles malacaste', 'richardmalacaste119@gmail.com', '$2y$10$y811oo1x.M5AtFXF3YnxD.C.RUfuNIVtq/UcwwMbdYcp7.Fiu5liy', NULL, NULL, NULL, '2025-05-23 06:18:00', '2025-05-23 06:18:00'),
(8, 2, 'james', 'james@gmail.com', '$2y$10$AFTFq8yet95wFusSPPmevOLCkgRPyJs/vYbebr/OMSy2wygWLfdHO', 'purok tambis', '09239168063', '2005-09-25', '2025-05-23 09:46:05', '2025-05-23 09:47:31'),
(11, 2, 'charles', 'malacsate@gmail.com', '$2y$10$eRfeQXYV3UIqFNj7U3LlnOd23VJqYx6hdpgy2xle29We64Xb4tnR6', 'purok tambis', '09239168063', '2005-01-16', '2025-05-23 09:59:17', '2025-05-23 10:00:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_customer` (`customer_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order` (`order_id`),
  ADD KEY `fk_product` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_customer` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `fk_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
