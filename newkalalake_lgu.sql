-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2025 at 09:08 AM
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
-- Database: `newkalalake_lgu`
--

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `Docket_Case_Number` varchar(20) NOT NULL,
  `Case_Title` varchar(60) DEFAULT NULL,
  `Complainant_Name` varchar(60) DEFAULT NULL,
  `Complainant_Address` varchar(60) DEFAULT NULL,
  `Respondent_Name` varchar(60) DEFAULT NULL,
  `Respondent_Address` varchar(60) DEFAULT NULL,
  `Case_Type` enum('Criminal','Civil') DEFAULT NULL,
  `filesUploaded` longblob NOT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` int(11) NOT NULL,
  `resident_id` varchar(60) NOT NULL,
  `certificate_type` varchar(60) NOT NULL,
  `purpose` text NOT NULL,
  `fileBlob` longblob DEFAULT NULL,
  `issued_by` varchar(60) DEFAULT NULL,
  `certificate_no` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `ID` int(11) NOT NULL,
  `Docket_Case_Number` varchar(20) DEFAULT NULL,
  `Document_Type` enum('Appeal','Summary') DEFAULT NULL,
  `PDF_File` longblob DEFAULT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `hearings`
--

CREATE TABLE `hearings` (
  `ID` int(11) NOT NULL,
  `Docket_Case_Number` varchar(20) DEFAULT NULL,
  `Hearing_Type` enum('1st Hearing','2nd Hearing','3rd Hearing','Rehearing','Banned') DEFAULT NULL,
  `Hearing_Date` date DEFAULT NULL,
  `Hearing_Time` varchar(60) NOT NULL,
  `Time_Period` varchar(60) NOT NULL,
  `Hearing_Status` enum('Ongoing','Dismissed','Withdrawn','Settled','CFA','Banned','Rehearing') DEFAULT 'Ongoing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `residents`
--

CREATE TABLE `residents` (
  `resident_id` int(11) NOT NULL,
  `first_name` varchar(60) NOT NULL,
  `middle_name` varchar(60) DEFAULT NULL,
  `last_name` varchar(60) NOT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `birthday` date NOT NULL,
  `age` int(20) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `civil_status` enum('Single','Married','Widowed','Separated','Annulled') NOT NULL,
  `address` varchar(100) NOT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `photo` longblob DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `residents_added_info`
--

CREATE TABLE `residents_added_info` (
  `update_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `is_deceased` tinyint(1) DEFAULT 0,
  `deceased_date` date DEFAULT NULL,
  `occupation` enum('Student','Employed','Unemployed') DEFAULT NULL,
  `job_title` varchar(100) DEFAULT NULL,
  `monthly_income` decimal(10,2) DEFAULT NULL,
  `educational_attainment` varchar(100) DEFAULT NULL,
  `father_first_name` varchar(60) DEFAULT NULL,
  `father_middle_name` varchar(60) DEFAULT NULL,
  `father_last_name` varchar(60) DEFAULT NULL,
  `father_suffix` varchar(10) DEFAULT NULL,
  `father_birth_date` date DEFAULT NULL,
  `father_age` int(11) DEFAULT NULL,
  `father_is_deceased` tinyint(1) DEFAULT 0,
  `father_deceased_date` date DEFAULT NULL,
  `father_occupation` enum('Student','Employed','Unemployed') DEFAULT NULL,
  `father_educational_attainment` varchar(100) DEFAULT NULL,
  `father_contact_no` varchar(20) DEFAULT NULL,
  `mother_first_name` varchar(60) DEFAULT NULL,
  `mother_middle_name` varchar(60) DEFAULT NULL,
  `mother_last_name` varchar(60) DEFAULT NULL,
  `mother_suffix` varchar(10) DEFAULT NULL,
  `mother_birth_date` date DEFAULT NULL,
  `mother_age` int(11) DEFAULT NULL,
  `mother_is_deceased` tinyint(1) DEFAULT 0,
  `mother_deceased_date` date DEFAULT NULL,
  `mother_occupation` enum('Student','Employed','Unemployed') DEFAULT NULL,
  `mother_educational_attainment` varchar(100) DEFAULT NULL,
  `mother_contact_no` varchar(20) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `emergency_contact_name` varchar(255) DEFAULT NULL,
  `emergency_contact_relationship` varchar(50) DEFAULT NULL,
  `emergency_contact_no` varchar(20) DEFAULT NULL,
  `have_a_business` tinyint(1) DEFAULT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `business_address` varchar(255) DEFAULT NULL,
  `num_brothers` int(11) DEFAULT NULL,
  `num_sisters` int(11) DEFAULT NULL,
  `order_of_birth` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `summary`
