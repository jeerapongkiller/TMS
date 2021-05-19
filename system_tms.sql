-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2021 at 04:43 AM
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
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `booking_no` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `agent` int(11) NOT NULL,
  `agent_voucher` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_aff` int(11) NOT NULL,
  `sale_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_firstname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_lastname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_mobile` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_receipt` int(11) NOT NULL DEFAULT 2,
  `receipt_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receipt_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `receipt_taxid` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receipt_detail` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `offline` int(11) NOT NULL DEFAULT 2,
  `trash_deleted` int(11) NOT NULL DEFAULT 2,
  `date_create` datetime NOT NULL,
  `date_edit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `company`, `booking_no`, `booking_date`, `agent`, `agent_voucher`, `company_aff`, `sale_name`, `customer_firstname`, `customer_lastname`, `customer_mobile`, `customer_email`, `full_receipt`, `receipt_name`, `receipt_address`, `receipt_taxid`, `receipt_detail`, `offline`, `trash_deleted`, `date_create`, `date_edit`) VALUES
(1, 4, 1, '2021-05-14', 2, '1850001', 4, 'K.Nut', 'John', 'Wick', '086-5926635', '', 1, 'คุณ แม็ก', '145/5 ถ. ปฏิพัทธิ์ ตำบล วิชิต \nอำเภอเมืองภูเก็ต \nภูเก็ต 83000', '12050062', '', 2, 2, '2021-05-14 15:02:37', '2021-05-14 15:02:37'),
(2, 4, 2, '2021-05-14', 0, '', 0, '', 'scott', 'corn', '089-5632219', 'scott@gmail.com', 2, 'K.Max', '  ', '1258005122166', '  ', 2, 2, '2021-05-14 15:09:12', '2021-05-14 15:09:12'),
(3, 4, 3, '2021-05-14', 1, '1850009', 3, 'Moshi', 'Yamama', 'Yura', '099-6932265', '', 2, 'คุณ หยาด', '12, 79 ถ. เจ้าฟ้าตะวันออก \nตำบล ฉลอง อำเภอเมืองภูเก็ต\n ภูเก็ต 83000', '5002366209', '', 2, 2, '2021-05-14 16:13:39', '2021-05-14 16:13:46');

-- --------------------------------------------------------

--
-- Table structure for table `booking_history`
--

CREATE TABLE `booking_history` (
  `id` int(11) NOT NULL,
  `booking` int(11) NOT NULL,
  `history_type` int(11) NOT NULL,
  `booking_products` int(11) NOT NULL,
  `description_field` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `users` int(11) NOT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_no`
--

