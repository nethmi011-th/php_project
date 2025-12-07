-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2025 at 10:16 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `abclibrary`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `author` varchar(100) NOT NULL,
  `category` varchar(50) DEFAULT 'Uncategorized',
  `publisher` varchar(200) NOT NULL,
  `status` varchar(100) DEFAULT 'Available',
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `booked_by` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `author`, `category`, `publisher`, `status`, `image`, `created_at`, `booked_by`) VALUES
(2, 'jeewithen masa hayak', 'manjula senarathna', 'novel', '', 'Not Available', 'uploads/book_68d55830380643.01841876.jpg', '2025-09-25 14:56:48', 'abcd'),
(3, 'Guru geethaya', 'chingiz Aitmatov', 'Novel', '', 'Available', 'uploads/book_68d55c9d678685.27884071.jpg', '2025-09-25 15:15:41', ''),
(4, 'hjkk', 'jkkkl', 'sfhhh', 'susasara', 'Available', NULL, '2025-09-25 15:31:14', ''),
(5, 'ooo', 'kkk', 'lll', 'susasara', 'Not Available', 'uploads/default_book.jpg', '2025-09-25 16:02:54', 'wear'),
(6, 'ggg', 'rrr', 'fff', 'aa', 'Not Available', 'uploads/default_book.jpg', '2025-09-25 16:03:31', 'StudentDemo'),
(7, 'lll', 'ooo', 'Novel', 'aa', 'Not Available', 'upload/default\'jpg', '2025-10-03 05:31:23', ''),
(8, 'jjj', 'rrr', 'Novel', 'susasara', 'Not Available', 'upload/default\'jpg', '2025-10-03 06:35:29', 'Thamasha'),
(10, 'vv', 'zzz', 'ss', 'hhh', 'Not Available', 'uploads/default_book.jpg', '2025-10-03 07:25:29', 'Thamasha');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'nethu', '$2y$10$lvhKZiOOhdMvJ2zUAQo3ZecFP68DCkv.dBFgRfbCiTIQrRTy9.eDG', 'student'),
(2, 'nethu', '$2y$10$VZTEX.HcP0SIA86e.xMMB.blAm.RcYIr9bLGyW/6p/wsHNUxyzwU.', 'student'),
(3, 'nethu', '$2y$10$Tuc/q3bOiW7slt0KfWCZ0exXKV7apsXKK5fuqhzROF5DJxG9JML66', 'librarian'),
(4, 'admin', 'admin', 'librarian'),
(5, 'admin', '$2y$10$TPtBtifSQ37uwRYe22jGYewCM6MIg.hpD4vBhsTTJ91gnMpeOn5Hq', 'librarian'),
(6, 'nethu', '$2y$10$3JW7.lEpByheHg1vi4iW0.F.5Ktds/O7g2gywyBhXVVnu2aFWuOjS', 'librarian'),
(7, 'abcd', '$2y$10$q77NJ.npGVjWp0V4LolE5OOb/3GvM1p7nauTBH3uQ.T2fiwPllYTC', 'librarian'),
(8, 'admin', '$2y$10$QIw1VWg8wYuXu8K2jFS/RefRbOCqhPDuw2GWMO/bLarht88/jlSoe', 'librarian'),
(9, 'nethu', '$2y$10$yrKm2RuLF0MoyvqyLcaAJ.Dg5mMnDEQYc0XeoqmzyVe6an8/hzT7m', 'librarian'),
(10, 'wear', '$2y$10$Ckj.y0ObySP5lc31RQM/Vu0TqhmMeiweXmZ5Z4drPNvYFIjFV81kG', 'librarian'),
(11, 'malsha', '$2y$10$Hx2XeT/3HzntLOIY5DtRG.jxIXMnVPf3gsJgsH.zQ.xvTUKV59k4i', 'librarian'),
(12, 'hiruni', '$2y$10$9Lf23LIaxRYgNrOiqKzNN.Yv.QVc/odoDiYXy54R1aTW32uW0K1OO', 'student'),
(13, 'saduni', '$2y$10$XdOJk2Vb9cnPWvD1N8ZhgOZhR4z8gicyWhzDJU6bsnX3QrQ0Av6Cm', 'librarian'),
(14, 'saduni', '$2y$10$MuzEDtGqofhLg6Uzh49qL.s1mJHfHoQdKfHKyvdEMveu1CzEmR2nG', 'librarian'),
(15, 'Thamasha', '$2y$10$/NJ8eoNYI1zR.SZYglOXuuQibrxo.ZaLG2lzMknBM/KNlt.9Gt3Be', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
