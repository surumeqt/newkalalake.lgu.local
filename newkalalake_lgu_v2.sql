-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2025 at 01:07 PM
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
-- Database: `newkalalake_lgu_v2`
--

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `case_id` int(11) NOT NULL,
  `case_number` varchar(60) NOT NULL,
  `case_title` varchar(60) NOT NULL,
  `case_nature` enum('civil','criminal') NOT NULL,
  `complainant_name` varchar(60) NOT NULL,
  `complainant_address` varchar(60) NOT NULL,
  `respondent_name` varchar(60) NOT NULL,
  `respondent_address` varchar(60) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cases`
--

INSERT INTO `cases` (`case_id`, `case_number`, `case_title`, `case_nature`, `complainant_name`, `complainant_address`, `respondent_name`, `respondent_address`, `created_at`) VALUES
(43, 'NK-01-01-25', 'Pambabastos/Death threat', 'criminal', 'Marc Alexis Gapul', '#164 shabu street, calapacuan, shibuya', 'Mark Torres', '#164 shabu street, calapacuan, shibuya', '2025-10-05 13:29:09'),
(44, 'NK-02-01-25', 'INAWAY/KINAGAT', 'civil', 'Marc Alexis Gapul', '#164 shabu street, calapacuan, shibuya', 'Kevin Dulay', 'Subic, Pampanga', '2025-10-05 13:42:14');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `document_id` int(60) NOT NULL,
  `document_summary` text NOT NULL,
  `document_path` tinytext NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `case_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`document_id`, `document_summary`, `document_path`, `created_at`, `case_id`) VALUES
(35, '', 'case_68e20225946f1.pdf', '2025-10-05 13:29:10', 43),
(36, '', 'case_68e2053626aa1.pdf', '2025-10-05 13:42:15', 44);

-- --------------------------------------------------------

--
-- Table structure for table `hearings`
--

CREATE TABLE `hearings` (
  `hearing_id` int(60) NOT NULL,
  `hearing_order` enum('1st Hearing','2nd Hearing','3rd Hearing') NOT NULL DEFAULT '1st Hearing',
  `hearing_status` enum('Settled','Dismissed','Ongoing','CFA','Withdrawn','Rehearing') NOT NULL DEFAULT 'Ongoing',
  `hearing_time` varchar(60) NOT NULL,
  `hearing_date` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `case_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hearings`
--

INSERT INTO `hearings` (`hearing_id`, `hearing_order`, `hearing_status`, `hearing_time`, `hearing_date`, `created_at`, `case_id`) VALUES
(26, '1st Hearing', 'Ongoing', '10:00', '2025-01-02', '2025-10-05 13:29:09', 43),
(27, '1st Hearing', 'Ongoing', '13:00', '2025-01-03', '2025-10-05 13:42:14', 44);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(60) NOT NULL,
  `user_name` varchar(60) NOT NULL,
  `user_pass` varchar(60) NOT NULL,
  `user_position` varchar(60) NOT NULL,
  `user_role` enum('admin','lupon','office') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `user_name`, `user_pass`, `user_position`, `user_role`, `created_at`) VALUES
(1, '202310261', 'kenbonzaiii@lgu.local', '$2a$12$a6s867iXBC6.n3SSIjx84OgqMhDMFFmPtjTN6q4bt0KbaPS5/7VTi', 'creator', 'lupon', '2025-09-24 19:43:48'),
(2, '202310262', 'bonzaiii@lgu.local', '$2a$12$a6s867iXBC6.n3SSIjx84OgqMhDMFFmPtjTN6q4bt0KbaPS5/7VTi', 'creator', 'admin', '2025-09-24 19:43:48'),
(3, '202310263', 'kenzaiii@lgu.local', '$2a$12$a6s867iXBC6.n3SSIjx84OgqMhDMFFmPtjTN6q4bt0KbaPS5/7VTi', 'creator', 'office', '2025-09-24 19:43:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`case_id`),
  ADD UNIQUE KEY `case_number` (`case_number`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`document_id`),
  ADD KEY `fk_document_case` (`case_id`);

--
-- Indexes for table `hearings`
--
ALTER TABLE `hearings`
  ADD PRIMARY KEY (`hearing_id`),
  ADD KEY `fk_hearing_case` (`case_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `case_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `document_id` int(60) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `hearings`
--
ALTER TABLE `hearings`
  MODIFY `hearing_id` int(60) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `fk_document_case` FOREIGN KEY (`case_id`) REFERENCES `cases` (`case_id`) ON DELETE CASCADE;

--
-- Constraints for table `hearings`
--
ALTER TABLE `hearings`
  ADD CONSTRAINT `fk_hearing_case` FOREIGN KEY (`case_id`) REFERENCES `cases` (`case_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
