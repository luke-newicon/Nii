
--
-- Table structure for table `nworx_core__files`
--

CREATE TABLE IF NOT EXISTS `nworx_core__files` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `original_name` varchar(50) NOT NULL,
  `category` varchar(100) NOT NULL,
  `filed_name` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `size` int(11) unsigned NOT NULL,
  `mime` varchar(50) NOT NULL,
  `file_path` varchar(250) NOT NULL,
  `uploaded-date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `support_assignees`
--

CREATE TABLE IF NOT EXISTS `support_assignee` (
  `assignee_id` int(11) unsigned NOT NULL auto_increment,
  `assignee_ticket_id` int(11) unsigned NOT NULL,
  `assignee_user` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`assignee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `support_attachments`
--

CREATE TABLE IF NOT EXISTS `support_attachment` (
  `attachment_id` int(11) unsigned NOT NULL auto_increment,
  `attachment_name` varchar(255) NOT NULL,
  `attachment_type` varchar(255) NOT NULL,
  `attachment_mail_id` int(11) unsigned NOT NULL,
  `attachment_file_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`attachment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `support_emails`
--

CREATE TABLE IF NOT EXISTS `support_email` (
  `email_id` int(11) unsigned NOT NULL auto_increment,
  `email_to` varchar(255) NOT NULL,
  `email_from` varchar(255) NOT NULL,
  `email_message_id` varchar(255) NOT NULL,
  `email_subject` varchar(255) NOT NULL,
  `email_headers` longtext NOT NULL,
  `email_template_id` int(11) unsigned NOT NULL,
  `email_message_text` text NOT NULL,
  `email_message_html` text NOT NULL,
  `email_sent` tinyint(1) unsigned NOT NULL,
  `email_opened` tinyint(1) unsigned NOT NULL,
  `email_opened_date` datetime NOT NULL,
  `email_bounced` tinyint(1) unsigned NOT NULL,
  `email_created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`email_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `support_ticketemails`
--

CREATE TABLE IF NOT EXISTS `support_ticket_email` (
  `ticketemail_id` int(11) unsigned NOT NULL auto_increment,
  `ticketemail_email_id` int(11) unsigned NOT NULL,
  `ticketemail_ticket_id` int(11) unsigned NOT NULL,
  `ticketemail_type` enum('TYPE_SENT','TYPE_RECEIVED') NOT NULL default 'TYPE_RECEIVED',
  PRIMARY KEY  (`ticketemail_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=101 ;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE IF NOT EXISTS `support_ticket` (
  `ticket_id` int(11) unsigned NOT NULL auto_increment,
  `ticket_subject` varchar(255) NOT NULL,
  `ticket_message` text NOT NULL,
  `ticket_from` varchar(255) NOT NULL,
  `ticket_priority` enum('PRIORITY_LOW','PRIORITY_NORMAL','PRIORITY_HIGH','PRIORITY_EMERGENCY') NOT NULL,
  `ticket_status` enum('STATUS_OPEN','STATUS_CLOSED') NOT NULL,
  `ticket_created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `ticket_answered` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY  (`ticket_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------
