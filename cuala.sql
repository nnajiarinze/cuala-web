-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2016 at 05:54 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cuala`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_create_event` (IN `titlee` VARCHAR(250), IN `locationn` VARCHAR(250), IN `datee` DATETIME, IN `imagee` VARCHAR(1000), IN `descriptionn` TEXT, IN `created_datee` DATE, OUT `id` INT)  BEGIN
        INSERT INTO bf_tbl_events (title,location,`date`,image,description,created_date)
         VALUES (titlee,locationn,datee,imagee,descriptionn,created_datee);

        SET id = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_create_event_invitation` (IN `event_idd` INT, IN `user_idd` INT, IN `attendingg` TINYINT, OUT `id` INT)  BEGIN
        INSERT INTO bf_tbl_events_invitations (event_id,user_id,attending)
         VALUES (event_idd,user_idd,attendingg);

        SET id = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_create_job` (IN `category_idd` INT, IN `titlee` VARCHAR(255), IN `locationn` VARCHAR(255), IN `descriptionn` TEXT, IN `created_datee` DATE, IN `end_datee` DATE, OUT `id` INT)  BEGIN
        INSERT INTO bf_tbl_jobs (category_id,title,location,description,created_date,end_date)
         VALUES (category_idd,titlee,locationn,descriptionn,created_datee,end_datee);

        SET id = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_create_job_category` (IN `namee` VARCHAR(255), OUT `id` INT)  BEGIN
        INSERT INTO bf_tbl_job_category (`name`) VALUES (namee);

        SET id = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_create_news` (IN `headlinee` VARCHAR(250), IN `brieff` VARCHAR(150), IN `descriptionn` TEXT, IN `authorr` VARCHAR(150), IN `publish_datee` DATE, IN `tweet_textt` VARCHAR(140), IN `created_datee` DATE, IN `tagss` TEXT, IN `imagee` VARCHAR(1000), IN `deletedd` TINYINT, OUT `id` INT)  BEGIN
	INSERT INTO bf_tbl_news(headline,brief,description,author,publish_date,tweet_text,created_date,tags,image,deleted)
    VALUES(headlinee,brieff,descriptionn,authorr,publish_datee,tweet_textt,created_datee,tagss,imagee,deletedd);

	SET id = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_create_news_comment` (IN `news_idd` INT, IN `user_idd` INT, IN `commentt` TEXT, OUT `id` INT)  BEGIN
        INSERT INTO bf_tbl_news_comments (news_id,user_id,comment)
         VALUES (news_idd,user_idd,commentt);

        SET id = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_create_user` (IN `fb_idd` VARCHAR(30), IN `namee` VARCHAR(255), IN `emaill` VARCHAR(255), IN `phonee` VARCHAR(255), IN `matric_noo` VARCHAR(11), IN `reg_noo` VARCHAR(10), IN `grad_yearr` INT, IN `imagee` VARCHAR(255), IN `coursee` VARCHAR(255), IN `occupationn` VARCHAR(255), OUT `id` INT)  BEGIN
	INSERT INTO bf_tbl_users(fb_id,`name`,email,phone,matric_no,reg_no,image,grad_year,course,occupation)
    VALUES(fb_idd,namee,emaill,phonee,matric_noo,reg_noo,imagee,grad_yearr,coursee,occupationn);

	SET id = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_delete_news` (IN `idd` INT)  BEGIN
        UPDATE bf_tbl_news SET deleted=true WHERE id=idd;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_fetch_paginated_news` (IN `page_size` INT, IN `page_num` INT)  BEGIN
    DECLARE offsett INT;
    SET offsett = (page_num - 1) * page_size;
	SELECT * FROM bf_tbl_news WHERE deleted=false ORDER BY id desc LIMIT offsett,page_size;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_get_events_between_date` (IN `start_datee` DATE, IN `end_datee` DATE)  BEGIN
    SELECT * FROM bf_tbl_events WHERE  CAST(date AS DATE) >= CAST(start_datee AS DATE) AND date<=CAST(end_datee AS DATE) ORDER BY id desc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_get_event_by_date` (IN `datee` DATE)  BEGIN
    SELECT * FROM bf_tbl_events WHERE CAST(date AS DATE)=CAST(datee AS DATE) ORDER BY id desc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_get_event_by_id` (IN `idd` INT)  BEGIN
    SELECT * FROM bf_tbl_events WHERE id=idd;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_get_jobs_per_category` (IN `category_idd` INT, IN `page_size` INT, IN `page_num` INT)  BEGIN
    DECLARE offsett INT;
    SET offsett = (page_num - 1) * page_size;
	SELECT * FROM bf_tbl_jobs WHERE category_id=category_idd ORDER BY id desc LIMIT offsett,page_size;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_get_job_by_id` (IN `idd` INT)  BEGIN
    SELECT bf_tbl_jobs.*, bf_tbl_job_category.name as category_name FROM bf_tbl_jobs 
      JOIN bf_tbl_job_category ON bf_tbl_jobs.category_id=bf_tbl_job_category.id
      WHERE bf_tbl_jobs.id=idd;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_get_job_categories` ()  BEGIN
    SELECT * FROM bf_tbl_job_category;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_get_news_by_id` (IN `idd` INT)  BEGIN

	SELECT * FROM bf_tbl_news WHERE id=idd;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_get_paginated_events` (IN `page_size` INT, IN `page_num` INT)  BEGIN
    DECLARE offsett INT;
    SET offsett = (page_num - 1) * page_size;
	SELECT * FROM bf_tbl_events WHERE deleted=false ORDER BY id DESC LIMIT offsett,page_size;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_get_paginated_jobs` (IN `page_size` INT, IN `page_num` INT)  BEGIN
    DECLARE offsett INT;
    SET offsett = (page_num - 1) * page_size;
SELECT bf_tbl_jobs.* , bf_tbl_job_category.name as category_name 
FROM bf_tbl_jobs JOIN bf_tbl_job_category ON bf_tbl_jobs.category_id=bf_tbl_job_category.id
  ORDER BY id desc LIMIT offsett,page_size; 
   
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_get_user_event_invitation_response` (IN `event_idd` INT, IN `user_idd` INT)  BEGIN
      SELECT * FROM bf_tbl_events_invitations WHERE event_id=event_idd AND user_id = user_idd;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_retrieve_users` (IN `page_num` INT, IN `page_size` INT)  BEGIN
    DECLARE offsett INT;
    SET offsett = (page_num - 1) * page_size;
    SELECT * FROM bf_tbl_users ORDER BY name asc LIMIT offsett,page_size;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_retrieve_users_by_course` (IN `page_num` INT, IN `page_size` INT, IN `coursee` VARCHAR(100))  BEGIN
    DECLARE offsett INT;
    SET offsett = (page_num - 1) * page_size;
    SELECT * FROM bf_tbl_users WHERE course=coursee ORDER BY name asc LIMIT offsett,page_size;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_retrieve_users_by_grad_year` (IN `page_num` INT, IN `page_size` INT, IN `grad_yearr` INT)  BEGIN
    DECLARE offsett INT;
    SET offsett = (page_num - 1) * page_size;
    SELECT * FROM bf_tbl_users WHERE grad_year=grad_yearr ORDER BY name asc LIMIT offsett,page_size;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_retrieve_user_by_email` (IN `userEmail` VARCHAR(50))  BEGIN
	SELECT * FROM bf_tbl_users WHERE email=userEmail;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_retrieve_user_by_facebook_id` (IN `facebook_id` VARCHAR(30))  BEGIN
	SELECT * FROM bf_tbl_users WHERE fb_id=facebook_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_retrieve_user_by_id` (IN `userId` INT)  BEGIN
	SELECT * FROM bf_tbl_users WHERE id=userId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_retrieve_user_by_matric_no` (IN `matricNumber` VARCHAR(50))  BEGIN
	SELECT * FROM bf_tbl_users WHERE matric_no=matricNumber;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_retrieve_user_by_phone` (IN `mobileNumber` VARCHAR(50))  BEGIN
	SELECT * FROM bf_tbl_users WHERE phone=mobileNumber;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_search_users_by_name` (IN `page_num` INT, IN `page_size` INT, IN `namee` VARCHAR(255))  BEGIN
    DECLARE offsett INT;
    SET offsett = (page_num - 1) * page_size;
    SELECT * FROM bf_tbl_users WHERE name LIKE CONCAT('%',namee,'%') LIMIT offsett,page_size;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_update_job` (IN `idd` INT, IN `category_idd` INT, IN `titlee` VARCHAR(255), IN `locationn` VARCHAR(255), IN `descriptionn` TEXT, IN `created_datee` DATE, IN `end_datee` DATE)  BEGIN
        UPDATE bf_tbl_jobs SET category_id=category_idd,title=titlee, location=locationn, description=descriptionn, created_date=created_datee, end_date=end_datee WHERE id=idd;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_update_news` (IN `idd` INT, IN `headlinee` VARCHAR(250), IN `brieff` VARCHAR(150), IN `descriptionn` TEXT, IN `authorr` VARCHAR(150), IN `publish_datee` DATE, IN `tweet_textt` VARCHAR(140), IN `created_datee` DATE, IN `tagss` TEXT, IN `imagee` VARCHAR(1000), IN `deletedd` TINYINT)  BEGIN
    UPDATE bf_tbl_news SET headline=headlinee, brief=brieff, description= descriptionn, author=authorr, publish_date= publish_datee,tweet_text=tweet_textt,created_date=created_datee,
    tags=tagss,image =imagee,deleted=deletedd WHERE id=idd;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `psp_update_user` (IN `idd` INT, IN `fb_idd` VARCHAR(30), IN `namee` VARCHAR(255), IN `emaill` VARCHAR(255), IN `phonee` VARCHAR(255), IN `matric_noo` VARCHAR(11), IN `reg_noo` VARCHAR(10), IN `grad_yearr` INT, IN `imagee` VARCHAR(255), IN `coursee` VARCHAR(255), IN `occupationn` VARCHAR(255))  BEGIN
     UPDATE bf_tbl_users SET fb_id=fb_idd ,`name`=namee, email=emaill,phone=phonee,matric_no=matric_noo,reg_no=reg_noo,grad_year=grad_yearr,
     course=coursee,occupation=occupationn,image=imagee WHERE id=idd;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bf_activities`
