-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2025 at 10:18 PM
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
-- Database: `webproject_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `credits` int(11) NOT NULL,
  `category` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `instructor_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `max_students` int(11) DEFAULT 30,
  `schedule_days` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `schedule_time` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `room` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `code`, `name`, `description`, `credits`, `category`, `instructor_name`, `max_students`, `schedule_days`, `schedule_time`, `room`, `created_at`, `updated_at`) VALUES
(1, 'CS101', 'Introduction to Programming', 'Basic programming concepts and problem solving', 3, 'Computer Science', 'Prof. Brown', 30, 'Monday,Wednesday', '11:00-12:30', 'Room 101', '2025-06-08 19:25:53', '2025-06-08 21:43:32'),
(2, 'MATH201', 'Calculus I', 'Limits, derivatives, and basic integration', 4, 'Mathematics', 'Prof. Smith', 25, 'Tuesday,Thursday', '11:00-12:30', 'Room 202', '2025-06-08 19:25:53', '2025-06-08 19:25:53'),
(3, 'ENG101', 'English Composition', 'Academic writing and critical thinking', 3, 'English', 'Prof. Wilson', 30, 'Monday,Wednesday', '13:00-14:30', 'Room 303', '2025-06-08 19:25:53', '2025-06-08 21:43:32'),
(4, 'PHY201', 'Physics I', 'Mechanics and thermodynamics', 4, 'Physics', 'Prof. Johnson', 25, 'Tuesday,Thursday', '09:00-10:30', 'Room 404', '2025-06-08 19:25:53', '2025-06-08 19:25:53'),
(35, 'CHEM101', 'General Chemistry', 'Basic chemistry concepts', 4, 'Chemistry', 'Dr. Davis', 30, 'Tuesday,Thursday', '10:00-12:00', 'Room 502', '2025-06-09 15:33:36', '2025-06-09 15:33:36'),
(36, 'BIO101', 'Introduction to Biology', 'Cell biology and genetics', 4, 'Biology', 'Dr. Wilson', 30, 'Tuesday,Thursday', '14:00-16:00', 'Room 601', '2025-06-09 15:33:36', '2025-06-09 15:33:36'),
(37, 'CS202', 'Data Structures', 'Advanced programming and algorithms', 3, 'Computer Science', 'Dr. Anderson', 30, 'Friday', '8:00-10:00', 'Room 102', '2025-06-09 15:33:36', '2025-06-09 15:33:36'),
(38, 'MATH202', 'Linear Algebra', 'Vectors, matrices, and linear transformations', 3, 'Mathematics', 'Dr. Taylor', 30, 'Friday', '10:00-12:00', 'Room 203', '2025-06-09 15:33:36', '2025-06-09 15:33:36'),
(39, 'CS303', 'Database Systems', 'Database design and SQL', 3, 'Computer Science', 'Dr. Martin', 30, 'Friday', '14:00-16:00', 'Room 103', '2025-06-09 15:33:36', '2025-06-09 15:33:36'),
(40, 'CS105', 'Web Development', 'HTML, CSS, and JavaScript', 3, 'Computer Science', 'Dr. Lee', 30, 'Monday,Wednesday', '08:00-10:00', 'Room 104', '2025-06-09 16:18:57', '2025-06-09 16:18:57'),
(41, 'MATH205', 'Statistics', 'Probability and statistical analysis', 3, 'Mathematics', 'Dr. Chen', 30, 'Monday,Wednesday', '10:00-12:00', 'Room 205', '2025-06-09 16:18:57', '2025-06-09 16:18:57'),
(42, 'ART101', 'Introduction to Art', 'Art history and appreciation', 3, 'Arts', 'Prof. Garcia', 30, 'Monday,Wednesday', '14:00-16:00', 'Room 304', '2025-06-09 16:18:57', '2025-06-09 16:18:57'),
(43, 'CS210', 'Object-Oriented Programming', 'Java programming concepts', 3, 'Computer Science', 'Dr. Kumar', 30, 'Tuesday,Thursday', '08:00-10:00', 'Room 402', '2025-06-09 16:18:57', '2025-06-09 16:18:57'),
(44, 'BUS201', 'Business Management', 'Principles of management', 3, 'Business', 'Dr. Thompson', 30, 'Tuesday,Thursday', '10:00-12:00', 'Room 503', '2025-06-09 16:18:57', '2025-06-09 16:18:57'),
(45, 'PSY101', 'Introduction to Psychology', 'Basic psychology concepts', 3, 'Psychology', 'Dr. Martinez', 30, 'Tuesday,Thursday', '14:00-16:00', 'Room 602', '2025-06-09 16:18:57', '2025-06-09 16:18:57'),
(46, 'ENG202', 'Creative Writing', 'Fiction and poetry writing', 3, 'English', 'Prof. Roberts', 30, 'Friday', '08:00-10:00', 'Room 105', '2025-06-09 16:18:57', '2025-06-09 16:18:57'),
(47, 'SOC101', 'Introduction to Sociology', 'Social structures and interactions', 3, 'Sociology', 'Dr. White', 30, 'Friday', '10:00-12:00', 'Room 204', '2025-06-09 16:18:57', '2025-06-09 16:18:57'),
(48, 'MUS101', 'Music Appreciation', 'Understanding music theory and history', 3, 'Music', 'Prof. Turner', 30, 'Friday', '14:00-16:00', 'Room 106', '2025-06-09 16:18:57', '2025-06-09 16:18:57');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrollment_date` date NOT NULL,
  `grade` varchar(2) DEFAULT NULL,
  `status` enum('enrolled','dropped','completed') DEFAULT 'enrolled',
  `assignments_grade` decimal(5,2) DEFAULT NULL,
  `midterm_grade` decimal(5,2) DEFAULT NULL,
  `final_grade` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `student_id`, `course_id`, `enrollment_date`, `grade`, `status`, `assignments_grade`, `midterm_grade`, `final_grade`, `created_at`, `updated_at`) VALUES
(2, 1, 2, '2024-01-15', '19', 'enrolled', 90.00, 88.50, NULL, '2025-06-08 19:25:53', '2025-06-08 21:19:07'),
(3, 2, 1, '2024-01-16', '17', 'enrolled', 92.00, 85.00, NULL, '2025-06-08 19:25:53', '2025-06-08 21:19:07'),
(4, 2, 3, '2024-01-16', '16', 'enrolled', 88.00, 91.50, NULL, '2025-06-08 19:25:53', '2025-06-08 21:19:07'),
(6, 1, 1, '0000-00-00', '18', 'enrolled', 75.00, 95.00, NULL, '2025-06-09 15:04:45', '2025-06-09 17:39:32');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `event_type` enum('class','study_group','exam','assignment') NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `recurring` tinyint(1) DEFAULT 0,
  `recurrence_pattern` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `student_id`, `event_type`, `title`, `description`, `start_time`, `end_time`, `location`, `recurring`, `recurrence_pattern`, `created_at`, `updated_at`) VALUES
(1, 1, 'class', 'CS101 Lecture', 'Introduction to Programming class', '2024-01-22 09:00:00', '2024-01-22 10:30:00', 'Room 101', 1, 'weekly-mon-wed', '2025-06-08 19:25:53', '2025-06-08 19:25:53'),
(2, 1, 'study_group', 'CS101 Study Group', 'Programming practice session', '2024-01-23 15:00:00', '2024-01-23 17:00:00', 'Library Room 2', 1, 'weekly-tue', '2025-06-08 19:25:53', '2025-06-08 19:25:53'),
(3, 2, 'class', 'ENG101 Lecture', 'English Composition class', '2024-01-22 14:00:00', '2024-01-22 15:30:00', 'Room 303', 1, 'weekly-mon-wed', '2025-06-08 19:25:53', '2025-06-08 19:25:53'),
(4, 2, 'exam', 'MATH201 Midterm', 'Calculus I Midterm Examination', '2024-03-15 11:00:00', '2024-03-15 13:00:00', 'Room 202', 0, NULL, '2025-06-08 19:25:53', '2025-06-08 19:25:53');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `class` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `first_name`, `last_name`, `student_id`, `date_of_birth`, `gender`, `address`, `phone`, `class`) VALUES
(1, 2, 'John', 'Doe', 'STU001', '2000-05-15', 'male', '123 Student St, College Town', '1234567890', '2023A'),
(2, 3, 'Jane', 'Smith', 'STU002', '2001-03-20', 'female', '456 Campus Ave, College Town', '0987654321', '2023A');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','teacher','student') NOT NULL DEFAULT 'student',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@school.com', '$2y$10$./42eeS2pxA360ulKGiiuuvvrPz1KJkqyH2MMLy0eLOizLe1/k.7y', 'admin', '2025-06-08 19:25:53', '2025-06-08 19:25:53'),
(2, 'john.doe', 'john.doe@student.com', '$2y$10$8xOcOxq44dvMC11klZNc8uY3DdrVo/dyQioVL2vlC0OhxbDJySZ3q', 'student', '2025-06-08 19:25:53', '2025-06-09 19:20:57'),
(3, 'jane.smith', 'jane.smith@student.com', '$2y$10$./42eeS2pxA360ulKGiiuuvvrPz1KJkqyH2MMLy0eLOizLe1/k.7y', 'student', '2025-06-08 19:25:53', '2025-06-08 19:25:53'),
(4, 'prof.brown', 'brown@school.com', '$2y$10$./42eeS2pxA360ulKGiiuuvvrPz1KJkqyH2MMLy0eLOizLe1/k.7y', 'teacher', '2025-06-08 19:25:53', '2025-06-08 19:25:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_unique` (`code`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_enrollment` (`student_id`,`course_id`),
  ADD KEY `fk_enrollment_course` (`course_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_enrollment_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_enrollment_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
