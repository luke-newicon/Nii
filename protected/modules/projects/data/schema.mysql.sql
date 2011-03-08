-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 08, 2011 at 03:45 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `project_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_address`
--

CREATE TABLE IF NOT EXISTS `crm_address` (
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
-- Table structure for table `crm_contact`
--

CREATE TABLE IF NOT EXISTS `crm_contact` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `company` varchar(250) NOT NULL,
  `company_id` int(11) unsigned NOT NULL,
  `type` enum('CONTACT','COMPANY','USER') NOT NULL DEFAULT 'CONTACT',
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=98 ;

-- --------------------------------------------------------

--
-- Table structure for table `crm_email`
--

CREATE TABLE IF NOT EXISTS `crm_email` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) unsigned NOT NULL,
  `address` varchar(250) NOT NULL,
  `label` varchar(250) NOT NULL,
  `verified` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`),
  KEY `address` (`address`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `crm_phone`
--

CREATE TABLE IF NOT EXISTS `crm_phone` (
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
-- Table structure for table `crm_website`
--

CREATE TABLE IF NOT EXISTS `crm_website` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(250) NOT NULL,
  `label` varchar(250) NOT NULL,
  `contact_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `projects_issue`
--

CREATE TABLE IF NOT EXISTS `projects_issue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('TYPE_ISSUE','TYPE_BUG','TYPE_FEATURE','TYPE_MOD','TYPE_ACTION') DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text,
  `status` enum('STATUS_NOT_STARTED','STATUS_STARTED','STATUS_FINISHED') DEFAULT 'STATUS_NOT_STARTED',
  `project_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `completed` datetime DEFAULT NULL,
  `completed_by` int(11) DEFAULT NULL,
  `deleted` int(2) DEFAULT NULL,
  `estimated_time` int(11) DEFAULT NULL,
  `out_of_scope` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `completed_by` (`completed_by`),
  KEY `project_id` (`project_id`),
  KEY `createdby` (`created_by`),
  KEY `completedby` (`completed_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `projects_project`
--

CREATE TABLE IF NOT EXISTS `projects_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `description` text,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `tree_lft` int(11) DEFAULT NULL,
  `tree_rgt` int(11) DEFAULT NULL,
  `tree_level` int(11) DEFAULT NULL,
  `tree_parent` int(11) DEFAULT NULL,
  `deleted` int(1) DEFAULT '0',
  `status` enum('DRAFT','STARTED','COMPLETED') NOT NULL DEFAULT 'DRAFT',
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `project_manager`.`test` AS select `project_manager`.`projects_project`.`id` AS `id`,`project_manager`.`projects_project`.`name` AS `name`,`project_manager`.`projects_project`.`code` AS `code`,`project_manager`.`projects_project`.`status` AS `status`,`project_manager`.`projects_project`.`description` AS `description`,`project_manager`.`projects_project`.`created` AS `created`,`project_manager`.`projects_project`.`created_by` AS `created_by`,`project_manager`.`projects_project`.`tree_lft` AS `tree_lft`,`project_manager`.`projects_project`.`tree_rgt` AS `tree_rgt`,`project_manager`.`projects_project`.`tree_level` AS `tree_level`,`project_manager`.`projects_project`.`tree_parent` AS `tree_parent`,`project_manager`.`user`.`username` AS `username` from (`project_manager`.`projects_project` left join `project_manager`.`user` on((`project_manager`.`projects_project`.`created_by` = `project_manager`.`user`.`id`)));

-- --------------------------------------------------------

--
-- Table structure for table `user_user`
--

CREATE TABLE IF NOT EXISTS `user_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `activekey` varchar(128) NOT NULL DEFAULT '',
  `createtime` int(10) NOT NULL DEFAULT '0',
  `lastvisit` int(10) NOT NULL DEFAULT '0',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`),
  KEY `superuser` (`superuser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `crm_address`
--
ALTER TABLE `crm_address`
  ADD CONSTRAINT `crm_address_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `crm_contact` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `crm_email`
--
ALTER TABLE `crm_email`
  ADD CONSTRAINT `crm_email_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `crm_contact` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `crm_phone`
--
ALTER TABLE `crm_phone`
  ADD CONSTRAINT `crm_phone_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `crm_contact` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `crm_website`
--
ALTER TABLE `crm_website`
  ADD CONSTRAINT `crm_website_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `crm_contact` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projects_issue`
--
ALTER TABLE `projects_issue`
  ADD CONSTRAINT `completedby` FOREIGN KEY (`completed_by`) REFERENCES `user_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `createdby` FOREIGN KEY (`created_by`) REFERENCES `user_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `project_id` FOREIGN KEY (`project_id`) REFERENCES `projects_project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `projects_project`
--
ALTER TABLE `projects_project`
  ADD CONSTRAINT `created_by` FOREIGN KEY (`created_by`) REFERENCES `user_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;