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
  `organization_name` varchar(255) NOT NULL,
  PRIMARY KEY (`org_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO academic_organizations (org_id, organization_name) VALUES 
    (1, 'Skimmers'),
    (2, 'Redbolts'),
    (3, 'Clovers'),
    (4, 'Bluechips'),
    (5, 'Elektrons'),
    (6, 'SOTECH'),
    (7, 'CFOS');

CREATE TABLE `degree_programs` (
  `program_id` int(11) NOT NULL,
  `degree_program` varchar(255) NOT NULL,
  `academic_organization_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`program_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO degree_programs (program_id, degree_program, academic_organization_id) VALUES
    (1, 'BA (Communication & Media Studies)', 1), -- Skimmers
    (2, 'BA in Political Science', 2),           -- Redbolts
    (3, 'BS (Biology)', 3),                      -- Clovers
    (4, 'BS Accountancy (4.5 yrs)', 4),          -- Bluechips
    (5, 'BS Applied Mathematics', 5),            -- Elektrons
    (6, 'BS Chemical Engineering', 6),          -- SOTECH
    (7, 'BS Computer Science', 5),              -- Elektrons
    (8, 'BS Fisheries', 7),                     -- CFOS
    (9, 'BS Food Technology', 6),               -- SOTECH
    (10, 'BS Statistics', 5);                   -- Elektrons

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
   PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `galleries` (
  `gallery_id` int(11) NOT NULL  AUTO_INCREMENT,
  `batch_year` year(4) NOT NULL,
  `gallery_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`gallery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `user_type` varchar(255) NOT NULL DEFAULT 'user',
  `status` enum('approved', 'pending', 'rejected') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Insert data into `user` table
INSERT INTO `user` (`user_id`, `fname`, `lname`, `address`, `contact_num`, `email`, `occupation`, `grad_year`, `degree_program`, `academic_org`, `bio`, `password`, `user_type`, `status`) VALUES
(1, 'Shaina', 'Talisay', 'General Santos City', '09454038207', 'shaina@gmail.com', 'Student', '2026', '7', '5', 'Hello', 'shaina', 'user', 'pending'),
(12, 'Admin', 'Admin', 'Admin City', '09454038207', 'admin@gmail.com', 'Student', '1999', '7', '5', 'Hello', 'admin', 'admin', 'approved'),

CREATE TABLE `memories` (
  `memory_id` int(11) NOT NULL  AUTO_INCREMENT,
  `gallery_id` int(11) DEFAULT NULL,
  `memory_date` date DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `uploader_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`memory_id`),
  CONSTRAINT `memories_ibfk_1` FOREIGN KEY (`gallery_id`) REFERENCES `galleries` (`gallery_id`) ON DELETE CASCADE,
  CONSTRAINT `memories_ibfk_2` FOREIGN KEY (`uploader_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `event_participants` (
  `participant_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` enum('going','not going') NOT NULL,
  PRIMARY KEY (`participant_id`),
  KEY `event_id` (`event_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_event_participants_event_id` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_event_participants_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- --------------------------------------------------------

