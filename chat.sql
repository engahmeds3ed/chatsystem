-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Host: localhost:3307
-- Generation Time: Jul 09, 2016 at 10:12 AM
-- Server version: 10.1.9-MariaDB-log
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chat`
--

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `cfg_id` bigint(20) UNSIGNED NOT NULL,
  `cfg_name` varchar(255) NOT NULL,
  `cfg_value` varchar(255) NOT NULL,
  `cfg_autoload` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`cfg_id`, `cfg_name`, `cfg_value`, `cfg_autoload`) VALUES
(1, 'sitename', 'Chat System', 1);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msg_id` bigint(20) NOT NULL,
  `msg_from` bigint(20) NOT NULL,
  `msg_to` bigint(20) NOT NULL,
  `msg_content` text NOT NULL,
  `msg_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `msg_readtime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`msg_id`, `msg_from`, `msg_to`, `msg_content`, `msg_created`, `msg_readtime`) VALUES
(1, 2, 3, 'First Message here', '2016-07-09 11:22:19', '2016-07-09 18:54:09'),
(2, 3, 2, 'Second Message', '2016-07-09 11:22:52', '2016-07-09 18:53:52'),
(3, 2, 3, 'test msg here', '2016-07-09 15:21:26', '2016-07-09 18:54:09'),
(4, 2, 3, 'tesssssst', '2016-07-09 15:26:04', '2016-07-09 18:54:09'),
(5, 2, 3, 'saasfasf', '2016-07-09 15:33:33', '2016-07-09 18:54:09'),
(6, 2, 3, 'asasasasa', '2016-07-09 16:01:24', '2016-07-09 18:54:09'),
(7, 2, 3, 'testat', '2016-07-09 16:02:57', '2016-07-09 18:54:09'),
(8, 2, 3, 'asdasdas', '2016-07-09 16:07:21', '2016-07-09 18:54:09'),
(9, 2, 3, 'yessssssss', '2016-07-09 16:16:26', '2016-07-09 18:54:09'),
(10, 2, 3, 'sfasdas', '2016-07-09 16:24:43', '2016-07-09 18:54:09'),
(11, 2, 3, 'yes I\'m here', '2016-07-09 16:24:49', '2016-07-09 18:54:09'),
(12, 2, 3, 'asdsdas', '2016-07-09 16:24:54', '2016-07-09 18:54:09'),
(13, 2, 3, 'teststtsts', '2016-07-09 16:48:44', '2016-07-09 18:54:09'),
(14, 3, 2, 'chrome test', '2016-07-09 16:54:23', '2016-07-09 18:54:27'),
(15, 2, 3, 'firefox test', '2016-07-09 16:54:34', '2016-07-09 18:54:34'),
(16, 2, 3, 'new firefox test', '2016-07-09 16:55:09', '2016-07-09 19:01:03'),
(17, 2, 3, 'last firefox test', '2016-07-09 16:55:38', '2016-07-09 19:01:03'),
(18, 2, 3, 'yes', '2016-07-09 16:55:52', '2016-07-09 19:01:03'),
(19, 3, 2, 'hi man', '2016-07-09 17:01:11', '2016-07-09 19:01:13');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `ses_id` bigint(20) UNSIGNED NOT NULL,
  `ses_userid` bigint(20) NOT NULL,
  `ses_timein` varchar(20) NOT NULL,
  `ses_timeout` varchar(20) NOT NULL,
  `ses_code` varchar(100) NOT NULL,
  `ses_lastactivity` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`ses_id`, `ses_userid`, `ses_timein`, `ses_timeout`, `ses_code`, `ses_lastactivity`) VALUES
(20, 3, '1468074195', '1468160595', '578108d35191c', '1468084626'),
(21, 2, '1468074218', '1468160618', '578108ea604bb', '1468084622');

-- --------------------------------------------------------

--
-- Table structure for table `usergroups`
--

CREATE TABLE `usergroups` (
  `ug_id` bigint(20) UNSIGNED NOT NULL,
  `ug_name` varchar(255) NOT NULL,
  `ug_status` tinyint(1) NOT NULL,
  `ug_addedby` bigint(20) NOT NULL,
  `ug_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usergroups`
--

INSERT INTO `usergroups` (`ug_id`, `ug_name`, `ug_status`, `ug_addedby`, `ug_created`) VALUES
(1, 'Admins', 1, 1, '2016-07-07 21:41:37'),
(2, 'Users', 1, 1, '2016-07-08 13:36:31');

-- --------------------------------------------------------

--
-- Table structure for table `usermeta`
--

CREATE TABLE `usermeta` (
  `um_id` bigint(20) UNSIGNED NOT NULL,
  `um_userid` bigint(20) NOT NULL,
  `um_metakey` varchar(255) NOT NULL,
  `um_metavalue` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_fullname` varchar(255) NOT NULL,
  `user_username` varchar(200) NOT NULL,
  `user_password` varchar(200) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_phone` varchar(255) NOT NULL,
  `user_gender` tinyint(1) NOT NULL,
  `user_groupid` int(11) NOT NULL,
  `user_status` tinyint(1) NOT NULL,
  `user_lastlogin` datetime DEFAULT NULL,
  `user_addedby` bigint(20) NOT NULL,
  `user_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_lastupdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_fullname`, `user_username`, `user_password`, `user_email`, `user_phone`, `user_gender`, `user_groupid`, `user_status`, `user_lastlogin`, `user_addedby`, `user_created`, `user_lastupdate`) VALUES
(1, 'Ahmed Saed', 'admin', '0b592686e4b5631a4652ac9e93b8d513', 'eng.ahmeds3ed@gmail.com', '', 0, 1, 1, NULL, 0, '2016-07-08 12:51:56', '0000-00-00 00:00:00'),
(2, 'Mohamed Magdy', 'user', 'ddadde61e2a27adb7994676fc1e6e192', 'asa@aa.cc', '', 0, 2, 1, '2016-07-09 16:23:38', 0, '2016-07-08 16:27:24', '0000-00-00 00:00:00'),
(3, 'Ahmed Saed', 'user2', 'ddadde61e2a27adb7994676fc1e6e192', 'asa@asa.com', '', 0, 2, 1, '2016-07-09 16:23:15', 0, '2016-07-09 10:47:49', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`cfg_id`),
  ADD UNIQUE KEY `cfg_id` (`cfg_id`),
  ADD UNIQUE KEY `cfg_name` (`cfg_name`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`ses_id`),
  ADD UNIQUE KEY `ses_id` (`ses_id`);

--
-- Indexes for table `usergroups`
--
ALTER TABLE `usergroups`
  ADD PRIMARY KEY (`ug_id`),
  ADD UNIQUE KEY `ug_id` (`ug_id`);

--
-- Indexes for table `usermeta`
--
ALTER TABLE `usermeta`
  ADD UNIQUE KEY `um_id` (`um_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `cfg_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `ses_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `usergroups`
--
ALTER TABLE `usergroups`
  MODIFY `ug_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `usermeta`
--
ALTER TABLE `usermeta`
  MODIFY `um_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
