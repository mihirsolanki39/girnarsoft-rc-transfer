-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2022 at 11:43 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_db_dealer_crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `crm_rc_timeline`
--

CREATE TABLE `crm_rc_timeline` (
  `id` int(11) NOT NULL,
  `rc_id` int(11) NOT NULL,
  `activity` varchar(50) NOT NULL,
  `remark` varchar(50) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `crm_rc_timeline`
--

INSERT INTO `crm_rc_timeline` (`id`, `rc_id`, `activity`, `remark`, `status`, `created_by`, `created_on`) VALUES
(1, 1, 'Pending', 'Pending', '1', 1, '2019-10-22 13:37:36'),
(2, 1, 'In-Process (Test RTO Agent)', 'In-Process', '1', 1, '2019-11-12 12:37:40'),
(3, 14, 'Pending', 'Pending', '1', 1, '2019-12-27 15:46:05'),
(4, 18, 'Pending', 'Pending', '1', 63, '2020-01-28 12:38:18'),
(5, 19, 'Pending', 'Pending', '1', 1, '2020-01-30 13:23:31'),
(6, 20, 'Pending', 'Pending', '1', 1, '2020-01-30 13:23:34'),
(7, 23, 'Pending', 'Pending', '1', 1, '2020-02-27 15:21:06'),
(8, 24, 'Pending', 'Pending', '1', 1, '2020-02-27 15:21:09'),
(9, 21, 'In-Process (Test RTO Agent)', 'In-Process', '1', 1, '2020-02-27 20:01:07'),
(10, 21, 'Transferred', 'Transferred', '1', 1, '2020-02-27 20:01:44'),
(11, 26, 'Pending', 'Pending', '1', 1, '2020-08-12 13:04:03'),
(12, 27, 'Pending', 'Pending', '1', 1, '2020-08-12 18:24:12'),
(13, 28, 'Pending', 'Pending', '1', 1, '2020-11-02 17:54:09'),
(14, 29, 'Pending', 'Pending', '1', 1, '2020-11-02 17:54:11'),
(15, 30, 'Pending', 'Pending', '1', 1, '2020-11-03 18:13:43'),
(16, 31, 'Pending', 'Pending', '1', 1, '2020-11-03 18:13:45'),
(17, 31, 'In-Process (Test RTO Agent)', 'In-Process', '1', 1, '2020-11-04 12:33:58'),
(18, 31, 'Transferred', 'Transferred', '1', 1, '2020-11-04 12:36:28'),
(19, 26, 'Transferred', 'Transferred', '1', 1, '2020-11-05 16:43:47'),
(20, 32, 'Pending', 'Pending', '1', 1, '2021-06-15 16:37:24'),
(21, 33, 'Pending', 'Pending', '1', 1, '2021-06-15 16:38:26'),
(22, 34, 'Pending', 'Pending', '1', 1, '2021-06-15 16:38:27'),
(23, 35, 'Pending', 'Pending', '1', 1, '2021-06-15 16:39:29'),
(24, 36, 'Pending', 'Pending', '1', 1, '2021-06-15 16:39:30'),
(25, 37, 'Pending', 'Pending', '1', 1, '2021-06-15 16:40:32'),
(26, 38, 'Pending', 'Pending', '1', 1, '2021-06-15 16:40:33'),
(27, 39, 'Pending', 'Pending', '1', 1, '2021-06-15 16:41:35'),
(28, 40, 'Pending', 'Pending', '1', 1, '2021-06-15 16:41:36'),
(29, 41, 'Pending', 'Pending', '1', 1, '2021-06-15 16:42:38'),
(30, 42, 'Pending', 'Pending', '1', 1, '2021-06-15 16:42:39'),
(31, 43, 'Pending', 'Pending', '1', 1, '2021-06-15 16:43:41'),
(32, 44, 'Pending', 'Pending', '1', 1, '2021-06-15 16:43:43'),
(33, 45, 'Pending', 'Pending', '1', 1, '2021-06-15 16:44:46'),
(34, 46, 'Pending', 'Pending', '1', 1, '2021-06-15 16:44:47'),
(35, 47, 'Pending', 'Pending', '1', 1, '2021-06-15 16:45:49'),
(36, 46, 'In-Process (Test RTO Agent)', 'In-Process', '1', 1, '2021-11-30 16:36:47'),
(37, 47, 'In-Process (Test RTO Agent)', 'In-Process', '1', 1, '2021-12-20 13:11:07'),
(38, 36, 'In-Process (Test RTO Agent)', 'In-Process', '1', 1, '2021-12-20 16:41:30'),
(39, 45, 'In-Process (Test RTO Agent)', 'In-Process', '1', 67, '2021-12-21 12:08:35'),
(40, 36, 'Transferred', 'Transferred', '1', 67, '2021-12-21 12:27:33'),
(41, 45, 'Transferred', 'Transferred', '1', 67, '2021-12-21 14:47:36'),
(42, 44, 'Transferred', 'Transferred', '1', 1, '2021-12-22 11:19:30'),
(43, 43, 'Transferred', 'Transferred', '1', 67, '2021-12-24 11:00:28'),
(44, 42, 'In-Process ', 'In-Process', '1', 1, '2021-12-24 14:36:22'),
(45, 39, 'In-Process (Test RTO Agent)', 'In-Process', '1', 67, '2021-12-28 12:49:23'),
(46, 41, 'In-Process (Test RTO Agent)', 'In-Process', '1', 1, '2021-12-29 13:31:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crm_rc_timeline`
--
ALTER TABLE `crm_rc_timeline`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crm_rc_timeline`
--
ALTER TABLE `crm_rc_timeline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
