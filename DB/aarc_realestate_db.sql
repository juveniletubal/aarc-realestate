-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2025 at 12:23 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aarc_realestate_db`
--
CREATE DATABASE IF NOT EXISTS `aarc_realestate_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `aarc_realestate_db`;

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `license_number` varchar(50) DEFAULT NULL,
  `percent` tinyint(3) UNSIGNED NOT NULL,
  `position` enum('director','manager','downline') NOT NULL,
  `upline_id` tinyint(4) DEFAULT NULL,
  `profile_image` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `firstname`, `lastname`, `email`, `facebook_link`, `phone`, `license_number`, `percent`, `position`, `upline_id`, `profile_image`, `created_at`, `updated_at`, `is_active`, `is_deleted`, `user_id`) VALUES
(1, 'Juvenile', 'Tubal', 'nile102202@gmail.com', '', '09262002986', '', 1, 'director', 0, 'tubal_eae8b7cf.webp', '2025-09-22 15:03:20', '2025-09-23 18:26:51', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `assigned_agent` int(11) DEFAULT NULL,
  `assigned_staff` int(11) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `payment_terms` enum('monthly','quarterly','spot_cash') NOT NULL,
  `total_price` decimal(15,2) DEFAULT NULL,
  `balance` decimal(15,2) DEFAULT NULL,
  `penalty` decimal(15,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `user_id`, `assigned_agent`, `assigned_staff`, `property_id`, `payment_terms`, `total_price`, `balance`, `penalty`, `created_at`, `updated_at`) VALUES
(1, 3, 2, NULL, 1, 'monthly', '100001.00', '100001.00', '0.00', '2025-09-24 08:36:48', '2025-09-24 08:36:48'),
(2, 4, 2, 2, 1, 'quarterly', '100001.00', '100001.00', '0.00', '2025-09-24 08:42:52', '2025-09-24 09:28:15'),
(3, 5, 2, 2, 1, 'spot_cash', '100001.00', '100001.00', '0.00', '2025-09-24 08:46:06', '2025-09-24 09:28:54');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `lot_area` varchar(50) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `location` varchar(255) NOT NULL,
  `property_type` enum('Residential','Commercial','Agricultural') NOT NULL DEFAULT 'Residential',
  `status` enum('available','reserved','sold','') NOT NULL DEFAULT 'available',
  `images` text DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `title`, `description`, `lot_area`, `price`, `location`, `property_type`, `status`, `images`, `created`, `is_deleted`) VALUES
(1, 'Lot1', 'lot 1 lot 1', '200', '100001.00', 'Bula', 'Commercial', 'available', 'prop_68d2ba458b2b29.95379624.webp,prop_68d2ba4647b278.09170732.webp', '2025-09-23 15:18:30', 0),
(2, 'Lot 2', 'lot2', '100', '90000.00', 'bula', 'Residential', 'available', 'prop_68d2be140984b8.95060878.webp,prop_68d2be14816f01.98013968.webp', '2025-09-23 15:34:44', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff','agent','client') NOT NULL DEFAULT 'client',
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `facebook_link` varchar(200) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `firstname`, `lastname`, `contact`, `email`, `address`, `facebook_link`, `image`, `created_at`, `updated_at`, `is_active`, `is_deleted`) VALUES
(1, 'admin', '$2y$10$lLkGNwKAs1ibxiUSJhXYo.kgpqaMHQ1dskAnKWk0wWzosoCPBMb9m', 'admin', 'Admin', 'Admin', '09262002986', '', '', '', 'admin_481ab08d.webp', '2025-09-22 15:03:20', '2025-09-24 10:22:13', 0, 0),
(2, 'ella', '$2y$10$lLkGNwKAs1ibxiUSJhXYo.kgpqaMHQ1dskAnKWk0wWzosoCPBMb9m', 'staff', 'Ellame', 'Tamorite', '09262002986', 'jake36386@gmail.com', 'Casquejo St Dadiangas East', 'aa', 'tamorite_c253426a.webp', '2025-09-23 17:15:26', '2025-09-24 10:20:11', 0, 0),
(3, '111', '$2y$10$TpyKAhQUH9Rc4H3XVvv0gOqTAnpXKBC5PxWTF.RgETaL0zWXRDY4C', 'client', 'Ellamesss', 'Tamorite', '09679585865', NULL, 'Casquejo St Dadiangas East', NULL, NULL, '2025-09-24 08:36:48', '2025-09-24 08:52:50', 0, 0),
(4, 'nile', '$2y$10$ZVggXrMmNfXDeWydhKBuceZU.o3yc/q7LwrWC8cuJ73o54vPtUqja', 'client', 'Juvenile', 'Tubal', '0922002986', NULL, '', NULL, NULL, '2025-09-24 08:42:52', '2025-09-24 08:42:52', 0, 0),
(5, '1', '$2y$10$S7G2JFVsKTaizuygAeZ9b.4REfhhPC3OVOPqGY6uvTWKp9PsTPL42', 'client', 'Ellameasasas', 'Tamorite', '09679585865', NULL, 'Casquejo St Dadiangas East', NULL, NULL, '2025-09-24 08:46:06', '2025-09-24 09:28:54', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_agents_users` (`user_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `assigned_agent` (`assigned_agent`),
  ADD KEY `assigned_staff` (`assigned_staff`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agents`
--
ALTER TABLE `agents`
  ADD CONSTRAINT `fk_agents_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `clients_ibfk_2` FOREIGN KEY (`assigned_agent`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `clients_ibfk_3` FOREIGN KEY (`assigned_staff`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `clients_ibfk_4` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
