-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2019 at 03:05 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dunhill`
--

-- --------------------------------------------------------

--
-- Table structure for table `addtocart`
--

CREATE TABLE `addtocart` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `package_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `total_box` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addtocart`
--

INSERT INTO `addtocart` (`id`, `customer_id`, `product_id`, `package_id`, `quantity`, `total_box`, `created_at`, `updated_at`) VALUES
(19, 9, 24, NULL, 3, 24, '2019-11-05 03:31:34', '2019-11-05 03:31:34'),
(20, 9, 23, NULL, 2, 10, '2019-11-05 03:31:37', '2019-11-05 03:31:37'),
(21, 9, 9, NULL, 2, 2, '2019-11-05 03:31:40', '2019-11-05 03:31:40');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Product', NULL, NULL),
(2, 'Package', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE `collections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` double NOT NULL,
  `check_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit` double NOT NULL,
  `balance` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer`, `address`, `contact`, `email`, `credit`, `balance`, `created_at`, `updated_at`) VALUES
(9, 'customer abc', 'Pasig', '123456789', 'sample@gmail.com', 30000, 30000, '2019-09-27 01:57:10', '2019-09-27 01:59:03'),
(10, 'Company pogi', 'Pasay', '321654789', 'test@gmail.com', 5000, 5000, '2019-10-02 07:22:18', '2019-10-02 07:22:18');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_09_04_071127_create_products_table', 2),
(5, '2019_09_06_055132_create_customers_table', 3),
(6, '2019_09_06_071334_add_credit_to_customers_table', 4),
(7, '2019_09_10_064140_create_addtocart_table', 5),
(8, '2019_09_12_050939_create_orders_table', 6),
(10, '2019_09_12_051016_create_order_details_table', 7),
(11, '2019_09_17_050510_create_roles_table', 8),
(12, '2019_09_17_051306_create_roles_table', 9),
(13, '2019_09_17_070935_create_positions_table', 10),
(14, '2019_09_18_004539_create_user_details_table', 11),
(15, '2019_09_18_005311_create_user_role_table', 11),
(18, '2019_10_16_160910_create_collections_table', 12),
(19, '2019_10_17_095415_add_status_to_orders_table', 13),
(20, '2019_10_29_135246_create_packages_table', 14),
(21, '2019_10_31_125333_create_package__details_table', 15),
(22, '2019_11_04_141339_add_image_to_packages', 16),
(23, '2019_11_04_150945_add_items_to_addtocart', 17),
(24, '2019_11_05_084444_create_categories_table', 18),
(25, '2019_11_05_084827_add_items_to_products', 18);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `total_box` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_id`, `price`, `total_box`, `created_at`, `updated_at`, `status`) VALUES
(9, 1, 9, 700, 5, '2019-11-04 03:54:52', '2019-11-05 08:17:25', 'delivery'),
(10, 1, 9, 27846, 32, '2019-11-05 03:30:27', '2019-11-05 03:30:27', 'delivery');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(21, 9, 9, 1, 100, '2019-11-04 03:54:52', '2019-11-04 03:54:52'),
(22, 9, 10, 2, 600, '2019-11-04 03:54:52', '2019-11-04 03:54:52'),
(23, 10, 9, 1, 100, '2019-11-05 03:30:27', '2019-11-05 03:30:27'),
(24, 10, 12, 2, 600, '2019-11-05 03:30:27', '2019-11-05 03:30:27'),
(25, 10, 17, 1, 250, '2019-11-05 03:30:27', '2019-11-05 03:30:27'),
(26, 10, 23, 2, 21600, '2019-11-05 03:30:27', '2019-11-05 03:30:27'),
(27, 10, 24, 2, 5296, '2019-11-05 03:30:27', '2019-11-05 03:30:27');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `package_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` float DEFAULT NULL,
  `total_box` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `package_name`, `discount`, `total_box`, `quantity`, `total_price`, `created_at`, `updated_at`, `image`) VALUES
(64, 'test', NULL, 3, 2, 400, '2019-11-04 02:40:29', '2019-11-04 02:40:29', NULL),
(65, 'test1', NULL, 3, 5, 6900, '2019-11-04 06:33:54', '2019-11-04 06:33:54', '1572849234_5dbfc65250fa2.jpeg'),
(66, 'test3', NULL, 4, 9, 2200, '2019-11-04 06:41:56', '2019-11-04 06:41:56', '1572849715_5dbfc833ee574.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `package__details`
--

CREATE TABLE `package__details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `package_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `package__details`
--

INSERT INTO `package__details` (`id`, `package_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(39, 23, 10, 2, '2019-11-05 02:34:58', '2019-11-05 02:34:58'),
(40, 23, 11, 3, '2019-11-05 02:34:58', '2019-11-05 02:34:58'),
(41, 23, 12, 4, '2019-11-05 02:34:58', '2019-11-05 02:34:58'),
(42, 24, 12, 2, '2019-11-05 03:23:22', '2019-11-05 03:23:22'),
(43, 24, 17, 2, '2019-11-05 03:23:22', '2019-11-05 03:23:22'),
(44, 24, 20, 4, '2019-11-05 03:23:22', '2019-11-05 03:23:22'),
(45, 24, 10, 5, '2019-11-05 03:23:22', '2019-11-05 03:23:22');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `position` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `position`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2019-09-17 00:37:30', '2019-09-17 00:37:30'),
(2, 'user', '2019-09-17 00:54:54', '2019-09-17 00:54:54');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `item` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier` int(11) DEFAULT NULL,
  `price` double NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `box` int(11) DEFAULT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `item`, `supplier`, `price`, `quantity`, `discount`, `box`, `photo`, `created_at`, `updated_at`) VALUES
(9, 1, 'Product 1', 0, 100, 14, NULL, 1, '1571708178.jpeg', '2019-10-22 01:36:18', '2019-11-05 03:30:27'),
(10, 1, 'Product 2', 0, 300, 12, NULL, 2, '1571708209.png', '2019-10-22 01:36:49', '2019-11-04 03:54:52'),
(11, 1, 'Product 3', 0, 3000, 20, NULL, 2, '1571708389.jpeg', '2019-10-22 01:39:49', '2019-10-22 01:39:49'),
(12, 1, 'Product 4', 0, 300, 18, NULL, 1, '1571708418.jpeg', '2019-10-22 01:40:18', '2019-11-05 03:30:27'),
(13, 1, 'Product 5', 0, 200, 20, NULL, 3, '1571708609.jpeg', '2019-10-22 01:43:29', '2019-10-22 01:43:29'),
(14, 1, 'Product 6', 0, 200, 30, NULL, 2, '1571708622.jpeg', '2019-10-22 01:43:42', '2019-10-22 01:43:42'),
(15, 1, 'Product 7', 0, 200, 30, NULL, 1, '1571708638.jpeg', '2019-10-22 01:43:58', '2019-10-22 01:43:58'),
(17, 1, 'test1', 200, 250, 19, NULL, 3, '1572832371.jpeg', '2019-11-04 01:52:51', '2019-11-05 03:30:27'),
(20, 1, 'Product nating lahat', 2, 12, 2, NULL, 2, '1572917716.jpeg', '2019-11-05 01:35:16', '2019-11-05 01:35:16'),
(22, 1, 'item123', 2, 2, 2, NULL, 2, '1572918466.jpeg', '2019-11-05 01:47:46', '2019-11-05 01:47:46'),
(23, 2, 'p6', 0, 10800, 7, NULL, 5, '1572921298_5dc0dfd21e843.jpeg', '2019-11-05 02:34:58', '2019-11-05 03:30:27'),
(24, 2, 'p7', 0, 2648, 11, NULL, 8, '1572924202_5dc0eb2a9694a.jpeg', '2019-11-05 03:23:22', '2019-11-05 03:30:27');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`, `created_at`, `updated_at`) VALUES
(1, 'User', '2019-09-16 16:00:00', '2019-09-16 16:00:00'),
(2, 'Position', '2019-09-16 16:00:00', '2019-09-16 16:00:00'),
(3, 'Customer', '2019-09-16 16:00:00', '2019-09-16 16:00:00'),
(4, 'Product', '2019-09-16 16:00:00', '2019-09-16 16:00:00'),
(5, 'New_Order', '2019-09-16 16:00:00', '2019-09-16 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `firstname`, `lastname`, `email`, `email_verified_at`, `password`, `user_type`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'khenneth', 'Super', 'Admin', 'khenneth.alaiza@gmail.com', NULL, '$2y$10$fQPNSd7i8PoAU8f1Ncd5MuspXPlxrIH0yj35oZfxM/0XYBcUVHotW', 'admin', NULL, '2019-09-03 19:12:20', '2019-09-03 19:12:20'),
(14, NULL, 'khenneth', 'alaiza', 'khenneth@gmail.com', NULL, '$2y$10$V58Neul9QDQJJ68om2huluhPPctsgzcVDY4Js9yro5kbfd0xAYX2S', NULL, NULL, '2019-09-18 17:46:56', '2019-09-18 17:46:56'),
(15, NULL, 'Jeric', 'Mangao', 'mangao_jeric@yahoo.com', NULL, '$2y$10$V6zHLwQodIm4nwt5n/e3heHRqwZC7OV4WoCosfRdJWH8U9pFNZmLy', NULL, NULL, '2019-10-04 06:11:51', '2019-10-04 06:11:51');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `user_id`, `address`, `position_id`, `created_at`, `updated_at`) VALUES
(5, 1, 'Pasig', 1, '2019-09-17 17:57:04', '2019-10-04 06:19:00'),
(11, 14, 'Pasig', 2, '2019-09-18 17:46:56', '2019-10-04 06:18:00'),
(12, 15, 'Comembo Makati City', 1, '2019-10-04 06:11:51', '2019-10-04 06:11:51');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(148, 15, 1, '2019-10-04 06:11:51', '2019-10-04 06:11:51'),
(149, 15, 2, '2019-10-04 06:11:51', '2019-10-04 06:11:51'),
(150, 15, 3, '2019-10-04 06:11:51', '2019-10-04 06:11:51'),
(151, 15, 4, '2019-10-04 06:11:51', '2019-10-04 06:11:51'),
(152, 15, 5, '2019-10-04 06:11:51', '2019-10-04 06:11:51'),
(154, 14, 1, '2019-10-04 06:18:00', '2019-10-04 06:18:00'),
(159, 1, 1, '2019-10-04 06:19:00', '2019-10-04 06:19:00'),
(160, 1, 3, '2019-10-04 06:19:00', '2019-10-04 06:19:00'),
(161, 1, 4, '2019-10-04 06:19:00', '2019-10-04 06:19:00'),
(162, 1, 5, '2019-10-04 06:19:00', '2019-10-04 06:19:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addtocart`
--
ALTER TABLE `addtocart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package__details`
--
ALTER TABLE `package__details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addtocart`
--
ALTER TABLE `addtocart`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `package__details`
--
ALTER TABLE `package__details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
