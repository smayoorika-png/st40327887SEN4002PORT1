-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 01, 2025 at 06:26 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `room_number` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `customer_id` int NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hotel_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_rooms` int NOT NULL,
  `num_members` int NOT NULL,
  `mobile_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_room_number` (`room_number`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `room_number`, `start_date`, `end_date`, `customer_id`, `customer_name`, `customer_email`, `customer_phone`, `customer_id_number`, `hotel_name`, `price`, `check_in_date`, `check_out_date`, `full_name`, `id_number`, `num_rooms`, `num_members`, `mobile_number`, `email_address`, `booking_date`) VALUES
(1, '102', '0000-00-00', '0000-00-00', 1, '', '', '', '', NULL, NULL, '2025-08-20', '2025-08-23', '', '', 0, 0, '', '', '2025-08-24 09:47:16'),
(2, '201', '0000-00-00', '0000-00-00', 1, '', '', '', '', NULL, NULL, '2025-08-25', '2025-08-27', '', '', 0, 0, '', '', '2025-08-24 09:47:16'),
(3, '102', '0000-00-00', '0000-00-00', 1, '', '', '', '', NULL, NULL, '2002-02-22', '2002-02-24', '', '', 0, 0, '', '', '2025-08-24 09:47:16'),
(4, '102', '0000-00-00', '0000-00-00', 1, '', '', '', '', NULL, NULL, '2025-08-30', '2025-08-31', '0', '242243435633', 1, 2, '8098693487', '0', '2025-08-24 09:47:16'),
(5, '', '0000-00-00', '0000-00-00', 1, '', '', '', '', NULL, NULL, '2025-08-02', '2025-08-04', 'mayoori senthan', '242243435633', 2, 4, '8098693487', '0', '2025-08-24 09:47:16'),
(6, '', '0000-00-00', '0000-00-00', 1, '', '', '', '', NULL, NULL, '2025-08-23', '2025-08-24', 'mayoori senthan', '242243435633', 2, 1, '890786', '0', '2025-08-24 09:47:16'),
(7, '', '0000-00-00', '0000-00-00', 1, '', '', '', '', NULL, NULL, '2025-08-23', '2025-08-24', 'mayoori senthan', '242243435633', 2, 1, '890786', '0', '2025-08-24 09:47:16'),
(8, '', '0000-00-00', '0000-00-00', 1, '', '', '', '', NULL, NULL, '2025-09-07', '2025-09-09', 'hamsha mahendrarasa', '35286e62356r', 2, 4, '57967986874', '0', '2025-08-24 09:47:16'),
(9, '', '0000-00-00', '0000-00-00', 1, '', '', '', '', NULL, NULL, '2025-08-22', '2025-08-24', 'mayoori senthan', '242243435633', 1, 2, '890786', '0', '2025-08-24 09:47:16'),
(10, '', '0000-00-00', '0000-00-00', 1, '', '', '', '', NULL, NULL, '2025-08-25', '2025-08-28', 'mayoori senthan', '242243435633', 1, 2, '890786', '0', '2025-08-24 09:47:16'),
(11, '', '0000-00-00', '0000-00-00', 1, '', '', '', '', NULL, NULL, '2025-08-25', '2025-08-28', 'mayoori senthan', '242243435633', 1, 2, '890786', '0', '2025-08-24 09:47:16'),
(13, '', '0000-00-00', '0000-00-00', 3, '', '', '', '', '', 0.00, '2025-08-25', '2025-08-28', 'mayoori senthan', '242243435633', 1, 2, '890786', 'mayu@gmail.com', '2025-08-24 09:47:16'),
(14, '', '0000-00-00', '0000-00-00', 3, '', '', '', '', 'Marino hotel', 12.00, '2025-08-30', '2025-08-31', 'mayoori senthan', '242243435633', 2, 4, '890786', 'mayu@gmail.com', '2025-08-24 09:47:16'),
(15, '', '0000-00-00', '0000-00-00', 3, '', '', '', '', 'Marino hotel', 12.00, '2025-08-30', '2025-08-31', 'mayoori senthan', '242243435633', 2, 4, '890786', 'mayu@gmail.com', '2025-08-24 09:47:16'),
(16, '', '0000-00-00', '0000-00-00', 3, '', '', '', '', 'Marino hotel', 12.00, '2025-09-04', '2025-09-06', 'hamsha mahendrarasa', '35286e62356r', 2, 4, '57967986874', 'mayu@gmail.com', '2025-08-24 09:47:16'),
(17, '', '0000-00-00', '0000-00-00', 3, '', '', '', '', 'Marino hotel', 12.00, '2025-08-28', '2025-08-29', 'ravindhi', '76796769', 3, 6, '67895567', 'sfgsad@gmail.com', '2025-08-24 09:47:16'),
(18, '', '0000-00-00', '0000-00-00', 3, '', '', '', '', 'Marino hotel', 12.00, '2025-08-28', '2025-08-29', 'ravindhi', '76796769', 3, 6, '67895567', 'sfgsad@gmail.com', '2025-08-24 09:47:16'),
(19, '', '0000-00-00', '0000-00-00', 3, '', '', '', '', 'Marino hotel', 12.00, '2025-08-31', '2025-09-01', 'ravika', '3333333312', 1, 2, '744487409', 'dfvy@gmail.com', '2025-08-24 09:47:16'),
(21, '', '0000-00-00', '0000-00-00', 3, '', '', '', '', '', 0.00, '2025-08-30', '2025-08-31', 'mayoori senthan', '35286e62356r', 1, 1, '57967986874', 'mayu@gmail.com', '2025-08-24 13:37:46'),
(23, '', '0000-00-00', '0000-00-00', 1, '', '', '', '', NULL, NULL, '2025-09-03', '2025-09-05', 'mayoori senthan', '242243435633', 1, 2, '67895567', '0', '2025-08-24 15:12:06'),
(24, '', '0000-00-00', '0000-00-00', 1, '', '', '', '', NULL, NULL, '2025-09-03', '2025-09-05', 'mayoori senthan', '242243435633', 1, 2, '67895567', '0', '2025-08-24 15:14:03'),
(25, '', '0000-00-00', '0000-00-00', 2, 'mnk,hjk', 'mayu@gmail.com', '674848', '', 'Marino hotel', 12.00, '2025-08-31', '2025-09-02', '', '', 1, 2, '', '', '2025-08-24 15:43:25'),
(26, '', '0000-00-00', '0000-00-00', 2, 'mayoori', 'mayu@gmail.com', '674848', '978678', 'Marino hotel', 12.00, '2025-08-29', '2025-08-30', '', '', 1, 2, '', '', '2025-08-24 15:50:49'),
(28, '', '0000-00-00', '0000-00-00', 2, 'hamzu', 'mayu@gmail.com', '674848', '978678', 'Love Palace', 14.00, '2025-08-29', '2025-08-31', '', '', 1, 2, '', '', '2025-08-24 15:53:55'),
(29, '', '0000-00-00', '0000-00-00', 2, 'hamzu', 'mayu@gmail.com', '0776252678', '20045625623', 'Hamshas hotel', 11.00, '2025-08-30', '2025-08-31', '', '', 2, 3, '', '', '2025-08-24 17:20:49'),
(30, '', '0000-00-00', '0000-00-00', 2, 'hamzu', 'hamsha0912@gmail.com', '0776252678', '978678', 'Udaï Niwas', 15.00, '2025-08-30', '2025-08-31', '', '', 1, 2, '', '', '2025-08-24 17:33:29'),
(31, '', '0000-00-00', '0000-00-00', 2, 'hamzu', 'mayu@gmail.com', '0776252678', '53667667', 'Udaï Niwas', 15.00, '2025-08-31', '2025-09-01', '', '', 3, 5, '', '', '2025-08-24 17:37:28'),
(32, '', '0000-00-00', '0000-00-00', 2, 'hamzu', 'mayu@gmail.com', '674848', '978678', 'Marino hotel', 12.00, '2025-08-29', '2025-08-30', '', '', 1, 2, '', '', '2025-08-25 14:11:37'),
(34, '', '0000-00-00', '0000-00-00', 2, 'hamzu', 'hamsha0912@gmail.com', '0776252678', '978678', 'Hamshas hotel', 11.00, '2025-08-29', '2025-08-31', '', '', 1, 2, '', '', '2025-08-28 23:10:24');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `booking_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_booking_id` (`booking_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `amount`, `payment_date`) VALUES
(1, 1, 360.00, '2025-08-19'),
(2, 2, 500.00, '2025-08-19');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE IF NOT EXISTS `rooms` (
  `room_number` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `facilities` text COLLATE utf8mb4_unicode_ci,
  `max_occupancy` int NOT NULL,
  `room_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_per_night` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`room_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_number`, `facilities`, `max_occupancy`, `room_type`, `price_per_night`) VALUES
('101', 'Wi-Fi, AC, Private Bathroom', 1, 'Single', 80.00),
('102', 'Wi-Fi, AC, Balcony, Minibar', 2, 'Double', 120.00),
('201', 'Wi-Fi, Jacuzzi, Living Room, Kitchenette', 4, 'Suite', 250.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_email` (`email`(191))
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'user1', 'mayu@gmail.com', '$2y$10$PrRmIaueLsY5FX2WeVbkC.nM53ZyHFIY85weV1wvcs7W/N1AU7PfW', '2025-08-19 06:20:13'),
(2, 'hamsha', 'hamsha@gmail.com', '$2y$10$QfkCRURe3qG/JqBZASq3JeomdC94mZxi77vx.a0zWM92/coSJkR6.', '2025-08-23 18:01:57'),
(3, 'admin', 'admin1@gmail.com', '$2y$10$gxuXQVpntrwkUX/yZ6XlCeiPgw4rw7yef3vUnCLnKjbCYEimMTeVy', '2025-08-23 18:06:03');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_booking_id` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
