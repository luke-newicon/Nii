

--
-- Table structure for table `support_assignee`
--

CREATE TABLE IF NOT EXISTS `support_assignee` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) unsigned NOT NULL,
  `user` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `support_attachment`
--

CREATE TABLE IF NOT EXISTS `support_attachment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `mail_id` int(11) unsigned NOT NULL,
  `file_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------


--
-- Table structure for table `support_email`
--

CREATE TABLE IF NOT EXISTS `support_email` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `to` text NOT NULL,
  `from` varchar(255) NOT NULL,
  `message_id` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `headers` longtext NOT NULL,
  `template_id` int(11) unsigned NOT NULL,
  `message_text` text NOT NULL,
  `message_html` text NOT NULL,
  `sent` tinyint(1) unsigned NOT NULL,
  `opened` tinyint(1) unsigned NOT NULL,
  `opened_date` datetime NOT NULL,
  `bounced` tinyint(1) unsigned NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date` datetime NOT NULL,
  `cc` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=74 ;


--
-- Table structure for table `support_ticket`
--

CREATE TABLE IF NOT EXISTS `support_ticket` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `from` varchar(255) NOT NULL,
  `priority` enum('PRIORITY_LOW','PRIORITY_NORMAL','PRIORITY_HIGH','PRIORITY_EMERGENCY') NOT NULL,
  `status` enum('STATUS_OPEN','STATUS_CLOSED') NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `answered` tinyint(1) unsigned NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Table structure for table `support_ticket_email`
--

CREATE TABLE IF NOT EXISTS `support_ticket_email` (
  `email_id` int(11) unsigned NOT NULL,
  `ticket_id` int(11) unsigned NOT NULL,
  `type` enum('TYPE_SENT','TYPE_RECEIVED') NOT NULL DEFAULT 'TYPE_RECEIVED',
  PRIMARY KEY (`email_id`,`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

