-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 08, 2011 at 03:57 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `project_manager`
--

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

--
-- Constraints for dumped tables
--

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