CREATE TABLE `booking_no` (
  `id` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `bo_title` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bo_date` date NOT NULL,
  `bo_year` int(11) NOT NULL,
  `bo_year_thai` int(11) NOT NULL,
  `bo_month` int(11) NOT NULL,
  `bo_no` int(11) NOT NULL,
  `bo_full` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_no`
--

INSERT INTO `booking_no` (`id`, `company`, `bo_title`, `bo_date`, `bo_year`, `bo_year_thai`, `bo_month`, `bo_no`, `bo_full`, `date_create`) VALUES
(1, 4, 'BO', '2021-05-14', 2021, 64, 5, 1, 'BO0004640500001', '2021-05-14 15:02:37'),
(2, 4, 'BO', '2021-05-14', 2021, 64, 5, 2, 'BO0004640500002', '2021-05-14 15:09:12'),
(3, 4, 'BO', '2021-05-14', 2021, 64, 5, 3, 'BO0004640500003', '2021-05-14 16:13:39');

-- --------------------------------------------------------

--
-- Table structure for table `booking_payment`
--

CREATE TABLE `booking_payment` (
  `id` int(11) NOT NULL,
  `booking` int(11) NOT NULL,
  `booking_products` int(11) NOT NULL,
  `products_all` int(11) NOT NULL DEFAULT 2,
  `payment_type` int(11) NOT NULL,
  `bank` int(11) NOT NULL,
  `bank_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_date` date NOT NULL,
  `receip_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_price` double(15,2) NOT NULL,
  `receiver_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `offline` int(11) NOT NULL DEFAULT 2,
  `trash_deleted` int(11) NOT NULL DEFAULT 2,
  `date_create` datetime NOT NULL,
  `date_edit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_products`
--

CREATE TABLE `booking_products` (
  `id` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `booking` int(11) NOT NULL,
  `combine_agent` int(11) NOT NULL,
  `products_type` int(11) NOT NULL,
  `products` int(11) NOT NULL,
  `products_periods` int(11) NOT NULL,
  `products_rates` int(11) NOT NULL,
  `rates_agent` int(11) NOT NULL,
  `travel_date` date NOT NULL,
  `adults` int(11) NOT NULL,
  `children` int(11) NOT NULL,
  `infant` int(11) NOT NULL,
  `transfer` int(11) NOT NULL DEFAULT 2,
  `no_cars` int(11) NOT NULL,
  `no_hours` int(11) NOT NULL,
  `pickup` int(11) NOT NULL,
  `pickup_time` time NOT NULL,
  `dropoff` int(11) NOT NULL,
  `dropoff_time` time NOT NULL,
  `rate_adults` double(15,2) NOT NULL,
  `rate_children` double(15,2) NOT NULL,
  `rate_infant` double(15,2) NOT NULL,
  `rate_group` double(15,2) NOT NULL,
  `rate_transfer` double(15,2) NOT NULL,
  `pax` double(15,2) NOT NULL,
  `price_default` double(15,2) NOT NULL,
  `price_latest` double(15,2) NOT NULL,
  `offline` int(11) NOT NULL DEFAULT 2,
  `trash_deleted` int(11) NOT NULL DEFAULT 2,
  `date_create` datetime NOT NULL,
  `date_edit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `combine_agent`
--

CREATE TABLE `combine_agent` (
  `id` int(11) NOT NULL,
  `supplier` int(11) NOT NULL,
  `agent` int(11) NOT NULL,
  `offline` int(11) NOT NULL DEFAULT 2,
  `trash_deleted` int(11) NOT NULL DEFAULT 2,
  `date_create` datetime NOT NULL,
  `date_edit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `combine_agent`
--

INSERT INTO `combine_agent` (`id`, `supplier`, `agent`, `offline`, `trash_deleted`, `date_create`, `date_edit`) VALUES
(1, 4, 1, 2, 2, '2021-03-02 15:57:41', '2021-03-02 15:57:41'),
(2, 4, 3, 2, 2, '2021-03-02 15:57:47', '2021-03-02 15:57:47'),
(3, 4, 2, 1, 1, '2021-03-11 17:06:16', '2021-03-11 17:06:16'),
(4, 1, 3, 2, 2, '2021-03-23 12:10:27', '2021-03-23 12:10:27'),
(5, 1, 4, 2, 2, '2021-03-30 16:57:04', '2021-03-30 16:57:04'),
(6, 3, 4, 2, 2, '2021-03-31 10:20:18', '2021-03-31 10:20:18');

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
(1, 'Nike', 'Nike Invoice', '2 Unit 278, 2 Fl, Mahidol Rd 252-252/1 \nHaiya, Muang Chiang Mai \nChiang Mai, Chiang Mai, 50100, TH', '076-548596', '076-548595', 'nike@gmail.com', 'www.nike.com', 'คุณ บอล', 'ฝ่ายขาย', '089-5923302', 'ball@gmail.com', '16177027171.jpg', 2, 2, '2021-02-22 10:42:35', '2021-04-06 16:51:57'),
(2, 'Microsoft', 'Microsoft invoice', '888/8 อาคาร ดิออฟฟิศเศส แอท เซ็นทรัลเวิลด์ ชั้น 55\nถนนพระราม 1  แขวงปทุมวัน \nเขตปทุมวัน กรุงเทพฯ 10330 ', '076-152005', '076-152004', 'microsoft@outlook.com', 'www.microsoft.com', 'คุน วิน', 'ฝ่ายขาย', '098-5923302', 'sale.win@outlook.com', '16139658001.jpg', 2, 2, '2021-02-22 10:50:00', '2021-02-22 10:50:00'),
(3, 'Apple', 'บริษัท แอปเปิ้ล เซาท์ เอเชีย (ประเทศไทย) จำกัด', '999/9 อาคาร ดิออฟฟิศเศส แอท เซ็นทรัลเวิลด์ ชั้น 44\nห้องเลขที่ เอชเอช 4401-6 และ เอชเอช 4408-9\nถนนพระราม 1 แขวงปทุมวัน เขตปทุมวัน กรุงเทพฯ 10330 ประเทศไทย', '077-59422', '077-59421', 'apple@gmail.com', 'www.apple.com', 'คุณ แอปเปิ้ล', 'การตลาด', '084-544596', 'sale.apple@gmail.com', '16177026741.png', 2, 2, '2021-02-22 10:59:12', '2021-04-06 16:51:14'),
(4, 'Adidas', 'Adidas Invoice', '', '076-485854', '076-485853', 'adidas@gmail.com', 'www.adidas.com', 'ไมค์', 'ฝ่ายขาย', '089-5626632', 'mike@gmail.com', '16139665001.png', 2, 2, '2021-02-22 11:01:40', '2021-02-22 11:01:40'),
(5, 'test-company', 'test', 'test', '078-59655', '078-59654', 'test@gmail.com', 'www.test.com', 'test', 'ฝ่ายขาย', '084-5956636', 'test@gmail.com', '', 1, 1, '2021-02-22 15:35:00', '2021-02-22 15:36:21');

-- --------------------------------------------------------

--
-- Table structure for table `company_aff`
--

CREATE TABLE `company_aff` (
  `id` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `name_aff` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receipt_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receipt_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `receipt_taxid` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receipt_detail` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `offline` int(11) NOT NULL DEFAULT 2,
  `trash_deleted` int(11) NOT NULL DEFAULT 2,
  `date_create` datetime NOT NULL,
  `date_edit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_aff`
--

INSERT INTO `company_aff` (`id`, `company`, `name_aff`, `receipt_name`, `receipt_address`, `receipt_taxid`, `receipt_detail`, `photo`, `offline`, `trash_deleted`, `date_create`, `date_edit`) VALUES
(1, 4, 'Mira Tour', 'คุณ ทีน่า', '21 10 หมู่ที่ 7 ถนน เจ้าฟ้าตะวันตก\n ตำบล ฉลอง อำเภอเมืองภูเก็ต\n ภูเก็ต 83000', '8800512009', '- Test Submit1\n- Test Submit1\n- Test Submit1', '16164755431.jpg', 2, 2, '2021-03-23 11:59:03', '2021-03-23 12:08:34'),
(2, 4, 'Deluxe Tour', 'คุณ กุ้ง', '27 ถนน เจ้าฟ้าตะวันตก\nตำบล ฉลอง อำเภอเมืองภูเก็ต \nภูเก็ต 83000', '18522003015', 'Test Detail\nTest Detail', '16164757961.png', 2, 2, '2021-03-23 12:03:16', '2021-03-23 12:07:24'),
(3, 1, 'Krabi Tour', 'คุณ หยาด', '12, 79 ถ. เจ้าฟ้าตะวันออก \nตำบล ฉลอง อำเภอเมืองภูเก็ต\n ภูเก็ต 83000', '5002366209', '', '16164762121.jpg', 2, 2, '2021-03-23 12:10:12', '2021-03-23 12:10:12'),
(4, 2, 'B-pack', 'คุณ แม็ก', '145/5 ถ. ปฏิพัทธิ์ ตำบล วิชิต \nอำเภอเมืองภูเก็ต \nภูเก็ต 83000', '12050062', '', '16165570041.jpg', 2, 2, '2021-03-24 10:36:44', '2021-03-24 10:36:44'),
(5, 1, 'EL-tour', 'คุณ บี', '28 ถนน กระบี่ ตำบลตลาดเหนือ \nอำเภอเมืองภูเก็ต \nภูเก็ต 83000', '100854005', '', '16165762891.jpg', 2, 2, '2021-03-24 15:58:09', '2021-03-24 15:58:09');

-- --------------------------------------------------------

--
-- Table structure for table `history_type`
--

CREATE TABLE `history_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_thai` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `history_type`
--

INSERT INTO `history_type` (`id`, `name`, `name_thai`, `date_create`) VALUES
(1, 'Create', 'เพิ่มข้อมูล', '2021-05-10 11:41:10'),
(2, 'Update', 'แก้ไขข้อมูล', '2021-05-10 11:41:14'),
(3, 'Delete', 'ลบข้อมูล', '2021-05-10 11:43:03'),
(4, 'Restore', 'คืนข้อมูล', '2021-05-10 11:43:06'),
(5, 'Confirmed', 'ยืนยันแล้ว', '2021-05-10 11:43:09'),
(6, 'Not Confirmed', 'ยังไม่ยืนยัน', '2021-05-10 11:43:12');

-- --------------------------------------------------------

--
-- Table structure for table `payment_type`
--

CREATE TABLE `payment_type` (
  `id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `offline` int(11) NOT NULL DEFAULT 2,
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_type`
--

INSERT INTO `payment_type` (`id`, `name`, `description`, `offline`, `date_create`) VALUES
(1, 'Cash', '', 2, '2021-05-12 17:29:27'),
(2, 'Bank', '', 2, '2021-05-12 17:29:27');

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
-- Table structure for table `place`
--

CREATE TABLE `place` (
  `id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pickup` int(11) NOT NULL DEFAULT 1,
  `dropoff` int(11) NOT NULL DEFAULT 1,
  `offline` int(11) NOT NULL DEFAULT 2,
  `trash_deleted` int(11) NOT NULL DEFAULT 2,
  `date_create` datetime NOT NULL,
  `date_edit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `place`
--

INSERT INTO `place` (`id`, `name`, `pickup`, `dropoff`, `offline`, `trash_deleted`, `date_create`, `date_edit`) VALUES
(1, 'Boat Lagoon', 1, 1, 2, 2, '2021-04-15 16:50:53', '2021-04-15 16:50:53'),
(2, 'Yacht Haven', 1, 1, 2, 2, '2021-04-15 16:50:53', '2021-04-15 16:50:53'),
(3, 'Royal Phuket Marina', 1, 1, 2, 2, '2021-04-15 16:51:14', '2021-04-15 16:51:14'),
(4, 'Phuket Fantasea', 1, 1, 2, 2, '2021-04-15 16:51:14', '2021-04-15 16:51:14');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `products_type` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cut_open` time NOT NULL,
  `cut_off` int(11) NOT NULL,
  `offline` int(11) NOT NULL DEFAULT 2,
  `trash_deleted` int(11) NOT NULL DEFAULT 2,
  `date_create` datetime NOT NULL,
  `date_edit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `company`, `products_type`, `name`, `cut_open`, `cut_off`, `offline`, `trash_deleted`, `date_create`, `date_edit`) VALUES
(1, 4, 1, 'Phi Phi Island (1 Day)', '00:00:00', 0, 2, 2, '2021-02-24 12:09:42', '2021-02-24 12:09:42'),
(2, 4, 1, 'Phi Phi Island (Half Day)', '00:00:00', 0, 2, 2, '2021-02-24 12:12:00', '2021-02-24 12:12:00'),
(3, 4, 1, 'James Bond Island (Allotment + Cut Off)', '21:25:00', 4, 2, 2, '2021-03-10 16:11:32', '2021-05-05 10:30:05'),
(4, 4, 1, 'James Bond Island (1 Day)', '00:00:00', 0, 1, 1, '2021-03-18 09:38:55', '2021-03-18 10:40:21'),
(5, 4, 1, 'Tachai Island (Cut Off)', '13:25:00', 3, 2, 2, '2021-03-22 09:45:58', '2021-04-08 11:46:13'),
(6, 1, 1, 'Air Max Tours (Cut off)', '19:00:00', 1, 2, 2, '2021-03-31 10:21:55', '2021-05-05 10:48:12'),
(7, 1, 1, 'Air Max Tours (Group)', '00:00:00', 0, 2, 2, '2021-03-31 10:39:48', '2021-03-31 10:39:48'),
(8, 1, 1, 'Jordan (Allotment)', '20:00:00', 2, 2, 2, '2021-03-31 10:49:41', '2021-03-31 10:49:52'),
(9, 3, 1, 'iPhone 12 (Cut Off)', '11:00:00', 2, 2, 2, '2021-03-31 12:05:21', '2021-03-31 12:05:21'),
(10, 3, 1, 'iPhone SE (Allotment)', '00:00:00', 0, 2, 2, '2021-03-31 12:06:38', '2021-05-05 10:50:51'),
(11, 3, 1, 'AirPods (Group)', '00:00:00', 0, 2, 2, '2021-03-31 12:08:29', '2021-03-31 12:08:29'),
(12, 1, 1, 'No Show', '00:00:00', 0, 2, 2, '2021-03-31 17:22:27', '2021-03-31 17:22:27'),
(13, 3, 1, 'No Show', '00:00:00', 0, 2, 2, '2021-03-31 17:23:36', '2021-03-31 17:23:36'),
(14, 1, 1, 'No Agent', '10:00:00', 2, 2, 2, '2021-04-05 16:22:39', '2021-04-05 16:22:39'),
(15, 3, 1, 'No Agent', '00:00:00', 0, 2, 2, '2021-04-05 16:25:45', '2021-04-05 16:25:45'),
(16, 1, 1, 'Offline Item', '00:00:00', 0, 1, 2, '2021-04-05 17:02:26', '2021-04-05 17:02:44'),
(17, 3, 1, 'Offline Item', '00:00:00', 0, 1, 2, '2021-04-05 17:29:41', '2021-04-05 17:29:57');

-- --------------------------------------------------------

--
-- Table structure for table `products_allotment`
--

CREATE TABLE `products_allotment` (
  `id` int(11) NOT NULL,
  `products` int(11) NOT NULL,
  `pax` int(11) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `offline` int(11) NOT NULL DEFAULT 2,
  `trash_deleted` int(11) NOT NULL DEFAULT 2,
  `date_create` datetime NOT NULL,
  `date_edit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_allotment`
--

INSERT INTO `products_allotment` (`id`, `products`, `pax`, `date_from`, `date_to`, `offline`, `trash_deleted`, `date_create`, `date_edit`) VALUES
(1, 3, 10, '2021-05-01', '2021-05-15', 2, 2, '2021-03-19 17:49:02', '2021-05-05 10:27:05'),
(2, 3, 20, '2021-05-16', '2021-05-31', 2, 2, '2021-03-19 18:00:50', '2021-05-05 10:27:18'),
(3, 5, 10, '2021-05-01', '2021-05-31', 2, 2, '2021-03-22 09:50:54', '2021-05-05 10:26:36'),
(4, 8, 12, '2021-05-01', '2021-05-15', 2, 2, '2021-03-31 10:50:16', '2021-05-05 10:32:46'),
(5, 8, 10, '2021-05-16', '2021-05-31', 2, 2, '2021-03-31 10:50:46', '2021-05-05 10:32:55'),
(6, 10, 12, '2021-05-01', '2021-05-31', 2, 2, '2021-03-31 12:07:10', '2021-05-05 10:50:27'),
(7, 1, 10, '2021-05-01', '2021-05-15', 2, 2, '2021-05-05 10:28:46', '2021-05-05 10:28:46'),
(8, 1, 14, '2021-05-16', '2021-05-31', 2, 2, '2021-05-05 10:29:06', '2021-05-05 10:29:06'),
(9, 7, 10, '2021-05-01', '2021-05-31', 2, 2, '2021-05-05 10:47:20', '2021-05-05 10:47:20');

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
(1, 2, '2021-05-16', '2021-05-31', 2, 2, '2021-03-11 12:26:49', '2021-05-05 10:25:08'),
(2, 2, '2021-05-01', '2021-05-15', 2, 2, '2021-03-11 12:28:21', '2021-05-05 10:24:49'),
(3, 1, '2021-05-16', '2021-05-31', 2, 2, '2021-03-12 16:09:18', '2021-05-05 10:25:29'),
(4, 3, '2021-05-01', '2021-05-31', 2, 2, '2021-03-12 16:11:51', '2021-05-05 10:24:36'),
(5, 4, '2021-05-01', '2021-05-31', 2, 2, '2021-03-18 09:38:55', '2021-05-05 10:23:08'),
(7, 5, '2021-05-01', '2021-05-31', 2, 2, '2021-03-22 09:45:58', '2021-05-05 10:22:55'),
(8, 6, '2021-05-16', '2021-05-31', 2, 2, '2021-03-31 10:36:06', '2021-05-05 10:47:47'),
(9, 6, '2021-05-01', '2021-05-15', 2, 2, '2021-03-31 10:39:03', '2021-03-31 10:39:03'),
(10, 7, '2021-06-01', '2021-06-30', 2, 2, '2021-03-31 10:47:55', '2021-05-05 10:46:38'),
(11, 8, '2021-05-01', '2021-05-31', 2, 2, '2021-03-31 11:37:39', '2021-05-05 10:32:34'),
(12, 9, '2021-05-16', '2021-05-31', 2, 2, '2021-03-31 12:05:53', '2021-05-05 10:51:33'),
(13, 10, '2021-05-01', '2021-05-31', 2, 2, '2021-03-31 12:07:41', '2021-05-05 10:50:18'),
(14, 11, '2021-05-01', '2021-05-31', 2, 2, '2021-03-31 12:09:11', '2021-05-05 10:49:33'),
(15, 12, '2021-04-01', '2021-04-30', 2, 2, '2021-03-31 17:22:45', '2021-03-31 17:22:45'),
(16, 13, '2021-04-01', '2021-04-30', 2, 2, '2021-03-31 17:23:52', '2021-03-31 17:23:52'),
(17, 14, '2021-05-01', '2021-05-31', 2, 2, '2021-04-05 16:23:36', '2021-05-05 10:32:10'),
(18, 15, '2021-04-01', '2021-04-30', 2, 2, '2021-04-05 16:26:13', '2021-04-05 16:26:13'),
(19, 16, '2021-04-01', '2021-04-15', 2, 2, '2021-04-05 17:02:26', '2021-04-22 11:08:54'),
(20, 7, '2021-05-01', '2021-05-31', 2, 2, '2021-04-05 17:03:56', '2021-05-05 10:46:58'),
(21, 17, '2021-04-01', '2021-04-30', 2, 2, '2021-04-05 17:29:41', '2021-04-05 17:29:41'),
(22, 10, '2021-04-01', '2021-04-30', 1, 2, '2021-04-05 17:33:09', '2021-04-05 17:33:09'),
(23, 9, '2021-05-01', '2021-05-15', 2, 2, '2021-04-06 17:41:40', '2021-05-05 10:51:12'),
(24, 1, '2021-05-01', '2021-05-15', 2, 2, '2021-04-06 18:17:48', '2021-04-06 18:17:48'),
(25, 16, '2021-02-01', '2021-02-28', 2, 2, '2021-04-22 10:50:30', '2021-04-22 10:59:16'),
(26, 16, '2021-05-01', '2021-05-15', 2, 2, '2021-04-22 11:00:03', '2021-04-22 11:00:03');

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
  `rate_transfer` double(15,2) NOT NULL,
  `offline` int(11) NOT NULL DEFAULT 2,
  `trash_deleted` int(11) NOT NULL DEFAULT 2,
  `date_create` datetime NOT NULL,
  `date_edit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_rates`
--

INSERT INTO `products_rates` (`id`, `products_periods`, `type_rates`, `rate_adult`, `rate_children`, `rate_infant`, `rate_group`, `pax`, `rate_transfer`, `offline`, `trash_deleted`, `date_create`, `date_edit`) VALUES
(1, 1, 1, 1000.00, 500.00, 200.00, 10000.00, 10, 200.00, 2, 2, '2021-03-11 12:26:49', '2021-03-11 12:26:49'),
(2, 1, 2, 1200.00, 600.00, 300.00, 11000.00, 10, 300.00, 2, 2, '2021-03-11 12:26:49', '2021-03-11 12:26:49'),
(3, 2, 1, 800.00, 300.00, 0.00, 8000.00, 10, 200.00, 2, 2, '2021-03-11 12:28:21', '2021-03-11 12:28:21'),
(4, 2, 2, 1000.00, 500.00, 0.00, 9500.00, 10, 200.00, 2, 2, '2021-03-11 12:28:21', '2021-03-11 12:28:21'),
(5, 2, 3, 1200.00, 800.00, 0.00, 0.00, 0, 0.00, 2, 2, '2021-03-12 16:01:22', '2021-03-12 16:01:22'),
(6, 2, 3, 2200.00, 800.00, 0.00, 0.00, 0, 0.00, 2, 2, '2021-03-11 16:50:16', '2021-03-11 16:50:16'),
(7, 2, 3, 3000.00, 2000.00, 0.00, 0.00, 0, 200.00, 2, 2, '2021-03-12 16:01:47', '2021-03-12 16:01:47'),
(8, 3, 1, 500.00, 200.00, 0.00, 0.00, 0, 200.00, 2, 2, '2021-03-12 16:09:18', '2021-03-12 16:09:18'),
(9, 3, 2, 700.00, 400.00, 0.00, 0.00, 0, 300.00, 2, 2, '2021-03-12 16:09:18', '2021-03-12 16:09:18'),
(10, 3, 3, 900.00, 600.00, 0.00, 0.00, 0, 300.00, 2, 2, '2021-03-12 16:10:00', '2021-03-12 16:10:00'),
(11, 4, 1, 800.00, 400.00, 0.00, 8000.00, 10, 150.00, 2, 2, '2021-03-12 16:11:51', '2021-03-12 16:11:51'),
(12, 4, 2, 1200.00, 800.00, 0.00, 10000.00, 10, 300.00, 2, 2, '2021-03-12 16:11:51', '2021-03-12 16:11:51'),
(13, 4, 3, 1400.00, 1000.00, 0.00, 24000.00, 22, 300.00, 2, 2, '2021-03-18 14:23:19', '2021-03-18 14:23:19'),
(14, 5, 1, 800.00, 400.00, 0.00, 8000.00, 10, 150.00, 2, 2, '2021-03-18 09:38:55', '2021-03-18 09:38:55'),
(15, 5, 2, 1200.00, 800.00, 0.00, 10000.00, 10, 300.00, 2, 2, '2021-03-18 09:38:55', '2021-03-18 09:38:55'),
(16, 6, 1, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 2, 2, '2021-03-19 14:25:30', '2021-03-19 14:25:30'),
(17, 6, 2, 0.00, 0.00, 0.00, 0.00, 0, 0.00, 2, 2, '2021-03-19 14:25:30', '2021-03-19 14:25:30'),
(18, 7, 1, 800.00, 400.00, 0.00, 8000.00, 10, 150.00, 2, 2, '2021-03-22 09:45:58', '2021-03-22 09:45:58'),
(19, 7, 2, 1200.00, 800.00, 0.00, 10000.00, 10, 300.00, 2, 2, '2021-03-22 09:45:58', '2021-03-22 09:45:58'),
(20, 8, 1, 2000.00, 1000.00, 100.00, 0.00, 0, 200.00, 2, 2, '2021-03-31 10:36:06', '2021-03-31 10:36:06'),
(21, 8, 2, 3000.00, 2000.00, 400.00, 0.00, 0, 300.00, 2, 2, '2021-03-31 10:36:06', '2021-03-31 10:36:06'),
(22, 9, 1, 1200.00, 600.00, 0.00, 12000.00, 10, 0.00, 2, 2, '2021-03-31 10:39:03', '2021-03-31 10:39:03'),
(23, 9, 2, 2000.00, 1000.00, 0.00, 18000.00, 10, 0.00, 2, 2, '2021-03-31 10:39:03', '2021-03-31 10:39:03'),
(24, 9, 3, 1400.00, 900.00, 0.00, 0.00, 0, 100.00, 2, 2, '2021-03-31 10:46:11', '2021-03-31 10:46:11'),
(25, 10, 1, 1000.00, 500.00, 0.00, 10000.00, 10, 100.00, 2, 2, '2021-03-31 10:47:55', '2021-03-31 10:47:55'),
(26, 10, 2, 1500.00, 800.00, 0.00, 14000.00, 10, 200.00, 2, 2, '2021-03-31 10:47:55', '2021-03-31 10:47:55'),
(27, 10, 3, 1300.00, 600.00, 0.00, 13000.00, 10, 100.00, 2, 2, '2021-03-31 10:48:26', '2021-03-31 10:48:26'),
(28, 11, 1, 900.00, 600.00, 0.00, 0.00, 0, 0.00, 2, 2, '2021-03-31 11:37:39', '2021-03-31 11:37:39'),
(29, 11, 2, 1800.00, 1200.00, 0.00, 0.00, 0, 0.00, 2, 2, '2021-03-31 11:37:39', '2021-03-31 11:37:39'),
(30, 11, 3, 2000.00, 1500.00, 0.00, 0.00, 0, 0.00, 2, 2, '2021-03-31 11:38:00', '2021-03-31 11:38:00'),
(31, 12, 1, 500.00, 300.00, 0.00, 0.00, 0, 100.00, 2, 2, '2021-03-31 12:05:53', '2021-03-31 12:05:53'),
(32, 12, 2, 1000.00, 400.00, 0.00, 0.00, 0, 200.00, 2, 2, '2021-03-31 12:05:53', '2021-03-31 12:05:53'),
(33, 12, 3, 1200.00, 800.00, 0.00, 0.00, 0, 0.00, 2, 2, '2021-03-31 12:06:13', '2021-03-31 12:06:13'),
(34, 13, 1, 300.00, 200.00, 0.00, 4000.00, 10, 0.00, 2, 2, '2021-03-31 12:07:41', '2021-03-31 12:07:41'),
(35, 13, 2, 800.00, 400.00, 0.00, 7500.00, 10, 0.00, 2, 2, '2021-03-31 12:07:41', '2021-03-31 12:07:41'),
(36, 13, 3, 750.00, 450.00, 0.00, 7500.00, 10, 0.00, 2, 2, '2021-03-31 12:08:09', '2021-03-31 12:08:09'),
(37, 14, 1, 600.00, 100.00, 100.00, 6000.00, 12, 0.00, 2, 2, '2021-03-31 12:09:11', '2021-03-31 12:09:11'),
(38, 14, 2, 900.00, 300.00, 100.00, 9000.00, 12, 0.00, 2, 2, '2021-03-31 12:09:11', '2021-03-31 12:09:11'),
(39, 14, 3, 1000.00, 700.00, 0.00, 10000.00, 10, 0.00, 2, 2, '2021-03-31 12:10:06', '2021-03-31 12:10:06'),
(40, 15, 1, 200.00, 100.00, 0.00, 0.00, 0, 0.00, 2, 2, '2021-03-31 17:22:45', '2021-03-31 17:22:45'),
(41, 15, 2, 500.00, 300.00, 0.00, 0.00, 0, 0.00, 2, 2, '2021-03-31 17:22:45', '2021-03-31 17:22:45'),
(42, 16, 1, 300.00, 100.00, 0.00, 0.00, 0, 0.00, 2, 2, '2021-03-31 17:23:52', '2021-03-31 17:23:52'),
(43, 16, 2, 600.00, 350.00, 0.00, 0.00, 0, 0.00, 2, 2, '2021-03-31 17:23:52', '2021-03-31 17:23:52'),
(44, 17, 1, 2000.00, 1000.00, 0.00, 20000.00, 10, 0.00, 2, 2, '2021-04-05 16:23:36', '2021-04-05 16:23:36'),
(45, 17, 2, 3000.00, 2000.00, 0.00, 30000.00, 10, 0.00, 2, 2, '2021-04-05 16:23:36', '2021-04-05 16:23:36'),
(46, 17, 3, 2500.00, 1200.00, 0.00, 24000.00, 10, 0.00, 2, 2, '2021-04-05 16:24:35', '2021-04-05 16:24:35'),
(47, 18, 1, 2100.00, 800.00, 100.00, 0.00, 0, 100.00, 2, 2, '2021-04-05 16:26:13', '2021-04-05 16:26:13'),
(48, 18, 2, 2900.00, 1700.00, 200.00, 0.00, 0, 300.00, 2, 2, '2021-04-05 16:26:13', '2021-04-05 16:26:13'),
(49, 19, 1, 200.00, 100.00, 0.00, 0.00, 0, 0.00, 2, 2, '2021-04-05 17:02:26', '2021-04-05 17:02:26'),
(50, 19, 2, 500.00, 300.00, 0.00, 0.00, 0, 0.00, 2, 2, '2021-04-05 17:02:26', '2021-04-05 17:02:26'),
(51, 20, 1, 200.00, 100.00, 0.00, 0.00, 0, 0.00, 1, 2, '2021-04-05 17:03:56', '2021-04-05 17:03:56'),
(52, 20, 2, 300.00, 50.00, 0.00, 0.00, 0, 0.00, 1, 2, '2021-04-05 17:03:56', '2021-04-05 17:03:56'),
(53, 20, 3, 200.00, 0.00, 0.00, 0.00, 0, 0.00, 1, 2, '2021-04-05 17:04:44', '2021-04-05 17:04:44'),
(54, 21, 1, 2100.00, 800.00, 100.00, 0.00, 0, 100.00, 2, 2, '2021-04-05 17:29:41', '2021-04-05 17:29:41'),
(55, 21, 2, 2900.00, 1700.00, 200.00, 0.00, 0, 300.00, 2, 2, '2021-04-05 17:29:41', '2021-04-05 17:29:41'),
(56, 22, 1, 200.00, 80.00, 0.00, 0.00, 0, 0.00, 1, 2, '2021-04-05 17:33:09', '2021-04-05 17:33:09'),
(57, 22, 2, 300.00, 100.00, 0.00, 0.00, 0, 0.00, 1, 2, '2021-04-05 17:33:09', '2021-04-05 17:33:09'),
(58, 22, 3, 100.00, 0.00, 0.00, 0.00, 0, 0.00, 1, 2, '2021-04-05 17:33:24', '2021-04-05 17:33:24'),
(59, 23, 1, 10000.00, 0.00, 0.00, 0.00, 0, 0.00, 2, 2, '2021-04-06 17:41:40', '2021-04-06 17:41:40'),
(60, 23, 2, 20000.00, 0.00, 0.00, 0.00, 0, 0.00, 2, 2, '2021-04-06 17:41:40', '2021-04-06 17:41:40'),
(61, 23, 3, 7000.00, 4000.00, 0.00, 0.00, 0, 0.00, 2, 2, '2021-04-06 17:43:52', '2021-04-06 17:43:52'),
(62, 24, 1, 3000.00, 1000.00, 0.00, 0.00, 0, 0.00, 2, 2, '2021-04-06 18:17:48', '2021-04-06 18:17:48'),
(63, 24, 2, 5000.00, 2000.00, 0.00, 0.00, 0, 0.00, 2, 2, '2021-04-06 18:17:48', '2021-04-06 18:17:48'),
(64, 25, 1, 200.00, 100.00, 0.00, 0.00, 0, 0.00, 2, 2, '2021-04-22 10:50:30', '2021-04-22 10:50:30'),
(65, 25, 2, 400.00, 200.00, 0.00, 0.00, 0, 0.00, 2, 2, '2021-04-22 10:50:30', '2021-04-22 10:50:30'),
(66, 26, 1, 400.00, 200.00, 0.00, 0.00, 0, 0.00, 2, 2, '2021-04-22 11:00:03', '2021-04-22 11:00:40'),
(67, 26, 2, 600.00, 300.00, 0.00, 0.00, 0, 0.00, 2, 2, '2021-04-22 11:00:03', '2021-04-22 11:00:29');

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
  `products_periods` int(11) NOT NULL,
  `products_rates` int(11) NOT NULL,
  `combine_agent` int(11) NOT NULL,
  `trash_deleted` int(11) NOT NULL DEFAULT 2,
  `date_create` datetime NOT NULL,
  `date_edit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rates_agent`
--

INSERT INTO `rates_agent` (`id`, `products_periods`, `products_rates`, `combine_agent`, `trash_deleted`, `date_create`, `date_edit`) VALUES
(2, 2, 6, 1, 2, '2021-03-11 16:50:16', '2021-03-11 16:50:16'),
(3, 2, 5, 3, 2, '2021-03-12 16:00:37', '2021-03-12 16:00:37'),
(5, 2, 7, 2, 2, '2021-03-12 16:01:47', '2021-03-12 16:01:47'),
(7, 3, 10, 2, 2, '2021-03-12 16:09:42', '2021-03-12 16:09:42'),
(8, 3, 10, 3, 2, '2021-03-12 16:10:00', '2021-03-12 16:10:00'),
(9, 4, 13, 1, 2, '2021-03-12 16:13:23', '2021-03-12 16:13:23'),
(10, 4, 13, 2, 2, '2021-03-12 16:13:23', '2021-03-12 16:13:23'),
(11, 4, 13, 3, 2, '2021-03-12 16:13:23', '2021-03-12 16:13:23'),
(12, 9, 24, 4, 2, '2021-03-31 10:46:11', '2021-03-31 10:46:11'),
(13, 9, 24, 5, 2, '2021-03-31 10:46:11', '2021-03-31 10:46:11'),
(14, 10, 27, 4, 2, '2021-03-31 10:48:26', '2021-03-31 10:48:26'),
(15, 10, 27, 5, 2, '2021-03-31 10:48:26', '2021-03-31 10:48:26'),
(16, 11, 30, 4, 2, '2021-03-31 11:38:00', '2021-03-31 11:38:00'),
(17, 11, 30, 5, 2, '2021-03-31 11:38:00', '2021-03-31 11:38:00'),
(18, 12, 33, 6, 2, '2021-03-31 12:06:13', '2021-03-31 12:06:13'),
(19, 13, 36, 6, 2, '2021-03-31 12:08:09', '2021-03-31 12:08:09'),
(20, 14, 39, 6, 2, '2021-03-31 12:10:06', '2021-03-31 12:10:06'),
(21, 17, 46, 4, 2, '2021-04-05 16:24:35', '2021-04-05 16:24:35'),
(22, 20, 53, 4, 2, '2021-04-05 17:04:44', '2021-04-05 17:04:44'),
(23, 20, 53, 5, 2, '2021-04-05 17:04:44', '2021-04-05 17:04:44'),
(24, 22, 58, 6, 2, '2021-04-05 17:33:24', '2021-04-05 17:33:24'),
(25, 23, 61, 6, 2, '2021-04-06 17:43:52', '2021-04-06 17:43:52');

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
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_history`
--
ALTER TABLE `booking_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_no`
--
ALTER TABLE `booking_no`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_payment`
--
ALTER TABLE `booking_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_products`
--
ALTER TABLE `booking_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `combine_agent`
--
ALTER TABLE `combine_agent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_aff`
--
ALTER TABLE `company_aff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_type`
--
ALTER TABLE `history_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_type`
--
ALTER TABLE `payment_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `place`
--
ALTER TABLE `place`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_allotment`
--
ALTER TABLE `products_allotment`
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
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `booking_history`
--
ALTER TABLE `booking_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_no`
--
ALTER TABLE `booking_no`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `booking_payment`
--
ALTER TABLE `booking_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_products`
--
ALTER TABLE `booking_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `combine_agent`
--
ALTER TABLE `combine_agent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `company_aff`
--
ALTER TABLE `company_aff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `history_type`
--
ALTER TABLE `history_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payment_type`
--
ALTER TABLE `payment_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `place`
--
ALTER TABLE `place`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `products_allotment`
--
ALTER TABLE `products_allotment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products_periods`
--
ALTER TABLE `products_periods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `products_rates`
--
ALTER TABLE `products_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `products_type`
--
ALTER TABLE `products_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rates_agent`
--
ALTER TABLE `rates_agent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
