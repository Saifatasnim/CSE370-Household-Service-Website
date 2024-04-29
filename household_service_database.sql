-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2024 at 07:23 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `household_service_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Admin_ID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Admin_ID`, `Name`) VALUES
(4, NULL),
(9, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cancel_request`
--

CREATE TABLE `cancel_request` (
  `Clientid` int(11) DEFAULT NULL,
  `Adminid` int(11) DEFAULT NULL,
  `Requestid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `Client_ID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Total_due` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`Client_ID`, `Name`, `Total_due`) VALUES
(1, 'anipa', 0);

-- --------------------------------------------------------

--
-- Table structure for table `complain`
--

CREATE TABLE `complain` (
  `Clientid` int(11) DEFAULT NULL,
  `Adminid` int(11) DEFAULT NULL,
  `Complain` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cook`
--

CREATE TABLE `cook` (
  `Cook_ID` int(11) NOT NULL,
  `Food_type1` varchar(255) DEFAULT NULL,
  `Food_type2` varchar(255) DEFAULT NULL,
  `Food_type3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `Driver_ID` int(11) NOT NULL,
  `Licence` varchar(255) DEFAULT NULL,
  `Vehicle` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`Driver_ID`, `Licence`, `Vehicle`) VALUES
(2, 'noe456', '99076'),
(6, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hire`
--

CREATE TABLE `hire` (
  `Clientid` int(11) DEFAULT NULL,
  `Workerid` int(11) DEFAULT NULL,
  `Duration` int(11) DEFAULT NULL,
  `Cost` float DEFAULT NULL,
  `Status` enum('Accepted','Rejected','Pending') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hire`
--

INSERT INTO `hire` (`Clientid`, `Workerid`, `Duration`, `Cost`, `Status`) VALUES
(1, 2, 2, 500, 'Accepted'),
(1, 5, 1, 400, 'Accepted'),
(1, 3, 1, 200, 'Accepted'),
(1, 6, 2, 100, 'Accepted'),
(1, 7, 3, 100, 'Accepted'),
(1, 8, 3, 100, 'Accepted');

-- --------------------------------------------------------

--
-- Table structure for table `nanny`
--

CREATE TABLE `nanny` (
  `Nanny_ID` int(11) NOT NULL,
  `Skill1` varchar(255) DEFAULT NULL,
  `Skill2` varchar(255) DEFAULT NULL,
  `Skill3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nanny`
--

INSERT INTO `nanny` (`Nanny_ID`, `Skill1`, `Skill2`, `Skill3`) VALUES
(5, NULL, NULL, NULL),
(7, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `Payment_Clientid` int(11) DEFAULT NULL,
  `Payment_Workerid` int(11) DEFAULT NULL,
  `Cost` float DEFAULT NULL,
  `Status` enum('paid','unpaid') DEFAULT 'unpaid',
  `Method` enum('Mobile banking','Card','Cash') DEFAULT 'Mobile banking'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`Payment_Clientid`, `Payment_Workerid`, `Cost`, `Status`, `Method`) VALUES
(1, 2, 500, 'paid', ''),
(1, 5, 400, 'paid', ''),
(1, 3, 200, 'paid', ''),
(1, 6, 100, 'paid', ''),
(1, 7, 100, 'paid', ''),
(1, 8, 100, 'paid', '');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `Clientid` int(11) DEFAULT NULL,
  `Workerid` int(11) DEFAULT NULL,
  `Rating` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `Clientid` int(11) DEFAULT NULL,
  `Workerid` int(11) DEFAULT NULL,
  `Comment` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `security_guard`
--

CREATE TABLE `security_guard` (
  `Security_guard_ID` int(11) NOT NULL,
  `Shift` enum('Night','Day','Both') DEFAULT 'Day',
  `Location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `security_guard`
--

INSERT INTO `security_guard` (`Security_guard_ID`, `Shift`, `Location`) VALUES
(3, 'Day', NULL),
(8, 'Day', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `Email_Phone` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `Email_Phone`, `Password`, `Type`) VALUES
(1, '1', '1', 'client'),
(2, '2', '2', 'worker'),
(3, '3', '3', 'worker'),
(4, '4', '4', 'admin'),
(5, '5', '5', 'worker'),
(6, '6', '6', 'worker'),
(7, '9', '9', 'worker'),
(8, '10', '10', 'worker'),
(9, '11', '11', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `worker`
--

CREATE TABLE `worker` (
  `Worker_ID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `Gender` varchar(255) DEFAULT NULL,
  `Type` varchar(255) DEFAULT NULL,
  `Status` enum('Inactive','Active') DEFAULT 'Active',
  `Rating` float DEFAULT NULL,
  `Experience_year` int(11) DEFAULT NULL,
  `Duration` int(11) DEFAULT NULL,
  `Type_Updated` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `worker`
--

INSERT INTO `worker` (`Worker_ID`, `Name`, `Age`, `Gender`, `Type`, `Status`, `Rating`, `Experience_year`, `Duration`, `Type_Updated`) VALUES
(2, 'hu', 24, 'Male', 'Driver', 'Inactive', NULL, 4, NULL, 1),
(3, NULL, NULL, NULL, 'Security Guard', 'Inactive', NULL, NULL, NULL, 1),
(5, NULL, NULL, NULL, 'Nanny', 'Inactive', NULL, NULL, NULL, 1),
(6, NULL, NULL, NULL, 'Driver', 'Inactive', NULL, NULL, NULL, 1),
(7, NULL, NULL, NULL, 'Nanny', 'Inactive', NULL, NULL, NULL, 1),
(8, NULL, NULL, NULL, 'Security Guard', 'Inactive', NULL, NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Admin_ID`);

--
-- Indexes for table `cancel_request`
--
ALTER TABLE `cancel_request`
  ADD KEY `Clientid` (`Clientid`),
  ADD KEY `Adminid` (`Adminid`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`Client_ID`);

--
-- Indexes for table `complain`
--
ALTER TABLE `complain`
  ADD KEY `Clientid` (`Clientid`),
  ADD KEY `Adminid` (`Adminid`);

--
-- Indexes for table `cook`
--
ALTER TABLE `cook`
  ADD PRIMARY KEY (`Cook_ID`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`Driver_ID`);

--
-- Indexes for table `hire`
--
ALTER TABLE `hire`
  ADD KEY `Clientid` (`Clientid`),
  ADD KEY `Workerid` (`Workerid`);

--
-- Indexes for table `nanny`
--
ALTER TABLE `nanny`
  ADD PRIMARY KEY (`Nanny_ID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD KEY `Payment_Clientid` (`Payment_Clientid`),
  ADD KEY `Payment_Workerid` (`Payment_Workerid`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD KEY `Clientid` (`Clientid`),
  ADD KEY `Workerid` (`Workerid`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD KEY `Clientid` (`Clientid`),
  ADD KEY `Workerid` (`Workerid`);

--
-- Indexes for table `security_guard`
--
ALTER TABLE `security_guard`
  ADD PRIMARY KEY (`Security_guard_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Email_Phone` (`Email_Phone`);

--
-- Indexes for table `worker`
--
ALTER TABLE `worker`
  ADD PRIMARY KEY (`Worker_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`Admin_ID`) REFERENCES `user` (`id`);

--
-- Constraints for table `cancel_request`
--
ALTER TABLE `cancel_request`
  ADD CONSTRAINT `cancel_request_ibfk_1` FOREIGN KEY (`Clientid`) REFERENCES `client` (`Client_ID`),
  ADD CONSTRAINT `cancel_request_ibfk_2` FOREIGN KEY (`Adminid`) REFERENCES `admin` (`Admin_ID`);

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`Client_ID`) REFERENCES `user` (`id`);

--
-- Constraints for table `complain`
--
ALTER TABLE `complain`
  ADD CONSTRAINT `complain_ibfk_1` FOREIGN KEY (`Clientid`) REFERENCES `client` (`Client_ID`),
  ADD CONSTRAINT `complain_ibfk_2` FOREIGN KEY (`Adminid`) REFERENCES `admin` (`Admin_ID`);

--
-- Constraints for table `cook`
--
ALTER TABLE `cook`
  ADD CONSTRAINT `cook_ibfk_1` FOREIGN KEY (`Cook_ID`) REFERENCES `worker` (`Worker_ID`);

--
-- Constraints for table `driver`
--
ALTER TABLE `driver`
  ADD CONSTRAINT `driver_ibfk_1` FOREIGN KEY (`Driver_ID`) REFERENCES `worker` (`Worker_ID`);

--
-- Constraints for table `hire`
--
ALTER TABLE `hire`
  ADD CONSTRAINT `hire_ibfk_1` FOREIGN KEY (`Clientid`) REFERENCES `client` (`Client_ID`),
  ADD CONSTRAINT `hire_ibfk_2` FOREIGN KEY (`Workerid`) REFERENCES `worker` (`Worker_ID`);

--
-- Constraints for table `nanny`
--
ALTER TABLE `nanny`
  ADD CONSTRAINT `nanny_ibfk_1` FOREIGN KEY (`Nanny_ID`) REFERENCES `worker` (`Worker_ID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`Payment_Clientid`) REFERENCES `client` (`Client_ID`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`Payment_Workerid`) REFERENCES `worker` (`Worker_ID`);

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`Clientid`) REFERENCES `client` (`Client_ID`),
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`Workerid`) REFERENCES `worker` (`Worker_ID`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`Clientid`) REFERENCES `client` (`Client_ID`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`Workerid`) REFERENCES `worker` (`Worker_ID`);

--
-- Constraints for table `security_guard`
--
ALTER TABLE `security_guard`
  ADD CONSTRAINT `security_guard_ibfk_1` FOREIGN KEY (`Security_guard_ID`) REFERENCES `worker` (`Worker_ID`);

--
-- Constraints for table `worker`
--
ALTER TABLE `worker`
  ADD CONSTRAINT `worker_ibfk_1` FOREIGN KEY (`Worker_ID`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
