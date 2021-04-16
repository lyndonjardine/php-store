-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 16, 2021 at 02:10 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `capstone`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_info`
--

CREATE TABLE `admin_info` (
  `admin_id` int(11) UNSIGNED NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL COMMENT 'Default password for ''username'' is ''changeThis''',
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_info`
--

INSERT INTO `admin_info` (`admin_id`, `username`, `password`, `active`) VALUES
(1, 'username', '$2y$10$d2p7/tIzkLS70Tt5OrpT.e5HniEGb2hGIC/RDPqQs3WrtjbT2f3ha', 1),
(2, 'lyndon', '$2y$10$OCkX71Fpqqb6xkUCPVUYDOPW6HmyUyRyDiQitDihD2ISYN57vYMKK', 1),
(3, 'hashtest', '$2y$10$//qLUioefcWT/kc03D3C9uOG8iHwu0zBv1liecuz/ctj6GpZCFdRi', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) UNSIGNED NOT NULL,
  `item_id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `item_id`, `userID`, `quantity`) VALUES
(1, 31, 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category` varchar(72) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category`) VALUES
(16, 'Asus'),
(15, 'Dell'),
(14, 'Apple'),
(17, 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `current_sessions`
--

CREATE TABLE `current_sessions` (
  `id` int(11) UNSIGNED NOT NULL,
  `sessionID` text NOT NULL,
  `admin_id` int(11) NOT NULL,
  `login_time` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `category` int(11) NOT NULL,
  `item_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(9999) NOT NULL DEFAULT '',
  `price` double NOT NULL,
  `quantity` varchar(16) NOT NULL,
  `sku` varchar(32) NOT NULL,
  `picture` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`category`, `item_id`, `title`, `description`, `price`, `quantity`, `sku`, `picture`) VALUES
(14, 31, 'Macbook Pro', '<p>This is a <em>mac book pro</em></p>', 1499.99, '988', '1235243', 'macbookpro.jpeg'),
(16, 32, 'Asus Laptop', '<p>This is a <em>asus laptop</em></p>', 999.99, '965', '8716813', 'asusVivobook15.png'),
(15, 34, 'Dell 15.6 Laptop', '<p>This is a dell laptop</p>', 799.99, '29', '123556', 'dellInspiron.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `items_sold`
--

CREATE TABLE `items_sold` (
  `sell_id` int(11) UNSIGNED NOT NULL,
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `sell_price` int(11) NOT NULL,
  `sell_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items_sold`
--

INSERT INTO `items_sold` (`sell_id`, `item_id`, `order_id`, `sell_price`, `sell_quantity`) VALUES
(17, 31, 16, 1500, 3),
(18, 32, 16, 1000, 10),
(19, 31, 17, 1500, 1),
(20, 31, 18, 1500, 1),
(21, 32, 18, 1000, 1),
(22, 32, 19, 1000, 19),
(23, 31, 20, 1500, 5),
(24, 32, 20, 1000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_info`
--

CREATE TABLE `order_info` (
  `order_id` int(11) UNSIGNED NOT NULL,
  `firstName` varchar(30) NOT NULL DEFAULT '',
  `lastName` varchar(30) NOT NULL DEFAULT '',
  `phone` varchar(10) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_info`
--

INSERT INTO `order_info` (`order_id`, `firstName`, `lastName`, `phone`, `email`, `userID`) VALUES
(16, 'Lyndon', 'Jardine', '9023221325', 'w0287543@nscc.ca', 12),
(17, 'Lyndon', 'Jardine', '902123456', 'w0287543@nscc.ca', 12),
(18, 'asdf', 'asdf', 'asdf', 'asdf@asdf.com', 12),
(19, 'asdf', 'jardine', 'zxcv', 'lyndon.jardine@gmail.com', 12),
(20, 'asdf', 'asdf', '9021231234', 'lyndon.jardine@gmail.com', 14);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `sessionID` varchar(255) NOT NULL DEFAULT '',
  `user_ip` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `sessionID`, `user_ip`) VALUES
(10, '59t07ro853vv55pgqi25lmotai', '::1'),
(11, 'mia931t96ehdnt30et1mv21k6i', '::1'),
(12, 'qgkjo5bhgb0b4dmrj6vuggnld5', '::1'),
(13, '5db0fc1fd4d799866c265f8c0ca84673', '::1'),
(14, '8ca7240b9ae01b6c38c8126fb3f621a0', '::1'),
(15, '46ca5338f915dabc0a67cc3ae835a536', '::1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_info`
--
ALTER TABLE `admin_info`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `current_sessions`
--
ALTER TABLE `current_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `items_sold`
--
ALTER TABLE `items_sold`
  ADD PRIMARY KEY (`sell_id`);

--
-- Indexes for table `order_info`
--
ALTER TABLE `order_info`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_info`
--
ALTER TABLE `admin_info`
  MODIFY `admin_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `current_sessions`
--
ALTER TABLE `current_sessions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `items_sold`
--
ALTER TABLE `items_sold`
  MODIFY `sell_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `order_info`
--
ALTER TABLE `order_info`
  MODIFY `order_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
