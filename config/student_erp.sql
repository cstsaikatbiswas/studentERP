-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2025 at 08:28 AM
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
-- Database: `student_erp`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_batches`
--

CREATE TABLE `academic_batches` (
  `id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `batch_year` year(4) NOT NULL,
  `batch_code` varchar(50) NOT NULL,
  `batch_name` varchar(255) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `current_semester` int(11) DEFAULT 1,
  `total_students` int(11) DEFAULT 0,
  `max_capacity` int(11) DEFAULT 60,
  `class_teacher_id` int(11) DEFAULT NULL,
  `fee_structure` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`fee_structure`)),
  `admission_criteria` text DEFAULT NULL,
  `status` enum('active','completed','upcoming','cancelled') DEFAULT 'active',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `academic_programs`
--

CREATE TABLE `academic_programs` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `duration_years` int(11) DEFAULT 4,
  `total_credits` int(11) DEFAULT 120,
  `department_id` int(11) NOT NULL,
  `degree_type` enum('undergraduate','postgraduate','diploma','certificate','phd') DEFAULT 'undergraduate',
  `program_level` enum('foundation','diploma','bachelor','master','doctoral') DEFAULT 'bachelor',
  `accreditation_status` enum('approved','pending','rejected','accredited') DEFAULT 'pending',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `total_semesters` int(11) DEFAULT 8,
  `max_students` int(11) DEFAULT 100,
  `current_students` int(11) DEFAULT 0,
  `program_fee` decimal(10,2) DEFAULT 0.00,
  `status` enum('active','inactive','draft') DEFAULT 'active',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL,
  `type` enum('main','branch','extension','online') DEFAULT 'branch',
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT 'India',
  `pincode` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `established_year` year(4) DEFAULT NULL,
  `total_students` int(11) DEFAULT 0,
  `total_faculty` int(11) DEFAULT 0,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL,
  `type` enum('academic','administrative','support') DEFAULT 'academic',
  `head_of_department` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `institute_id`, `name`, `code`, `type`, `head_of_department`, `email`, `phone`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'D-CST', 'CST', 'academic', 'S. Paul', 'kpchodcst@keical.edu.in', '1234658790', 'TestTestTestTestTestTestTestTestTestTestTestTest', 'active', '2025-10-11 07:18:40', '2025-10-11 07:19:48'),
(2, 1, 'CRC', 'CRC', 'administrative', 'S. BISWAS', 'abcf@domain.com', '1234658790', 'sgsdfgsdfgd', 'active', '2025-10-11 07:19:32', '2025-10-11 07:20:10');

-- --------------------------------------------------------

--
-- Table structure for table `institutes`
--

