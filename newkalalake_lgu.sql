-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2025 at 12:02 PM
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

-- --------------------------------------------------------

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

-- --------------------------------------------------------

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

-- --------------------------------------------------------

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

--
-- Dumping data for table `residents`
--

INSERT INTO `residents` (`resident_id`, `first_name`, `middle_name`, `last_name`, `suffix`, `birthday`, `age`, `gender`, `civil_status`, `address`, `contact_number`, `email`, `photo`, `created_at`) VALUES
(249449, 'userFN2', 'userMN2', 'userLN2', '', '2017-07-07', 8, 'Female', 'Married', '123, Northon, New Kalalake, Olongapo City', '', '', NULL, '2025-07-17 06:33:54'),
(930179, 'david', 'baloloy', 'candido', '', '2020-03-04', 5, 'Male', 'Single', '148, Murphy, New Kalalake, Olongapo City', '', '', NULL, '2025-07-17 05:59:25'),
(2025000001, 'Juan', 'Santos', 'Dela Cruz', NULL, '1990-05-15', 35, 'Male', 'Married', 'Purok 1, Rizal St., Brgy. Barretto, Olongapo City', '09171234567', 'juan.s@example.com', NULL, '2025-07-17 00:00:00'),
(2025000002, 'Maria', 'Reyes', 'Garcia', NULL, '1988-11-20', 36, 'Female', 'Single', 'Purok 2, Magsaysay Ave., Brgy. East Bajac-Bajac, Olongapo City', '09187654321', 'maria.r@example.com', NULL, '2025-07-17 00:05:00'),
(2025000003, 'Jose', 'Lim', 'Tan', 'Jr.', '1975-03-10', 50, 'Male', 'Married', 'Purok 3, Quezon St., Brgy. Pag-asa, Olongapo City', '09192345678', 'jose.l@example.com', NULL, '2025-07-17 00:10:00'),
(2025000004, 'Ana', 'Cruz', 'Sy', NULL, '1995-07-01', 30, 'Female', 'Single', 'Purok 4, Gordon Ave., Brgy. Sta. Rita, Olongapo City', '09203456789', 'ana.c@example.com', NULL, '2025-07-17 00:15:00'),
(2025000005, 'Pedro', 'Gonzales', 'Lee', NULL, '1980-01-25', 45, 'Male', 'Married', 'Purok 5, Gen. Luna St., Brgy. Kalaklan, Olongapo City', '09214567890', 'pedro.g@example.com', NULL, '2025-07-17 00:20:00'),
(2025000006, 'Sofia', 'Dela Cruz', 'Chua', NULL, '1992-09-03', 32, 'Female', 'Married', 'Purok 6, Gov. Vicente Magsaysay Ave., Brgy. New Cabalan, Olongapo City', '09225678901', 'sofia.d@example.com', NULL, '2025-07-17 00:25:00'),
(2025000007, 'Miguel', 'Aquino', 'Go', NULL, '1970-12-12', 54, 'Male', 'Widowed', 'Purok 7, Anonas St., Brgy. Old Cabalan, Olongapo City', '09236789012', 'miguel.a@example.com', NULL, '2025-07-17 00:30:00'),
(2025000008, 'Isabella', 'Mercado', 'Lim', NULL, '1998-04-28', 27, 'Female', 'Single', 'Purok 8, Sampaguita St., Brgy. Asinan, Olongapo City', '09247890123', 'isabella.m@example.com', NULL, '2025-07-17 00:35:00'),
(2025000009, 'Carlo', 'Rodriguez', 'Cruz', NULL, '1985-06-05', 40, 'Male', 'Married', 'Purok 9, Daisy St., Brgy. Barretto, Olongapo City', '09258901234', 'carlo.r@example.com', NULL, '2025-07-17 00:40:00'),
(2025000010, 'Andrea', 'Perez', 'Diaz', NULL, '1993-10-18', 31, 'Female', 'Single', 'Purok 10, Orchid St., Brgy. East Bajac-Bajac, Olongapo City', '09269012345', 'andrea.p@example.com', NULL, '2025-07-17 00:45:00'),
(2025000011, 'Daniel', 'Gomez', 'Lopez', NULL, '1978-02-22', 47, 'Male', 'Married', 'Purok 11, Sunflower St., Brgy. Pag-asa, Olongapo City', '09270123456', 'daniel.g@example.com', NULL, '2025-07-17 00:50:00'),
(2025000012, 'Bianca', 'Torres', 'Navarro', NULL, '1991-08-08', 33, 'Female', '', 'Purok 12, Rose St., Brgy. Sta. Rita, Olongapo City', '09281234567', 'bianca.t@example.com', NULL, '2025-07-17 00:55:00'),
(2025000013, 'Ethan', 'Villanueva', 'Fernandez', NULL, '1983-04-01', 42, 'Male', 'Single', 'Purok 13, Lily St., Brgy. Kalaklan, Olongapo City', '09292345678', 'ethan.v@example.com', NULL, '2025-07-17 01:00:00'),
(2025000014, 'Chloe', 'Ramirez', 'Santos', NULL, '1996-11-29', 28, 'Female', 'Married', 'Purok 14, Jasmine St., Brgy. New Cabalan, Olongapo City', '09303456789', 'chloe.r@example.com', NULL, '2025-07-17 01:05:00'),
(2025000015, 'Joshua', 'Santiago', 'Mendoza', NULL, '1972-07-17', 53, 'Male', 'Married', 'Purok 15, Bougainvillea St., Brgy. Old Cabalan, Olongapo City', '09314567890', 'joshua.s@example.com', NULL, '2025-07-17 01:10:00'),
(2025000016, 'Samantha', 'Cruz', 'Aquino', NULL, '1999-02-14', 26, 'Female', 'Single', 'Purok 16, Camia St., Brgy. Asinan, Olongapo City', '09325678901', 'samantha.c@example.com', NULL, '2025-07-17 01:15:00'),
(2025000017, 'Kevin', 'Dizon', 'Castro', NULL, '1987-09-09', 37, 'Male', 'Married', 'Purok 17, Ylang-Ylang St., Brgy. Barretto, Olongapo City', '09336789012', 'kevin.d@example.com', NULL, '2025-07-17 01:20:00'),
(2025000018, 'Michelle', 'Manalo', 'Reyes', NULL, '1994-01-05', 31, 'Female', 'Married', 'Purok 18, Adelfa St., Brgy. East Bajac-Bajac, Olongapo City', '09347890123', 'michelle.m@example.com', NULL, '2025-07-17 01:25:00'),
(2025000019, 'Aaron', 'Valdez', 'Gonzales', NULL, '1979-05-30', 46, 'Male', 'Single', 'Purok 19, San Roque St., Brgy. Pag-asa, Olongapo City', '09358901234', 'aaron.v@example.com', NULL, '2025-07-17 01:30:00'),
(2025000020, 'Nicole', 'Garcia', 'Perez', NULL, '1997-12-25', 27, 'Female', 'Single', 'Purok 20, Sto. Rosario St., Brgy. Sta. Rita, Olongapo City', '09369012345', 'nicole.g@example.com', NULL, '2025-07-17 01:35:00'),
(2025000021, 'Bryan', 'Fabian', 'Sison', NULL, '1982-08-11', 43, 'Male', 'Married', 'Purok 21, Fatima St., Brgy. Kalaklan, Olongapo City', '09370123456', 'bryan.f@example.com', NULL, '2025-07-17 01:40:00'),
(2025000022, 'Grace', 'Alcantara', 'Abad', NULL, '1990-03-07', 35, 'Female', 'Married', 'Purok 22, Lourdes St., Brgy. New Cabalan, Olongapo City', '09381234567', 'grace.a@example.com', NULL, '2025-07-17 01:45:00'),
(2025000023, 'Christopher', 'Enriquez', 'Lim', NULL, '1970-10-02', 54, 'Male', 'Married', 'Purok 23, Carmina St., Brgy. Old Cabalan, Olongapo City', '09392345678', 'chris.e@example.com', NULL, '2025-07-17 01:50:00'),
(2025000024, 'Joy', 'Corpuz', 'David', NULL, '1995-06-19', 30, 'Female', 'Single', 'Purok 24, Gloria St., Brgy. Asinan, Olongapo City', '09403456789', 'joy.c@example.com', NULL, '2025-07-17 01:55:00'),
(2025000025, 'Mark', 'Ferrer', 'Aquino', NULL, '1980-12-01', 44, 'Male', '', 'Purok 25, Mabini St., Brgy. Barretto, Olongapo City', '09414567890', 'mark.f@example.com', NULL, '2025-07-17 02:00:00'),
(2025000026, 'Patricia', 'Gutierrez', 'Espiritu', NULL, '1992-04-20', 33, 'Female', 'Single', 'Purok 26, Bonifacio St., Brgy. East Bajac-Bajac, Olongapo City', '09425678901', 'patricia.g@example.com', NULL, '2025-07-17 02:05:00'),
(2025000027, 'Ronald', 'Santiago', 'Francisco', NULL, '1976-01-14', 49, 'Male', 'Married', 'Purok 27, Del Pilar St., Brgy. Pag-asa, Olongapo City', '09436789012', 'ronald.s@example.com', NULL, '2025-07-17 02:10:00'),
(2025000028, 'Judy Ann', 'Cruz', 'Reyes', NULL, '1998-08-01', 27, 'Female', 'Married', 'Purok 28, Burgos St., Brgy. Sta. Rita, Olongapo City', '09447890123', 'judy.a@example.com', NULL, '2025-07-17 02:15:00'),
(2025000029, 'Raymond', 'Torres', 'Zulueta', NULL, '1984-03-29', 41, 'Male', 'Single', 'Purok 29, Lapu-Lapu St., Brgy. Kalaklan, Olongapo City', '09458901234', 'raymond.t@example.com', NULL, '2025-07-17 02:20:00'),
(2025000030, 'Erica', 'Montes', 'Agustin', NULL, '1993-11-11', 31, 'Female', 'Single', 'Purok 30, Quezon Ave., Brgy. New Cabalan, Olongapo City', '09469012345', 'erica.m@example.com', NULL, '2025-07-17 02:25:00'),
(2025000031, 'Gary', 'Molina', 'Bautista', NULL, '1971-06-03', 54, 'Male', 'Widowed', 'Purok 31, A. Bonifacio St., Brgy. Old Cabalan, Olongapo City', '09470123456', 'gary.m@example.com', NULL, '2025-07-17 02:30:00'),
(2025000032, 'Hazel', 'Villafuerte', 'Concepcion', NULL, '1996-09-24', 28, 'Female', 'Married', 'Purok 32, Iba-Zambales Road, Brgy. Asinan, Olongapo City', '09481234567', 'hazel.v@example.com', NULL, '2025-07-17 02:35:00'),
(2025000033, 'Ivan', 'Lim', 'Domingo', NULL, '1986-02-18', 39, 'Male', 'Single', 'Purok 33, Olongapo-Gapan Road, Brgy. Barretto, Olongapo City', '09492345678', 'ivan.l@example.com', NULL, '2025-07-17 02:40:00'),
(2025000034, 'Jessica', 'Ramos', 'Eugenio', NULL, '1994-07-07', 31, 'Female', 'Single', 'Purok 34, Rizal Hwy., Brgy. East Bajac-Bajac, Olongapo City', '09503456789', 'jessica.r@example.com', NULL, '2025-07-17 02:45:00'),
(2025000035, 'Leo', 'Gonzales', 'Flores', NULL, '1977-04-22', 48, 'Male', 'Married', 'Purok 35, Subic-Tipo Road, Brgy. Pag-asa, Olongapo City', '09514567890', 'leo.g@example.com', NULL, '2025-07-17 02:50:00'),
(2025000036, 'Karen', 'Dela Rosa', 'Gomez', NULL, '1991-09-01', 33, 'Female', 'Married', 'Purok 36, Airport Rd., Brgy. Sta. Rita, Olongapo City', '09525678901', 'karen.d@example.com', NULL, '2025-07-17 02:55:00'),
(2025000037, 'Patrick', 'Alvarez', 'Hernandez', NULL, '1983-12-15', 41, 'Male', 'Single', 'Purok 37, Tabacuhan St., Brgy. Kalaklan, Olongapo City', '09536789012', 'patrick.a@example.com', NULL, '2025-07-17 03:00:00'),
(2025000038, 'Monica', 'Soriano', 'Ignacio', NULL, '1999-05-08', 26, 'Female', 'Single', 'Purok 38, Bgy. Hall Rd., Brgy. New Cabalan, Olongapo City', '09547890123', 'monica.s@example.com', NULL, '2025-07-17 03:05:00'),
(2025000039, 'Vincent', 'Castro', 'Javier', NULL, '1974-07-29', 50, 'Male', 'Married', 'Purok 39, Public Market Rd., Brgy. Old Cabalan, Olongapo City', '09558901234', 'vincent.c@example.com', NULL, '2025-07-17 03:10:00'),
(2025000040, 'Christine', 'Cruz', 'Kato', NULL, '1997-03-17', 28, 'Female', 'Single', 'Purok 40, National Hwy., Brgy. Asinan, Olongapo City', '09569012345', 'christine.c@example.com', NULL, '2025-07-17 03:15:00');

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

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(20) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `position` varchar(60) NOT NULL,
  `role` enum('admin','frontdesk') NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `position`, `role`, `createdAt`) VALUES
(202410262, 'Kenbonzaiii@local.lgu', '$2y$10$ik0t1Av2Lqn2/hqCqcASnu6C1mE11iGsL/hKo1KrNOzQwkR3LUgWS', 'creator', 'admin', '2025-07-03 13:35:55'),
(2024411263, 'Dave@local.lgu', '$2y$10$5fBQnzcDKwXmDwf0PBCXfeqZ2pkf2mZtacrpWYjS8iivUNcJr6XEG', 'creator', 'frontdesk', '2025-07-03 14:27:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`Docket_Case_Number`);

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
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `hearings`
--
ALTER TABLE `hearings`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `summary`
--
ALTER TABLE `summary`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
