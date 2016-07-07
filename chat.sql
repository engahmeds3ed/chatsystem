-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Host: localhost:3307
-- Generation Time: Jul 07, 2016 at 02:11 PM
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
  `msg_readtime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `ses_id` bigint(20) UNSIGNED NOT NULL,
  `ses_userid` bigint(20) NOT NULL,
  `ses_timein` varchar(20) NOT NULL,
  `ses_timeout` varchar(20) NOT NULL,
  `ses_code` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `user_code` varchar(50) NOT NULL,
  `user_username` varchar(200) NOT NULL,
  `user_password` varchar(200) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_phone` varchar(255) NOT NULL,
  `user_phone2` varchar(255) NOT NULL,
  `user_gender` tinyint(1) NOT NULL,
  `user_groupid` int(11) NOT NULL,
  `user_status` tinyint(1) NOT NULL,
  `user_lastlogin` datetime DEFAULT NULL,
  `user_addedby` bigint(20) NOT NULL,
  `user_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_lastupdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  MODIFY `msg_id` bigint(20) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