--

CREATE TABLE `bf_activities` (
  `activity_id` bigint(20) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `activity` varchar(255) NOT NULL,
  `module` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL,
  `deleted` tinyint(12) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bf_ci3_sessions`
--

CREATE TABLE `bf_ci3_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bf_email_queue`
--

CREATE TABLE `bf_email_queue` (
  `id` int(11) NOT NULL,
  `to_email` varchar(254) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `alt_message` text,
  `max_attempts` int(11) NOT NULL DEFAULT '3',
  `attempts` int(11) NOT NULL DEFAULT '0',
  `success` tinyint(1) NOT NULL DEFAULT '0',
  `date_published` datetime DEFAULT NULL,
  `last_attempt` datetime DEFAULT NULL,
  `date_sent` datetime DEFAULT NULL,
  `csv_attachment` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bf_login_attempts`
--

CREATE TABLE `bf_login_attempts` (
  `id` bigint(20) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(255) NOT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bf_permissions`
--

CREATE TABLE `bf_permissions` (
  `permission_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(100) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bf_roles`
--

CREATE TABLE `bf_roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(60) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `can_delete` tinyint(1) NOT NULL DEFAULT '1',
  `login_destination` varchar(255) NOT NULL DEFAULT '/',
  `default_context` varchar(255) DEFAULT 'content',
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bf_role_permissions`
--

CREATE TABLE `bf_role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bf_schema_version`
--

CREATE TABLE `bf_schema_version` (
  `type` varchar(40) NOT NULL,
  `version` int(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bf_sessions`
--

CREATE TABLE `bf_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bf_settings`
--

CREATE TABLE `bf_settings` (
  `name` varchar(30) NOT NULL,
  `module` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bf_tbl_events`
--

CREATE TABLE `bf_tbl_events` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `location` varchar(250) NOT NULL,
  `date` datetime NOT NULL,
  `image` varchar(1000) DEFAULT NULL,
  `description` text NOT NULL,
  `created_date` date NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `last_modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bf_tbl_events_invitations`
--

CREATE TABLE `bf_tbl_events_invitations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `attending` tinyint(1) NOT NULL,
  `last_modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bf_tbl_jobs`
--

CREATE TABLE `bf_tbl_jobs` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_date` date NOT NULL,
  `end_date` date NOT NULL,
  `last_modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bf_tbl_job_category`
--

CREATE TABLE `bf_tbl_job_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bf_tbl_news`
--

CREATE TABLE `bf_tbl_news` (
  `id` int(11) NOT NULL,
  `headline` varchar(250) NOT NULL,
  `brief` varchar(150) DEFAULT NULL,
  `description` text NOT NULL,
  `publish_date` date DEFAULT NULL,
  `author` varchar(150) NOT NULL,
  `tweet_text` varchar(140) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `tags` text,
  `image` varchar(1000) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `last_modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bf_tbl_news_comments`
--

CREATE TABLE `bf_tbl_news_comments` (
  `id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `last_modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bf_tbl_users`
--

CREATE TABLE `bf_tbl_users` (
  `id` int(11) NOT NULL,
  `fb_id` varchar(30) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `matric_no` varchar(11) NOT NULL,
  `reg_no` varchar(10) DEFAULT NULL,
  `grad_year` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `course` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bf_users`
--

CREATE TABLE `bf_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '4',
  `email` varchar(254) NOT NULL,
  `username` varchar(30) NOT NULL DEFAULT '',
  `password_hash` char(60) DEFAULT NULL,
  `reset_hash` varchar(40) DEFAULT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_ip` varchar(45) NOT NULL DEFAULT '',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `reset_by` int(10) DEFAULT NULL,
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_message` varchar(255) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT '',
  `display_name_changed` date DEFAULT NULL,
  `timezone` varchar(40) NOT NULL DEFAULT 'UM6',
  `language` varchar(20) NOT NULL DEFAULT 'english',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `activate_hash` varchar(40) NOT NULL DEFAULT '',
  `force_password_reset` tinyint(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bf_user_cookies`
--

CREATE TABLE `bf_user_cookies` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(128) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bf_user_meta`
--

CREATE TABLE `bf_user_meta` (
  `meta_id` int(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) NOT NULL DEFAULT '',
  `meta_value` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bf_activities`
--
ALTER TABLE `bf_activities`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `bf_ci3_sessions`
--
ALTER TABLE `bf_ci3_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bf_email_queue`
--
ALTER TABLE `bf_email_queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bf_login_attempts`
--
ALTER TABLE `bf_login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bf_permissions`
--
ALTER TABLE `bf_permissions`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `bf_roles`
--
ALTER TABLE `bf_roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `bf_role_permissions`
--
ALTER TABLE `bf_role_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`);

--
-- Indexes for table `bf_schema_version`
--
ALTER TABLE `bf_schema_version`
  ADD PRIMARY KEY (`type`);

--
-- Indexes for table `bf_sessions`
--
ALTER TABLE `bf_sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `bf_settings`
--
ALTER TABLE `bf_settings`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `bf_tbl_events`
--
ALTER TABLE `bf_tbl_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bf_tbl_events_invitations`
--
ALTER TABLE `bf_tbl_events_invitations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bf_tbl_jobs`
--
ALTER TABLE `bf_tbl_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bf_tbl_job_category`
--
ALTER TABLE `bf_tbl_job_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `bf_tbl_news`
--
ALTER TABLE `bf_tbl_news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bf_tbl_news_comments`
--
ALTER TABLE `bf_tbl_news_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bf_tbl_users`
--
ALTER TABLE `bf_tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fb_id` (`fb_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `matric_no` (`matric_no`);

--
-- Indexes for table `bf_users`
--
ALTER TABLE `bf_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `bf_user_cookies`
--
ALTER TABLE `bf_user_cookies`
  ADD KEY `token` (`token`);

--
-- Indexes for table `bf_user_meta`
--
ALTER TABLE `bf_user_meta`
  ADD PRIMARY KEY (`meta_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bf_activities`
--
ALTER TABLE `bf_activities`
  MODIFY `activity_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `bf_email_queue`
--
ALTER TABLE `bf_email_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bf_login_attempts`
--
ALTER TABLE `bf_login_attempts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bf_permissions`
--
ALTER TABLE `bf_permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `bf_roles`
--
ALTER TABLE `bf_roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `bf_tbl_events`
--
ALTER TABLE `bf_tbl_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `bf_tbl_events_invitations`
--
ALTER TABLE `bf_tbl_events_invitations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bf_tbl_jobs`
--
ALTER TABLE `bf_tbl_jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `bf_tbl_job_category`
--
ALTER TABLE `bf_tbl_job_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `bf_tbl_news`
--
ALTER TABLE `bf_tbl_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `bf_tbl_news_comments`
--
ALTER TABLE `bf_tbl_news_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `bf_tbl_users`
--
ALTER TABLE `bf_tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `bf_users`
--
ALTER TABLE `bf_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `bf_user_meta`
--
ALTER TABLE `bf_user_meta`
  MODIFY `meta_id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
