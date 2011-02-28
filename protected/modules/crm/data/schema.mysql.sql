
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
  `type` enum('CONTACT','COMPANY','USER') NOT NULL DEFAULT 'CONTACT',
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=96 ;


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
