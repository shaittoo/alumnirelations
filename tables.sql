-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 29, 2024 at 04:19 PM
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
-- Database: `backinup`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_organizations`
--

CREATE TABLE `academic_organizations` (
  `org_id` int(11) NOT NULL,
  `organization_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `degree_programs`
--

CREATE TABLE `degree_programs` (
  `program_id` int(11) NOT NULL,
  `degree_program` varchar(255) NOT NULL,
  `academic_organization_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------


INSERT INTO academic_organizations (org_id, organization_name) VALUES 
    (1, 'Skimmers'),
    (2, 'Redbolts'),
    (3, 'Clovers'),
    (4, 'Bluechips'),
    (5, 'Elektrons'),
    (6, 'SOTECH'),
    (7, 'CFOS');

INSERT INTO degree_programs (program_id, degree_program, academic_organization_id) VALUES
    (1, 'BA (Communication & Media Studies)', 1), -- Skimmers
    (2,'BA in Political Science', 2),            -- Redbolts
    (3,'BS (Biology)', 3),                        -- Clovers
    (4,'BS Accountancy (4.5 yrs)', 4),            -- Bluechips
    (5,'BS Applied Mathematics', 5),              -- Elektrons
    (6,'BS Chemical Engineering', 6),             -- SOTECH
    (7,'BS Computer Science', 5),                 -- Elektrons
    (8,'BS Fisheries', 7),                        -- CFOS
    (9,'BS Food Technology', 6),                  -- SOTECH
    (10,'BS Statistics', 5);                       -- Elektrons
--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_participants`
--

CREATE TABLE `event_participants` (
  `participant_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` enum('going','not going') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `gallery_id` int(11) NOT NULL,
  `batch_year` year(4) NOT NULL,
  `gallery_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `memories`
--

CREATE TABLE `memories` (
  `memory_id` int(11) NOT NULL,
  `gallery_id` int(11) DEFAULT NULL,
  `memory_date` date DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `uploader_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_num` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `grad_year` year(4) NOT NULL,
  `degree_program` varchar(255) NOT NULL,
  `academic_org` varchar(255) NOT NULL,
  `bio` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `fname`, `lname`, `address`, `contact_num`, `email`, `occupation`, `grad_year`, `degree_program`, `academic_org`, `bio`, `password`, `user_type`) VALUES
(1, 'Shaina', 'Talisay', 'General Santos City', '09454038207', 'shaina@gmail.com', 'Student', '2026', '7', '5', 'Hello', 'shaina', 'user'),
(12, 'Shaina', 'Talisay', 'General Santos City', '09454038207', 'shaina@gmail.com', 'Student', '2026', '7', '5', 'Hello', 'shaina', 'admin'),
(13, 'sda', 'sda', 'sadas', '213873212', 'sadh@hsdj.com', 'sad', '2131', '1', '2', 'sajha', 'shaina', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `graduating_year` year(4) DEFAULT NULL,
  `degree_program_id` int(11) DEFAULT NULL,
  `academic_organization_id` int(11) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `cpassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_organizations`
--
-- Indexes for table `degree_programs`
--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `event_participants`
--
ALTER TABLE `event_participants`
  ADD PRIMARY KEY (`participant_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`gallery_id`);

--
-- Indexes for table `memories`
--
ALTER TABLE `memories`
  ADD PRIMARY KEY (`memory_id`),
  ADD KEY `gallery_id` (`gallery_id`),
  ADD KEY `uploader_id` (`uploader_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `degree_program_id` (`degree_program_id`),
  ADD KEY `academic_organization_id` (`academic_organization_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_participants`
--
ALTER TABLE `event_participants`
  MODIFY `participant_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `gallery_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `memories`
--
ALTER TABLE `memories`
  MODIFY `memory_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

-

--
-- Constraints for table `event_participants`
--
ALTER TABLE `event_participants`
  ADD CONSTRAINT `event_participants_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_participants_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `memories`
--
ALTER TABLE `memories`
  ADD CONSTRAINT `memories_ibfk_1` FOREIGN KEY (`gallery_id`) REFERENCES `galleries` (`gallery_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `memories_ibfk_2` FOREIGN KEY (`uploader_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`degree_program_id`) REFERENCES `degree_programs` (`program_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`academic_organization_id`) REFERENCES `academic_organizations` (`org_id`) ON DELETE SET NULL;
COMMIT;
