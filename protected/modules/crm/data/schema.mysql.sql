

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `crm_email` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) unsigned NOT NULL,
  `address` varchar(250) NOT NULL,
  `label` varchar(250) NOT NULL,
  `verified` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`),
  KEY `address` (`address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `crm_phone` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(250) NOT NULL,
  `label` varchar(250) NOT NULL,
  `contact_id` int(11) unsigned NOT NULL,
  `verified` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `crm_website` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(250) NOT NULL,
  `label` varchar(250) NOT NULL,
  `contact_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


ALTER TABLE `crm_address`
  ADD CONSTRAINT `crm_address_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `crm_contact` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;


ALTER TABLE `crm_email`
  ADD CONSTRAINT `crm_email_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `crm_contact` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;


ALTER TABLE `crm_phone`
  ADD CONSTRAINT `crm_phone_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `crm_contact` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;


ALTER TABLE `crm_website`
  ADD CONSTRAINT `crm_website_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `crm_contact` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;
