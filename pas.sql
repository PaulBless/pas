-- PHP version: 7.2

-- Database Script for Building Permit Application System
-- Script Written by: Paul Eshun (Web & Software Developer)
-- Date Written: October 2020


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- Database Name: `pas`
-- ----------------------------------

-- Admin Table
-- ---------------------
CREATE TABLE `admin_account` (
  `adminid` int(11) NOT NULL AUTO_INCREMENT,
    `fullname` varchar(350) NOT NULL,
    `mobileno` varchar(10) NOT NULL,
  `email` varchar(350) NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `activity` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `regdate` timestamp NOT NULL default current_timestamp,
  PRIMARY KEY (`adminid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Employee/users table structure
-- ------------------------------
CREATE TABLE `users_account` (
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
  `regdate` date NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- System users table structure
-- ------------------------------
CREATE TABLE `system_users` (
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
CREATE TABLE `departments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(100) NOT NULL,
    `comments` varchar(500) NULL,
  `dateadded` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- checklist table structure
-- ------------------------------
CREATE TABLE `check_list` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `check_name` varchar(100) NOT NULL,
    `comments` varchar(500) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- landuse table structure
-- ------------------------------
CREATE TABLE `landuse` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `land_use` varchar(50) NOT NULL,
  `comments` varchar(500) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Locality table structure
-- ------------------------------
CREATE TABLE `locality` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `loc_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Table structure for table `settings`
-- -----------------------
CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `dist_name` varchar(500) NOT NULL,
  `dist_town` varchar(255) DEFAULT NULL,
  `dist_address` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  `logo` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- table structure for tasks
-- --------------------------
CREATE  TABLE `tasks` (
`taskid` INT(11) NOT NULL AUTO_INCREMENT,
`task_name` VARCHAR(500) NOT NULL,
`task_doer` VARCHAR(50) NOT NULL,
`task_state` VARCHAR(50) NOT NULL,
`task_date` DATE NOT NULL,
PRIMARY KEY (`taskid`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;

-- table structure for designation
-- ---------------------------------
CREATE  TABLE `designation`(
`id` INT(10) NOT NULL AUTO_INCREMENT,
`desg_name` VARCHAR(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;


-- table structure for permits
-- ------------------------------
CREATE  TABLE `permits`(
`permitid` INT(11) NOT NULL AUTO_INCREMENT,
`application_id` INT(11) NOT NULL,
`permit_number` VARCHAR(50) NOT NULL,
`assignedby` VARCHAR(255) NOT NULL,
PRIMARY KEY(`permitid`)
)
ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------
-- Table structure for table `applications`
-- -----------------------------
CREATE TABLE `applications` (
  `applicationid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `phoneno` varchar(10) NOT NULL,
  `town` varchar(50) NOT NULL,
  `occupation` varchar(50) NOT NULL,
  `contactname` varchar(255) NOT NULL,
  `contactnumber` varchar(10) NOT NULL,
  `location` varchar(50) NOT NULL, -- locationId as foreign_key
  `project_type` text NOT NULL,
  `datecreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `application_no` varchar(50) NOT NULL,
  `createdby` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `landuse_id` int(11) NOT NULL, 	-- landuseId as foreign_key
  `category_id` int(11) NOT NULL,	-- application_categoryId as foreign key
	PRIMARY KEY (`applicationid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='stores records of building applications';

-- table structure for user activities
-- ------------------------------------
CREATE  TABLE `user_activities`(
`id` INT(11) NOT NULL AUTO_INCREMENT,
`activity` VARCHAR(1000) NOT NULL,
`date_created` DATE NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


-- Table structure for table `approval`
-- -----------------------
CREATE TABLE `approval`(
  `id` int(10) NOT NULL,
  `appID` int(11) NOT NULL,
  `reason` varchar(500) DEFAULT NULL,
  `dateEncode` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `app_processes`
-- ------------------------------------------------
CREATE TABLE `app_processes` (
  `id` int(10) NOT NULL,
  `app_id` int(11) NOT NULL,
  `check_id` int(11) NOT NULL,
  `dateEncode` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `filename` blob,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT 'stores records of building application that have been processed for review by committee';

-- Table structure for table `app_types`
-- ---------------------------------------
CREATE TABLE `app_types` (
  `id` int(10) NOT NULL,
  `type_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT 'stores info about the types of application';

-- Table structure for table `defer`
-- ------------------------------------
CREATE TABLE `defer` (
  `id` int(11) NOT NULL,
  `appID` int(11) NOT NULL,
  `reason` varchar(500) DEFAULT NULL,
  `dateDefer` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `state` int(11) NOT NULL,
  `dateReview` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `holding`
-- ------------------------
CREATE TABLE `holding` (
  `id` int(11) NOT NULL,
  `appID` int(11) NOT NULL,
  `reason` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT 'store details of applications that are put on hold/pending';

-- Table structure for table `inspections`
-- ----------------------------------------
CREATE TABLE `inspections` (
  `id` int(11) NOT NULL,
  `applicationID` int(11) NOT NULL,
  `inspID` varchar(255) DEFAULT NULL,
  `remarks` varchar(2500) DEFAULT NULL,
  `inspDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT 'site inspections records are stored in this table';


-- Table structure for table `permits application received`
-- --------------------------------------------------------
CREATE TABLE `app_received` (
  `id` int(10) NOT NULL,
  `app_id` int(11) NOT NULL,
  `givenby` int(11) DEFAULT NULL,
  `rec_name` varchar(255) NOT NULL,
  `rec_number` varchar(10) DEFAULT NULL,
  `dateReceived` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT 'stores information about permits applications that have been handed over to clients';

-- Table structure for table `userlogs`
-- --------------------------------------
CREATE TABLE `userlogs` (
  `id` int(10) NOT NULL,
  `userId` int(11) NOT NULL,
  `login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logout` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT 'save records of all users login and logout details {time & date}';

-- Table structure for table `userlog`
-- ---------------------------------------
CREATE TABLE `userlog` (
  `userId` int(11) NOT NULL,
  `login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logout` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT 'records of all login and logout details';

-- Table structure for table `user_activities`
-- ---------------------------------------------
CREATE TABLE `user_activities` (
  `id` int(11) NOT NULL,
  `activity` varchar(1000) NOT NULL,
  `date_created` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT 'all system activities executed by the users';


-- =========  ALTER TABLE CONSTRAINTS
-- ========= SET & INDICATE PRIMARY & FOREIGN KEYS
-- --------------------------------------------------
-- Constraints for table `application_processes` | `app_procesess`
-- ------------------------------------------------------------------
ALTER TABLE `app_processes`
  ADD CONSTRAINT `app_processes_fk_appid` FOREIGN KEY (`app_id`) REFERENCES `applications` (`applicationid`) ON DELETE CASCADE,
  ADD CONSTRAINT `app_processes_fk_checkid` FOREIGN KEY (`check_id`) REFERENCES `check_list` (`id`) ON DELETE CASCADE;


-- Constraints for table `applications`
-- ------------------------------------------------------------------
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_fk_locality` FOREIGN KEY (`location`) REFERENCES `locality` (`id`) ON DELETE CASCADE, -- 1st: location_ID
  ADD CONSTRAINT `applications_fk_landuse` FOREIGN KEY (`landuse_id`) REFERENCES `landuse` (`id`) ON DELETE CASCADE, -- 2nd: landuse_ID
  ADD CONSTRAINT `applications_fk_category` FOREIGN KEY (`category_id`) REFERENCES `app_types` (`id`) ON DELETE CASCADE; -- 3rd: category_ID


-- Constraints for table `defer`
-- --------------------------------------





-- Constraints for table `approval`
-- -----------------------------------

