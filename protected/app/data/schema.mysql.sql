CREATE TABLE tbl_user (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(128) NOT NULL,
    password VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL
);

INSERT INTO tbl_user (username, password, email) VALUES ('test1', 'pass1', 'test1@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test2', 'pass2', 'test2@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test3', 'pass3', 'test3@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test4', 'pass4', 'test4@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test5', 'pass5', 'test5@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test6', 'pass6', 'test6@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test7', 'pass7', 'test7@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test8', 'pass8', 'test8@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test9', 'pass9', 'test9@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test10', 'pass10', 'test10@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test11', 'pass11', 'test11@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test12', 'pass12', 'test12@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test13', 'pass13', 'test13@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test14', 'pass14', 'test14@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test15', 'pass15', 'test15@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test16', 'pass16', 'test16@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test17', 'pass17', 'test17@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test18', 'pass18', 'test18example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test19', 'pass19', 'test19example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test20', 'pass20', 'test20@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test21', 'pass21', 'test21@example.com');

-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 19, 2011 at 02:00 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `projects_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `nii_crm__address`
--

CREATE TABLE IF NOT EXISTS `nii_crm__address` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lines` text NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `country_id` varchar(10) NOT NULL,
  `city` varchar(250) NOT NULL,
  `county` varchar(250) NOT NULL,
  `label` varchar(250) NOT NULL,
  `verified` enum('0','1') NOT NULL,
  `contact_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `nii_crm__contact`
--

CREATE TABLE IF NOT EXISTS `nii_crm__contact` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `company` varchar(250) NOT NULL,
  `company_id` int(11) unsigned NOT NULL,
  `type` enum('CONTACT','COMPANY') NOT NULL DEFAULT 'CONTACT',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `nii_crm__email`
--

CREATE TABLE IF NOT EXISTS `nii_crm__email` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) unsigned NOT NULL,
  `address` varchar(250) NOT NULL,
  `label` varchar(250) NOT NULL,
  `verified` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`),
  KEY `address` (`address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `nii_crm__phone`
--

CREATE TABLE IF NOT EXISTS `nii_crm__phone` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(250) NOT NULL,
  `label` varchar(250) NOT NULL,
  `contact_id` int(11) unsigned NOT NULL,
  `verified` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `nii_crm__website`
--

CREATE TABLE IF NOT EXISTS `nii_crm__website` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(250) NOT NULL,
  `label` varchar(250) NOT NULL,
  `contact_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nii_crm__address`
--
ALTER TABLE `nii_crm__address`
  ADD CONSTRAINT `nii_crm__address_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `nii_crm__contact` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `nii_crm__email`
--
ALTER TABLE `nii_crm__email`
  ADD CONSTRAINT `nii_crm__email_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `nii_crm__contact` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `nii_crm__phone`
--
ALTER TABLE `nii_crm__phone`
  ADD CONSTRAINT `nii_crm__phone_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `nii_crm__contact` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `nii_crm__website`
--
ALTER TABLE `nii_crm__website`
  ADD CONSTRAINT `nii_crm__website_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `nii_crm__contact` (`id`) ON UPDATE CASCADE;
