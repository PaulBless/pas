-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2021 at 02:51 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Create Database
CREATE DATABASE IF NOT EXISTS `pas` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

-- select database
USE `pas`;

-- --------------------------------------------------------

--
-- Table structure for table `admin_account`
--

CREATE TABLE `admin_account` (
  `adminid` int(11) NOT NULL,
  `fullname` varchar(350) NOT NULL,
  `mobileno` varchar(10) NOT NULL,
  `email` varchar(350) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `activity` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `regdate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_account`
--

INSERT INTO `admin_account` (`adminid`, `fullname`, `mobileno`, `email`, `username`, `password`, `activity`, `status`, `regdate`) VALUES
(41, 'Jecmas Ghana', '0555428455', 'jecmasghana@gmail.com', 'jecmas', '$2y$10$/Lo.Ktx9y4qhgj1YRi6t7eT4UFduYOpLJjFXCv9W7zjj3nHAuiRmC', '', 'Active', '2021-02-05 12:43:03'),
(45, 'sys admin', '0320201000', 'sysadmin@eps.org', 'sysadm', '$2y$10$s1F59Dkg44v4iZBPAWgeqeOLKYQxEdXWnDEAlHh3JH9QAoICXIfkO', '', 'Inactive', '2021-02-05 12:44:22');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `applicationid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `phoneno` varchar(10) NOT NULL,
  `town` varchar(50) NOT NULL,
  `occupation` varchar(50) NOT NULL,
  `contactname` varchar(255) NOT NULL,
  `contactnumber` varchar(10) NOT NULL,
  `location` varchar(50) NOT NULL,
  `project_type` text NOT NULL,
  `datecreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `application_no` varchar(50) NOT NULL,
  `createdby` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `landuse_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='stores records of building applications';

-- --------------------------------------------------------

--
-- Table structure for table `approval`
--

CREATE TABLE `approval` (
  `id` int(10) NOT NULL,
  `appID` int(11) NOT NULL,
  `reason` varchar(500) DEFAULT NULL,
  `dateEncode` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_processes`
--

CREATE TABLE `app_processes` (
  `id` int(10) NOT NULL,
  `app_id` int(11) NOT NULL,
  `check_id` int(11) NOT NULL,
  `dateEncode` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `filename` blob
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_received`
--

CREATE TABLE `app_received` (
  `id` int(10) NOT NULL,
  `app_id` int(11) NOT NULL,
  `givenby` int(11) DEFAULT NULL,
  `rec_name` varchar(255) NOT NULL,
  `rec_number` varchar(10) DEFAULT NULL,
  `dateReceived` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_types`
--

CREATE TABLE `app_types` (
  `id` int(10) NOT NULL,
  `type_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `check_list`
--

CREATE TABLE `check_list` (
  `id` int(10) NOT NULL,
  `check_name` varchar(100) NOT NULL,
  `comments` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `defer`
--

CREATE TABLE `defer` (
  `id` int(11) NOT NULL,
  `appID` int(11) NOT NULL,
  `reason` varchar(500) DEFAULT NULL,
  `dateDefer` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `state` int(11) NOT NULL,
  `dateReview` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(10) NOT NULL,
  `dept_name` varchar(100) NOT NULL,
  `comments` varchar(500) DEFAULT NULL,
  `dateadded` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `id` int(10) NOT NULL,
  `desg_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `holding`
--

CREATE TABLE `holding` (
  `id` int(11) NOT NULL,
  `appID` int(11) NOT NULL,
  `reason` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inspections`
--

CREATE TABLE `inspections` (
  `id` int(11) NOT NULL,
  `applicationID` int(11) NOT NULL,
  `inspID` varchar(255) DEFAULT NULL,
  `remarks` varchar(2500) DEFAULT NULL,
  `inspDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `landuse`
--

CREATE TABLE `landuse` (
  `id` int(10) NOT NULL,
  `land_use` varchar(50) NOT NULL,
  `comments` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `landuse`
--

INSERT INTO `landuse` (`id`, `land_use`, `comments`) VALUES
(2, 'Commercial', 'Category of and being use for commercial activities such as market'),
(3, 'Educational', 'Category of land used for educational purposes such as school infrastructure, library, '),
(4, 'Civic & Culture ', 'Land use for cultural and social activities such as culture center, police station, etc.'),
(6, 'Residential', 'The category specifies land being used for housing or settlement purposes.');

-- --------------------------------------------------------

--
-- Table structure for table `locality`
--

CREATE TABLE `locality` (
  `id` int(10) NOT NULL,
  `loc_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permits`
--

CREATE TABLE `permits` (
  `permitid` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `permit_number` varchar(255) NOT NULL,
  `dateAssigned` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `assignedby` int(11) NOT NULL,
  `townsheet` varchar(255) NOT NULL,
  `zoning` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `dist_name` varchar(500) NOT NULL,
  `dist_town` varchar(255) DEFAULT NULL,
  `dist_address` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  `logo` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `dist_name`, `dist_town`, `dist_address`, `description`, `logo`) VALUES
(1, 'Upper West Akim District Assembly', 'Adeiso', 'Tiokrom, Off Asamankese Nsawam Road', 'Physical Planning Department', '');

-- --------------------------------------------------------

--
-- Table structure for table `system_users`
--

CREATE TABLE `system_users` (
  `userid` int(11) NOT NULL,
  `fullname` varchar(500) NOT NULL,
  `mobileno` varchar(50) NOT NULL,
  `email` varchar(350) DEFAULT NULL,
  `department` varchar(50) NOT NULL,
  `jobholder` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `regdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `first_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `taskid` int(11) NOT NULL,
  `task_name` varchar(500) NOT NULL,
  `task_doer` varchar(50) NOT NULL,
  `task_state` varchar(50) NOT NULL,
  `task_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE `userlog` (
  `userId` int(11) NOT NULL,
  `login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logout` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userlogs`
--

CREATE TABLE `userlogs` (
  `id` int(10) NOT NULL,
  `userId` int(11) NOT NULL,
  `login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logout` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users_account`
--

CREATE TABLE `users_account` (
  `userid` int(11) NOT NULL,
  `fullname` varchar(500) NOT NULL,
  `mobileno` varchar(50) NOT NULL,
  `email` varchar(350) DEFAULT NULL,
  `department_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `activity` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `regdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_activities`
--

CREATE TABLE `user_activities` (
  `id` int(11) NOT NULL,
  `activity` varchar(1000) NOT NULL,
  `date_created` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_account`
--
ALTER TABLE `admin_account`
  ADD PRIMARY KEY (`adminid`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`applicationid`);

--
-- Indexes for table `approval`
--
ALTER TABLE `approval`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_processes`
--
ALTER TABLE `app_processes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_received`
--
ALTER TABLE `app_received`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_types`
--
ALTER TABLE `app_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `check_list`
--
ALTER TABLE `check_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `defer`
--
ALTER TABLE `defer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holding`
--
ALTER TABLE `holding`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inspections`
--
ALTER TABLE `inspections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `landuse`
--
ALTER TABLE `landuse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locality`
--
ALTER TABLE `locality`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permits`
--
ALTER TABLE `permits`
  ADD PRIMARY KEY (`permitid`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_users`
--
ALTER TABLE `system_users`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`taskid`);

--
-- Indexes for table `userlogs`
--
ALTER TABLE `userlogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_account`
--
ALTER TABLE `users_account`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `user_activities`
--
ALTER TABLE `user_activities`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_account`
--
ALTER TABLE `admin_account`
  MODIFY `adminid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `applicationid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `approval`
--
ALTER TABLE `approval`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_processes`
--
ALTER TABLE `app_processes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_received`
--
ALTER TABLE `app_received`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_types`
--
ALTER TABLE `app_types`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `check_list`
--
ALTER TABLE `check_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `defer`
--
ALTER TABLE `defer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holding`
--
ALTER TABLE `holding`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inspections`
--
ALTER TABLE `inspections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `landuse`
--
ALTER TABLE `landuse`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `locality`
--
ALTER TABLE `locality`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permits`
--
ALTER TABLE `permits`
  MODIFY `permitid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_users`
--
ALTER TABLE `system_users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `taskid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userlogs`
--
ALTER TABLE `userlogs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_account`
--
ALTER TABLE `users_account`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_activities`
--
ALTER TABLE `user_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
