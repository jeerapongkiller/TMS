-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2021 at 12:35 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `system_tms`
--

-- --------------------------------------------------------

--
-- Table structure for table `agent`
--

CREATE TABLE `agent` (
  `id` int(11) NOT NULL,
  `supplier` int(11) NOT NULL,
  `agent` int(11) NOT NULL,
  `offline` int(11) NOT NULL DEFAULT 2,
  `trash_deleted` int(11) NOT NULL DEFAULT 2,
  `date_create` datetime NOT NULL,
  `date_edit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agent`
--

INSERT INTO `agent` (`id`, `supplier`, `agent`, `offline`, `trash_deleted`, `date_create`, `date_edit`) VALUES
(1, 4, 1, 2, 2, '2021-02-22 14:43:09', '2021-02-22 14:43:09'),
(2, 4, 3, 2, 2, '2021-02-22 15:01:54', '2021-02-22 15:01:54'),
(3, 2, 1, 2, 2, '2021-02-22 15:12:54', '2021-02-22 15:12:54'),
(4, 2, 4, 2, 2, '2021-02-22 15:14:12', '2021-02-22 15:14:12'),
(5, 5, 3, 1, 1, '2021-02-22 15:36:28', '2021-02-22 15:36:28'),
(6, 5, 2, 1, 1, '2021-02-22 15:41:32', '2021-02-22 15:41:32'),
(7, 3, 4, 2, 2, '2021-02-22 15:58:32', '2021-02-22 15:58:32');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_invoice` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fax` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_position` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `offline` int(11) NOT NULL DEFAULT 2,
  `trash_deleted` int(11) NOT NULL DEFAULT 2,
  `date_create` datetime NOT NULL,
  `date_edit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `name_invoice`, `address`, `phone`, `fax`, `email`, `website`, `contact_person`, `contact_position`, `contact_phone`, `contact_email`, `photo`, `offline`, `trash_deleted`, `date_create`, `date_edit`) VALUES
(1, 'Apple', 'บริษัท แอปเปิ้ล เซาท์ เอเชีย (ประเทศไทย) จำกัด', '999/9 อาคาร ดิออฟฟิศเศส แอท เซ็นทรัลเวิลด์ ชั้น 44\nห้องเลขที่ เอชเอช 4401-6 และ เอชเอช 4408-9\nถนนพระราม 1 แขวงปทุมวัน เขตปทุมวัน กรุงเทพฯ 10330 ประเทศไทย', '076-548596', '076-548595', 'apple@gmail.com', 'www.apple.com', 'คุณ แอปเปิ้ล', 'ฝ่ายขาย', '089-5923302', 'sale.apple@gmail.com', '16139653551.png', 2, 2, '2021-02-22 10:42:35', '2021-02-22 10:42:35'),
(2, 'Microsoft', 'Microsoft invoice', '888/8 อาคาร ดิออฟฟิศเศส แอท เซ็นทรัลเวิลด์ ชั้น 55\nถนนพระราม 1  แขวงปทุมวัน \nเขตปทุมวัน กรุงเทพฯ 10330 ', '076-152005', '076-152004', 'microsoft@outlook.com', 'www.microsoft.com', 'คุน วิน', 'ฝ่ายขาย', '098-5923302', 'sale.win@outlook.com', '16139658001.jpg', 2, 2, '2021-02-22 10:50:00', '2021-02-22 10:50:00'),
(3, 'Nike', 'Nike Invoice', '2 Unit 278, 2 Fl, Mahidol Rd 252-252/1 \nHaiya, Muang Chiang Mai \nChiang Mai, Chiang Mai, 50100, TH', '077-59422', '077-59421', 'nike@gmail.com', 'www.nike.com', 'คุณ บอล', 'การตลาด', '084-544596', 'ball@gmail.com', '16139663521.jpg', 2, 2, '2021-02-22 10:59:12', '2021-02-22 10:59:12'),
(4, 'Adidas', 'Adidas Invoice', '', '076-485854', '076-485853', 'adidas@gmail.com', 'www.adidas.com', 'ไมค์', 'ฝ่ายขาย', '089-5626632', 'mike@gmail.com', '16139665001.png', 2, 2, '2021-02-22 11:01:40', '2021-02-22 11:01:40'),
(5, 'test-company', 'test', 'test', '078-59655', '078-59654', 'test@gmail.com', 'www.test.com', 'test', 'ฝ่ายขาย', '084-5956636', 'test@gmail.com', '', 1, 1, '2021-02-22 15:35:00', '2021-02-22 15:36:21');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `offline` int(11) NOT NULL DEFAULT 2,
  `trash_deleted` int(11) NOT NULL DEFAULT 2,
  `date_create` datetime NOT NULL,
  `date_edit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `name`, `offline`, `trash_deleted`, `date_create`, `date_edit`) VALUES
(1, 'Super Admin', 2, 2, '2021-02-22 16:38:13', '2021-02-22 16:38:13'),
(2, 'Admin', 2, 2, '2021-02-22 16:38:13', '2021-02-22 16:38:13'),
(3, 'Member', 2, 2, '2021-02-22 16:38:13', '2021-02-22 16:38:13'),
(4, 'Account', 2, 2, '2021-02-22 17:13:50', '2021-02-22 17:13:50'),
(5, 'Reservation', 2, 2, '2021-02-22 17:15:45', '2021-02-22 17:15:45'),
(6, 'test', 1, 1, '2021-02-22 17:16:21', '2021-02-22 17:42:51');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `products_type` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `offline` int(11) NOT NULL DEFAULT 2,
  `trash_deleted` int(11) NOT NULL DEFAULT 2,
  `date_create` datetime NOT NULL,
  `date_edit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `company`, `products_type`, `name`, `offline`, `trash_deleted`, `date_create`, `date_edit`) VALUES
