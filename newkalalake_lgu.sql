-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2025 at 02:43 PM
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
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `certificate_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `certificate_type_id` int(11) NOT NULL,
  `issuance_date` date NOT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `generated_pdf_data` longblob DEFAULT NULL,
  `issued_by_user_id` int(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificate_data`
--

CREATE TABLE `certificate_data` (
  `data_id` int(11) NOT NULL,
  `certificate_id` int(11) NOT NULL,
  `data_key` varchar(100) NOT NULL,
  `data_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificate_types`
--

CREATE TABLE `certificate_types` (
  `certificate_type_id` int(11) NOT NULL,
  `type_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certificate_types`
--

INSERT INTO `certificate_types` (`certificate_type_id`, `type_name`, `description`) VALUES
(1, 'Barangay Residency', 'Confirms a resident\'s residency in the barangay.'),
(2, 'Certificate of Non-Residency', 'Certifies that a person is not a resident of the barangay.'),
(3, 'Certificate of Indigency', 'Issued to individuals who are indigent for various purposes, often medical assistance.'),
(4, 'Vehicle Clearance', 'Clearance for a vehicle owned by a resident.'),
(5, 'Barangay Endorsement', 'Endorsement for business or other purposes.'),
(6, 'Barangay Permit', 'General permit issued by the barangay.');

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
  `house_number` varchar(20) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `purok` varchar(100) DEFAULT NULL,
  `barangay` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `is_banned` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `residents`
--

INSERT INTO `residents` (`resident_id`, `first_name`, `middle_name`, `last_name`, `suffix`, `birthday`, `age`, `gender`, `civil_status`, `house_number`, `street`, `purok`, `barangay`, `city`, `contact_number`, `email`, `photo_path`, `is_banned`, `created_at`, `updated_at`) VALUES
(1, 'Maria', 'S.', 'Santos', NULL, '1985-03-10', 40, 'Female', 'Married', '123', 'Acacia St', 'Purok 1', 'New Kalalake', 'Olongapo City', '09171234567', 'maria.santos@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(2, 'Jose', 'L.', 'Reyes', NULL, '1992-07-22', 33, 'Male', 'Single', '45', 'Sampaguita Rd', 'Purok 2', 'Pag-asa', 'Olongapo City', '09187654321', 'jose.reyes@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(3, 'Ana', 'M.', 'Cruz', NULL, '1978-11-05', 47, 'Female', 'Married', '789', 'Mabini Ave', 'Purok 3', 'Barretto', 'Olongapo City', '09191122334', 'ana.cruz@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(4, 'Pedro', 'D.', 'Lim', 'Jr.', '1995-01-30', 30, 'Male', 'Single', '10', 'Orchid St', 'Purok 4', 'Gordon Heights', 'Olongapo City', '09204455667', 'pedro.lim@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(5, 'Sophia', 'G.', 'Mercado', NULL, '1980-09-12', 45, 'Female', 'Widowed', '56', 'Rosewood Dr', 'Purok 5', 'Sta. Rita', 'Olongapo City', '09218899001', 'sophia.mercado@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(6, 'Daniel', 'A.', 'Garcia', NULL, '1988-04-25', 37, 'Male', 'Married', '22', 'Jasmine Blvd', 'Purok 1', 'East Bajac-Bajac', 'Olongapo City', '09223344556', 'daniel.garcia@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(7, 'Isabella', 'F.', 'Martinez', NULL, '1998-02-18', 27, 'Female', 'Single', '87', 'Tulip Lane', 'Purok 2', 'West Bajac-Bajac', 'Olongapo City', '09236677889', 'isabella.martinez@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(8, 'Christian', 'K.', 'Gonzales', NULL, '1975-06-01', 50, 'Male', 'Separated', '333', 'Daisy St', 'Purok 3', 'Olongapo Proper', 'Olongapo City', '09249900112', 'christian.gonzales@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(9, 'Olivia', 'P.', 'Rodriguez', NULL, '1990-10-08', 35, 'Female', 'Married', '99', 'Sunflower Ave', 'Purok 4', 'Asinan', 'Olongapo City', '09252233445', 'olivia.rodriguez@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(10, 'Ethan', 'C.', 'Perez', NULL, '1983-12-03', 42, 'Male', 'Single', '111', 'Lotus Rd', 'Purok 5', 'Wawa', 'Olongapo City', '09265566778', 'ethan.perez@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(11, 'Ava', 'B.', 'Gomez', NULL, '1993-08-14', 32, 'Female', 'Married', '44', 'Pine St', 'Purok 1', 'Bani', 'Olongapo City', '09179876543', 'ava.gomez@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(12, 'Noah', 'J.', 'Torres', NULL, '1987-01-20', 38, 'Male', 'Single', '77', 'Maple Dr', 'Purok 2', 'Kababae', 'Olongapo City', '09183456789', 'noah.torres@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(13, 'Mia', 'E.', 'Aquino', NULL, '1996-03-28', 29, 'Female', 'Married', '555', 'Cedar Ln', 'Purok 3', 'New Asinan', 'Olongapo City', '09190099887', 'mia.aquino@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(14, 'Liam', 'V.', 'Ramos', NULL, '1981-07-07', 44, 'Male', 'Widowed', '66', 'Oak St', 'Purok 4', 'Old Cabalan', 'Olongapo City', '09207766554', 'liam.ramos@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(15, 'Chloe', 'H.', 'Castro', NULL, '1999-04-02', 26, 'Female', 'Single', '888', 'Birch Ave', 'Purok 5', 'New Cabalan', 'Olongapo City', '09214433221', 'chloe.castro@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(16, 'Benjamin', 'N.', 'De Leon', NULL, '1970-11-19', 55, 'Male', 'Married', '12', 'Elm St', 'Purok 1', 'Gordon Heights', 'Olongapo City', '09221122334', 'benjamin.deleon@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(17, 'Ella', 'R.', 'Ferrer', NULL, '1994-06-29', 31, 'Female', 'Single', '345', 'Willow Rd', 'Purok 2', 'Barretto', 'Olongapo City', '09238877665', 'ella.ferrer@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(18, 'Lucas', 'W.', 'Santiago', NULL, '1986-09-09', 39, 'Male', 'Separated', '67', 'Spruce Ln', 'Purok 3', 'Pag-asa', 'Olongapo City', '09245544332', 'lucas.santiago@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(19, 'Grace', 'D.', 'Castañeda', NULL, '1991-05-23', 34, 'Female', 'Married', '90', 'Fir St', 'Purok 4', 'New Kalalake', 'Olongapo City', '09252211009', 'grace.castaneda@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(20, 'Samuel', 'T.', 'Cruz', NULL, '1979-02-11', 46, 'Male', 'Single', '101', 'Poplar Blvd', 'Purok 5', 'Sta. Rita', 'Olongapo City', '09269988776', 'samuel.cruz@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(21, 'Lily', 'Z.', 'Diaz', NULL, '1997-10-01', 28, 'Female', 'Single', '20', 'Palm Ave', 'Purok 1', 'East Tapinac', 'Olongapo City', '09171212121', 'lily.diaz@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(22, 'David', 'X.', 'Fabian', NULL, '1984-04-04', 41, 'Male', 'Married', '300', 'Coconut St', 'Purok 2', 'West Tapinac', 'Olongapo City', '09183434343', 'david.fabian@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(23, 'Zoe', 'Q.', 'Esteban', NULL, '1973-12-16', 52, 'Female', 'Widowed', '400', 'Mango Ln', 'Purok 3', 'Kalaklan', 'Olongapo City', '09195656565', 'zoe.esteban@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(24, 'Gabriel', 'Y.', 'Flores', NULL, '1990-07-09', 35, 'Male', 'Single', '50', 'Avocado Rd', 'Purok 4', 'Manggahan', 'Olongapo City', '09207878787', 'gabriel.flores@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(25, 'Hannah', 'U.', 'Ignacio', NULL, '1982-01-22', 43, 'Female', 'Married', '60', 'Banana Blvd', 'Purok 5', 'San Isidro', 'Olongapo City', '09219090909', 'hannah.ignacio@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(26, 'Isaac', 'I.', 'Javier', NULL, '1996-08-05', 29, 'Male', 'Single', '700', 'Guava St', 'Purok 1', 'Amoranto', 'Olongapo City', '09221133557', 'isaac.javier@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(27, 'Nora', 'O.', 'Lopez', NULL, '1976-03-17', 49, 'Female', 'Separated', '80', 'Papaya Ave', 'Purok 2', 'Cabalan', 'Olongapo City', '09232244668', 'nora.lopez@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(28, 'Leo', 'E.', 'Montes', NULL, '1989-11-29', 36, 'Male', 'Married', '900', 'Rambutan Rd', 'Purok 3', 'Gordon Heights', 'Olongapo City', '09243355779', 'leo.montes@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(29, 'Ruby', 'D.', 'Nario', NULL, '1992-05-06', 33, 'Female', 'Single', '1000', 'Durian St', 'Purok 4', 'Barretto', 'Olongapo City', '09254466880', 'ruby.nario@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(30, 'Caleb', 'M.', 'Ocampo', NULL, '1980-09-03', 45, 'Male', 'Widowed', '1100', 'Lanzones Blvd', 'Purok 5', 'Pag-asa', 'Olongapo City', '09265577991', 'caleb.ocampo@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(31, 'Scarlett', 'F.', 'Palma', NULL, '1995-02-20', 30, 'Female', 'Single', '120', 'Lychee St', 'Purok 1', 'New Kalalake', 'Olongapo City', '09176688002', 'scarlett.palma@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(32, 'Owen', 'G.', 'Quinto', NULL, '1983-07-11', 42, 'Male', 'Married', '130', 'Dragonfruit Ave', 'Purok 2', 'Sta. Rita', 'Olongapo City', '09187799113', 'owen.quinto@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(33, 'Victoria', 'H.', 'Ramos', NULL, '1977-04-18', 48, 'Female', 'Single', '140', 'Jackfruit Rd', 'Purok 3', 'East Bajac-Bajac', 'Olongapo City', '09198800224', 'victoria.ramos@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(34, 'Elijah', 'I.', 'Sarmiento', NULL, '1991-09-27', 34, 'Male', 'Married', '150', 'Pomelo St', 'Purok 4', 'West Bajac-Bajac', 'Olongapo City', '09209911335', 'elijah.sarmiento@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(35, 'Penelope', 'J.', 'Tadeo', NULL, '1986-06-05', 39, 'Female', 'Widowed', '160', 'Santol Blvd', 'Purok 5', 'Olongapo Proper', 'Olongapo City', '09210022446', 'penelope.tadeo@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(36, 'Julian', 'K.', 'Ubalde', NULL, '1998-01-10', 27, 'Male', 'Single', '170', 'Atis Ave', 'Purok 1', 'Asinan', 'Olongapo City', '09221133558', 'julian.ubalde@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(37, 'Aria', 'L.', 'Valdez', NULL, '1974-11-24', 51, 'Female', 'Married', '180', 'Guyabano Rd', 'Purok 2', 'Wawa', 'Olongapo City', '09232244669', 'aria.valdez@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(38, 'Milo', 'M.', 'Yap', NULL, '1989-03-08', 36, 'Male', 'Separated', '190', 'Mangosteen St', 'Purok 3', 'Bani', 'Olongapo City', '09243355770', 'milo.yap@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(39, 'Hazel', 'N.', 'Zulueta', NULL, '1993-08-17', 32, 'Female', 'Single', '200', 'Caimito Blvd', 'Purok 4', 'Kababae', 'Olongapo City', '09254466881', 'hazel.zulueta@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(40, 'Jasper', 'O.', 'Abad', NULL, '1981-12-01', 44, 'Male', 'Married', '210', 'Duhat Ave', 'Purok 5', 'New Asinan', 'Olongapo City', '09265577992', 'jasper.abad@email.com', NULL, 0, '2025-07-18 01:45:27', '2025-07-18 02:43:39'),
(162739, 'david', 'baloloy', 'candido', '', '2002-03-29', 23, 'Male', 'Single', '148', 'Murphy', '', 'New Kalalake', 'Olongapo City', '09123456789', 'Dave@local.lgu', NULL, 0, '2025-07-18 02:10:01', '2025-07-18 02:43:39'),
(270791, 'test 2', 'test 2', 'test 2', 'Jr.', '2000-03-12', 25, 'Male', 'Separated', '', 'Northon', '2', 'New Kalalake', 'Olongapo City', '09123456789', 'test2@demo.com', 'frontdesk/images/residents/resident_687bca0ccdc5a3.41868332.jpg', 1, '2025-07-18 02:56:33', '2025-07-19 17:39:23'),
(455286, 'test 1', 'test 1', 'test 1', 'jr.', '2009-02-03', 16, 'Male', 'Annulled', '123', 'Northon', '2', 'New Kalalake', 'Olongapo City', '09123456789', 'test1@demo.com', NULL, 0, '2025-07-18 02:45:44', '2025-07-18 02:45:44');

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
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`certificate_id`),
  ADD KEY `resident_id` (`resident_id`),
  ADD KEY `certificate_type_id` (`certificate_type_id`),
  ADD KEY `issued_by_user_id` (`issued_by_user_id`);

--
-- Indexes for table `certificate_data`
--
ALTER TABLE `certificate_data`
  ADD PRIMARY KEY (`data_id`),
  ADD UNIQUE KEY `certificate_id` (`certificate_id`,`data_key`);

--
-- Indexes for table `certificate_types`
--
ALTER TABLE `certificate_types`
  ADD PRIMARY KEY (`certificate_type_id`),
  ADD UNIQUE KEY `type_name` (`type_name`);

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
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `certificate_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certificate_data`
--
ALTER TABLE `certificate_data`
  MODIFY `data_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certificate_types`
--
ALTER TABLE `certificate_types`
  MODIFY `certificate_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `residents` (`resident_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `certificates_ibfk_2` FOREIGN KEY (`certificate_type_id`) REFERENCES `certificate_types` (`certificate_type_id`),
  ADD CONSTRAINT `certificates_ibfk_3` FOREIGN KEY (`issued_by_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `certificate_data`
--
ALTER TABLE `certificate_data`
  ADD CONSTRAINT `certificate_data_ibfk_1` FOREIGN KEY (`certificate_id`) REFERENCES `certificates` (`certificate_id`) ON DELETE CASCADE;

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
