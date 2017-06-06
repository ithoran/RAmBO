-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2017 at 03:25 AM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rambo`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `ID` int(11) NOT NULL,
  `FADMINISTRATOR` tinyint(1) DEFAULT '0',
  `FCLAN` tinyint(1) DEFAULT NULL,
  `USERNAME` varchar(20) NOT NULL,
  `PASSWORD` varchar(30) NOT NULL,
  `EMAIL` varchar(30) DEFAULT NULL,
  `DRZAVA` varchar(30) NOT NULL,
  `BROJ_PRIJAVA` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`ID`, `FADMINISTRATOR`, `FCLAN`, `USERNAME`, `PASSWORD`, `EMAIL`, `DRZAVA`, `BROJ_PRIJAVA`) VALUES
(100001, 1, 0, 'admin', 'admin', NULL, '', 0),
(100003, 0, 1, 'pera3', 'pera3', 'pera3@gmail.com', 'Serbia', 0),
(100010, 0, 1, 'harry potter', 'harrypotter', 'harrypotter@gmail.com', 'United Kingdom', 0),
(100012, 0, 1, 'ivan', 'ivan', 'ivan', 'Serbia', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100013;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