CREATE TABLE `institutes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(50) NOT NULL,
  `type` varchar(100) NOT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT 'India',
  `pincode` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `established_year` year(4) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `institutes`
--

INSERT INTO `institutes` (`id`, `name`, `code`, `type`, `address`, `city`, `state`, `country`, `pincode`, `phone`, `email`, `website`, `established_year`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Kingston Polytechnic College', 'KPC', 'college', 'KINGSTON EDUCATIONAL INSTITUTE, Berunanpukhuria, West Bengal', 'Barasat', 'West Bengal', 'India', '700122', '1234658790', 'kpcprincipal@keical.edu.in', 'https://www.keical.edu.in', '2004', 'Kingston Law College is a Legal education institution situated at Berunanpukuria, North 24 Parganas in the indian state of West Bengal. It is affiliated to the West Bengal State University. It offers 3 years and 5-year Integrated Course in Law leading to LL.B and B.A.', 'active', '2025-10-11 06:36:26', '2025-10-11 06:36:26');

-- --------------------------------------------------------

--
-- Table structure for table `institute_types`
--

CREATE TABLE `institute_types` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `institute_types`
--

INSERT INTO `institute_types` (`id`, `name`, `code`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'University', 'UNIV', 'Higher education and research institution', 'active', '2025-10-11 06:53:38', '2025-10-11 06:53:38'),
(2, 'College', 'COL', 'Educational institution or constituent part', 'active', '2025-10-11 06:53:38', '2025-10-11 06:53:38'),
(3, 'School', 'SCH', 'Primary or secondary educational institution', 'active', '2025-10-11 06:53:38', '2025-10-11 06:53:38'),
(4, 'Institute', 'INST', 'Specialized educational institution', 'active', '2025-10-11 06:53:38', '2025-10-11 06:53:38'),
(5, 'Training Center', 'TRG', 'Vocational and training institution', 'active', '2025-10-11 06:53:38', '2025-10-11 06:53:38'),
(6, 'Research Center', 'RES', 'Research and development institution', 'active', '2025-10-11 06:53:38', '2025-10-11 06:53:38'),
(7, 'Test', 'Test', 'TestTestTest', 'active', '2025-10-11 07:17:22', '2025-10-11 07:17:22');

-- --------------------------------------------------------

--
-- Table structure for table `program_subjects`
--

CREATE TABLE `program_subjects` (
  `id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `is_optional` tinyint(1) DEFAULT 0,
  `min_credits` decimal(4,2) DEFAULT NULL,
  `max_credits` decimal(4,2) DEFAULT NULL,
  `course_code` varchar(50) DEFAULT NULL,
  `course_type` enum('mandatory','elective','audit') DEFAULT 'mandatory',
  `teaching_methodology` text DEFAULT NULL,
  `assessment_pattern` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`assessment_pattern`)),
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `credit_hours` decimal(4,2) DEFAULT 3.00,
  `theory_hours` int(11) DEFAULT 0,
  `practical_hours` int(11) DEFAULT 0,
  `subject_type` enum('core','elective','lab','project','seminar','workshop') DEFAULT 'core',
  `difficulty_level` enum('basic','intermediate','advanced') DEFAULT 'intermediate',
  `department_id` int(11) DEFAULT NULL,
  `prerequisites` text DEFAULT NULL,
  `learning_outcomes` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Gustavo Frienge', 'abc@domain.com', '$2y$10$2boPZwPqY9MOFkPqkgDIKuYeVZMJG/TFAYr/LHY8gsYNZVhVPpxaq', '2025-10-10 06:22:40'),
(2, 'Ram Das', 'xyz@domain.com', '$2y$10$3jt7HYDgTy6ObpTrJNpwS.uYo8flKCZQEk0Dr5egJ6kduyyqJckm.', '2025-10-10 06:59:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_batches`
--
ALTER TABLE `academic_batches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_batch_code` (`program_id`,`batch_code`),
  ADD KEY `class_teacher_id` (`class_teacher_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `idx_batch_program` (`program_id`),
  ADD KEY `idx_batch_year` (`batch_year`),
  ADD KEY `idx_batch_status` (`status`);

--
-- Indexes for table `academic_programs`
--
ALTER TABLE `academic_programs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `idx_program_department` (`department_id`),
  ADD KEY `idx_program_status` (`status`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_branch_code` (`institute_id`,`code`),
  ADD KEY `idx_branch_institute` (`institute_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_dept_code` (`institute_id`,`code`),
  ADD KEY `idx_department_institute` (`institute_id`);

--
-- Indexes for table `institutes`
--
ALTER TABLE `institutes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `institute_types`
--
ALTER TABLE `institute_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `program_subjects`
--
ALTER TABLE `program_subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_program_subject` (`program_id`,`subject_id`,`semester`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `idx_program_subject_program` (`program_id`),
  ADD KEY `idx_program_subject_semester` (`semester`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_subject_code` (`code`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `idx_subject_department` (`department_id`),
  ADD KEY `idx_subject_type` (`subject_type`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_batches`
--
ALTER TABLE `academic_batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `academic_programs`
--
ALTER TABLE `academic_programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `institutes`
--
ALTER TABLE `institutes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `institute_types`
--
ALTER TABLE `institute_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `program_subjects`
--
ALTER TABLE `program_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `academic_batches`
--
ALTER TABLE `academic_batches`
  ADD CONSTRAINT `academic_batches_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `academic_programs` (`id`),
  ADD CONSTRAINT `academic_batches_ibfk_2` FOREIGN KEY (`class_teacher_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `academic_batches_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `academic_programs`
--
ALTER TABLE `academic_programs`
  ADD CONSTRAINT `academic_programs_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `academic_programs_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `branches_ibfk_1` FOREIGN KEY (`institute_id`) REFERENCES `institutes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_ibfk_1` FOREIGN KEY (`institute_id`) REFERENCES `institutes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `program_subjects`
--
ALTER TABLE `program_subjects`
  ADD CONSTRAINT `program_subjects_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `academic_programs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_subjects_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `subjects_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
