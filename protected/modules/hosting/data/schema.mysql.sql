-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 16, 2011 at 09:25 AM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `project_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `hosting_domain`
--

CREATE TABLE IF NOT EXISTS `hosting_domain` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `domain` varchar(250) CHARACTER SET latin1 NOT NULL,
  `registered_date` datetime NOT NULL,
  `expires_date` datetime NOT NULL,
  `registered_with` varchar(250) CHARACTER SET latin1 NOT NULL,
  `contact_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;



--
-- Table structure for table `hosting_hosting`
--

CREATE TABLE IF NOT EXISTS `hosting_hosting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `domain_id` int(11) unsigned NOT NULL,
  `server` varchar(250) CHARACTER SET latin1 NOT NULL,
  `product` varchar(250) CHARACTER SET latin1 NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `expires_date` datetime NOT NULL,
  `start_date` datetime NOT NULL,
  `contact_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hosting_hosting`
--
ALTER TABLE `hosting_hosting`
  ADD CONSTRAINT `hosting_hosting_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `crm_contact` (`id`) ON UPDATE CASCADE;


--
-- Constraints for dumped tables
--

--
-- Constraints for table `hosting_domain`
--
ALTER TABLE `hosting_domain`
  ADD CONSTRAINT `hosting_domain_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `crm_contact` (`id`) ON UPDATE CASCADE;
