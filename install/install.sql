--
-- Database: `pdns`
--

-- --------------------------------------------------------

--
-- Table structure for table `w_domaindata`
--

CREATE TABLE IF NOT EXISTS `w_domaindata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domainID` int(11) NOT NULL,
  `domainHash` varchar(255) NOT NULL,
  `domainAdmin` int(11) DEFAULT '0',
  `domainMaxRecords` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `w_domaindata`
--


-- --------------------------------------------------------

--
-- Table structure for table `w_userlevels`
--

CREATE TABLE `w_userlevels` (
  `userLevelID` int(11) NOT NULL,
  `userLevelDesc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `w_userlevels`
--

INSERT INTO `w_userlevels` (`userLevelID`, `userLevelDesc`) VALUES
(0, 'Domain User'),
(1, 'Domain Admin'),
(2, 'System Admin');

-- --------------------------------------------------------

--
-- Table structure for table `w_users`
--

CREATE TABLE IF NOT EXISTS `w_users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `userEmail` varchar(255) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `userAdminLevel` int(1) NOT NULL DEFAULT '0',
  `userHash` varchar(255) DEFAULT NULL,
  `userEnabled` int(1) NOT NULL,
  `userMaxDomains` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Added By DNS Admin';

--
-- Dumping data for table `w_users`
--

INSERT INTO `w_users` (`userID`, `userEmail`, `userPassword`, `userName`, `userAdminLevel`, `userHash`, `userEnabled`, `userMaxDomains`) VALUES
(1, 'admin@admin.com', '$2y$10$5fEa3XaoXdl.npvVEz3o6uvMemRgeKIsu6gdyapbJ/5sdKeNl9gY.', 'You', 2, '', 1,0),
