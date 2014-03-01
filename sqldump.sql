-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 28, 2014 at 08:12 AM
-- Server version: 5.5.33
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `TC-Calendar`
--

USE michaela_tccalendar;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `allDay` tinyint(1) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `start`, `end`, `allDay`, `url`, `created`, `updated`) VALUES
(12, 'Dennis Chen 2', '2014-02-09 00:00:00', '2014-02-14 00:00:00', NULL, '', '2014-02-27 18:33:04', '0000-00-00 00:00:00'),
(35, 'Test Event edit number 2', '2014-02-06 00:00:00', '2014-02-06 00:00:00', NULL, '', '2014-02-27 19:19:49', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `googleCalendars`
--

CREATE TABLE `googleCalendars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `color` varchar(20) NOT NULL,
  `textColor` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `googleCalendars`
--

INSERT INTO `googleCalendars` (`id`, `url`, `color`, `textColor`) VALUES
(1, 'http://www.google.com/calendar/feeds/usa__en%40holiday.calendar.google.com/public/basic', 'yellow', 'black'),
(15, 'https://www.google.com/calendar/feeds/ucsd.tzuching%40gmail.com/public/basic', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `Username` varchar(65) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `EmailAddress` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Username` (`Username`),
  UNIQUE KEY `Username_2` (`Username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;
