-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 15, 2011 at 04:57 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `project_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `project_action_assigned`
--

CREATE TABLE IF NOT EXISTS `project_action_assigned` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `issue_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `project_role` enum('SUPPORT','SALES','TEAMLEAD','CUSTOMER') DEFAULT NULL,
  `added` datetime DEFAULT NULL,
  `assigned_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `apUserId` (`user_id`),
  KEY `apIssueId` (`issue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_project`
--

CREATE TABLE IF NOT EXISTS `project_project` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `logo` int(11) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `description` text,
  `completion_date` date DEFAULT NULL,
  `tree_lft` int(11) DEFAULT NULL,
  `tree_rgt` int(11) DEFAULT NULL,
  `tree_level` int(11) DEFAULT NULL,
  `tree_parent` int(11) DEFAULT NULL,
  `estimated_time` int(5) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pCreatedBy` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_project_assigned`
--

CREATE TABLE IF NOT EXISTS `project_project_assigned` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `project_role` enum('SUPPORT','SALES','TEAMLEAD','CUSTOMER') DEFAULT NULL,
  `added` datetime DEFAULT NULL,
  `assigned_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `apUserId` (`user_id`),
  KEY `apProjectId` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_project_history`
--

CREATE TABLE IF NOT EXISTS `project_project_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) unsigned DEFAULT NULL,
  `status` enum('STATUS_NOT_STARTED','STATUS_STARTED','STATUS_FINISHED','STATUS_DELETED') DEFAULT 'STATUS_NOT_STARTED',
  `comment` text,
  `updated_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pProject_id` (`project_id`),
  KEY `pUpdatedBy` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_sprint`
--

CREATE TABLE IF NOT EXISTS `project_sprint` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(45) DEFAULT NULL,
  `description` text,
  `duration` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `project_id` int(11) unsigned DEFAULT NULL,
  `status` enum('PREVIOUS','CURRENT','FUTURE') DEFAULT NULL,
  `sprint_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sUserId` (`created_by`),
  KEY `sProjectId` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_task`
--

CREATE TABLE IF NOT EXISTS `project_task` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('TYPE_ISSUE','TYPE_BUG','TYPE_FEATURE','TYPE_MOD','TYPE_ACTION') DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text,
  `project_id` int(11) unsigned DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `estimated_time` int(11) DEFAULT NULL,
  `out_of_scope` int(2) DEFAULT NULL,
  `assigned_user` int(11) DEFAULT NULL,
  `sprint_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `PIrojectId` (`project_id`),
  KEY `PICreatedBy` (`created_by`),
  KEY `PAssignedUser` (`assigned_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_task_history`
--

CREATE TABLE IF NOT EXISTS `project_task_history` (
  `id` int(10) unsigned NOT NULL,
  `issue_id` int(11) unsigned DEFAULT NULL,
  `status` enum('FRESH','IN_PROGRESS','CLOSED') DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `comment` text,
  PRIMARY KEY (`id`),
  KEY `ihIssueId` (`issue_id`),
  KEY `ihUpdatedBy` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_time_record`
--

CREATE TABLE IF NOT EXISTS `project_time_record` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(11) unsigned DEFAULT NULL,
  `description` text,
  `added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` int(11) DEFAULT NULL,
  `type` int(11) unsigned DEFAULT NULL,
  `time_started` datetime NOT NULL,
  `time_finished` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `timeAddedId` (`added_by`),
  KEY `timeType` (`type`),
  KEY `timeIssueId` (`task_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_time_recordtype`
--

CREATE TABLE IF NOT EXISTS `project_time_recordtype` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `project_action_assigned`
--
ALTER TABLE `project_action_assigned`
  ADD CONSTRAINT `apIssueId0` FOREIGN KEY (`issue_id`) REFERENCES `project_task` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `apUserId0` FOREIGN KEY (`user_id`) REFERENCES `user_user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `project_project`
--
ALTER TABLE `project_project`
  ADD CONSTRAINT `pCreatedBy` FOREIGN KEY (`created_by`) REFERENCES `user_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `project_project_assigned`
--
ALTER TABLE `project_project_assigned`
  ADD CONSTRAINT `apProjectId` FOREIGN KEY (`project_id`) REFERENCES `project_project` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `apUserId` FOREIGN KEY (`user_id`) REFERENCES `user_user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `project_project_history`
--
ALTER TABLE `project_project_history`
  ADD CONSTRAINT `pProject_id` FOREIGN KEY (`project_id`) REFERENCES `project_project` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `pUpdatedBy` FOREIGN KEY (`updated_by`) REFERENCES `user_user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `project_sprint`
--
ALTER TABLE `project_sprint`
  ADD CONSTRAINT `sProjectId` FOREIGN KEY (`project_id`) REFERENCES `project_project` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `sUserId` FOREIGN KEY (`created_by`) REFERENCES `user_user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `project_task`
--
ALTER TABLE `project_task`
  ADD CONSTRAINT `PAssignedUser` FOREIGN KEY (`assigned_user`) REFERENCES `user_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `PICreatedBy` FOREIGN KEY (`created_by`) REFERENCES `user_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `project_task_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_task_history`
--
ALTER TABLE `project_task_history`
  ADD CONSTRAINT `ihIssueId` FOREIGN KEY (`issue_id`) REFERENCES `project_task` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ihUpdatedBy` FOREIGN KEY (`updated_by`) REFERENCES `user_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `project_time_record`
--
ALTER TABLE `project_time_record`
  ADD CONSTRAINT `project_time_record_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `project_task` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_time_record_ibfk_2` FOREIGN KEY (`added_by`) REFERENCES `user_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_time_record_ibfk_3` FOREIGN KEY (`type`) REFERENCES `project_time_recordtype` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