(1, 4, 1, 'Phi Phi Island (1 Day)', 2, 2, '2021-02-24 12:09:42', '2021-02-24 12:09:42'),
(2, 4, 1, 'Phi Phi Island (Half Day)', 2, 2, '2021-02-24 12:12:00', '2021-02-24 12:12:00');

-- --------------------------------------------------------

--
-- Table structure for table `products_periods`
--

CREATE TABLE `products_periods` (
  `id` int(11) NOT NULL,
  `products` int(11) NOT NULL,
  `periods_from` date NOT NULL,
  `periods_to` date NOT NULL,
  `offline` int(11) NOT NULL DEFAULT 2,
  `trash_deleted` int(11) NOT NULL DEFAULT 2,
  `date_create` datetime NOT NULL,
  `date_edit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_periods`
--

INSERT INTO `products_periods` (`id`, `products`, `periods_from`, `periods_to`, `offline`, `trash_deleted`, `date_create`, `date_edit`) VALUES
(1, 2, '2021-02-01', '2021-03-31', 2, 2, '2021-02-24 16:08:11', '2021-02-24 16:08:11'),
(2, 2, '2021-04-01', '2021-04-30', 2, 2, '2021-02-24 17:14:01', '2021-02-24 17:14:01');

-- --------------------------------------------------------

--
-- Table structure for table `products_rates`
--

CREATE TABLE `products_rates` (
  `id` int(11) NOT NULL,
  `products_periods` int(11) NOT NULL,
  `type_rates` int(11) NOT NULL,
  `rate_adult` double(15,2) NOT NULL,
  `rate_children` double(15,2) NOT NULL,
  `rate_infant` double(15,2) NOT NULL,
  `rate_group` double(15,2) NOT NULL,
  `pax` int(11) NOT NULL,
  `offline` int(11) NOT NULL DEFAULT 2,
  `trash_delete` int(11) NOT NULL DEFAULT 2,
  `date_create` datetime NOT NULL,
  `date_edit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products_type`
--

CREATE TABLE `products_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_thai` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_type`
--

INSERT INTO `products_type` (`id`, `name`, `name_thai`, `date_create`) VALUES
(1, 'Tour', 'ทัวร์', '2021-02-23 15:13:56'),
(2, 'Activities', 'กิจกรรม', '2021-02-23 15:13:56'),
(3, 'Transfer', 'รถรับส่ง', '2021-02-23 15:13:56'),
(4, 'Hotel', 'โรงแรม', '2021-02-23 15:13:56'),
(5, 'Ticket', 'ตั๋ว', '2021-02-23 16:44:20');

-- --------------------------------------------------------

--
-- Table structure for table `rates_agent`
--

CREATE TABLE `rates_agent` (
  `id` int(11) NOT NULL,
  `products_rates` int(11) NOT NULL,
  `agent` int(11) NOT NULL,
  `offline` int(11) NOT NULL DEFAULT 2,
  `trash_deleted` int(11) NOT NULL DEFAULT 2,
  `date_create` datetime NOT NULL,
  `date_edit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `type_rates`
--

CREATE TABLE `type_rates` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `type_rates`
--

INSERT INTO `type_rates` (`id`, `name`, `date_create`) VALUES
(1, 'Cost', '2021-02-23 15:16:14'),
(2, 'Sale', '2021-02-23 15:16:14'),
(3, 'Agent', '2021-02-23 15:16:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `permission` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `offline` int(11) NOT NULL DEFAULT 2,
  `trash_deleted` int(11) NOT NULL DEFAULT 2,
  `date_create` datetime NOT NULL,
  `date_edit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `permission`, `company`, `username`, `password`, `firstname`, `lastname`, `photo`, `offline`, `trash_deleted`, `date_create`, `date_edit`) VALUES
(1, 1, 0, 'solution', '$2y$10$smftfoqY/OdRkLw7hfRwwe7WA5omjAlcEdNhdi1LUXAxHYBKSg9Ly', 'Phuket', 'Solution', 'solution.jpg', 2, 2, '2021-02-18 13:45:21', '2021-02-18 13:45:21'),
(2, 4, 3, 'admin', '$2y$10$R56QjijrRnJ2861lKznkDeuoj7Ni2oGPN1pO6a8c1rBF7bJg1eYiu', 'Nezuko', 'Kamado', '16139649091.jpg', 2, 2, '2021-02-22 10:35:09', '2021-02-22 17:27:23'),
(3, 2, 1, 'test', '$2y$10$UHAQuYnUyklRB5qLC6YbuOxsIney1a3lhRbDtJ78KMw2TkDuYzGbu', 'Tanjiro', 'Kamado', '16139649771.jpg', 2, 2, '2021-02-22 10:36:17', '2021-02-22 17:27:17'),
(4, 5, 4, 'test2', '$2y$10$nS9F8LeIlG5JMFNaqT9jsOLlYqs./TKfnXtXt0kpMjtWDpCwcQdLS', 'Zenitsu', 'Agatsuma', '16139650521.jpg', 2, 2, '2021-02-22 10:37:32', '2021-02-22 17:27:29'),
(5, 3, 2, 'test3', '$2y$10$YrePRoCZz8SwMRJuewhnT.pee2dYfak.AW4CTz7LpBG4nKzTpubna', 'คุณ มีน่า', 'มากดี', '', 1, 2, '2021-02-22 10:39:53', '2021-02-23 09:52:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agent`
--
ALTER TABLE `agent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_periods`
--
ALTER TABLE `products_periods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_rates`
--
ALTER TABLE `products_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_type`
--
ALTER TABLE `products_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rates_agent`
--
ALTER TABLE `rates_agent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type_rates`
--
ALTER TABLE `type_rates`
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
-- AUTO_INCREMENT for table `agent`
--
ALTER TABLE `agent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products_periods`
--
ALTER TABLE `products_periods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products_rates`
--
ALTER TABLE `products_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products_type`
--
ALTER TABLE `products_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rates_agent`
--
ALTER TABLE `rates_agent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `type_rates`
--
ALTER TABLE `type_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
