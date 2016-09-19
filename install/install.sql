--
-- Database: `pdns`
--

-- --------------------------------------------------------

--
-- Table structure for table `w_domaindata`
--

CREATE TABLE `w_domaindata` (
  `id` int(11) NOT NULL,
  `domainID` int(11) NOT NULL,
  `domainHash` varchar(255) NOT NULL,
  `domainAdmin` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `w_users` (
  `userID` int(11) NOT NULL,
  `userEmail` varchar(255) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `userAdminLevel` int(1) NOT NULL,
  `userHash` varchar(255) NOT NULL,
  `userEnabled` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Added By DNS Admin';

--
-- Dumping data for table `w_users`
--

INSERT INTO `w_users` (`userID`, `userEmail`, `userPassword`, `userName`, `userAdminLevel`, `userHash`, `userEnabled`) VALUES
(1, 'admin@admin.com', '$2y$10$5fEa3XaoXdl.npvVEz3o6uvMemRgeKIsu6gdyapbJ/5sdKeNl9gY.', 'You', 2, '', 1),

--
-- Indexes for dumped tables
--

--
-- Indexes for table `w_domaindata`
--
ALTER TABLE `w_domaindata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `w_userlevels`
--
ALTER TABLE `w_userlevels`
  ADD PRIMARY KEY (`userLevelID`);

--
-- Indexes for table `w_users`
--
ALTER TABLE `w_users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `w_domaindata`
--
ALTER TABLE `w_domaindata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `w_userlevels`
--
ALTER TABLE `w_userlevels`
  MODIFY `userLevelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `w_users`
--
ALTER TABLE `w_users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
