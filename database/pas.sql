-- PHP version: 7.2

-- Database Script for Building Permit Application System
-- Script Written by: Paul Eshun (Web & Software Developer)
-- Date Written: October 2020


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
-- SET default_timezone;

-- Database Name: `pas`
-- ----------------------------------

-- Create Database
CREATE DATABASE IF NOT EXISTS `pas` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

-- select database
USE `pas`;


-- Admin Table
-- ---------------------
CREATE TABLE IF NOT EXISTS `admin_account` (
  `adminid` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(350) NOT NULL,
  `mobileno` varchar(10) NOT NULL,
  `email` varchar(350) NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `activity` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `regdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`adminid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Employee/users table structure
-- ------------------------------
CREATE TABLE IF NOT EXISTS `users_account` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(500) NOT NULL,
	`mobileno` varchar(50) NOT NULL,
  `email` varchar(350) NULL,
  `department_name` VARCHAR(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `activity` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `regdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- System users table structure
-- ------------------------------
CREATE TABLE IF NOT EXISTS `system_users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(500) NOT NULL,
	`mobileno` varchar(50) NOT NULL,
  `email` varchar(350) NULL,
  `department` VARCHAR(50) NOT NULL,
  `jobholder` VARCHAR(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `regdate` timestamp NOT NULL,
  `first_login` datetime NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;


-- Departments table structure
-- ------------------------------
CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(100) NOT NULL,
  `comments` varchar(500) NULL,
  `dateadded` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- checklist table structure
-- ------------------------------
CREATE TABLE IF NOT EXISTS `check_list` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `check_name` varchar(100) NOT NULL,
  `comments` varchar(500) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- landuse table structure
-- ------------------------------
CREATE TABLE IF NOT EXISTS `landuse` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `land_use` varchar(50) NOT NULL,
  `comments` varchar(500) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Locality table structure
-- ------------------------------
CREATE TABLE IF NOT EXISTS `locality` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `loc_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Table structure for table `settings`
-- -----------------------
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dist_name` varchar(500) NOT NULL,
  `dist_town` varchar(255) DEFAULT NULL,
  `dist_address` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  `logo` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- table structure for tasks
-- --------------------------
CREATE TABLE IF NOT EXISTS `tasks` (
  `taskid` INT(11) NOT NULL AUTO_INCREMENT,
  `task_name` VARCHAR(500) NOT NULL,
  `task_doer` VARCHAR(50) NOT NULL,
  `task_state` VARCHAR(50) NOT NULL,
  `task_date` DATE NOT NULL,
  PRIMARY KEY (`taskid`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;

-- table structure for designation
-- ---------------------------------
CREATE TABLE IF NOT EXISTS `designation`(
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `desg_name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;


-- table structure for permits
-- ------------------------------
CREATE TABLE IF NOT EXISTS `permits`(
  `permitid` INT(11) NOT NULL AUTO_INCREMENT,
  `application_id` INT(11) NOT NULL,
  `permit_number` VARCHAR(255) NOT NULL,
  `dateAssigned` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `assignedby` int(11) NOT NULL,
  `townsheet` varchar(255) NOT NULL,
  `zoning` varchar(50) NOT NULL,
  PRIMARY KEY(`permitid`)
)
ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;


-- --------------------------------
-- Table structure for table `applications`
-- -----------------------------
CREATE TABLE IF NOT EXISTS `applications` (
  `applicationid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `phoneno` varchar(10) NOT NULL,
  `town` varchar(50) NOT NULL,
  `occupation` varchar(50) NOT NULL,
  `contactname` varchar(255) NOT NULL,
  `contactnumber` varchar(10) NOT NULL,
  `location` int(11) NOT NULL, -- locationId as foreign_key
  `project_type` text NOT NULL,
  `datecreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `application_no` varchar(50) NOT NULL,
  `createdby` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `landuse_id` int(11) NOT NULL, 	-- landuseId as foreign_key
  `category_id` int(11) NOT NULL,	-- application_categoryId as foreign key
	PRIMARY KEY (`applicationid`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COMMENT='stores records of building applications';

-- table structure for user activities
-- ------------------------------------
CREATE TABLE IF NOT EXISTS `user_activities`(
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `activity` VARCHAR(1000) NOT NULL,
  `date_created` DATE NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;


-- Table structure for table `approval`
-- -----------------------
CREATE TABLE IF NOT EXISTS `approval`(
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `appID` int(11) NOT NULL,
  `reason` varchar(500) NOT NULL,
  `dateEncode` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, 
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Table structure for table `app_processes`
-- ------------------------------------------------
CREATE TABLE IF NOT EXISTS `app_processes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `app_id` int(11) NOT NULL,
  `check_id` int(11) NOT NULL,
  `dateEncode` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `filename` blob,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COMMENT 'stores records of building application that have been processed for review by committee';

-- Table structure for table `app_types`
-- ---------------------------------------
CREATE TABLE IF NOT EXISTS `app_types` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(50) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COMMENT 'stores info about the types of application';

-- Table structure for table `defer`
-- ------------------------------------
CREATE TABLE IF NOT EXISTS `defer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appID` int(11) NOT NULL,
  `reason` varchar(500) DEFAULT NULL,
  `dateDefer` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `state` int(11) NOT NULL,
  `dateReview` date NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Table structure for table `holding`
-- ------------------------
CREATE TABLE IF NOT EXISTS `holding` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appID` int(11) NOT NULL,
  `reason` varchar(500) DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COMMENT 'store details of applications that are put on hold/pending';

-- Table structure for table `inspections`
-- ----------------------------------------
CREATE TABLE IF NOT EXISTS `inspections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicationID` int(11) NOT NULL,
  `inspID` varchar(255) DEFAULT NULL,
  `remarks` varchar(2500) DEFAULT NULL,
  `inspDate` date NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COMMENT 'site inspections records are stored in this table';


-- Table structure for table `permits application received`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `app_received` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `app_id` int(11) NOT NULL,
  `givenby` int(11) DEFAULT NULL,
  `rec_name` varchar(255) NOT NULL,
  `rec_number` varchar(10) DEFAULT NULL,
  `dateReceived` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COMMENT 'stores information about permits applications that have been handed over to clients';

-- Table structure for table `userlogs`
-- --------------------------------------
CREATE TABLE IF NOT EXISTS `userlogs` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logout` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COMMENT 'save records of all users login and logout details {time & date}';

-- Table structure for table `userlog`
-- ---------------------------------------
CREATE TABLE IF NOT EXISTS `userlog` (
  `userId` int(11) NOT NULL,
  `login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logout` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT 'records of all login and logout details';

-- Table structure for table `user_activities`
-- ---------------------------------------------
CREATE TABLE IF NOT EXISTS `user_activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity` varchar(1000) NOT NULL,
  `date_created` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COMMENT 'all system activities executed by the users';

-- === END TABLE CREATION HERE ===
-- =============================================


-- =========  ALTER TABLE CONSTRAINTS
-- ========= SET & INDICATE PRIMARY & FOREIGN KEYS
-- --------------------------------------------------
-- Constraints for table `application_processes` | `app_procesess`
-- ------------------------------------------------------------------
-- ALTER TABLE `app_processes`
 -- ADD CONSTRAINT `app_processes_fk_application_identity` FOREIGN KEY (`app_id`) REFERENCES `applications` (`applicationid`) ON DELETE CASCADE,
  -- ADD CONSTRAINT `app_processes_fk_checkid` FOREIGN KEY (`check_id`) REFERENCES `check_list` (`id`) ON DELETE CASCADE;


-- Constraints for table `applications`
-- ------------------------------------------------------------------
-- ALTER TABLE `applications`
  -- ADD CONSTRAINT `applications_fk_locality` FOREIGN KEY (`location`) REFERENCES `locality` (`id`) ON DELETE CASCADE, -- 1st: location_ID
 -- ADD CONSTRAINT `applications_fk_landuse` FOREIGN KEY (`landuse_id`) REFERENCES `landuse` (`id`) ON DELETE CASCADE, -- 2nd: landuse_ID
 -- ADD CONSTRAINT `applications_fk_category` FOREIGN KEY (`category_id`) REFERENCES `app_types` (`id`) ON DELETE CASCADE; -- 3rd: category_ID


-- Constraints for table `defer`
-- --------------------------------------
-- ALTER TABLE `defer`
  -- ADD CONSTRAINT `defer_fk_app_identity` FOREIGN KEY (`appID`) REFERENCES `applications` (`applicationid`) ON DELETE CASCADE,


-- Constraints for table `holding`
-- --------------------------------------
-- ALTER TABLE `holding`
 -- ADD CONSTRAINT `holding_fk_application_no` FOREIGN KEY (`appID`) REFERENCES `applications` (`applicationid`) ON DELETE CASCADE,


-- Constraints for table `approval`
-- --------------------------------------
-- ALTER TABLE `approval`
 -- ADD CONSTRAINT `approval_fk_application` FOREIGN KEY (`appID`) REFERENCES `applications` (`applicationid`) ON DELETE CASCADE,


-- Constraints for table `permits`
-- -----------------------------------
-- ALTER TABLE `permits`
 -- ADD CONSTRAINT `permits_fk_applicationidentity` FOREIGN KEY (`application_id`) REFERENCES `applications` (`applicationid`) ON DELETE CASCADE,


-- Constraints for table `userlogs`
-- ------------------------------------
-- ALTER TABLE `userlogs`
  -- ADD CONSTRAINT `userlogs_fk_userId` FOREIGN KEY (`userId`) REFERENCES `admin_account` (`adminid`) ON DELETE CASCADE;

-- Constraints for `userlog`
-- ----------------------------
-- ALTER TABLE `userlog`
  -- ADD CONSTRAINT `userlog_fk_userId` FOREIGN KEY (`userId`) REFERENCES `users_account` (`userid`) ON DELETE CASCADE,

-- Constraints for `inspections`
-- ----------------------------------
-- ALTER Table `inspections` 
 -- ADD CONSTRAINT `inspections_fk_applicationID` FOREIGN KEY ('applicationID') REFERENCES `applications` ('applicationid') ON DELETE CASCADE,

-- === END TABLE CONSTRAINTS === ---
-- ========================================


 -- === DUMP DATA INTO TABLES
-- BEGIN INSERT RECORDS HERE
-- ===============================================

-- add records to admin_account table
INSERT INTO `admin_account` (`adminid`, `fullname`, `mobileno`, `email`, `username`, `password`, `activity`, `status`, `regdate`) VALUES
('Jecmas Ghana', '0555428455', 'jecmasghana@gmail.com', 'jecmas', '$2y$10$/Lo.Ktx9y4qhgj1YRi6t7eT4UFduYOpLJjFXCv9W7zjj3nHAuiRmC', '', 'Active', '2021-02-05 12:43:03'),
('System Admin', '0320201000', 'sysadmin@eps.org', 'sysadm', '$2y$10$s1F59Dkg44v4iZBPAWgeqeOLKYQxEdXWnDEAlHh3JH9QAoICXIfkO', '', 'Inactive', '2021-02-05 12:44:22');

-- add records to landuse table
INSERT INTO `landuse` ( `land_use`, `comments`) VALUES
('Commercial', 'Category of and being use for commercial activities such as market'),
('Educational', 'Category of land used for educational purposes such as school infrastructure, library, '),
('Civic & Culture ', 'Land use for cultural and social activities such as culture center, police station, etc.'),
('Residential', 'The category specifies land being used for housing or settlement purposes.');

-- add record to settings table
INSERT INTO `settings` (`id`, `dist_name`, `dist_town`, `dist_address`, `description`, `logo`) VALUES
(NULL, 'Upper West Akim District Assembly', 'Adeiso', 'Tiokrom, Off Asamankese Nsawam Road', 'Physical Planning Department', '');

-- add record to application category
INSERT INTO `app_types` (`type_name`) VALUES 
('Organization'), ('Individual'), ('Business'), ('Religious Body');

-- === END INSERT RECORDS HERE
-- ================================================









  