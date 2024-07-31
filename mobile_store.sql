-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 31, 2024 at 10:08 AM
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
-- Database: `mobile_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` enum('superadmin','editor','moderator') DEFAULT 'editor'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `email`, `created_at`, `updated_at`, `role`) VALUES
(1, 'admin', '$2y$10$9ZfPFIrzxbiGuBz8pWhWK.nIwAZoGX4tfrVg54rgh66JHAm8uu8JO', 'admin@gmail.com', '2024-07-20 23:19:00', '2024-07-20 23:19:00', 'superadmin'),
(2, 'Editor', '$2y$10$IZloQFtufF90Iq0./W8RKu2fC143cB6T.dRCoXejeg27hDdYoIpVC', 'editor@gmail.com', '2024-07-20 23:23:34', '2024-07-20 23:23:34', 'editor'),
(4, 'admin2', '$2y$10$yVTX9Uyewxu5KEH5nv6tfeygDFnTFxXYDALLact61hFpBGWUWRfzO', 'admin2@gmail.com', '2024-07-23 23:24:28', '2024-07-23 23:24:28', 'superadmin');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`cart_id`, `user_id`, `created_at`) VALUES
(3, 6, '2024-07-20 08:12:41'),
(4, 7, '2024-07-20 15:42:14'),
(5, 8, '2024-07-20 19:10:56'),
(6, 15, '2024-07-23 23:13:55');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
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
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(100) DEFAULT 'pending',
  `cancel_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `quantity`, `order_date`, `status`, `cancel_reason`) VALUES
(35, 6, 1, 1, '2024-07-31 07:27:07', 'canceled', 'Not Needed'),
(36, 6, 13, 1, '2024-07-31 07:36:42', 'delivered', 'Hello'),
(37, 6, 1, 1, '2024-07-31 07:48:03', 'delivered', 'No More Needed');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_url`, `stock`) VALUES
(1, 'SAMSUNG Galaxy A35 5G', 'Color: Lilac\r\nBrand	SAMSUNG\r\nOperating System	ONE UI 6.0, Android 14\r\nRam Memory Installed Size	6 GB\r\nMemory Storage Capacity	128 GB\r\nScreen Size	6.6 Inches\r\nRefresh Rate	120 Hz\r\nModel Name	Galaxy A35\r\nWireless Carrier	Unlocked for All Carriers\r\nCellular Technology	5G\r\nConnectivity Technology	Bluetooth, Wi-Fi, USB, NFC', 386.30, 'https://m.media-amazon.com/images/I/71lw4ZWUfYL._AC_SX679_.jpg', 5),
(2, 'Apple iPhone 14 Pro', 'Brand	Apple\r\nOperating System	iOS 16\r\nRam Memory Installed Size	8 GB\r\nMemory Storage Capacity	256 GB\r\nScreen Size	6.1 Inches\r\nModel Name	iPhone 14 Pro\r\nWireless Carrier	Unlocked for All Carriers\r\nCellular Technology	5G\r\nColor	Silver\r\nWireless network technology	GSM', 716.29, 'https://m.media-amazon.com/images/I/51xiCpbirGL._AC_SX679_.jpg', 8),
(3, 'OnePlus 12', 'Brand	OnePlus\r\nOperating System	Android 14\r\nRam Memory Installed Size	16 GB\r\nMemory Storage Capacity	16 GB\r\nScreen Size	6.82 Inches\r\nRefresh Rate	120 Hz\r\nModel Name	OnePlus 12\r\nWireless Carrier	Unlocked for All Carriers\r\nCellular Technology	5G\r\nConnectivity Technology	USB', 799.99, 'https://m.media-amazon.com/images/I/711F6T6aySL._AC_SX679_.jpg', 10),
(4, 'OnePlus 12R', 'Brand	OnePlus\r\nOperating System	Android 14\r\nRam Memory Installed Size	16 GB\r\nCPU Speed	3.2 GHz\r\nMemory Storage Capacity	16 GB\r\nScreen Size	6.82 Inches\r\nRefresh Rate	120 Hz\r\nModel Name	OnePlus 12R\r\nWireless Carrier	Unlocked for All Carriers\r\nCellular Technology	5G', 499.99, 'https://m.media-amazon.com/images/I/71xMs88FYbL._AC_SX679_.jpg', 10),
(5, 'Apple iPhone 15', 'Brand	Apple\r\nOperating System	iOS\r\nMemory Storage Capacity	128 GB\r\nScreen Size	6.1 Inches\r\nModel Name	iPhone 15 (Renewed)\r\nWireless Carrier	Unlocked for All Carriers\r\nCellular Technology	5G\r\nConnectivity Technology	USB\r\nColor	Blue\r\nWireless network technology	Wi-Fi', 689.89, 'https://m.media-amazon.com/images/I/61NBF0uWXRL._AC_SY879_.jpg', 10),
(8, 'Google Pixel 8 Pro', 'Brand	Google\r\nOperating System	Android 13.0\r\nRam Memory Installed Size	12 GB\r\nMemory Storage Capacity	128 GB\r\nScreen Size	6.7 Inches\r\nResolution	1344 x 2992\r\nRefresh Rate	120 Hz\r\nModel Name	Pixel 8 Pro\r\nWireless Carrier	Unlocked for All Carriers\r\nCellular Technology	5G', 745.99, 'https://m.media-amazon.com/images/I/713eEl39eLL._AC_SX679_.jpg', 9),
(11, 'Samsung Galaxy Z Fold6', 'Brand	SAMSUNG\nOperating System	OneUI 6.1, Android 14\nRam Memory Installed Size	12 GB\nCPU Speed	3.4 GHz\nMemory Storage Capacity	512 GB\nScreen Size	6.7 Inches\nRefresh Rate	120 Hz\nModel Name	Galaxy Z Flip6\nWireless Carrier	Unlocked for All Carriers\nCellular Technology	5G', 2019.99, 'https://image-us.samsung.com/us/smartphones/galaxy-z-flip6/gallery/01-B6-CraftedBlack-1600x1200.jpg?$product-details-jpg$', 9),
(12, 'Apple iPhone 15 Pro Max', '\r\nBrand	Apple\r\nOperating System	iOS 17\r\nRam Memory Installed Size	8 GB\r\nMemory Storage Capacity	256 GB\r\nScreen Size	6.7 Inches\r\nModel Name	iPhone 15 Pro Max\r\nWireless Carrier	Unlocked for All Carriers\r\nCellular Technology	5G\r\nConnectivity Technology	USB\r\nColor	Natural Titanium', 1069.97, 'https://m.media-amazon.com/images/I/61gq+-U+rPL._AC_SX679_.jpg', 10),
(13, 'SAMSUNG Galaxy A15', 'Brand	SAMSUNG\r\nMemory Storage Capacity	128 GB\r\nScreen Size	6.5 Inches\r\nResolution	1080 x 2340\r\nWireless Carrier	Unlocked for All Carriers\r\nCellular Technology	5G\r\nConnectivity Technology	Bluetooth\r\nColor	Blue Black\r\nForm Factor	Slate\r\nBattery Capacity	5000 Milliamp Hours', 413.99, 'https://m.media-amazon.com/images/I/51mRnMaCDpL._AC_SX679_.jpg', 11);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `registration_date`, `firstname`, `lastname`, `phone`) VALUES
(6, 'user1', '$2y$10$KalWEJHCQAZLX952YroZ3OzPxa9E48VOFlYTMkZzQTWLSt/Num2Su', 'user1@gmail.com', '2024-07-20 01:36:18', 'User First Name', 'User Last Name', '1231231231'),
(8, 'test1', '$2y$10$wdIXomiPPrQCBrcD7H0YkOgNZeHefscxMIlwpBKM89QSoAKFCF4Hi', 'test1@gmail.com', '2024-07-20 19:10:15', '', '', ''),
(11, 'user4', '$2y$10$k/znfqLaMN3B/cBNE8rnhepmO5xRllu73oSl9LEIt/6jMetz3muIG', 'user4@gmail.com', '2024-07-21 05:17:18', '', '', ''),
(13, 'test3', '$2y$10$6D9EA2vqTp4XIhqWNXhY4.AX33agxME3kyNUStp0R4Tuqp/KMkkei', 'test3@gmail.com', '2024-07-21 06:36:49', '', '', ''),
(14, 'test4', '$2y$10$s/XnNkshfmmdcAWWbZ5IvuqaDpjkhnz16ci9z1R4Lvn5viiwkGC0q', 'test4@gmail.com', '2024-07-21 06:37:41', '', '', ''),
(15, 'tarun', '$2y$10$SiaM6D9QSjc23JQcylsESOI1h16SuC1HcGETnuVa3Ay9Zk8.9A8Gy', 'tarun@gmail.com', '2024-07-23 23:07:43', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`cart_id`),
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
