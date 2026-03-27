-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 27, 2026 at 11:20 AM
-- Server version: 8.0.45-0ubuntu0.22.04.1
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dg250227688_astoncv`
--

-- --------------------------------------------------------

--
-- Table structure for table `cvs`
--

CREATE TABLE `cvs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyprogramming` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `education` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `URLlinks` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cvs`
--

INSERT INTO `cvs` (`id`, `name`, `email`, `password`, `keyprogramming`, `profile`, `education`, `URLlinks`) VALUES
(1, 'James Walker', 'james.walker@example.com', '$2y$10$Xr6HKiVAbX9v4.29BteAde.AE4LS1Aj7yq5ZdEBgoMq5VoU3vijNi', 'PHP', 'Backend web developer interested in secure server-side applications and database design.', 'BSc Computer Science - Aston University (2021–2024)', 'https://github.com/jwalker | https://linkedin.com/in/jameswalker | https://jameswalker.uk'),
(2, 'Sarah Patel', 'sarah.patel@example.com', '$2y$10$Xr6HKiVAbX9v4.29BteAde.AE4LS1Aj7yq5ZdEBgoMq5VoU3vijNi', 'Python', 'Developer passionate about data science, automation, and machine learning applications.', 'MSc Data Science - University of Warwick (2022–2023)', 'https://github.com/sarahpatel'),
(3, 'Daniel Carter', 'daniel.carter@example.com', '$2y$10$Xr6HKiVAbX9v4.29BteAde.AE4LS1Aj7yq5ZdEBgoMq5VoU3vijNi', 'Java', 'Software engineer specialising in object-oriented programming and scalable backend systems.', 'BEng Software Engineering - University of Manchester (2020–2023)', 'https://github.com/dcarter | https://linkedin.com/in/danielcarter'),
(4, 'Emily Thompson', 'emily.thompson@example.com', '$2y$10$Xr6HKiVAbX9v4.29BteAde.AE4LS1Aj7yq5ZdEBgoMq5VoU3vijNi', 'JavaScript', 'Front-end developer focused on modern JavaScript frameworks and UI design.', 'BSc Digital Media Technology - Birmingham City University (2021–2024)', 'https://github.com/emilyt | https://portfolio.emilyt.dev'),
(5, 'Ahmed Khan', 'ahmed.khan@example.com', '$2y$10$Xr6HKiVAbX9v4.29BteAde.AE4LS1Aj7yq5ZdEBgoMq5VoU3vijNi', 'C++', 'Systems programmer with strong interest in performance optimisation and low-level programming.', 'BSc Computer Engineering - University of Leeds (2020–2023)', 'https://github.com/ahmedkhan'),
(6, 'Olivia Brown', 'olivia.brown@example.com', '$2y$10$Xr6HKiVAbX9v4.29BteAde.AE4LS1Aj7yq5ZdEBgoMq5VoU3vijNi', 'PHP', 'Web developer experienced in building secure server-side applications and REST APIs.', 'BSc Web Development - Nottingham Trent University (2021–2024)', 'https://github.com/oliviabrown; https://oliviabrown.dev'),
(7, 'Michael Singh', 'michael.singh@example.com', '$2y$10$Xr6HKiVAbX9v4.29BteAde.AE4LS1Aj7yq5ZdEBgoMq5VoU3vijNi', 'Python', 'Backend developer with experience building automation tools and APIs.', 'BSc Information Technology - University of Leicester (2020–2023)', 'https://github.com/msingh | https://linkedin.com/in/michaelsingh'),
(8, 'Chloe Richardson', 'chloe.richardson@example.com', '$2y$10$Xr6HKiVAbX9v4.29BteAde.AE4LS1Aj7yq5ZdEBgoMq5VoU3vijNi', 'Java', 'Mobile application developer specialising in Android development.', 'BSc Mobile Computing - University of Sheffield (2021–2024)', 'https://github.com/chloer | https://linkedin.com/in/chloerichardson'),
(9, 'David Wilson', 'david.wilson@example.com', '$2y$10$Xr6HKiVAbX9v4.29BteAde.AE4LS1Aj7yq5ZdEBgoMq5VoU3vijNi', 'JavaScript', 'Full-stack developer experienced with JavaScript, Node.js and modern web technologies.', 'BSc Computer Systems Engineering - University of Nottingham (2020–2023)', 'https://github.com/dwilson, https://davidwilson.dev'),
(10, 'Hannah Clarke', 'hannah.clarke@example.com', '$2y$10$Xr6HKiVAbX9v4.29BteAde.AE4LS1Aj7yq5ZdEBgoMq5VoU3vijNi', 'C#', 'Software developer experienced with C# and the .NET ecosystem.', 'BSc Software Development - Coventry University (2021–2024)', 'https://github.com/hclarke | https://linkedin.com/in/hannahclarke');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cvs`
--
ALTER TABLE `cvs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cvs`
--
ALTER TABLE `cvs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
