-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 02, 2012 at 01:16 PM
-- Server version: 5.5.23
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `species-invaders`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE IF NOT EXISTS `activities` (
  `activityid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `extra_notes` text NOT NULL,
  PRIMARY KEY (`activityid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `activities-locations`
--

CREATE TABLE IF NOT EXISTS `activities-locations` (
  `activityid` int(11) NOT NULL,
  `locationid` int(11) NOT NULL,
  KEY `activityid` (`activityid`),
  KEY `locationid` (`locationid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `common-names`
--

CREATE TABLE IF NOT EXISTS `common-names` (
  `speciesid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  KEY `speciesid` (`speciesid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `locationid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `polygon` polygon NOT NULL,
  PRIMARY KEY (`locationid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `species`
--

CREATE TABLE IF NOT EXISTS `species` (
  `speciesid` int(11) NOT NULL AUTO_INCREMENT,
  `kingdom` varchar(100) NOT NULL,
  `phylum` varchar(100) NOT NULL,
  `class` varchar(100) NOT NULL,
  `order` varchar(100) NOT NULL,
  `family` varchar(100) NOT NULL,
  `genus` varchar(100) NOT NULL,
  `species` varchar(100) NOT NULL,
  `extra_notes` text NOT NULL,
  PRIMARY KEY (`speciesid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `species-locations`
--

CREATE TABLE IF NOT EXISTS `species-locations` (
  `speciesid` int(11) NOT NULL,
  `native_location` int(11) NOT NULL,
  `invading_location` int(11) NOT NULL,
  KEY `speciesid` (`speciesid`),
  KEY `native_location` (`native_location`),
  KEY `invading_location` (`invading_location`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities-locations`
--
ALTER TABLE `activities-locations`
  ADD CONSTRAINT `activities@002dlocations_ibfk_2` FOREIGN KEY (`locationid`) REFERENCES `locations` (`locationid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `activities@002dlocations_ibfk_1` FOREIGN KEY (`activityid`) REFERENCES `activities` (`activityid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `common-names`
--
ALTER TABLE `common-names`
  ADD CONSTRAINT `common@002dnames_ibfk_1` FOREIGN KEY (`speciesid`) REFERENCES `species` (`speciesid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `species-locations`
--
ALTER TABLE `species-locations`
  ADD CONSTRAINT `species@002dlocations_ibfk_3` FOREIGN KEY (`invading_location`) REFERENCES `locations` (`locationid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `species@002dlocations_ibfk_1` FOREIGN KEY (`speciesid`) REFERENCES `species` (`speciesid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `species@002dlocations_ibfk_2` FOREIGN KEY (`native_location`) REFERENCES `locations` (`locationid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
