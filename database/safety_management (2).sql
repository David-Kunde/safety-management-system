-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2025 at 11:33 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `safety_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `incidents_reports`
--

CREATE TABLE `incidents_reports` (
  `incident_id` int(11) NOT NULL,
  `reporter_id` varchar(255) NOT NULL,
  `incident_title` varchar(255) NOT NULL,
  `incident_type` enum('Hazard','Accident','Incident') NOT NULL,
  `description` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `date_reported` timestamp NOT NULL DEFAULT current_timestamp(),
  `severity_level` enum('Low','Medium','High') NOT NULL,
  `risk_score` int(11) DEFAULT NULL,
  `status` enum('Open','In Progress','Resolved','Closed') DEFAULT 'Open',
  `file_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incidents_reports`
--

INSERT INTO `incidents_reports` (`incident_id`, `reporter_id`, `incident_title`, `incident_type`, `description`, `location`, `date_reported`, `severity_level`, `risk_score`, `status`, `file_path`) VALUES
(9, '1', 'Sint omnis sit minim', 'Hazard', 'khawedb jdjbd djkdhj', 'mansonry plant', '2025-03-06 23:00:00', 'Medium', 0, '', 'incident_report_files/.trashed-1740816158-IMG20250128125450.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `type` enum('Hazard','Violation','Emergency','system nptification') NOT NULL,
  `reported_by` varchar(255) NOT NULL,
  `meant_for` varchar(255) NOT NULL,
  `details` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `staff_id` varchar(255) NOT NULL,
  `is_registered` enum('0','1') NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) NOT NULL,
  `profile_picture_path` varchar(255) NOT NULL,
  `role` enum('anonymous','employee','safety officer','admin') NOT NULL DEFAULT 'anonymous',
  `section` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `job_title` varchar(255) DEFAULT NULL,
  `date_of_employment` date DEFAULT NULL,
  `home_address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `staff_id`, `is_registered`, `password`, `first_name`, `middle_name`, `surname`, `profile_picture_path`, `role`, `section`, `department`, `phone`, `job_title`, `date_of_employment`, `home_address`) VALUES
(1, 'precious@gmail.com', '', '1', '$2y$10$gzABUbpTR16FQqvHu9GeeuIol8wcsZ2smt0.pDcMOK1SbJrOO3r76', 'Precious', 'Alisha', 'Peters', 'assets/img/users/joy.jpg', 'admin', 'Admin', 'Welfare', '08012345678', NULL, '2016-03-08', '23 thomas akin street, Alagomeji Yaba Lagos'),
(2, 'joy@gmail.com', '', '1', '$2y$10$9vBY7jb97.qyx7s.GbKRmeA34ERdPt50fs4uRSq/yMDTUpNEUndCq', 'Joy', 'Dooshima', 'Williams', 'assets/img/users/precious.jpg', 'safety officer', 'Safety', 'Health & Safety', '08122334455', 'Safety Officer', '2018-05-14', '45 Gwarinpa Estate, Abuja'),
(3, 'sesugh@gmail.com', '', '1', '$2y$10$ohgJfOfgU7D5/C7Ni.DZZeYYqeOaZOH74M0uj.aNYGvQaFlcmCMeG', 'Sesugh', 'Terwase', 'Anase', 'assets/img/users/sesugh.jpg', 'employee', 'Site Operations', 'Engineering', '08031234567', 'Site Engineer', '2020-06-12', '12 Construction Ave, Lagos'),
(4, 'agber@gmail.com', '', '1', '$2y$10$s4hNIE03Q0mSVWX96kZ/EOan3O8tw4xLNz.MrIPmFf7VHJbg8gHka', 'Agber', 'Peter', 'Tsavnum', 'assets/img/users/agber.jpg', 'employee', 'Safety', 'Health & Safety', '08123456789', 'Safety Inspector', '2019-09-18', '67 Wuse, Abuja'),
(5, 'shima@gmail.com', '', '1', '$2y$10$C7PSecziHp8Aaxt5NNweqOsTBrbmiYvHkB3JYzpCsXxEOfFJFHVqG', 'Kundu', 'Shima', 'Kaase', 'assets/img/users/kudus.jpg', 'employee', 'Procurement', 'Logistics & Supply', '08092345678', 'Procurement Officer', '2021-02-25', '23 Ojota Road, Lagos'),
(6, 'halima@gmail.com', '', '1', '$2y$10$wKKYgh0J.9KvwQ2vwNpuDuk3StdPgNtMIfcJuu5S7PfsL1NE5eKmi', 'Abubakar', 'Halima', 'Aishat', 'assets/img/users/aisha.jpg', 'employee', 'Admin', 'Human Resources', '09087654321', 'HR Manager', '2018-11-10', '16 Wuse 2, Abuja'),
(7, 'dooter@gmail.com', '', '1', '$2y$10$GqftxdKqMmVEoheQRuh6wu9iSEDBzc538NPBVjVqMjCp31hss8e4K', 'dooter', 'mimidoo', 'Aondoakaa', 'assets/img/users/dooter.jpg', 'employee', 'Surveying', 'Engineering', '08134567890', 'Surveyor', '2020-07-22', '15 Jabi, Abuja'),
(8, 'gundu@gmail.com', '', '1', '$2y$10$D2mAPrI4qvX9Dz84K/IAu.75AFg1/2PVBUNSu0V4.TiYMn3PAdHdO', 'Gundu', 'Chomo', 'Kuve', 'assets/img/users/gundu.jpg', 'employee', 'Electrical', 'Engineering', '08056781234', 'Electrical Engineer', '2017-12-05', '28 Lekki Phase 1, Lagos'),
(9, 'daniel@gmail.com', '', '1', '$2y$10$kaosHhQjgOrgsRTpEpXYi.iPuqn.xWismmT2UPbdG51bnKER1l8qO', 'Daniel', 'Chijioke', 'Obi', 'assets/img/users/daniel.jpg', 'employee', 'Mechanical', 'Engineering', '08178901234', 'Mechanical Engineer', '2019-04-15', '32 Garki, Abuja');

-- --------------------------------------------------------

--
-- Table structure for table `violations`
--

CREATE TABLE `violations` (
  `violation_id` int(11) NOT NULL,
  `violator_email` varchar(255) NOT NULL,
  `violator_staff_id` varchar(50) NOT NULL,
  `reporter_email` varchar(255) NOT NULL,
  `violation_type` enum('1st degree','2nd degree','3rd degree') NOT NULL,
  `description` text NOT NULL,
  `date_reported` datetime DEFAULT current_timestamp(),
  `status` enum('resolved','pending') NOT NULL DEFAULT 'pending',
  `media_path` varchar(2083) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `incidents_reports`
--
ALTER TABLE `incidents_reports`
  ADD PRIMARY KEY (`incident_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `violations`
--
ALTER TABLE `violations`
  ADD PRIMARY KEY (`violation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `incidents_reports`
--
ALTER TABLE `incidents_reports`
  MODIFY `incident_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `violations`
--
ALTER TABLE `violations`
  MODIFY `violation_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
