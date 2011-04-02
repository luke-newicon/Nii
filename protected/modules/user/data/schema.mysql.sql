-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 28, 2011 at 12:28 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `project_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


drop table if exists auth_assignment;
drop table if exists auth_item_child;
drop table if exists auth_item;

create table auth_item
(
   name                 varchar(64) not null,
   type                 integer not null,
   description          text,
   bizrule              text,
   data                 text,
   primary key (name)
);

create table auth_item_child
(
   parent               varchar(64) not null,
   child                varchar(64) not null,
   primary key (parent,child),
   foreign key (parent) references auth_item (name) on delete cascade on update cascade,
   foreign key (child) references auth_item (name) on delete cascade on update cascade
);

create table auth_assignment
(
   itemname             varchar(64) not null,
   userid               varchar(64) not null,
   bizrule              text,
   data                 text,
   primary key (itemname,userid),
   foreign key (itemname) references auth_item (name) on delete cascade on update cascade
);
