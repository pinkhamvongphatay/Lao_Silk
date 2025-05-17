-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2025 at 05:53 PM
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
-- Database: `laosilk`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(10) NOT NULL COMMENT 'ລະຫັດລູກຄ້າ',
  `username` varchar(50) NOT NULL COMMENT 'ຊື່ລູກຄ້າ',
  `password` varchar(50) NOT NULL COMMENT 'ລະຫັດຜ່ານ',
  `updated_date` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp() COMMENT 'ວັນທີປັບປຸງ',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'ວັນທີສ້າງ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `username`, `password`, `updated_date`, `created_date`) VALUES
(2, 'touktick', '$2y$10$oAAn8Ottjqmpa30WliIvmeTY5PKebod2fHC5MFVbxU7', NULL, '2025-05-16 04:33:15'),
(3, 'beer', '$2y$10$Juno4xlP3c1TQ3fLoVdo4OwuqLkeLiUwQeiWvnjH33x', NULL, '2025-05-16 04:33:24'),
(4, 'thipphaphone', '$2y$10$WLhQVK/meamO34HKHgryr.CEF//UefnIaa9E3ixFLpj', NULL, '2025-05-16 04:33:37'),
(5, 'touktick', '$2y$10$FOhB7tEDyFmLSh30f6CDLOf7OdKCBgc34/NQPXmT6wK', NULL, '2025-05-16 04:35:26');

-- --------------------------------------------------------

--
-- Table structure for table `dress`
--

CREATE TABLE `dress` (
  `id` int(10) NOT NULL,
  `size` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  `length` varchar(50) NOT NULL,
  `width` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `updated_date` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` varchar(50) NOT NULL,
  `type_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(10) NOT NULL COMMENT 'ລະຫັດພະນັກງານ',
  `username` varchar(50) NOT NULL COMMENT 'ຊື່ພະນັກງານ',
  `password` varchar(255) NOT NULL COMMENT 'ລະຫັດຜ່ານ',
  `updated_date` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp() COMMENT 'ວັນທີປັບປຸງ',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'ວັນທີສ້າງ',
  `tel` varchar(50) NOT NULL COMMENT 'ເບີໂທ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `username`, `password`, `updated_date`, `created_date`, `tel`) VALUES
(1, 'pinkham', '$2y$10$wFhozqVCoBP0mOkGGGS5b.5nCEK0qeFIQFrRNkNwLQWDnJONWeIXC', '2025-03-27 08:41:48', '2025-03-27 08:39:38', ''),
(2, 'lacky', '$2y$10$h3sc3PR4EUlsHXnRLnmHYOu3AqDkJqiVvg4erPE6zill.RgWvsUeq', '2025-03-28 07:37:08', '2025-03-28 07:34:15', '555555');

-- --------------------------------------------------------

--
-- Table structure for table `rental`
--

CREATE TABLE `rental` (
  `id` int(10) NOT NULL COMMENT 'ລະຫັດຂອງຊຸດ',
  `total` float NOT NULL COMMENT 'ລາຄາ',
  `updated_date` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp() COMMENT 'ອັບເດດວັນທີ',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'ວັນທີສ້າງ',
  `return_date` date NOT NULL COMMENT 'ວັນທີ່ສົ່ງຊຸດ',
  `customer_id` int(10) NOT NULL COMMENT 'ລະຫັດຂອງລູກຄ້າ',
  `employee_id` int(10) NOT NULL COMMENT 'ລະຫັດພະນັກງານ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental_detail`
--

CREATE TABLE `rental_detail` (
  `id` int(10) NOT NULL,
  `qty` int(10) NOT NULL,
  `amount` int(10) NOT NULL,
  `dress_id` int(10) NOT NULL,
  `rental_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `type_dress`
--

CREATE TABLE `type_dress` (
  `id` int(10) NOT NULL,
  `type` varchar(50) NOT NULL,
  `updated_date` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `type_dress`
--

INSERT INTO `type_dress` (`id`, `type`, `updated_date`, `created_date`) VALUES
(4, 'ໄຫມມ້ອນ', NULL, '2025-05-16 03:36:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `dress`
--
ALTER TABLE `dress`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rental`
--
ALTER TABLE `rental`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rental_detail`
--
ALTER TABLE `rental_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type_dress`
--
ALTER TABLE `type_dress`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດລູກຄ້າ', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dress`
--
ALTER TABLE `dress`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດພະນັກງານ', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rental_detail`
--
ALTER TABLE `rental_detail`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `type_dress`
--
ALTER TABLE `type_dress`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