--

CREATE TABLE `summary` (
  `ID` int(11) NOT NULL,
  `Docket_Case_Number` varchar(20) NOT NULL,
  `Hearing_Type` enum('1st Hearing','2nd Hearing','3rd Hearing') NOT NULL,
  `Hearing_Status` enum('Rehearing','Dismissed','Withdrawn','Settled','CFA','Banned') NOT NULL,
  `Hearing_Date` varchar(60) NOT NULL,
  `Document_Type` set('Summary') DEFAULT 'Summary',
  `PDF_File` longblob NOT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(20) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `position` varchar(60) NOT NULL,
  `role` enum('admin','lupon') NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `position`, `role`, `createdAt`) VALUES
(202011090, 'Dave@local.lgu', '$2y$10$5fBQnzcDKwXmDwf0PBCXfeqZ2pkf2mZtacrpWYjS8iivUNcJr6XEG', 'creator', 'admin', '2025-07-03 14:27:32'),
(202310262, 'Kenbonzaiii@local.lgu', '$2y$10$ik0t1Av2Lqn2/hqCqcASnu6C1mE11iGsL/hKo1KrNOzQwkR3LUgWS', 'creator', 'lupon', '2025-07-03 13:35:55'),
(202508101, 'reymar@local.lgu', '$2y$10$kYOqxrE3jcuNCRRaC6KZvutewrnjxOjy7Wgp0uIFNj9ZgK6g5rNRu', 'frontdesk', 'admin', '2025-08-01 03:50:49'),
(202508102, 'rochelle@local.lgu', '$2y$10$q0stgw9912X6zrKsM9VumuO2KJ.FdNhgGBUxrdJQyFHd7WZo4gnU.', 'frontdesk', 'admin', '2025-08-01 03:50:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`Docket_Case_Number`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Docket_Case_Number` (`Docket_Case_Number`);

--
-- Indexes for table `hearings`
--
ALTER TABLE `hearings`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Docket_Case_Number` (`Docket_Case_Number`);

--
-- Indexes for table `residents`
--
ALTER TABLE `residents`
  ADD PRIMARY KEY (`resident_id`);

--
-- Indexes for table `residents_added_info`
--
ALTER TABLE `residents_added_info`
  ADD PRIMARY KEY (`update_id`),
  ADD KEY `resident_id` (`resident_id`);

--
-- Indexes for table `summary`
--
ALTER TABLE `summary`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `hearings`
--
ALTER TABLE `hearings`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `residents_added_info`
--
ALTER TABLE `residents_added_info`
  MODIFY `update_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `summary`
--
ALTER TABLE `summary`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2024411264;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`Docket_Case_Number`) REFERENCES `cases` (`Docket_Case_Number`) ON DELETE CASCADE;

--
-- Constraints for table `hearings`
--
ALTER TABLE `hearings`
  ADD CONSTRAINT `hearings_ibfk_1` FOREIGN KEY (`Docket_Case_Number`) REFERENCES `cases` (`Docket_Case_Number`) ON DELETE CASCADE;

--
-- Constraints for table `residents_added_info`
--
ALTER TABLE `residents_added_info`
  ADD CONSTRAINT `residents_added_info_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `residents` (`resident_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
