-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2022 at 06:50 AM
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
-- Table structure for table `crm_upload_docs_loan`
--

CREATE TABLE `crm_upload_docs_loan` (
  `id` int(11) NOT NULL,
  `doc_name` varchar(50) NOT NULL,
  `doc_url_old` text NOT NULL,
  `doc_url` text NOT NULL,
  `sent_to_aws` enum('0','1') NOT NULL DEFAULT '0',
  `doc_type` int(11) NOT NULL DEFAULT 0 COMMENT '0,1,2=loan 3=insurance 4=rc',
  `customer_id` int(20) NOT NULL,
  `case_id` int(20) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `crm_upload_docs_loan`
--

INSERT INTO `crm_upload_docs_loan` (`id`, `doc_name`, `doc_url_old`, `doc_url`, `sent_to_aws`, `doc_type`, `customer_id`, `case_id`, `status`, `created_by`, `updated_by`, `created_on`, `updated_on`) VALUES
(1, '944907ff8958c154afc68f2fdb76de3f.jpg', '', 'upload_rc_doc/944907ff8958c154afc68f2fdb76de3f.jpg', '0', 4, 45608, 39, '1', 0, 0, '0000-00-00 00:00:00', '2021-12-28 12:49:32'),
(2, '4aa7fd32eb9a03ed97c17f67e3416376.jpg', '', 'upload_rc_doc/4aa7fd32eb9a03ed97c17f67e3416376.jpg', '0', 4, 45608, 41, '1', 0, 0, '0000-00-00 00:00:00', '2021-12-29 13:31:51'),
(3, 'cf233865a6e386fd907b953e09c23fc1.jpg', '', 'upload_rc_doc/cf233865a6e386fd907b953e09c23fc1.jpg', '0', 4, 45608, 41, '1', 0, 0, '0000-00-00 00:00:00', '2021-12-29 13:31:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crm_upload_docs_loan`
--
ALTER TABLE `crm_upload_docs_loan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crm_upload_docs_loan`
--
ALTER TABLE `crm_upload_docs_loan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
