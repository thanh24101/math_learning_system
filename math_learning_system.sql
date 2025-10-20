-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2025 at 06:12 PM
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
-- Database: `math_learning_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `exercises`
--

CREATE TABLE `exercises` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `question` text DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `correct_answer` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exercises`
--

INSERT INTO `exercises` (`id`, `lesson_id`, `question`, `answer`, `correct_answer`, `created_at`) VALUES
(6, 21, 'dsadasdas', 'uploads/exercises/1760853615_HW3-ANT.jpg', '1', '2025-10-19 13:00:15'),
(7, 21, '11', 'uploads/exercises/1760853632_HW3-ANT.jpg', '11', '2025-10-19 13:00:32'),
(8, 22, '1', 'uploads/exercises/1760854677_class_quan_ly_hoc_sinh_full.png', '1', '2025-10-19 13:17:57');

-- --------------------------------------------------------

--
-- Table structure for table `exercise_submissions`
--

CREATE TABLE `exercise_submissions` (
  `id` int(11) NOT NULL,
  `exercise_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `answer_text` varchar(255) DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT 0,
  `submitted_at` datetime DEFAULT current_timestamp(),
  `score` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exercise_submissions`
--

INSERT INTO `exercise_submissions` (`id`, `exercise_id`, `user_id`, `answer_text`, `is_correct`, `submitted_at`, `score`) VALUES
(21, 8, 113, '1', 1, '2025-10-19 13:27:17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `game_links`
--

CREATE TABLE `game_links` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `game_url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `game_links`
--

INSERT INTO `game_links` (`id`, `lesson_id`, `game_url`, `description`, `created_at`) VALUES
(5, 21, 'https://music.youtube.com', '1', '2025-10-20 22:00:58');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `media_type` enum('text','video','file') DEFAULT 'text',
  `media_url` varchar(255) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `content` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `title`, `description`, `created_by`, `created_at`, `media_type`, `media_url`, `subject`, `content`) VALUES
(21, 'dsad', 'sadasdas', 118, '2025-10-19 12:35:04', 'text', NULL, 'dsadas', ''),
(22, '1', '1', 118, '2025-10-19 13:17:43', 'text', NULL, '1', '1'),
(24, 'Toán', '1', 118, '2025-10-20 20:12:59', 'file', 'uploads/lessons/1760965979_Chuong 1- Gioi thieu.pdf', 'toán', '');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `type` enum('giaovien','he_thong') NOT NULL DEFAULT 'he_thong',
  `created_at` datetime DEFAULT current_timestamp(),
  `is_read` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `receiver_id`, `title`, `message`, `attachment`, `type`, `created_at`, `is_read`) VALUES
(50, 118, 112, '321', '321', NULL, '', '2025-10-18 21:04:06', 0),
(51, 118, 113, '321', '321', NULL, '', '2025-10-18 21:04:06', 1),
(52, 118, 114, '321', '321', NULL, '', '2025-10-18 21:04:06', 0),
(53, 118, 115, '321', '321', NULL, '', '2025-10-18 21:04:06', 0),
(54, 118, 116, '321', '321', NULL, '', '2025-10-18 21:04:06', 0),
(55, 118, 117, '321', '321', NULL, '', '2025-10-18 21:04:06', 1),
(56, 113, NULL, 'Hoàn thành bài học', '🎉 Bạn đã hoàn thành bài học: đấ', NULL, '', '2025-10-18 22:15:16', 0),
(57, 113, NULL, 'Hoàn thành bài học', '🎉 Bạn đã hoàn thành bài học: đấ', NULL, '', '2025-10-18 22:15:19', 0),
(58, 113, NULL, 'Hoàn thành bài học', '🎉 Bạn đã hoàn thành bài học: đấ', NULL, '', '2025-10-18 22:15:42', 0),
(59, 113, NULL, 'Đạt điểm bài tập', '🏅 Bạn đã làm đúng bài tập trong bài học ID 9!', NULL, '', '2025-10-18 22:26:49', 0),
(60, 118, 112, 'dsad', 'đasa', NULL, 'giaovien', '2025-10-18 23:22:00', 1),
(61, 113, 113, 'Hoàn thành bài học', '🎉 Bạn đã hoàn thành bài học ID 16!', NULL, 'he_thong', '2025-10-19 00:08:37', 1),
(62, 113, 113, 'Hoàn thành bài học', '🎉 Bạn đã hoàn thành bài học ID 16!', NULL, 'he_thong', '2025-10-19 00:08:46', 1),
(63, 117, 117, 'Hoàn thành bài học', '🎉 Bạn đã hoàn thành bài học ID 20!', NULL, 'he_thong', '2025-10-19 01:22:02', 1),
(64, 117, 117, 'Hoàn thành bài học', '🎉 Bạn đã hoàn thành bài học ID 20!', NULL, 'he_thong', '2025-10-19 01:22:38', 1),
(65, 117, 117, 'Hoàn thành bài học', '🎉 Bạn đã hoàn thành bài học ID 20!', NULL, 'he_thong', '2025-10-19 01:31:59', 0),
(66, 117, 117, 'Hoàn thành bài học', '🎉 Bạn đã hoàn thành bài học ID 20!', NULL, 'he_thong', '2025-10-19 01:33:05', 1),
(67, 113, 113, 'Hoàn thành bài học', '🎉 Bạn đã hoàn thành bài học ID 20!', NULL, 'he_thong', '2025-10-19 01:43:32', 1),
(68, 112, 112, 'Hoàn thành bài học', '🎉 Bạn đã hoàn thành bài học ID 20!', NULL, 'he_thong', '2025-10-19 12:30:14', 1),
(69, 118, 118, 'Hoàn thành bài học', '🎉 Bạn đã hoàn thành bài học ID 21!', NULL, 'he_thong', '2025-10-19 12:35:08', 1),
(70, 113, NULL, '🎉 Hoàn thành bài học!', 'Bạn đã hoàn thành bài học: <b>Bài học không xác định</b>. Hệ thống đã ghi nhận kết quả của bạn.', NULL, 'he_thong', '2025-10-19 12:48:14', 0),
(71, 113, NULL, '🎉 Hoàn thành bài học!', 'Bạn đã hoàn thành bài học: <b>dsad</b>.', NULL, 'he_thong', '2025-10-19 12:59:28', 0),
(72, 113, NULL, '🎉 Hoàn thành bài học!', 'Bạn đã hoàn thành bài học: <b>dsad</b>.', NULL, 'he_thong', '2025-10-19 13:09:51', 0),
(73, 113, NULL, '🎉 Hoàn thành bài học!', 'Bạn đã hoàn thành bài học: <b>dsad</b>.', NULL, 'he_thong', '2025-10-19 13:11:03', 0),
(74, 113, NULL, '🎉 Hoàn thành bài học!', 'Bạn đã hoàn thành bài học: <b>dsad</b>.', NULL, 'he_thong', '2025-10-19 13:11:46', 0),
(75, 113, NULL, '🎉 Hoàn thành bài học!', 'Bạn đã hoàn thành bài học: <b>dsad</b>.', NULL, 'he_thong', '2025-10-19 13:14:14', 0),
(76, 113, NULL, '🎉 Hoàn thành bài học!', 'Bạn đã hoàn thành bài học: <b>dsad</b>.', NULL, 'he_thong', '2025-10-19 13:15:46', 0),
(77, 113, NULL, '🎉 Hoàn thành bài học!', 'Bạn đã hoàn thành bài học: <b>dsad</b>.', NULL, 'he_thong', '2025-10-19 13:18:51', 0),
(78, 113, 113, '1', '🎉 Bạn đã hoàn thành bài học: 1!', NULL, 'he_thong', '2025-10-19 13:21:25', 1),
(79, 113, 113, '1', '🎉 Bạn đã hoàn thành bài học: 1!', NULL, 'he_thong', '2025-10-19 13:21:40', 1),
(80, 113, 113, 'đá', '🎉 Bạn đã hoàn thành bài học: đá!', NULL, 'he_thong', '2025-10-19 13:28:28', 1),
(81, 117, 117, '1', '🎉 Bạn đã hoàn thành bài học: 1!', NULL, 'he_thong', '2025-10-20 13:58:41', 1),
(82, 118, 113, '111', '111', NULL, 'giaovien', '2025-10-20 20:12:16', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expire_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `studies`
--

CREATE TABLE `studies` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `start_time` datetime DEFAULT current_timestamp(),
  `end_time` datetime DEFAULT NULL,
  `status` enum('chua_hoc','dang_hoc','hoan_thanh') DEFAULT 'chua_hoc',
  `progress` decimal(5,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studies`
--

INSERT INTO `studies` (`id`, `user_id`, `lesson_id`, `start_time`, `end_time`, `status`, `progress`) VALUES
(8, 113, 21, '2025-10-19 13:15:43', '2025-10-19 13:18:51', 'hoan_thanh', 100.00),
(9, 118, 22, '2025-10-19 13:18:09', NULL, 'hoan_thanh', 100.00),
(10, 113, 22, '2025-10-19 13:18:29', '2025-10-19 13:21:40', 'hoan_thanh', 100.00),
(12, 117, 22, '2025-10-20 13:56:53', '2025-10-20 13:58:41', 'hoan_thanh', 100.00),
(13, 117, 24, '2025-10-20 22:02:19', NULL, 'dang_hoc', 0.00),
(14, 117, 21, '2025-10-20 22:02:24', NULL, 'dang_hoc', 0.00);

-- --------------------------------------------------------

--
-- Stand-in structure for view `study_statistics`
-- (See below for the actual view)
--
CREATE TABLE `study_statistics` (
`user_id` int(11)
,`student_name` varchar(50)
,`total_lessons` bigint(21)
,`lessons_completed` decimal(22,0)
,`avg_progress` decimal(6,2)
,`avg_score` double(19,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('tre','phuhuynh','giaovien','admin') DEFAULT 'tre',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(76, 'admin', '', '1', 'admin', '2025-10-14 00:03:26', '2025-10-14 00:06:52'),
(112, 'chithanh241', 'thanh24101@gmail.com', '$2y$10$RwVRCDJxUeDZtCshK75pxu7lZ0I7EjxknbYlB24LN1uAD72sR8kRi', 'phuhuynh', '2025-10-14 01:48:49', '2025-10-18 20:07:44'),
(113, 'chithanh231', 'thanh.dlc33644@hust.sis.vn', '$2y$10$yHjxnub.YyTcexcvqFQPxekAiMpes7eA1dQFsQTVPrpgewSmd1Yt.', 'tre', '2025-10-18 20:06:46', '2025-10-18 20:06:46'),
(114, 'phu_huynh_1', 'ph1@gmail.com', '$2y$10$abcdefghi...hash', 'phuhuynh', '2025-10-18 20:27:21', '2025-10-18 20:27:21'),
(115, 'tre_A', 'tre_a@gmail.com', '$2y$10$abcdefghi...hash', 'tre', '2025-10-18 20:27:21', '2025-10-18 20:27:21'),
(116, 'tre_B', 'tre_b@gmail.com', '$2y$10$abcdefghi...hash', 'tre', '2025-10-18 20:27:21', '2025-10-18 20:27:21'),
(117, 'chithanh251', 'fdasda@gdsadas', '$2y$10$WrVXNg3L8NV45PAOZvB16e2DksZP1pWYgV.MMm/T.acmGLNoBem1y', 'tre', '2025-10-18 20:29:56', '2025-10-18 20:29:56'),
(118, 'chithanh261', 'dsadasdsa@fasfasjk', '$2y$10$XPZtEuf0k7dH4qyzCoesvufMXv0T5GOy3rzrTJCthxfnSrSEZBEV6', 'giaovien', '2025-10-18 20:31:19', '2025-10-18 20:31:52');

-- --------------------------------------------------------

--
-- Structure for view `study_statistics`
--
DROP TABLE IF EXISTS `study_statistics`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `study_statistics`  AS SELECT `u`.`id` AS `user_id`, `u`.`username` AS `student_name`, count(distinct `s`.`lesson_id`) AS `total_lessons`, sum(case when `s`.`status` = 'hoan_thanh' then 1 else 0 end) AS `lessons_completed`, round(avg(`s`.`progress`),2) AS `avg_progress`, round(avg(`es`.`score`) * 10,2) AS `avg_score` FROM ((`users` `u` left join `studies` `s` on(`u`.`id` = `s`.`user_id`)) left join `exercise_submissions` `es` on(`u`.`id` = `es`.`user_id`)) WHERE `u`.`role` = 'tre' GROUP BY `u`.`id`, `u`.`username` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exercises`
--
ALTER TABLE `exercises`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ex_lesson` (`lesson_id`);

--
-- Indexes for table `exercise_submissions`
--
ALTER TABLE `exercise_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exercise_id` (`exercise_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `game_links`
--
ALTER TABLE `game_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_game_lesson` (`lesson_id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studies`
--
ALTER TABLE `studies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `lesson_id` (`lesson_id`);

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
-- AUTO_INCREMENT for table `exercises`
--
ALTER TABLE `exercises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `exercise_submissions`
--
ALTER TABLE `exercise_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `game_links`
--
ALTER TABLE `game_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `studies`
--
ALTER TABLE `studies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exercises`
--
ALTER TABLE `exercises`
  ADD CONSTRAINT `exercises_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ex_lesson` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exercise_submissions`
--
ALTER TABLE `exercise_submissions`
  ADD CONSTRAINT `exercise_submissions_ibfk_1` FOREIGN KEY (`exercise_id`) REFERENCES `exercises` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exercise_submissions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `game_links`
--
ALTER TABLE `game_links`
  ADD CONSTRAINT `fk_game_lesson` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `game_links_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `studies`
--
ALTER TABLE `studies`
  ADD CONSTRAINT `studies_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `studies_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
