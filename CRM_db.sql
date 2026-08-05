-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Aug 05, 2026 at 11:13 PM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `CRM_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `module` varchar(100) NOT NULL,
  `action` varchar(100) NOT NULL,
  `record_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `module`, `action`, `record_id`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 1, 'auth', 'login', NULL, '127.0.0.1', 'System', '2026-07-24 06:34:05'),
(2, 1, 'users', 'create', 2, '127.0.0.1', 'System', '2026-07-24 06:34:05'),
(3, 4, 'customers', 'create', 1, '127.0.0.1', 'System', '2026-07-01 02:00:00'),
(4, 5, 'leads', 'create', 1, '127.0.0.1', 'System', '2026-07-02 03:00:00'),
(5, 6, 'deals', 'create', 1, '127.0.0.1', 'System', '2026-07-03 04:00:00'),
(6, 4, 'invoices', 'create', 1, '127.0.0.1', 'System', '2026-07-15 06:00:00'),
(7, 5, 'quotes', 'create', 1, '127.0.0.1', 'System', '2026-07-01 01:00:00'),
(8, 6, 'tasks', 'create', 1, '127.0.0.1', 'System', '2026-07-28 00:00:00'),
(9, 4, 'meetings', 'create', 1, '127.0.0.1', 'System', '2026-07-28 08:00:00'),
(10, 7, 'tickets', 'create', 1, '127.0.0.1', 'System', '2026-07-30 05:00:00'),
(11, 1, 'deals', 'update_stage', 1, '::1', 'curl/8.7.1', '2026-07-24 17:56:11'),
(12, 1, 'deals', 'update_stage', 1, '::1', 'curl/8.7.1', '2026-07-24 17:56:16'),
(13, 1, 'deals', 'update_stage', 5, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-24 18:09:56'),
(14, 1, 'deals', 'update_stage', 14, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-24 18:10:03'),
(15, 1, 'deals', 'update_stage', 10, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-24 18:10:13'),
(16, 1, 'deals', 'update_stage', 8, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-24 18:23:03'),
(17, 1, 'deals', 'update_stage', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-24 18:23:06'),
(18, 1, 'deals', 'update_stage', 5, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-24 18:23:25'),
(19, 1, 'deals', 'update', 3, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-24 18:32:03'),
(20, 1, 'deals', 'update', 3, '::1', 'curl/8.7.1', '2026-07-24 18:33:45'),
(21, 1, 'deals', 'update', 12, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-24 18:43:34'),
(22, 1, 'meetings', 'update', 6, '::1', 'curl/8.7.1', '2026-07-24 18:54:14'),
(23, 1, 'meetings', 'update', 9, '::1', 'curl/8.7.1', '2026-07-24 18:57:43'),
(24, 1, 'users', 'profile_updated', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-24 19:03:32'),
(25, 1, 'customers', 'update', 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-24 19:53:08'),
(26, 1, 'customers', 'update', 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-24 19:53:44'),
(27, 1, 'customers', 'update', 1, '::1', 'curl/8.7.1', '2026-07-24 19:55:14'),
(28, 1, 'deals', 'update_stage', 3, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-26 14:44:44'),
(29, 1, 'deals', 'update_stage', 6, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-26 14:47:42'),
(30, 1, 'deals', 'update_stage', 4, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-26 14:47:44'),
(31, 1, 'deals', 'update_stage', 4, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-26 14:47:47'),
(32, 1, 'deals', 'update_stage', 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-26 15:00:39'),
(33, 1, 'deals', 'update_stage', 14, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-26 15:01:53'),
(34, 1, 'deals', 'update_stage', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-26 15:19:19'),
(35, 1, 'deals', 'update_stage', 7, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-26 15:25:18'),
(36, 1, 'deals', 'update_stage', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-07-26 15:25:22'),
(37, 1, 'deals', 'update_stage', 4, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-26 19:00:56'),
(38, 1, 'deals', 'update_stage', 4, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-26 19:44:22'),
(39, 1, 'deals', 'update_stage', 15, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-26 19:45:46'),
(40, 1, 'deals', 'update_stage', 9, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-26 19:50:27'),
(41, 1, 'deals', 'update_stage', 4, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-26 19:50:30'),
(42, 1, 'deals', 'update_stage', 12, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-26 20:34:02'),
(43, 1, 'deals', 'update_stage', 6, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-26 20:35:34'),
(44, 1, 'deals', 'update_stage', 5, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-26 20:55:31'),
(45, 1, 'deals', 'update_stage', 13, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-26 20:57:49'),
(46, 1, 'users', 'profile_updated', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-26 20:58:24'),
(47, 1, 'deals', 'update_stage', 4, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-26 21:09:59'),
(48, 1, 'customers', 'update', 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-26 21:39:03'),
(49, 1, 'customers', 'update', 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-26 21:39:23'),
(50, 1, 'customers', 'create', 51, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-27 16:16:02'),
(51, 1, 'contacts', 'create', 13, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-27 16:24:04'),
(52, 1, 'customers', 'update', 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-27 18:24:47'),
(53, 1, 'customers', 'delete', 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-27 20:32:37'),
(54, 1, 'customers', 'update', 2, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-27 20:33:15'),
(55, 1, 'customers', 'update', 2, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-27 20:33:31'),
(56, 1, 'customers', 'delete', 51, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-27 20:40:19'),
(57, 1, 'customers', 'create', 51, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-28 16:36:28'),
(58, 1, 'customers', 'update', 51, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-28 16:37:01'),
(59, 1, 'customers', 'update', 51, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-28 16:37:33'),
(60, 1, 'contacts', 'create', 14, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-28 16:39:11'),
(61, 1, 'notes', 'create', 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-28 16:40:02'),
(62, 1, 'customers', 'delete', 51, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-28 18:29:14'),
(63, 1, 'contacts', 'update', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-28 18:29:41'),
(64, 1, 'contacts', 'update', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-28 19:06:05'),
(65, 1, 'contacts', 'create', 15, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-28 20:09:23'),
(66, 1, 'contacts', 'delete', 12, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-29 15:29:13'),
(67, 1, 'contacts', 'delete', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-29 15:29:23'),
(68, 1, 'contacts', 'delete', 15, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-29 15:29:30'),
(69, 1, 'deals', 'update_stage', 14, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-29 15:29:48'),
(70, 1, 'deals', 'delete', 3, '::1', 'curl/8.7.1', '2026-07-29 16:58:43'),
(71, 1, 'deals', 'delete', 3, '::1', 'curl/8.7.1', '2026-07-29 17:01:42'),
(72, 1, 'deals', 'create', 16, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-30 04:23:49'),
(73, 1, 'deals', 'update', 16, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-30 04:24:37'),
(74, 1, 'deals', 'delete', 16, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-30 04:25:13'),
(75, 1, 'meetings', 'update', 7, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-30 04:30:42'),
(76, 1, 'meetings', 'update', 7, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-30 04:31:13'),
(77, 1, 'meetings', 'create', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-30 04:47:18'),
(78, 1, 'meetings', 'delete', 6, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-30 04:53:36'),
(79, 1, 'meetings', 'delete', 9, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-30 04:53:41'),
(80, 1, 'meetings', 'update', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-30 04:54:03'),
(81, 1, 'meetings', 'update', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-30 04:54:15'),
(82, 1, 'meetings', 'update', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-30 04:55:51'),
(83, 1, 'meetings', 'delete', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-30 04:56:22'),
(84, 1, 'tasks', 'create', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-30 05:06:58'),
(85, 1, 'tasks', 'update', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-30 05:07:14'),
(86, 1, 'tasks', 'update', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-30 05:07:31'),
(87, 1, 'tasks', 'update', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-30 05:11:45'),
(88, 1, 'tasks', 'delete', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-30 05:11:52'),
(89, 1, 'quotes', 'update', 2, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-30 15:42:26'),
(90, 1, 'quotes', 'update', 2, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-30 15:42:46'),
(91, 1, 'quotes', 'create', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-30 15:44:27'),
(92, 1, 'quotes', 'delete', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-30 15:47:23'),
(93, 1, 'quotes', 'update', 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-07-30 15:59:19'),
(94, 1, 'invoices', 'update', 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-30 17:31:42'),
(95, 1, 'products', 'update', 8, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-30 17:50:16'),
(96, 1, 'products', 'update', 8, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-30 18:03:44'),
(97, 1, 'products', 'update', 8, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-30 18:03:53'),
(98, 1, 'products', 'update', 8, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-30 18:04:00'),
(99, 1, 'products', 'create', 16, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-30 18:04:39'),
(100, 1, 'products', 'delete', 16, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-30 18:06:46'),
(101, 1, 'tickets', 'reply', 2, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-31 04:24:41'),
(102, 1, 'tickets', 'update_status', 2, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-31 04:29:27'),
(103, 1, 'tickets', 'create', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-31 04:30:08'),
(104, 1, 'tickets', 'create', 12, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-31 04:38:05'),
(105, 1, 'tickets', 'update_status', 12, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-31 04:38:43'),
(106, 1, 'tickets', 'delete', 12, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-31 04:47:06'),
(107, 1, 'tickets', 'delete', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-31 04:47:15'),
(108, 1, 'email_templates', 'create', 6, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-07-31 04:48:07'),
(110, 1, 'users', 'created', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-08-01 03:33:21'),
(111, 1, 'users', 'deleted', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-08-01 03:33:40'),
(112, 1, 'roles', 'update', 2, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-08-01 03:37:54'),
(113, 1, 'roles', 'update', 2, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-08-01 03:37:55'),
(114, 1, 'roles', 'update', 2, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-08-01 03:38:21'),
(115, 1, 'roles', 'update', 5, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-08-01 03:39:07'),
(116, 1, 'roles', 'update', 2, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-08-01 03:39:42'),
(121, 1, 'settings', 'update', 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-08-01 03:53:55'),
(122, 1, 'settings', 'backup', 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-08-01 03:54:17'),
(123, 1, 'settings', 'backup', 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-08-01 03:54:24'),
(124, 1, 'auth', 'logout', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', '2026-08-01 03:54:50'),
(125, 1, 'customers', 'update', 2, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:00:52'),
(126, 1, 'customers', 'create', 51, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:02:43'),
(127, 1, 'customers', 'update', 51, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:03:14'),
(128, 1, 'customers', 'delete', 51, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:03:20'),
(129, 1, 'contacts', 'create', 14, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:04:37'),
(130, 1, 'contacts', 'update', 14, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:04:53'),
(131, 1, 'deals', 'update_stage', 9, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:05:07'),
(132, 1, 'deals', 'update_stage', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:05:15'),
(133, 1, 'deals', 'create', 16, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:07:56'),
(134, 1, 'meetings', 'create', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:10:39'),
(135, 1, 'meetings', 'update', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:11:05'),
(136, 1, 'meetings', 'delete', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:11:11'),
(137, 1, 'tasks', 'create', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:12:27'),
(138, 1, 'tasks', 'update', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:13:16'),
(139, 1, 'tasks', 'delete', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:13:21'),
(140, 1, 'quotes', 'create', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:15:46'),
(141, 1, 'quotes', 'create', 12, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:15:46'),
(142, 1, 'quotes', 'update', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:16:22'),
(143, 1, 'quotes', 'update', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:16:22'),
(144, 1, 'quotes', 'delete', 11, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:16:26'),
(145, 1, 'invoices', 'update', 4, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:17:27'),
(146, 1, 'invoices', 'update', 4, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:17:27'),
(147, 1, 'products', 'create', 16, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:19:50'),
(148, 1, 'products', 'update', 16, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:20:05'),
(149, 1, 'products', 'update', 16, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:20:05'),
(150, 1, 'tickets', 'reply', 3, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:21:57'),
(151, 1, 'tickets', 'update_status', 3, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:22:04'),
(152, 1, 'users', 'created', 12, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:26:12'),
(153, 1, 'users', 'updated', 12, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:26:21'),
(154, 1, 'users', 'deleted', 12, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:26:27'),
(155, 1, 'roles', 'create', 7, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:27:45'),
(157, 1, 'settings', 'update', 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:29:19'),
(158, 1, 'auth', 'logout', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:29:35'),
(159, 1, 'deals', 'update_stage', 2, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-01 04:31:24');

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `module` varchar(100) DEFAULT NULL,
  `record_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `table_name` varchar(100) NOT NULL,
  `record_id` int(11) DEFAULT NULL,
  `action` enum('create','update','delete') NOT NULL,
  `old_values` json DEFAULT NULL,
  `new_values` json DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `customer_code` varchar(50) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `customer_type` enum('company','individual') DEFAULT 'company',
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `industry` varchar(100) DEFAULT NULL,
  `tax_number` varchar(100) DEFAULT NULL,
  `billing_address` text,
  `shipping_address` text,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `notes` text,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `assigned_to`, `customer_code`, `company_name`, `customer_type`, `first_name`, `last_name`, `email`, `phone`, `mobile`, `website`, `industry`, `tax_number`, `billing_address`, `shipping_address`, `city`, `state`, `country`, `postal_code`, `status`, `notes`, `image`, `created_at`, `updated_at`) VALUES
(2, 4, 'CUST-002', 'GreenLeaf Industries', 'company', 'Bob', 'Smith', 'bob@greenleaf.com', '+1-555-1002', '+1-555-2002', 'https://greenleaf.com', 'Manufacturing', 'TAX-1002', '456 Green Ave', '456 Green Ave', 'Chicago', 'Illinois', 'USA', '60601', 'active', 'Manufacturing client', 'uploads/customers/130638F5.jpeg', '2026-07-24 06:34:05', '2026-08-01 12:00:52'),
(3, 5, 'CUST-003', 'BlueOcean Media', 'company', 'Carol', 'Williams', 'carol@blueocean.com', '+1-555-1003', '+1-555-2003', 'https://blueocean.com', 'Media', 'TAX-1003', '789 Media Blvd', '789 Media Blvd', 'New York', 'New York', 'USA', '10001', 'active', 'Media agency', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(4, 5, 'CUST-004', 'RedRock Realty', 'company', 'Dan', 'Brown', 'dan@redrock.com', '+1-555-1004', '+1-555-2004', 'https://redrock.com', 'Real Estate', 'TAX-1004', '321 Realty Dr', '321 Realty Dr', 'Miami', 'Florida', 'USA', '33101', 'active', 'Real estate partner', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(5, 6, 'CUST-005', 'SilverLine Logistics', 'company', 'Eve', 'Davis', 'eve@silverline.com', '+1-555-1005', '+1-555-2005', 'https://silverline.com', 'Logistics', 'TAX-1005', '654 Logistics Pkwy', '654 Logistics Pkwy', 'Houston', 'Texas', 'USA', '77001', 'active', 'Logistics provider', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(6, 3, 'CUST-006', 'GoldStar Financial', 'company', 'Frank', 'Miller', 'frank@goldstar.com', '+1-555-1006', '+1-555-2006', 'https://goldstar.com', 'Finance', 'TAX-1006', '987 Finance Ave', '987 Finance Ave', 'Boston', 'Massachusetts', 'USA', '02101', 'active', 'Financial services', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(7, 4, 'CUST-007', 'BrightPath Education', 'company', 'Grace', 'Wilson', 'grace@brightpath.com', '+1-555-1007', '+1-555-2007', 'https://brightpath.com', 'Education', 'TAX-1007', '147 Education Ln', '147 Education Ln', 'Seattle', 'Washington', 'USA', '98101', 'active', 'Education sector', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(8, 5, 'CUST-008', 'Quantum Healthcare', 'company', 'Henry', 'Moore', 'henry@quantumhealth.com', '+1-555-1008', '+1-555-2008', 'https://quantumhealth.com', 'Healthcare', 'TAX-1008', '258 Health Dr', '258 Health Dr', 'Atlanta', 'Georgia', 'USA', '30301', 'active', 'Healthcare client', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(9, 6, 'CUST-009', 'Summit Construction', 'company', 'Ivy', 'Taylor', 'ivy@summitconst.com', '+1-555-1009', '+1-555-2009', 'https://summitconst.com', 'Construction', 'TAX-1009', '369 Build St', '369 Build St', 'Denver', 'Colorado', 'USA', '80201', 'active', 'Construction company', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(10, 3, 'CUST-010', 'Pioneer Energy', 'company', 'Jack', 'Anderson', 'jack@pioneerenergy.com', '+1-555-1010', '+1-555-2010', 'https://pioneerenergy.com', 'Energy', 'TAX-1010', '741 Energy Blvd', '741 Energy Blvd', 'Dallas', 'Texas', 'USA', '75201', 'active', 'Energy sector', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(11, 4, 'CUST-011', 'Atlas Global Trading', 'company', 'Karen', 'Thomas', 'karen@atlasglobal.com', '+1-555-1011', '+1-555-2011', 'https://atlasglobal.com', 'Trading', 'TAX-1011', '852 Trade Ct', '852 Trade Ct', 'Los Angeles', 'California', 'USA', '90001', 'active', 'Trading partner', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(12, 5, 'CUST-012', 'NovaStar Insurance', 'company', 'Leo', 'Jackson', 'leo@novastar.com', '+1-555-1012', '+1-555-2012', 'https://novastar.com', 'Insurance', 'TAX-1012', '963 Insurance Ln', '963 Insurance Ln', 'Phoenix', 'Arizona', 'USA', '85001', 'active', 'Insurance client', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(13, 6, 'CUST-013', 'Vertex Digital', 'company', 'Mia', 'White', 'mia@vertexdigital.com', '+1-555-1013', '+1-555-2013', 'https://vertexdigital.com', 'Technology', 'TAX-1013', '159 Digital Ave', '159 Digital Ave', 'Austin', 'Texas', 'USA', '73301', 'active', 'Digital agency', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(14, 4, 'CUST-014', 'Apex Security', 'company', 'Noah', 'Harris', 'noah@apexsecurity.com', '+1-555-1014', '+1-555-2014', 'https://apexsecurity.com', 'Security', 'TAX-1014', '753 Security St', '753 Security St', 'San Diego', 'California', 'USA', '92101', 'active', 'Security services', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(15, 5, 'CUST-015', 'Crestview Hospitality', 'company', 'Olivia', 'Martin', 'olivia@crestview.com', '+1-555-1015', '+1-555-2015', 'https://crestview.com', 'Hospitality', 'TAX-1015', '951 Hotel Blvd', '951 Hotel Blvd', 'Las Vegas', 'Nevada', 'USA', '89101', 'active', 'Hospitality group', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(16, 6, 'CUST-016', 'Dynamic Solutions Inc', 'company', 'Peter', 'Garcia', 'peter@dynamicsol.com', '+1-555-1016', '+1-555-2016', 'https://dynamicsol.com', 'Consulting', 'TAX-1016', '357 Consult Dr', '357 Consult Dr', 'Portland', 'Oregon', 'USA', '97201', 'active', 'Consulting firm', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(17, 4, 'CUST-017', 'Elite Sports Group', 'company', 'Quinn', 'Martinez', 'quinn@elitesports.com', '+1-555-1017', '+1-555-2017', 'https://elitesports.com', 'Sports', 'TAX-1017', '258 Sports Ave', '258 Sports Ave', 'Philadelphia', 'Pennsylvania', 'USA', '19101', 'active', 'Sports organization', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(18, 5, 'CUST-018', 'Harbor Freight Co', 'company', 'Rachel', 'Robinson', 'rachel@harborfreight.com', '+1-555-1018', '+1-555-2018', 'https://harborfreight.com', 'Transportation', 'TAX-1018', '654 Harbor St', '654 Harbor St', 'Baltimore', 'Maryland', 'USA', '21201', 'active', 'Transportation company', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(19, 6, 'CUST-019', 'Innova Pharmaceuticals', 'company', 'Sam', 'Clark', 'sam@innovapharma.com', '+1-555-1019', '+1-555-2019', 'https://innovapharma.com', 'Pharmaceutical', 'TAX-1019', '951 Pharma Dr', '951 Pharma Dr', 'Raleigh', 'North Carolina', 'USA', '27601', 'active', 'Pharma client', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(20, 3, 'CUST-020', 'Jade Technologies', 'company', 'Tina', 'Lewis', 'tina@jadetech.com', '+1-555-1020', '+1-555-2020', 'https://jadetech.com', 'Technology', 'TAX-1020', '753 Tech Park', '753 Tech Park', 'San Jose', 'California', 'USA', '95101', 'active', 'Tech startup', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(21, 4, 'CUST-021', 'Keystone Partners', 'company', 'Uma', 'Lee', 'uma@keystonepartners.com', '+1-555-1021', '+1-555-2021', 'https://keystonepartners.com', 'Consulting', 'TAX-1021', '159 Partner Way', '159 Partner Way', 'Minneapolis', 'Minnesota', 'USA', '55401', 'active', 'Strategic partner', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(22, 5, 'CUST-022', 'Lighthouse Media Group', 'company', 'Victor', 'Walker', 'victor@lighthousemedia.com', '+1-555-1022', '+1-555-2022', 'https://lighthousemedia.com', 'Media', 'TAX-1022', '357 Media Ave', '357 Media Ave', 'Nashville', 'Tennessee', 'USA', '37201', 'active', 'Media group', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(23, 6, 'CUST-023', 'Magnolia Retail', 'company', 'Wendy', 'Hall', 'wendy@magnoliaretail.com', '+1-555-1023', '+1-555-2023', 'https://magnoliaretail.com', 'Retail', 'TAX-1023', '852 Retail Row', '852 Retail Row', 'Charlotte', 'North Carolina', 'USA', '28201', 'active', 'Retail chain', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(24, 4, 'CUST-024', 'NorthStar Analytics', 'company', 'Xander', 'Allen', 'xander@northstaranalytics.com', '+1-555-1024', '+1-555-2024', 'https://northstaranalytics.com', 'Analytics', 'TAX-1024', '963 Data Dr', '963 Data Dr', 'Detroit', 'Michigan', 'USA', '48201', 'active', 'Data analytics', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(25, 5, 'CUST-025', 'Omega Software', 'company', 'Yara', 'Young', 'yara@omegasoft.com', '+1-555-1025', '+1-555-2025', 'https://omegasoft.com', 'Software', 'TAX-1025', '147 Code Ln', '147 Code Ln', 'Indianapolis', 'Indiana', 'USA', '46201', 'active', 'Software company', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(26, 6, 'CUST-026', 'Prime Properties', 'company', 'Zack', 'King', 'zack@primeprops.com', '+1-555-1026', '+1-555-2026', 'https://primeprops.com', 'Real Estate', 'TAX-1026', '258 Estate Dr', '258 Estate Dr', 'Tampa', 'Florida', 'USA', '33601', 'active', 'Property management', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(27, 4, 'CUST-027', 'Quest Legal Services', 'company', 'Amy', 'Wright', 'amy@questlegal.com', '+1-555-1027', '+1-555-2027', 'https://questlegal.com', 'Legal', 'TAX-1027', '369 Law St', '369 Law St', 'Washington', 'District of Columbia', 'USA', '20001', 'active', 'Legal firm', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(28, 5, 'CUST-028', 'Resonance Audio', 'company', 'Ben', 'Lopez', 'ben@resonanceaudio.com', '+1-555-1028', '+1-555-2028', 'https://resonanceaudio.com', 'Entertainment', 'TAX-1028', '741 Sound Blvd', '741 Sound Blvd', 'Los Angeles', 'California', 'USA', '90002', 'active', 'Audio production', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(29, 6, 'CUST-029', 'Skyline Advertising', 'company', 'Cathy', 'Hill', 'cathy@skylinead.com', '+1-555-1029', '+1-555-2029', 'https://skylinead.com', 'Advertising', 'TAX-1029', '852 Ad Ave', '852 Ad Ave', 'New York', 'New York', 'USA', '10002', 'active', 'Advertising agency', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(30, 3, 'CUST-030', 'Titan Machinery', 'company', 'Derek', 'Scott', 'derek@titanmach.com', '+1-555-1030', '+1-555-2030', 'https://titanmach.com', 'Manufacturing', 'TAX-1030', '963 Factory Ln', '963 Factory Ln', 'Cleveland', 'Ohio', 'USA', '44101', 'active', 'Heavy machinery', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(31, 4, 'CUST-031', 'John Doe Consulting', 'individual', 'John', 'Doe', 'john.doe@email.com', '+1-555-1031', '+1-555-2031', 'https://johndoe.com', 'Consulting', 'TAX-1031', '123 Main St', '123 Main St', 'Portland', 'Oregon', 'USA', '97202', 'active', 'Independent consultant', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(32, 5, 'CUST-032', 'Jane Smith Design', 'individual', 'Jane', 'Smith', 'jane.smith@email.com', '+1-555-1032', '+1-555-2032', 'https://janesmith.design', 'Design', 'TAX-1032', '456 Oak Ave', '456 Oak Ave', 'Austin', 'Texas', 'USA', '73302', 'active', 'Freelance designer', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(33, 6, 'CUST-033', 'Dr. Robert Chen', 'individual', 'Robert', 'Chen', 'dr.chen@email.com', '+1-555-1033', '+1-555-2033', NULL, 'Healthcare', 'TAX-1033', '789 Pine St', '789 Pine St', 'Seattle', 'Washington', 'USA', '98102', 'active', 'Medical professional', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(34, 4, 'CUST-034', 'Maria Garcia Law', 'individual', 'Maria', 'Garcia', 'maria.garcia@email.com', '+1-555-1034', '+1-555-2034', 'https://mariagarcialaw.com', 'Legal', 'TAX-1034', '321 Elm St', '321 Elm St', 'Miami', 'Florida', 'USA', '33102', 'active', 'Attorney', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(35, 5, 'CUST-035', 'Tom Wilson Photography', 'individual', 'Tom', 'Wilson', 'tom.wilson@email.com', '+1-555-1035', '+1-555-2035', 'https://tomwilsonphoto.com', 'Photography', 'TAX-1035', '654 Birch St', '654 Birch St', 'Denver', 'Colorado', 'USA', '80202', 'active', 'Photographer', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(36, 6, 'CUST-036', 'Apex Agri Corp', 'company', 'Aaron', 'Baker', 'aaron@apexagri.com', '+1-555-1036', '+1-555-2036', 'https://apexagri.com', 'Agriculture', 'TAX-1036', '147 Farm Rd', '147 Farm Rd', 'Kansas City', 'Missouri', 'USA', '64101', 'active', 'Agriculture company', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(37, 4, 'CUST-037', 'Blue Ridge Telecom', 'company', 'Bella', 'Nelson', 'bella@blueridgetel.com', '+1-555-1037', '+1-555-2037', 'https://blueridgetel.com', 'Telecommunications', 'TAX-1037', '258 Tower Dr', '258 Tower Dr', 'Richmond', 'Virginia', 'USA', '23201', 'active', 'Telecom provider', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(38, 5, 'CUST-038', 'Cobalt Mining Co', 'company', 'Chris', 'Carter', 'chris@cobaltmining.com', '+1-555-1038', '+1-555-2038', 'https://cobaltmining.com', 'Mining', 'TAX-1038', '369 Mine Ave', '369 Mine Ave', 'Pittsburgh', 'Pennsylvania', 'USA', '15201', 'active', 'Mining operation', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(39, 6, 'CUST-039', 'Delta Robotics', 'company', 'Diana', 'Mitchell', 'diana@deltarobotics.com', '+1-555-1039', '+1-555-2039', 'https://deltarobotics.com', 'Robotics', 'TAX-1039', '741 Robot Ave', '741 Robot Ave', 'Detroit', 'Michigan', 'USA', '48202', 'active', 'Robotics company', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(40, 3, 'CUST-040', 'Eagle Aerospace', 'company', 'Edward', 'Roberts', 'edward@eagleaero.com', '+1-555-1040', '+1-555-2040', 'https://eagleaero.com', 'Aerospace', 'TAX-1040', '852 Flight St', '852 Flight St', 'Huntsville', 'Alabama', 'USA', '35801', 'active', 'Aerospace contractor', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(41, 4, 'CUST-041', 'Fusion Biotech', 'company', 'Fiona', 'Turner', 'fiona@fusionbio.com', '+1-555-1041', '+1-555-2041', 'https://fusionbio.com', 'Biotechnology', 'TAX-1041', '963 Bio Ln', '963 Bio Ln', 'Cambridge', 'Massachusetts', 'USA', '02102', 'active', 'Biotech research', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(42, 5, 'CUST-042', 'Global Trade Partners', 'company', 'George', 'Phillips', 'george@globaltrade.com', '+1-555-1042', '+1-555-2042', 'https://globaltrade.com', 'Trading', 'TAX-1042', '159 Trade Way', '159 Trade Way', 'Newark', 'New Jersey', 'USA', '07101', 'active', 'International trade', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(43, 6, 'CUST-043', 'Hydro Electric Corp', 'company', 'Helen', 'Campbell', 'helen@hydroelectric.com', '+1-555-1043', '+1-555-2043', 'https://hydroelectric.com', 'Energy', 'TAX-1043', '753 Power Dr', '753 Power Dr', 'Buffalo', 'New York', 'USA', '14201', 'active', 'Energy company', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(44, 4, 'CUST-044', 'Iris Cloud Services', 'company', 'Ian', 'Parker', 'ian@iriscloud.com', '+1-555-1044', '+1-555-2044', 'https://iriscloud.com', 'Technology', 'TAX-1044', '951 Cloud Ave', '951 Cloud Ave', 'Salt Lake City', 'Utah', 'USA', '84101', 'active', 'Cloud services', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(45, 5, 'CUST-045', 'Jupiter Marine', 'company', 'Julia', 'Evans', 'julia@jupitermarine.com', '+1-555-1045', '+1-555-2045', 'https://jupitermarine.com', 'Marine', 'TAX-1045', '357 Harbor Blvd', '357 Harbor Blvd', 'Norfolk', 'Virginia', 'USA', '23501', 'active', 'Marine logistics', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(46, 6, 'CUST-046', 'Kappa Food Group', 'company', 'Kevin', 'Edwards', 'kevin@kappafood.com', '+1-555-1046', '+1-555-2046', 'https://kappafood.com', 'Food & Beverage', 'TAX-1046', '258 Food Ave', '258 Food Ave', 'St. Louis', 'Missouri', 'USA', '63101', 'active', 'Food distribution', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(47, 4, 'CUST-047', 'Lunar Space Tech', 'company', 'Laura', 'Collins', 'laura@lunarspace.com', '+1-555-1047', '+1-555-2047', 'https://lunarspace.com', 'Aerospace', 'TAX-1047', '147 Space Blvd', '147 Space Blvd', 'Orlando', 'Florida', 'USA', '32801', 'active', 'Space technology', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(48, 5, 'CUST-048', 'Morgan Financial Group', 'company', 'Mark', 'Stewart', 'mark@morganfinancial.com', '+1-555-1048', '+1-555-2048', 'https://morganfinancial.com', 'Finance', 'TAX-1048', '369 Finance St', '369 Finance St', 'San Francisco', 'California', 'USA', '94106', 'active', 'Investment firm', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(49, 6, 'CUST-049', 'Nebula Gaming', 'company', 'Nina', 'Sanchez', 'nina@nebulagaming.com', '+1-555-1049', '+1-555-2049', 'https://nebulagaming.com', 'Gaming', 'TAX-1049', '852 Game Dr', '852 Game Dr', 'Los Angeles', 'California', 'USA', '90003', 'active', 'Gaming studio', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(50, 3, 'CUST-050', 'Orion Defense Systems', 'company', 'Oscar', 'Morris', 'oscar@oriondefense.com', '+1-555-1050', '+1-555-2050', 'https://oriondefense.com', 'Defense', 'TAX-1050', '963 Defense Pkwy', '963 Defense Pkwy', 'Arlington', 'Virginia', 'USA', '22201', 'active', 'Defense contractor', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05');

-- --------------------------------------------------------

--
-- Table structure for table `customer_contacts`
--

CREATE TABLE `customer_contacts` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `is_primary` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_contacts`
--

INSERT INTO `customer_contacts` (`id`, `customer_id`, `first_name`, `last_name`, `designation`, `email`, `phone`, `mobile`, `is_primary`, `created_at`, `updated_at`) VALUES
(3, 2, 'Carol', 'Smith', 'Director', 'carol@greenleaf.com', '+1-555-1002', '+1-555-2002', 1, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(4, 3, 'Dan', 'Williams', 'Marketing Head', 'dan@blueocean.com', '+1-555-1003', '+1-555-2003', 1, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(5, 4, 'Eve', 'Brown', 'VP Sales', 'eve@redrock.com', '+1-555-1004', '+1-555-2004', 1, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(6, 5, 'Frank', 'Davis', 'Operations Manager', 'frank@silverline.com', '+1-555-1005', '+1-555-2005', 1, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(7, 6, 'Grace', 'Miller', 'CFO', 'grace@goldstar.com', '+1-555-1006', '+1-555-2006', 1, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(8, 7, 'Henry', 'Wilson', 'Principal', 'henry@brightpath.com', '+1-555-1007', '+1-555-2007', 1, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(9, 8, 'Ivy', 'Moore', 'Medical Director', 'ivy@quantumhealth.com', '+1-555-1008', '+1-555-2008', 1, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(10, 9, 'Jack', 'Taylor', 'Project Manager', 'jack@summitconst.com', '+1-555-1009', '+1-555-2009', 1, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(13, 36, 'contact1', 'lastname', 'test', 'testcontact@gmail.com', '324234', '34234', 0, '2026-07-28 00:24:04', '2026-08-01 12:04:37'),
(14, 36, 'Catlin', 'Ednalan', 'Marketing Head', 'catlin@test.com', '234234234', '24234234', 1, '2026-08-01 12:04:37', '2026-08-01 12:04:53');

-- --------------------------------------------------------

--
-- Table structure for table `customer_documents`
--

CREATE TABLE `customer_documents` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer_tags`
--

CREATE TABLE `customer_tags` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `color` varchar(20) DEFAULT '#6c757d',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_tags`
--

INSERT INTO `customer_tags` (`id`, `name`, `color`, `created_at`, `updated_at`) VALUES
(1, 'VIP', '#ffc107', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(2, 'New', '#0d6efd', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(3, 'Regular', '#198754', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(4, 'Priority', '#dc3545', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(5, 'Enterprise', '#6610f2', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(6, 'Startup', '#fd7e14', '2026-07-24 06:34:05', '2026-07-24 06:34:05');

-- --------------------------------------------------------

--
-- Table structure for table `customer_tag_map`
--

CREATE TABLE `customer_tag_map` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_tag_map`
--

INSERT INTO `customer_tag_map` (`id`, `customer_id`, `tag_id`) VALUES
(33, 2, 3),
(4, 3, 4),
(5, 4, 3),
(6, 5, 5),
(7, 6, 1),
(8, 7, 2),
(9, 8, 4),
(10, 9, 3),
(11, 10, 5),
(12, 11, 2),
(13, 12, 3),
(14, 13, 6),
(15, 14, 1),
(16, 15, 5),
(17, 16, 6),
(18, 17, 3),
(19, 18, 3),
(20, 19, 1),
(21, 20, 6),
(22, 21, 1),
(23, 22, 3),
(24, 23, 5),
(25, 24, 6),
(26, 25, 5),
(27, 26, 3),
(28, 27, 2),
(29, 28, 3),
(30, 29, 4);

-- --------------------------------------------------------

--
-- Table structure for table `deals`
--

CREATE TABLE `deals` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `lead_id` int(11) DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `stage_id` int(11) DEFAULT NULL,
  `deal_name` varchar(255) NOT NULL,
  `expected_value` decimal(12,2) DEFAULT '0.00',
  `probability` int(11) DEFAULT '0',
  `expected_close_date` date DEFAULT NULL,
  `status` enum('open','won','lost') DEFAULT 'open',
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `deals`
--

INSERT INTO `deals` (`id`, `customer_id`, `lead_id`, `assigned_to`, `stage_id`, `deal_name`, `expected_value`, `probability`, `expected_close_date`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 4, 2, 'TechCorp Enterprise Suite', '75000.00', 60, '2026-09-15', 'open', 'Full CRM suite implementation', '2026-07-24 06:34:05', '2026-07-26 23:00:39'),
(2, 2, 2, 5, 5, 'GreenLeaf Supply Chain', '45000.00', 75, '2026-08-30', 'open', 'Supply chain management module', '2026-07-24 06:34:05', '2026-08-01 12:31:24'),
(4, 4, 4, 3, 6, 'RedRock Property Management', '95000.00', 90, '2026-07-15', 'open', 'Property management system - 90% probability', '2026-07-24 06:34:05', '2026-07-27 05:09:59'),
(5, 5, 5, 4, 1, 'SilverLine Fleet Tracking', '25000.00', 20, '2026-11-01', 'open', 'Fleet tracking solution', '2026-07-24 06:34:05', '2026-07-27 04:55:31'),
(6, 6, 6, 5, 5, 'GoldStar Financial Portal', '120000.00', 85, '2026-08-01', 'open', 'Financial portal development', '2026-07-24 06:34:05', '2026-07-27 04:35:34'),
(7, 7, 7, 6, 3, 'BrightPath LMS', '30000.00', 35, '2026-10-15', 'open', 'Learning management system', '2026-07-24 06:34:05', '2026-07-26 23:25:17'),
(8, 8, 8, 4, 4, 'Quantum Health Records', '85000.00', 70, '2026-09-01', 'open', 'Electronic health records system', '2026-07-24 06:34:05', '2026-07-25 02:23:03'),
(9, 9, 9, 5, 3, 'Summit Project Tracker', '20000.00', 15, '2026-12-01', 'open', 'Project tracking software', '2026-07-24 06:34:05', '2026-08-01 12:05:07'),
(10, 10, 10, 6, 6, 'Pioneer Energy Dashboard', '150000.00', 95, '2026-07-01', 'open', 'Energy monitoring dashboard - almost closed', '2026-07-24 06:34:05', '2026-07-25 02:10:13'),
(11, NULL, 1, 4, 5, 'TechCorp Maintenance Contract', '25000.00', 80, '2026-08-15', 'open', 'Annual maintenance contract', '2026-07-24 06:34:05', '2026-08-01 12:05:15'),
(12, 3, 3, 5, 3, 'BlueOcean Analytics Suite', '55000.00', 55, '2026-09-30', 'open', 'Data analytics add-on', '2026-07-24 06:34:05', '2026-07-27 04:34:02'),
(13, 5, 5, 6, 2, 'SilverLine IoT Integration', '40000.00', 65, '2026-10-01', 'open', 'IoT sensors integration', '2026-07-24 06:34:05', '2026-07-27 04:57:49'),
(14, 7, 7, 4, 5, 'BrightPath Student Portal', '28000.00', 50, '2026-11-01', 'open', 'Student self-service portal', '2026-07-24 06:34:05', '2026-07-29 23:29:48'),
(15, 10, 10, 5, 2, 'Pioneer Safety System', '35000.00', 30, '2026-12-15', 'open', 'Safety compliance system', '2026-07-24 06:34:05', '2026-07-27 03:45:46'),
(16, 3, 28, 5, 1, 'BlueOcean Analytics Suite', '55000.00', 55, '2026-09-26', 'open', 'Data analytics add-on', '2026-08-01 12:07:56', '2026-08-01 12:07:56');

-- --------------------------------------------------------

--
-- Table structure for table `deal_stages`
--

CREATE TABLE `deal_stages` (
  `id` int(11) NOT NULL,
  `pipeline_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `color` varchar(20) DEFAULT '#6c757d',
  `sort_order` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `deal_stages`
--

INSERT INTO `deal_stages` (`id`, `pipeline_id`, `name`, `color`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'New', '#0d6efd', 0, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(2, 1, 'Qualified', '#6610f2', 1, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(3, 1, 'Proposal', '#fd7e14', 2, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(4, 1, 'Negotiation', '#ffc107', 3, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(5, 1, 'Won', '#198754', 4, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(6, 1, 'Lost', '#dc3545', 5, '2026-07-24 06:34:05', '2026-07-24 06:34:05');

-- --------------------------------------------------------

--
-- Table structure for table `email_logs`
--

CREATE TABLE `email_logs` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `template_id` int(11) DEFAULT NULL,
  `recipient` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `status` enum('sent','failed') DEFAULT 'sent',
  `sent_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `name`, `subject`, `body`, `created_at`, `updated_at`) VALUES
(1, 'Welcome Email', 'Welcome to CRM Pro!', '<h1>Welcome {{name}}!</h1><p>Thank you for choosing CRM Pro. We are excited to have you on board.</p>', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(2, 'Invoice Reminder', 'Invoice Payment Reminder', '<p>Dear {{customer_name}},</p><p>This is a reminder that invoice {{invoice_number}} of ${{amount}} is due on {{due_date}}.</p>', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(3, 'Meeting Reminder', 'Meeting Reminder: {{meeting_title}}', '<p>Hi {{name}},</p><p>This is a reminder for your meeting <strong>{{meeting_title}}</strong> scheduled on {{meeting_date}} at {{meeting_time}}.</p>', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(4, 'Task Assignment', 'New Task Assigned: {{task_title}}', '<p>Hi {{name}},</p><p>A new task <strong>{{task_title}}</strong> has been assigned to you with due date {{due_date}}.</p>', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(5, 'Ticket Confirmation', 'Support Ticket #{{ticket_number}} Confirmation', '<p>Dear {{customer_name}},</p><p>Your support ticket #{{ticket_number}} has been created. We will get back to you shortly.</p>', '2026-07-24 06:34:05', '2026-07-24 06:34:05');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `quote_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `invoice_number` varchar(50) NOT NULL,
  `invoice_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `subtotal` decimal(12,2) DEFAULT '0.00',
  `tax` decimal(12,2) DEFAULT '0.00',
  `discount` decimal(12,2) DEFAULT '0.00',
  `total` decimal(12,2) DEFAULT '0.00',
  `paid_amount` decimal(12,2) DEFAULT '0.00',
  `balance` decimal(12,2) DEFAULT '0.00',
  `status` enum('draft','sent','partial','paid','overdue','cancelled') DEFAULT 'draft',
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `customer_id`, `quote_id`, `created_by`, `invoice_number`, `invoice_date`, `due_date`, `subtotal`, `tax`, `discount`, `total`, `paid_amount`, `balance`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 3, 3, 6, 'INV-2026-0001', '2026-07-15', '2026-08-14', '5789.92', '-99575.52', '25000.00', '-118785.60', '37000.00', '-155785.60', 'paid', 'Ad platform - Paid in full', '2026-07-24 06:34:05', '2026-07-31 01:31:42'),
(2, 6, 6, 6, 'INV-2026-0002', '2026-07-28', '2026-08-27', '120000.00', '12000.00', '10000.00', '122000.00', '61000.00', '61000.00', 'partial', 'Financial portal - 50% paid', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(3, NULL, 1, 4, 'INV-2026-0003', '2026-07-20', '2026-08-19', '75000.00', '7500.00', '5000.00', '77500.00', '0.00', '77500.00', 'sent', 'Enterprise suite - awaiting payment', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(4, 4, 4, 4, 'INV-2026-0004', '2026-08-01', '2026-08-31', '28079.84', '-2933991.25', '255999.70', '-3161911.11', '99500.00', '-3261411.11', 'paid', 'Property management - Paid', '2026-07-24 06:34:05', '2026-08-01 12:17:27'),
(5, 8, 8, 5, 'INV-2026-0005', '2026-08-05', '2026-09-04', '85000.00', '8500.00', '5000.00', '88500.00', '0.00', '88500.00', 'sent', 'Health records - sent for payment', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(6, 10, 10, 4, 'INV-2026-0006', '2026-08-10', '2026-09-09', '150000.00', '15000.00', '10000.00', '155000.00', '0.00', '155000.00', 'draft', 'Energy dashboard - draft', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(7, 2, 2, 5, 'INV-2026-0007', '2026-08-12', '2026-09-11', '45000.00', '4500.00', '2000.00', '47500.00', '47500.00', '0.00', 'paid', 'Supply chain - Paid', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(8, 9, 9, 6, 'INV-2026-0008', '2026-08-15', '2026-09-14', '20000.00', '2000.00', '1000.00', '21000.00', '0.00', '21000.00', 'sent', 'Project tracker - sent', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(9, 7, 7, 4, 'INV-2026-0009', '2026-08-18', '2026-09-17', '30000.00', '3000.00', '2000.00', '31000.00', '0.00', '31000.00', 'draft', 'LMS - draft', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(10, 5, 5, 5, 'INV-2026-0010', '2026-08-20', '2026-09-19', '25000.00', '2500.00', '1000.00', '26500.00', '13250.00', '13250.00', 'partial', 'Fleet tracking - 50% paid', '2026-07-24 06:34:05', '2026-07-24 06:34:05');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT '1',
  `price` decimal(12,2) DEFAULT '0.00',
  `tax` decimal(12,2) DEFAULT '0.00',
  `discount` decimal(12,2) DEFAULT '0.00',
  `total` decimal(12,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `product_id`, `quantity`, `price`, `tax`, `discount`, `total`) VALUES
(4, 2, 3, 20, '199.99', '399.98', '500.00', '3499.80'),
(5, 2, 4, 2, '5000.00', '1000.00', '0.00', '10000.00'),
(6, 2, 6, 24, '999.00', '2397.60', '1000.00', '22976.00'),
(7, 3, 3, 10, '199.99', '199.99', '100.00', '1899.90'),
(8, 3, 4, 1, '5000.00', '500.00', '500.00', '5000.00'),
(9, 3, 2, 1, '150.00', '15.00', '0.00', '150.00'),
(13, 1, 2, 8, '79.99', '63.99', '0.00', '1049.40'),
(14, 1, 4, 1, '5000.00', '500.00', '500.00', '-120000.00'),
(15, 1, 5, 1, '150.00', '10.00', '0.00', '165.00'),
(20, 4, 3, 15, '199.99', '299.99', '200.00', '-11999.10'),
(21, 4, 4, 2, '5000.00', '1000.00', '1000.00', '-990000.00'),
(22, 4, 7, 1, '15000.00', '1500.00', '1000.00', '-2160000.00'),
(23, 4, 2, 1, '79.99', '10.00', '0.00', '87.99');

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` int(11) NOT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `expected_revenue` decimal(12,2) DEFAULT '0.00',
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `notes` text,
  `converted_customer_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `assigned_to`, `source_id`, `status_id`, `company`, `first_name`, `last_name`, `email`, `phone`, `website`, `expected_revenue`, `priority`, `notes`, `converted_customer_id`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 1, 'InnoTech Solutions', 'Adam', 'Taylor', 'adam@innotech.com', '+1-555-3001', 'https://innotech.com', '50000.00', 'high', 'Interested in CRM platform', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(2, 5, 2, 2, 'Pinnacle Group', 'Beth', 'Anderson', 'beth@pinnacle.com', '+1-555-3002', 'https://pinnacle.com', '35000.00', 'medium', 'Referred by existing client', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(3, 6, 3, 1, 'Vanguard Systems', 'Carl', 'Thomas', 'carl@vanguard.com', '+1-555-3003', 'https://vanguard.com', '75000.00', 'high', 'From LinkedIn outreach', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(4, 3, 4, 3, 'Zenith Corp', 'Diana', 'Harris', 'diana@zenithcorp.com', '+1-555-3004', 'https://zenithcorp.com', '25000.00', 'medium', 'Responded to email campaign', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(5, 4, 5, 2, 'CoreBridge Ltd', 'Eric', 'Martin', 'eric@corebridge.com', '+1-555-3005', 'https://corebridge.com', '60000.00', 'high', 'Phone inquiry about enterprise plan', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(6, 5, 6, 1, 'FusionWorks', 'Fiona', 'Garcia', 'fiona@fusionworks.com', '+1-555-3006', 'https://fusionworks.com', '40000.00', 'medium', 'Met at trade show', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(7, 6, 7, 4, 'Horizon Media', 'Greg', 'Martinez', 'greg@horizonmedia.com', '+1-555-3007', 'https://horizonmedia.com', '55000.00', 'high', 'Social media campaign lead', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(8, 4, 8, 2, 'Ironclad Security', 'Holly', 'Robinson', 'holly@ironclad.com', '+1-555-3008', 'https://ironclad.com', '30000.00', 'medium', 'Cold call follow-up', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(9, 5, 9, 1, 'Junction Networks', 'Ivan', 'Clark', 'ivan@junctionnet.com', '+1-555-3009', 'https://junctionnet.com', '45000.00', 'low', 'Partner referral', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(10, 6, 10, 3, 'Kensington Ltd', 'Julia', 'Lewis', 'julia@kensington.com', '+1-555-3010', 'https://kensington.com', '80000.00', 'high', 'Other source - direct inquiry', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(11, 4, 1, 1, 'Liberty Tech', 'Kevin', 'Lee', 'kevin@libertytech.com', '+1-555-3011', 'https://libertytech.com', '20000.00', 'medium', 'Website form submission', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(12, 5, 2, 2, 'Meridian Health', 'Linda', 'Walker', 'linda@meridianhealth.com', '+1-555-3012', 'https://meridianhealth.com', '65000.00', 'high', 'Referral from healthcare partner', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(13, 6, 3, 1, 'NorthPoint Logistics', 'Mike', 'Hall', 'mike@northpointlog.com', '+1-555-3013', 'https://northpointlog.com', '35000.00', 'medium', 'LinkedIn campaign', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(14, 4, 4, 4, 'Optimum Retail', 'Nina', 'Allen', 'nina@optimumretail.com', '+1-555-3014', 'https://optimumretail.com', '70000.00', 'high', 'Email campaign response', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(15, 5, 5, 2, 'Pacific Solutions', 'Oscar', 'Young', 'oscar@pacificsol.com', '+1-555-3015', 'https://pacificsol.com', '40000.00', 'medium', 'Phone inquiry', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(16, 6, 6, 1, 'Quantum Finance', 'Patty', 'King', 'patty@quantumfin.com', '+1-555-3016', 'https://quantumfin.com', '90000.00', 'high', 'Financial conference lead', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(17, 4, 7, 3, 'Ridgewood Properties', 'Quinn', 'Wright', 'quinn@ridgewood.com', '+1-555-3017', 'https://ridgewood.com', '55000.00', 'medium', 'Social media', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(18, 5, 8, 2, 'Starlight Entertainment', 'Ray', 'Lopez', 'ray@starlightent.com', '+1-555-3018', 'https://starlightent.com', '30000.00', 'low', 'Cold outreach', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(19, 6, 9, 1, 'Titan Robotics', 'Sara', 'Hill', 'sara@titanrobotics.com', '+1-555-3019', 'https://titanrobotics.com', '85000.00', 'high', 'Partner referral', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(20, 3, 10, 4, 'United Energy', 'Tom', 'Scott', 'tom@unitedenergy.com', '+1-555-3020', 'https://unitedenergy.com', '95000.00', 'high', 'Direct inquiry from website', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(21, 4, 1, 1, 'Vertex Ventures', 'Uma', 'Baker', 'uma@vertexventures.com', '+1-555-3021', 'https://vertexventures.com', '25000.00', 'medium', 'Website lead', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(22, 5, 2, 2, 'WebSphere Tech', 'Vince', 'Nelson', 'vince@websphere.com', '+1-555-3022', 'https://websphere.com', '50000.00', 'high', 'Referral from partner', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(23, 6, 3, 1, 'Xenon Data', 'Wendy', 'Carter', 'wendy@xenondata.com', '+1-555-3023', 'https://xenondata.com', '40000.00', 'medium', 'LinkedIn ad', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(24, 4, 4, 3, 'Yellowstone Hospitality', 'Xavier', 'Mitchell', 'xavier@yellowstone.com', '+1-555-3024', 'https://yellowstone.com', '60000.00', 'medium', 'Email campaign', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(25, 5, 5, 2, 'Zenith Aerospace', 'Yvonne', 'Roberts', 'yvonne@zenithacro.com', '+1-555-3025', 'https://zenithacro.com', '100000.00', 'high', 'Phone inquiry - decision maker', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(26, 6, 6, 1, 'Alpha Legal Services', 'Zane', 'Turner', 'zane@alphalegal.com', '+1-555-3026', 'https://alphalegal.com', '30000.00', 'low', 'Legal conference', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(27, 4, 7, 4, 'Brighton Education', 'Amy', 'Phillips', 'amy@brightonedu.com', '+1-555-3027', 'https://brightonedu.com', '45000.00', 'medium', 'Social media campaign', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(28, 5, 8, 2, 'CloudBase Systems', 'Brian', 'Campbell', 'brian@cloudbase.com', '+1-555-3028', 'https://cloudbase.com', '55000.00', 'high', 'Direct cold call', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(29, 6, 9, 1, 'Drake Manufacturing', 'Cindy', 'Parker', 'cindy@drakemfg.com', '+1-555-3029', 'https://drakemfg.com', '70000.00', 'medium', 'Partner network', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(30, 3, 10, 3, 'Everest Insurance', 'Derek', 'Evans', 'derek@everestins.com', '+1-555-3030', 'https://everestins.com', '35000.00', 'medium', 'Direct inquiry', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(31, 4, 1, 1, 'First Federal Bank', 'Elaine', 'Edwards', 'elaine@firstfed.com', '+1-555-3031', 'https://firstfed.com', '120000.00', 'high', 'Website demo request', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(32, 5, 2, 2, 'Green Earth NGO', 'Fred', 'Collins', 'fred@greenearth.org', '+1-555-3032', 'https://greenearth.org', '15000.00', 'low', 'Referral from board member', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(33, 6, 3, 1, 'Helix Pharmaceuticals', 'Gina', 'Stewart', 'gina@helixpharma.com', '+1-555-3033', 'https://helixpharma.com', '80000.00', 'high', 'LinkedIn connection', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(34, 4, 4, 4, 'Integrity IT Solutions', 'Hank', 'Sanchez', 'hank@integrityit.com', '+1-555-3034', 'https://integrityit.com', '50000.00', 'medium', 'Email campaign', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(35, 5, 5, 2, 'Jasper Construction', 'Iris', 'Morris', 'iris@jasperconst.com', '+1-555-3035', 'https://jasperconst.com', '65000.00', 'high', 'Phone inquiry - new project', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(36, 6, 6, 1, 'Knight Security Systems', 'Jake', 'Rogers', 'jake@knightsec.com', '+1-555-3036', 'https://knightsec.com', '40000.00', 'medium', 'Security expo', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(37, 4, 7, 3, 'Lyon Properties', 'Kara', 'Reed', 'kara@lyonprops.com', '+1-555-3037', 'https://lyonprops.com', '55000.00', 'medium', 'Social media', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(38, 5, 8, 2, 'Matrix Consulting', 'Liam', 'Cook', 'liam@matrixconsult.com', '+1-555-3038', 'https://matrixconsult.com', '30000.00', 'low', 'Cold outreach', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(39, 6, 9, 1, 'NovaNutri Foods', 'Mona', 'Morgan', 'mona@novanutri.com', '+1-555-3039', 'https://novanutri.com', '45000.00', 'medium', 'Partner referral', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(40, 3, 10, 4, 'Omega Defense', 'Nate', 'Bell', 'nate@omegadefense.com', '+1-555-3040', 'https://omegadefense.com', '150000.00', 'high', 'Government contract inquiry', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(41, 4, 1, 1, 'Pearl Hospitality', 'Olive', 'Murphy', 'olive@pearlhospitality.com', '+1-555-3041', 'https://pearlhospitality.com', '35000.00', 'medium', 'Website inquiry', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(42, 5, 2, 2, 'Quantum Publishing', 'Paul', 'Bailey', 'paul@quantumpub.com', '+1-555-3042', 'https://quantumpub.com', '20000.00', 'low', 'Referral', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(43, 6, 3, 1, 'Redstone Mining', 'Queen', 'Rivera', 'queen@redstonemine.com', '+1-555-3043', 'https://redstonemine.com', '85000.00', 'high', 'LinkedIn campaign', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(44, 4, 4, 3, 'Summit Education', 'Rick', 'Cooper', 'rick@summitedu.com', '+1-555-3044', 'https://summitedu.com', '40000.00', 'medium', 'Email campaign', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(45, 5, 5, 2, 'Trident Maritime', 'Sue', 'Richardson', 'sue@tridentmaritime.com', '+1-555-3045', 'https://tridentmaritime.com', '70000.00', 'high', 'Industry expo', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(46, 6, 6, 1, 'Umbra Gaming Studio', 'Troy', 'Cox', 'troy@umbragaming.com', '+1-555-3046', 'https://umbragaming.com', '25000.00', 'medium', 'Gaming convention', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(47, 4, 7, 4, 'Vortex Analytics', 'Ursula', 'Howard', 'ursula@vortexanalytics.com', '+1-555-3047', 'https://vortexanalytics.com', '60000.00', 'high', 'Social media ad', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(48, 5, 8, 2, 'WhiteStar Energy', 'Victor', 'Ward', 'victor@whitestar.com', '+1-555-3048', 'https://whitestar.com', '95000.00', 'high', 'Energy summit', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(49, 6, 9, 1, 'Xylem Tech', 'Willow', 'Torres', 'willow@xylemtech.com', '+1-555-3049', 'https://xylemtech.com', '30000.00', 'medium', 'Partner referral', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(50, 3, 10, 3, 'Yorkshire Financial', 'Xander', 'Peterson', 'xander@yorkshirefin.com', '+1-555-3050', 'https://yorkshirefin.com', '50000.00', 'medium', 'Direct inquiry', NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05');

-- --------------------------------------------------------

--
-- Table structure for table `lead_activities`
--

CREATE TABLE `lead_activities` (
  `id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `activity` varchar(255) NOT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lead_sources`
--

CREATE TABLE `lead_sources` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lead_sources`
--

INSERT INTO `lead_sources` (`id`, `name`, `created_at`) VALUES
(1, 'Website', '2026-07-24 06:34:05'),
(2, 'Referral', '2026-07-24 06:34:05'),
(3, 'LinkedIn', '2026-07-24 06:34:05'),
(4, 'Email Campaign', '2026-07-24 06:34:05'),
(5, 'Phone Inquiry', '2026-07-24 06:34:05'),
(6, 'Trade Show', '2026-07-24 06:34:05'),
(7, 'Social Media', '2026-07-24 06:34:05'),
(8, 'Cold Call', '2026-07-24 06:34:05'),
(9, 'Partner', '2026-07-24 06:34:05'),
(10, 'Other', '2026-07-24 06:34:05');

-- --------------------------------------------------------

--
-- Table structure for table `lead_statuses`
--

CREATE TABLE `lead_statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `color` varchar(20) DEFAULT '#6c757d',
  `sort_order` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lead_statuses`
--

INSERT INTO `lead_statuses` (`id`, `name`, `color`, `sort_order`) VALUES
(1, 'New', '#0d6efd', 0),
(2, 'Contacted', '#6610f2', 1),
(3, 'Qualified', '#198754', 2),
(4, 'Proposal', '#fd7e14', 3),
(5, 'Negotiation', '#ffc107', 4),
(6, 'Won', '#198754', 5),
(7, 'Lost', '#dc3545', 6);

-- --------------------------------------------------------

--
-- Table structure for table `login_logs`
--

CREATE TABLE `login_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `login_time` timestamp NULL DEFAULT NULL,
  `logout_time` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `operating_system` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login_logs`
--

INSERT INTO `login_logs` (`id`, `user_id`, `login_time`, `logout_time`, `ip_address`, `browser`, `operating_system`) VALUES
(1, 1, '2026-07-25 01:14:58', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Darwin'),
(2, 1, '2026-07-25 01:20:00', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Darwin'),
(3, 1, '2026-07-25 01:27:11', NULL, '::1', 'curl/8.7.1', 'Darwin'),
(4, 1, '2026-07-25 01:32:22', NULL, '::1', 'curl/8.7.1', 'Darwin'),
(5, 1, '2026-07-25 02:04:21', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Darwin'),
(6, 1, '2026-07-25 02:13:10', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Darwin'),
(7, 1, '2026-07-26 22:20:23', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Darwin'),
(8, 1, '2026-07-27 02:50:56', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', 'Darwin'),
(9, 1, '2026-07-27 03:45:39', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', 'Darwin'),
(10, 1, '2026-07-30 00:48:16', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', 'Darwin'),
(11, 1, '2026-07-30 00:54:36', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', 'Darwin'),
(12, 1, '2026-07-30 00:57:33', NULL, '::1', 'curl/8.7.1', 'Darwin'),
(13, 2, '2026-07-30 00:57:36', NULL, '::1', 'curl/8.7.1', 'Darwin'),
(14, 1, '2026-07-30 00:57:45', NULL, '::1', 'curl/8.7.1', 'Darwin'),
(15, 1, '2026-07-30 00:57:49', NULL, '::1', 'curl/8.7.1', 'Darwin'),
(16, 1, '2026-07-30 01:01:35', NULL, '::1', 'curl/8.7.1', 'Darwin'),
(17, 1, '2026-07-30 02:02:47', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Darwin'),
(18, 1, '2026-07-30 02:03:13', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'Darwin'),
(19, 1, '2026-07-30 12:17:15', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'Darwin'),
(20, 1, '2026-07-30 12:50:09', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'Darwin'),
(21, 1, '2026-07-30 23:10:36', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'Darwin'),
(22, 1, '2026-07-30 23:30:58', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'Darwin'),
(23, 1, '2026-07-30 23:47:11', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'Darwin'),
(24, 1, '2026-07-31 01:02:25', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'Darwin'),
(25, 1, '2026-07-31 02:06:35', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', 'Darwin'),
(26, 1, '2026-07-31 12:22:58', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', 'Darwin'),
(27, 1, '2026-07-31 12:59:23', NULL, '::1', 'curl/8.7.1', 'Darwin'),
(28, 1, '2026-08-01 11:39:33', '2026-08-01 11:54:50', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 OPR/133.0.0.0', 'Darwin'),
(29, 1, '2026-08-01 11:59:45', '2026-08-01 12:29:35', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'Darwin'),
(30, 1, '2026-08-01 12:31:04', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'Darwin'),
(31, 1, '2026-08-01 13:06:49', NULL, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'Darwin');

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `id` int(11) NOT NULL,
  `organizer_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `lead_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `meeting_date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `description` text,
  `meeting_type` enum('internal','client','phone','video') DEFAULT 'internal',
  `status` enum('scheduled','completed','cancelled') DEFAULT 'scheduled',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`id`, `organizer_id`, `customer_id`, `lead_id`, `title`, `location`, `meeting_date`, `start_time`, `end_time`, `description`, `meeting_type`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, NULL, NULL, 'TechCorp Demo Session', 'Virtual - Zoom', '2026-08-12', '10:00:00', '11:30:00', 'Product demonstration of enterprise CRM suite', 'video', 'scheduled', '2026-07-24 06:34:05', '2026-07-30 12:28:01'),
(2, 5, 2, NULL, 'GreenLeaf Proposal Review', 'GreenLeaf Office - Chicago', '2026-08-07', '14:00:00', '15:00:00', 'Review and discuss proposal details', 'internal', 'scheduled', '2026-07-24 06:34:05', '2026-07-30 12:28:01'),
(3, 6, NULL, 1, 'InnoTech Discovery Call', 'Virtual - Teams', '2026-08-05', '11:00:00', '11:45:00', 'Initial discovery call with Adam Taylor', 'video', 'scheduled', '2026-07-24 06:34:05', '2026-07-30 12:28:01'),
(4, 4, NULL, 4, 'Zenith Corp Requirements', 'Virtual - Zoom', '2026-08-10', '09:00:00', '10:30:00', 'Gather detailed requirements', 'video', 'scheduled', '2026-07-24 06:34:05', '2026-07-30 12:28:01'),
(5, 5, 3, NULL, 'BlueOcean Strategy Meeting', 'BlueOcean Office - NY', '2026-08-14', '13:00:00', '14:30:00', 'Strategic planning for ad platform', 'internal', 'scheduled', '2026-07-24 06:34:05', '2026-07-30 12:28:01'),
(7, 4, 4, NULL, 'RedRock Contract Signing', 'RedRock Office - Miami', '2026-08-01', '15:00:00', '16:00:00', 'Final contract review and signing', 'internal', 'scheduled', '2026-07-24 06:34:05', '2026-07-30 12:31:13'),
(8, 5, NULL, 2, 'Pinnacle Group Introduction', 'Virtual - Zoom', '2026-08-08', '14:00:00', '14:30:00', 'Introduction call with Beth Anderson', 'video', 'scheduled', '2026-07-24 06:34:05', '2026-07-30 12:28:01'),
(10, 3, NULL, 6, 'FusionWorks Follow-up', 'Virtual - Zoom', '2026-08-11', '10:30:00', '11:00:00', 'Follow-up after trade show meeting', 'video', 'scheduled', '2026-07-24 06:34:05', '2026-07-30 12:28:01');

-- --------------------------------------------------------

--
-- Table structure for table `meeting_attendees`
--

CREATE TABLE `meeting_attendees` (
  `id` int(11) NOT NULL,
  `meeting_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `lead_id` int(11) DEFAULT NULL,
  `deal_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text,
  `type` varchar(50) DEFAULT 'info',
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `payment_method` enum('cash','check','bank_transfer','credit_card','other') DEFAULT 'bank_transfer',
  `transaction_reference` varchar(255) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT '0.00',
  `payment_date` date DEFAULT NULL,
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `invoice_id`, `customer_id`, `payment_method`, `transaction_reference`, `amount`, `payment_date`, `notes`, `created_at`) VALUES
(1, 1, 3, 'bank_transfer', 'BT-2026-001', '37000.00', '2026-07-20', 'Full payment for ad platform', '2026-07-24 06:34:05'),
(2, 2, 6, 'bank_transfer', 'BT-2026-002', '61000.00', '2026-08-01', '50% deposit for financial portal', '2026-07-24 06:34:05'),
(3, 4, 4, 'credit_card', 'CC-2026-001', '99500.00', '2026-08-05', 'Full payment - credit card', '2026-07-24 06:34:05'),
(4, 7, 2, 'check', 'CHK-2026-001', '47500.00', '2026-08-15', 'Check received - supply chain', '2026-07-24 06:34:05'),
(5, 10, 5, 'bank_transfer', 'BT-2026-003', '13250.00', '2026-08-22', '50% deposit for fleet tracking', '2026-07-24 06:34:05');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `module` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `slug`, `module`, `created_at`, `updated_at`) VALUES
(1, 'View Dashboard', 'view_dashboard', 'Dashboard', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(2, 'Manage Users', 'manage_users', 'Users', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(3, 'Create Users', 'create_users', 'Users', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(4, 'Edit Users', 'edit_users', 'Users', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(5, 'Delete Users', 'delete_users', 'Users', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(6, 'Manage Roles', 'manage_roles', 'Roles', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(7, 'Manage Permissions', 'manage_permissions', 'Permissions', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(8, 'Manage Customers', 'manage_customers', 'Customers', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(9, 'Create Customers', 'create_customers', 'Customers', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(10, 'Edit Customers', 'edit_customers', 'Customers', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(11, 'Delete Customers', 'delete_customers', 'Customers', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(12, 'View Customers', 'view_customers', 'Customers', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(13, 'Manage Leads', 'manage_leads', 'Leads', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(14, 'Create Leads', 'create_leads', 'Leads', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(15, 'Edit Leads', 'edit_leads', 'Leads', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(16, 'Delete Leads', 'delete_leads', 'Leads', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(17, 'View Leads', 'view_leads', 'Leads', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(18, 'Manage Deals', 'manage_deals', 'Deals', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(19, 'Create Deals', 'create_deals', 'Deals', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(20, 'Edit Deals', 'edit_deals', 'Deals', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(21, 'Delete Deals', 'delete_deals', 'Deals', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(22, 'View Deals', 'view_deals', 'Deals', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(23, 'Manage Tasks', 'manage_tasks', 'Tasks', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(24, 'Manage Meetings', 'manage_meetings', 'Meetings', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(25, 'Manage Products', 'manage_products', 'Products', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(26, 'Manage Quotes', 'manage_quotes', 'Quotes', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(27, 'Manage Invoices', 'manage_invoices', 'Invoices', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(28, 'Manage Payments', 'manage_payments', 'Payments', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(29, 'Manage Tickets', 'manage_tickets', 'Tickets', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(30, 'Manage Email', 'manage_email', 'Email', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(31, 'View Reports', 'view_reports', 'Reports', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(32, 'Manage Settings', 'manage_settings', 'Settings', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(33, 'View Activity Logs', 'view_activity_logs', 'Activity Logs', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(34, 'View Audit Logs', 'view_audit_logs', 'Audit Logs', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(35, 'Manage Notifications', 'manage_notifications', 'Notifications', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(36, 'View Contacts', 'contacts_view', 'Contacts', '2026-07-25 01:38:42', '2026-07-25 01:38:42'),
(37, 'Create Contacts', 'contacts_create', 'Contacts', '2026-07-25 01:38:42', '2026-07-25 01:38:42'),
(38, 'Edit Contacts', 'contacts_edit', 'Contacts', '2026-07-25 01:38:42', '2026-07-25 01:38:42'),
(39, 'Delete Contacts', 'contacts_delete', 'Contacts', '2026-07-25 01:38:42', '2026-07-25 01:38:42'),
(40, 'View Users', 'users_view', 'Users', '2026-07-31 12:55:51', '2026-07-31 12:55:51'),
(41, 'Create Users', 'users_create', 'Users', '2026-07-31 12:55:51', '2026-07-31 12:55:51'),
(42, 'Edit Users', 'users_edit', 'Users', '2026-07-31 12:55:51', '2026-07-31 12:55:51'),
(43, 'Delete Users', 'users_delete', 'Users', '2026-07-31 12:55:51', '2026-07-31 12:55:51'),
(44, 'View Roles', 'roles_view', 'Roles', '2026-07-31 12:55:51', '2026-07-31 12:55:51'),
(45, 'Create Roles', 'roles_create', 'Roles', '2026-07-31 12:55:51', '2026-07-31 12:55:51'),
(46, 'Edit Roles', 'roles_edit', 'Roles', '2026-07-31 12:55:51', '2026-07-31 12:55:51'),
(47, 'Delete Roles', 'roles_delete', 'Roles', '2026-07-31 12:55:51', '2026-07-31 12:55:51'),
(48, 'View Permissions', 'permissions_view', 'Permissions', '2026-07-31 12:55:51', '2026-07-31 12:55:51'),
(49, 'Create Permissions', 'permissions_create', 'Permissions', '2026-07-31 12:55:51', '2026-07-31 12:55:51'),
(50, 'Delete Permissions', 'permissions_delete', 'Permissions', '2026-07-31 12:55:51', '2026-07-31 12:55:51'),
(51, 'View Activity Logs', 'activity_logs_view', 'Activity Logs', '2026-07-31 12:55:51', '2026-07-31 12:55:51'),
(52, 'View Audit Logs', 'audit_logs_view', 'Audit Logs', '2026-07-31 12:55:51', '2026-07-31 12:55:51'),
(53, 'Delete Activity Logs', 'activity_logs_delete', 'Activity Logs', '2026-08-01 11:44:49', '2026-08-01 11:44:49');

-- --------------------------------------------------------

--
-- Table structure for table `pipelines`
--

CREATE TABLE `pipelines` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pipelines`
--

INSERT INTO `pipelines` (`id`, `name`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'Sales Pipeline', 1, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(2, 'Support Pipeline', 0, '2026-07-24 06:34:05', '2026-07-24 06:34:05');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text,
  `unit_price` decimal(12,2) DEFAULT '0.00',
  `tax_rate` decimal(5,2) DEFAULT '0.00',
  `stock_quantity` int(11) DEFAULT '0',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `sku`, `product_name`, `description`, `unit_price`, `tax_rate`, `stock_quantity`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'CRM-BASIC', 'CRM Basic License', 'Basic CRM license per user per month', '29.99', '10.00', 999, 'active', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(2, 1, 'CRM-PRO', 'CRM Pro License', 'Professional CRM license per user per month', '79.99', '10.00', 999, 'active', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(3, 1, 'CRM-ENT', 'CRM Enterprise License', 'Enterprise CRM license per user per month', '199.99', '10.00', 999, 'active', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(4, 2, 'SVC-IMPL', 'Implementation Service', 'CRM implementation and setup service', '5000.00', '10.00', 999, 'active', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(5, 2, 'SVC-CUST', 'Customization Service', 'Custom CRM customization per hour', '150.00', '10.00', 999, 'active', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(6, 2, 'SVC-SUPP', 'Premium Support', 'Premium support package per month', '999.00', '10.00', 999, 'active', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(7, 3, 'HW-SERV', 'Server Hardware', 'Dedicated server hardware', '15000.00', '10.00', 50, 'active', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(8, 4, 'CON-STRA', 'Strategic Consulting', 'Strategic consulting per day', '2500.00', '10.00', 999, 'active', '2026-07-24 06:34:05', '2026-07-31 02:04:00'),
(9, 4, 'CON-TECH', 'Technical Consulting', 'Technical consulting per hour', '200.00', '10.00', 999, 'active', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(10, 5, 'TRN-BASIC', 'Basic Training', 'Basic CRM training per person', '500.00', '10.00', 999, 'active', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(11, 5, 'TRN-ADV', 'Advanced Training', 'Advanced CRM training per person', '1200.00', '10.00', 999, 'active', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(12, 1, 'CRM-MOBILE', 'Mobile App License', 'Mobile CRM app license per user', '19.99', '10.00', 999, 'active', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(13, 1, 'CRM-API', 'API Access License', 'API access license', '499.00', '10.00', 999, 'active', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(14, 2, 'SVC-DATA', 'Data Migration Service', 'Data migration from legacy systems', '3500.00', '10.00', 999, 'active', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(15, 5, 'TRN-CUST', 'Custom Training', 'Customized training program', '3000.00', '10.00', 999, 'active', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(16, 5, 'SKU-TRAINING', 'Basic Training 2', 'Basic CRM training Group person', '500.00', '10.00', 100, 'active', '2026-08-01 12:19:50', '2026-08-01 12:20:05');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `category_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Software', 'Software products and licenses', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(2, 'Services', 'Professional services', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(3, 'Hardware', 'Hardware equipment', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(4, 'Consulting', 'Consulting services', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(5, 'Training', 'Training and certification', '2026-07-24 06:34:05', '2026-07-24 06:34:05');

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE `quotes` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `quote_number` varchar(50) NOT NULL,
  `quote_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `subtotal` decimal(12,2) DEFAULT '0.00',
  `tax` decimal(12,2) DEFAULT '0.00',
  `discount` decimal(12,2) DEFAULT '0.00',
  `total` decimal(12,2) DEFAULT '0.00',
  `status` enum('draft','sent','accepted','rejected','converted') DEFAULT 'draft',
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quotes`
--

INSERT INTO `quotes` (`id`, `customer_id`, `created_by`, `quote_number`, `quote_date`, `expiry_date`, `subtotal`, `tax`, `discount`, `total`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 2, 4, 'QTE-2026-0001', '2026-07-01', '2026-08-01', '7079.89', '-99992.00', '26999.90', '-119912.01', 'sent', 'Enterprise CRM suite for TechCorp', '2026-07-24 06:34:05', '2026-07-30 23:59:19'),
(2, 2, 5, 'QTE-2026-0002', '2026-07-05', '2026-08-05', '19187.95', '-674228.65', '85439.98', '-740480.68', 'draft', 'Supply chain management module', '2026-07-24 06:34:05', '2026-07-30 23:42:46'),
(3, 3, 6, 'QTE-2026-0003', '2026-07-10', '2026-08-10', '35000.00', '3500.00', '1500.00', '37000.00', 'accepted', 'Ad platform integration', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(4, 4, 4, 'QTE-2026-0004', '2026-07-15', '2026-08-15', '95000.00', '9500.00', '5000.00', '99500.00', 'sent', 'Property management system', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(5, 5, 5, 'QTE-2026-0005', '2026-07-20', '2026-08-20', '25000.00', '2500.00', '1000.00', '26500.00', 'draft', 'Fleet tracking solution', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(6, 6, 6, 'QTE-2026-0006', '2026-07-25', '2026-08-25', '120000.00', '12000.00', '10000.00', '122000.00', 'accepted', 'Financial portal - accepted', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(7, 7, 4, 'QTE-2026-0007', '2026-07-28', '2026-08-28', '30000.00', '3000.00', '2000.00', '31000.00', 'draft', 'LMS for BrightPath', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(8, 8, 5, 'QTE-2026-0008', '2026-07-30', '2026-08-30', '85000.00', '8500.00', '5000.00', '88500.00', 'sent', 'Health records system', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(9, 9, 6, 'QTE-2026-0009', '2026-08-01', '2026-09-01', '20000.00', '2000.00', '1000.00', '21000.00', 'draft', 'Project tracker', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(10, 10, 4, 'QTE-2026-0010', '2026-08-02', '2026-09-02', '150000.00', '15000.00', '10000.00', '155000.00', 'sent', 'Energy dashboard', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(12, 4, NULL, 'QTE-0012', '2026-08-01', '2026-08-03', '5299.92', '500.11', '298.80', '5501.23', 'draft', 'sample quoatation', '2026-08-01 12:15:46', '2026-08-01 12:15:46');

-- --------------------------------------------------------

--
-- Table structure for table `quote_items`
--

CREATE TABLE `quote_items` (
  `id` int(11) NOT NULL,
  `quote_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT '1',
  `price` decimal(12,2) DEFAULT '0.00',
  `tax` decimal(12,2) DEFAULT '0.00',
  `discount` decimal(12,2) DEFAULT '0.00',
  `total` decimal(12,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quote_items`
--

INSERT INTO `quote_items` (`id`, `quote_id`, `product_id`, `quantity`, `price`, `tax`, `discount`, `total`) VALUES
(7, 3, 2, 8, '79.99', '63.99', '0.00', '639.92'),
(8, 3, 4, 1, '5000.00', '500.00', '500.00', '5000.00'),
(9, 3, 5, 40, '150.00', '600.00', '0.00', '6000.00'),
(10, 4, 3, 15, '199.99', '299.99', '200.00', '2799.85'),
(11, 4, 4, 2, '5000.00', '1000.00', '1000.00', '10000.00'),
(12, 4, 7, 1, '15000.00', '1500.00', '1000.00', '15500.00'),
(16, 2, 3, 5, '199.99', '99.99', '50.00', '999.90'),
(17, 2, 4, 1, '5000.00', '500.00', '500.00', '-120000.00'),
(18, 2, 6, 12, '999.00', '1198.80', '500.00', '-622800.58'),
(19, 2, 11, 1, '1200.00', '10.00', '0.00', '1320.00'),
(22, 1, 3, 10, '199.99', '199.99', '100.00', '0.00'),
(23, 1, 4, 1, '5000.00', '500.00', '500.00', '-120000.00'),
(24, 1, 2, 1, '79.99', '10.00', '0.00', '87.99'),
(28, 12, 11, 1, '1200.00', '10.00', '4.00', '1267.20'),
(29, 12, 10, 5, '500.00', '10.00', '10.00', '2475.00'),
(30, 12, 3, 8, '199.99', '10.00', '0.05', '1759.03');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'Full system access', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(2, 'Admin', 'Administrative access', '2026-07-24 06:34:05', '2026-08-01 11:40:56'),
(3, 'Manager', 'Management level access', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(4, 'Sales Representative', 'Sales team member', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(5, 'Support Staff', 'Customer support team', '2026-07-24 06:34:05', '2026-08-01 11:39:07');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`, `created_at`) VALUES
(1, 1, 9, '2026-07-24 06:34:05'),
(2, 1, 19, '2026-07-24 06:34:05'),
(3, 1, 14, '2026-07-24 06:34:05'),
(4, 1, 3, '2026-07-24 06:34:05'),
(5, 1, 11, '2026-07-24 06:34:05'),
(6, 1, 21, '2026-07-24 06:34:05'),
(7, 1, 16, '2026-07-24 06:34:05'),
(8, 1, 5, '2026-07-24 06:34:05'),
(9, 1, 10, '2026-07-24 06:34:05'),
(10, 1, 20, '2026-07-24 06:34:05'),
(11, 1, 15, '2026-07-24 06:34:05'),
(12, 1, 4, '2026-07-24 06:34:05'),
(13, 1, 8, '2026-07-24 06:34:05'),
(14, 1, 18, '2026-07-24 06:34:05'),
(15, 1, 30, '2026-07-24 06:34:05'),
(16, 1, 27, '2026-07-24 06:34:05'),
(17, 1, 13, '2026-07-24 06:34:05'),
(18, 1, 24, '2026-07-24 06:34:05'),
(19, 1, 35, '2026-07-24 06:34:05'),
(20, 1, 28, '2026-07-24 06:34:05'),
(21, 1, 7, '2026-07-24 06:34:05'),
(22, 1, 25, '2026-07-24 06:34:05'),
(23, 1, 26, '2026-07-24 06:34:05'),
(24, 1, 6, '2026-07-24 06:34:05'),
(25, 1, 32, '2026-07-24 06:34:05'),
(26, 1, 23, '2026-07-24 06:34:05'),
(27, 1, 29, '2026-07-24 06:34:05'),
(28, 1, 2, '2026-07-24 06:34:05'),
(29, 1, 33, '2026-07-24 06:34:05'),
(30, 1, 34, '2026-07-24 06:34:05'),
(31, 1, 12, '2026-07-24 06:34:05'),
(32, 1, 1, '2026-07-24 06:34:05'),
(33, 1, 22, '2026-07-24 06:34:05'),
(34, 1, 17, '2026-07-24 06:34:05'),
(35, 1, 31, '2026-07-24 06:34:05'),
(127, 3, 9, '2026-07-24 06:34:05'),
(128, 3, 19, '2026-07-24 06:34:05'),
(129, 3, 14, '2026-07-24 06:34:05'),
(130, 3, 10, '2026-07-24 06:34:05'),
(131, 3, 20, '2026-07-24 06:34:05'),
(132, 3, 15, '2026-07-24 06:34:05'),
(133, 3, 8, '2026-07-24 06:34:05'),
(134, 3, 18, '2026-07-24 06:34:05'),
(135, 3, 30, '2026-07-24 06:34:05'),
(136, 3, 27, '2026-07-24 06:34:05'),
(137, 3, 13, '2026-07-24 06:34:05'),
(138, 3, 24, '2026-07-24 06:34:05'),
(139, 3, 35, '2026-07-24 06:34:05'),
(140, 3, 28, '2026-07-24 06:34:05'),
(141, 3, 25, '2026-07-24 06:34:05'),
(142, 3, 26, '2026-07-24 06:34:05'),
(143, 3, 23, '2026-07-24 06:34:05'),
(144, 3, 29, '2026-07-24 06:34:05'),
(145, 3, 12, '2026-07-24 06:34:05'),
(146, 3, 1, '2026-07-24 06:34:05'),
(147, 3, 22, '2026-07-24 06:34:05'),
(148, 3, 17, '2026-07-24 06:34:05'),
(149, 3, 31, '2026-07-24 06:34:05'),
(158, 4, 9, '2026-07-24 06:34:05'),
(159, 4, 19, '2026-07-24 06:34:05'),
(160, 4, 14, '2026-07-24 06:34:05'),
(161, 4, 10, '2026-07-24 06:34:05'),
(162, 4, 20, '2026-07-24 06:34:05'),
(163, 4, 15, '2026-07-24 06:34:05'),
(164, 4, 24, '2026-07-24 06:34:05'),
(165, 4, 25, '2026-07-24 06:34:05'),
(166, 4, 23, '2026-07-24 06:34:05'),
(167, 4, 12, '2026-07-24 06:34:05'),
(168, 4, 1, '2026-07-24 06:34:05'),
(169, 4, 22, '2026-07-24 06:34:05'),
(170, 4, 17, '2026-07-24 06:34:05'),
(179, 1, 37, '2026-07-25 01:38:42'),
(180, 1, 39, '2026-07-25 01:38:42'),
(181, 1, 38, '2026-07-25 01:38:42'),
(182, 1, 36, '2026-07-25 01:38:42'),
(187, 1, 51, '2026-07-31 12:55:51'),
(188, 1, 52, '2026-07-31 12:55:51'),
(189, 1, 49, '2026-07-31 12:55:51'),
(190, 1, 50, '2026-07-31 12:55:51'),
(191, 1, 48, '2026-07-31 12:55:51'),
(192, 1, 45, '2026-07-31 12:55:51'),
(193, 1, 47, '2026-07-31 12:55:51'),
(194, 1, 46, '2026-07-31 12:55:51'),
(195, 1, 44, '2026-07-31 12:55:51'),
(196, 1, 41, '2026-07-31 12:55:51'),
(197, 1, 43, '2026-07-31 12:55:51'),
(198, 1, 42, '2026-07-31 12:55:51'),
(199, 1, 40, '2026-07-31 12:55:51'),
(366, 5, 12, '2026-08-01 11:39:07'),
(367, 5, 1, '2026-08-01 11:39:07'),
(368, 5, 24, '2026-08-01 11:39:07'),
(369, 5, 35, '2026-08-01 11:39:07'),
(370, 5, 23, '2026-08-01 11:39:07'),
(371, 5, 29, '2026-08-01 11:39:07'),
(452, 2, 33, '2026-08-01 11:40:56'),
(453, 2, 34, '2026-08-01 11:40:56'),
(454, 2, 37, '2026-08-01 11:40:56'),
(455, 2, 39, '2026-08-01 11:40:56'),
(456, 2, 38, '2026-08-01 11:40:56'),
(457, 2, 36, '2026-08-01 11:40:56'),
(458, 2, 9, '2026-08-01 11:40:56'),
(459, 2, 11, '2026-08-01 11:40:56'),
(460, 2, 10, '2026-08-01 11:40:56'),
(461, 2, 8, '2026-08-01 11:40:56'),
(462, 2, 12, '2026-08-01 11:40:56'),
(463, 2, 1, '2026-08-01 11:40:56'),
(464, 2, 19, '2026-08-01 11:40:56'),
(465, 2, 21, '2026-08-01 11:40:56'),
(466, 2, 20, '2026-08-01 11:40:56'),
(467, 2, 18, '2026-08-01 11:40:56'),
(468, 2, 22, '2026-08-01 11:40:56'),
(469, 2, 30, '2026-08-01 11:40:56'),
(470, 2, 27, '2026-08-01 11:40:56'),
(471, 2, 14, '2026-08-01 11:40:56'),
(472, 2, 16, '2026-08-01 11:40:56'),
(473, 2, 15, '2026-08-01 11:40:56'),
(474, 2, 13, '2026-08-01 11:40:56'),
(475, 2, 17, '2026-08-01 11:40:56'),
(476, 2, 24, '2026-08-01 11:40:56'),
(477, 2, 35, '2026-08-01 11:40:56'),
(478, 2, 28, '2026-08-01 11:40:56'),
(479, 2, 25, '2026-08-01 11:40:56'),
(480, 2, 26, '2026-08-01 11:40:56'),
(481, 2, 31, '2026-08-01 11:40:56'),
(482, 2, 23, '2026-08-01 11:40:56'),
(483, 2, 29, '2026-08-01 11:40:56'),
(484, 2, 3, '2026-08-01 11:40:56'),
(485, 2, 41, '2026-08-01 11:40:56'),
(486, 2, 5, '2026-08-01 11:40:56'),
(487, 2, 43, '2026-08-01 11:40:56'),
(488, 2, 4, '2026-08-01 11:40:56'),
(489, 2, 42, '2026-08-01 11:40:56'),
(490, 2, 2, '2026-08-01 11:40:56'),
(491, 2, 40, '2026-08-01 11:40:56'),
(492, 2, 53, '2026-08-01 11:44:49'),
(493, 3, 53, '2026-08-01 11:44:49'),
(494, 4, 53, '2026-08-01 11:44:49'),
(495, 1, 53, '2026-08-01 11:44:49'),
(496, 5, 53, '2026-08-01 11:44:49');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_email` varchar(255) DEFAULT NULL,
  `company_phone` varchar(50) DEFAULT NULL,
  `address` text,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'USD',
  `timezone` varchar(50) DEFAULT 'UTC',
  `language` varchar(10) DEFAULT 'en',
  `logo` varchar(255) DEFAULT NULL,
  `smtp_host` varchar(255) DEFAULT NULL,
  `smtp_port` int(11) DEFAULT '587',
  `smtp_username` varchar(255) DEFAULT NULL,
  `smtp_password` varchar(255) DEFAULT NULL,
  `smtp_encryption` varchar(10) DEFAULT 'tls',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `company_name`, `company_email`, `company_phone`, `address`, `city`, `state`, `country`, `postal_code`, `currency`, `timezone`, `language`, `logo`, `smtp_host`, `smtp_port`, `smtp_username`, `smtp_password`, `smtp_encryption`, `created_at`, `updated_at`) VALUES
(1, 'CRM Pro', 'info@crmpro.com', '+1-555-0000', '123 Business Ave, Suite 100', 'San Francisco', 'California', 'USA', '94105', 'USD', 'America/New_York', 'en', NULL, '', 587, '', '', 'tls', '2026-07-24 06:34:05', '2026-08-01 12:29:19');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `lead_id` int(11) DEFAULT NULL,
  `deal_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `priority` enum('low','medium','high','urgent') DEFAULT 'medium',
  `status` enum('pending','in_progress','completed','cancelled') DEFAULT 'pending',
  `due_date` date DEFAULT NULL,
  `reminder_date` datetime DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `assigned_to`, `customer_id`, `lead_id`, `deal_id`, `title`, `description`, `priority`, `status`, `due_date`, `reminder_date`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 4, NULL, NULL, 1, 'Schedule demo with TechCorp', 'Set up product demonstration for the enterprise suite', 'high', 'in_progress', '2026-08-10', NULL, NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(2, 5, 2, NULL, 2, 'Send proposal to GreenLeaf', 'Prepare and send detailed proposal for supply chain module', 'high', 'pending', '2026-08-05', NULL, NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(3, 6, 3, NULL, NULL, 'Follow up on BlueOcean inquiry', 'Call Carol Williams about ad platform requirements', 'medium', 'completed', '2026-07-28', NULL, NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(4, 4, 4, NULL, 4, 'Prepare contract for RedRock', 'Draft contract for property management system', 'high', 'in_progress', '2026-08-01', NULL, NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(5, 5, 5, NULL, 5, 'Research fleet tracking solutions', 'Research available fleet tracking APIs', 'low', 'pending', '2026-08-20', NULL, NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(6, 6, NULL, 1, NULL, 'Call InnoTech lead', 'Initial call with Adam Taylor about CRM platform', 'medium', 'completed', '2026-07-25', NULL, NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(7, 4, NULL, 4, NULL, 'Follow up with Zenith Corp', 'Send additional information to Diana Harris', 'medium', 'pending', '2026-08-08', NULL, NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(8, 5, NULL, 2, NULL, 'Prepare referral reward', 'Process referral reward for Beth Anderson', 'low', 'pending', '2026-08-15', NULL, NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(9, 3, NULL, 10, NULL, 'Schedule meeting with Kensington', 'Arrange meeting with Julia Lewis about enterprise solution', 'high', 'in_progress', '2026-08-03', NULL, NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(10, 4, NULL, 7, NULL, 'Respond to Horizon Media', 'Reply to Greg Martinez about social media campaign', 'medium', 'pending', '2026-08-12', NULL, NULL, '2026-07-24 06:34:05', '2026-07-24 06:34:05');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `ticket_number` varchar(50) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `priority` enum('low','medium','high','urgent') DEFAULT 'medium',
  `status` enum('open','in_progress','resolved','closed') DEFAULT 'open',
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `customer_id`, `assigned_to`, `category_id`, `ticket_number`, `subject`, `priority`, `status`, `description`, `created_at`, `updated_at`) VALUES
(1, NULL, 7, 1, 'TKT-2026-0001', 'Cannot login to CRM dashboard', 'high', 'open', 'User reporting login issues after recent update', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(2, 2, 7, 2, 'TKT-2026-0002', 'Invoice discrepancy', 'medium', 'resolved', 'Invoice amount does not match agreed upon pricing', '2026-07-24 06:34:05', '2026-07-31 12:29:27'),
(3, 3, 8, 3, 'TKT-2026-0003', 'Need additional user licenses', 'low', 'in_progress', 'Requesting 5 additional user licenses', '2026-07-24 06:34:05', '2026-08-01 12:22:04'),
(4, 4, 7, 4, 'TKT-2026-0004', 'Feature request: Dark mode', 'low', 'resolved', 'Would like dark mode toggle in settings', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(5, 5, 8, 5, 'TKT-2026-0005', 'Data export not working', 'high', 'open', 'Export to CSV function returns empty file', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(6, 6, 7, 1, 'TKT-2026-0006', 'Slow system performance', 'medium', 'in_progress', 'System is running slow during peak hours', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(7, 7, 8, 1, 'TKT-2026-0007', 'Email notifications not sending', 'medium', 'open', 'Not receiving email notifications for tasks', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(8, 8, 7, 2, 'TKT-2026-0008', 'Payment not reflected', 'high', 'in_progress', 'Made payment 3 days ago, still shows as unpaid', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(9, 9, 8, 3, 'TKT-2026-0009', 'Account password reset', 'low', 'closed', 'Reset password link not working', '2026-07-24 06:34:05', '2026-07-24 06:34:05'),
(10, 10, 7, 4, 'TKT-2026-0010', 'Request: API integration docs', 'low', 'open', 'Need documentation for REST API', '2026-07-24 06:34:05', '2026-07-24 06:34:05');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_categories`
--

CREATE TABLE `ticket_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ticket_categories`
--

INSERT INTO `ticket_categories` (`id`, `name`, `created_at`) VALUES
(1, 'Technical Support', '2026-07-24 06:34:05'),
(2, 'Billing', '2026-07-24 06:34:05'),
(3, 'Account Management', '2026-07-24 06:34:05'),
(4, 'Feature Request', '2026-07-24 06:34:05'),
(5, 'Bug Report', '2026-07-24 06:34:05');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_replies`
--

CREATE TABLE `ticket_replies` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ticket_replies`
--

INSERT INTO `ticket_replies` (`id`, `ticket_id`, `user_id`, `message`, `attachment`, `created_at`) VALUES
(1, 1, 7, 'We are looking into this issue. Please clear your browser cache and try again.', NULL, '2026-07-24 06:34:05'),
(2, 1, 1, 'I cleared cache but still unable to login.', NULL, '2026-07-24 06:34:05'),
(3, 1, 7, 'We have identified the issue. Our team is deploying a fix.', NULL, '2026-07-24 06:34:05'),
(4, 2, 7, 'Checking the invoice details with the sales team.', NULL, '2026-07-24 06:34:05'),
(5, 2, 2, 'The discount was not applied correctly. We will issue a credit note.', NULL, '2026-07-24 06:34:05'),
(6, 4, 8, 'Thank you for the suggestion. We will add this to our roadmap.', NULL, '2026-07-24 06:34:05'),
(7, 6, 7, 'We are optimizing database queries to improve performance.', NULL, '2026-07-24 06:34:05'),
(8, 8, 7, 'Our finance team is verifying the transaction.', NULL, '2026-07-24 06:34:05'),
(9, 9, 8, 'The password reset issue has been resolved.', NULL, '2026-07-24 06:34:05'),
(10, 2, 1, 'ok', NULL, '2026-07-31 12:24:41'),
(11, 3, 1, 'ok additional user licenses', NULL, '2026-08-01 12:21:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `address` text,
  `status` enum('active','inactive') DEFAULT 'active',
  `last_login` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `first_name`, `last_name`, `username`, `email`, `password`, `phone`, `avatar`, `address`, `status`, `last_login`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Super', 'Admin', 'superadmin', 'admin@test.com', '$2y$12$ez5FM998RFyiTHIkAv.pTO.ucT4dVzrzNPwUEK85aLYXegn5i0isi', '+1-555-0100', 'uploads/avatars/096910BA.jpeg', '', 'active', '2026-08-01 13:06:49', NULL, '2026-07-24 06:34:05', '2026-08-01 13:06:49'),
(2, 2, 'John', 'Smith', 'admin', 'john@crmpro.com', '$2y$12$ez5FM998RFyiTHIkAv.pTO.ucT4dVzrzNPwUEK85aLYXegn5i0isi', '+1-555-0101', NULL, NULL, 'active', '2026-07-30 00:57:36', NULL, '2026-07-24 06:34:05', '2026-07-30 00:57:36'),
(3, 3, 'Sarah', 'Johnson', 'manager', 'sarah@crmpro.com', '$2y$12$ez5FM998RFyiTHIkAv.pTO.ucT4dVzrzNPwUEK85aLYXegn5i0isi', '+1-555-0102', NULL, NULL, 'active', NULL, NULL, '2026-07-24 06:34:05', '2026-07-25 01:19:03'),
(4, 4, 'Mike', 'Williams', 'salesrep', 'mike@crmpro.com', '$2y$12$ez5FM998RFyiTHIkAv.pTO.ucT4dVzrzNPwUEK85aLYXegn5i0isi', '+1-555-0103', NULL, NULL, 'active', NULL, NULL, '2026-07-24 06:34:05', '2026-07-25 01:19:03'),
(5, 4, 'Emily', 'Brown', 'emilyb', 'emily@crmpro.com', '$2y$12$ez5FM998RFyiTHIkAv.pTO.ucT4dVzrzNPwUEK85aLYXegn5i0isi', '+1-555-0104', NULL, NULL, 'active', NULL, NULL, '2026-07-24 06:34:05', '2026-07-25 01:19:03'),
(6, 4, 'David', 'Miller', 'davidm', 'david@crmpro.com', '$2y$12$ez5FM998RFyiTHIkAv.pTO.ucT4dVzrzNPwUEK85aLYXegn5i0isi', '+1-555-0105', NULL, NULL, 'active', NULL, NULL, '2026-07-24 06:34:05', '2026-07-25 01:19:03'),
(7, 5, 'Lisa', 'Anderson', 'lisaa', 'lisa@crmpro.com', '$2y$12$ez5FM998RFyiTHIkAv.pTO.ucT4dVzrzNPwUEK85aLYXegn5i0isi', '+1-555-0106', NULL, NULL, 'active', NULL, NULL, '2026-07-24 06:34:05', '2026-07-25 01:19:03'),
(8, 5, 'James', 'Taylor', 'jamest', 'james@crmpro.com', '$2y$12$ez5FM998RFyiTHIkAv.pTO.ucT4dVzrzNPwUEK85aLYXegn5i0isi', '+1-555-0107', NULL, NULL, 'active', NULL, NULL, '2026-07-24 06:34:05', '2026-07-25 01:19:03'),
(9, 1, 'Robert', 'Wilson', 'robertw', 'robert@crmpro.com', '$2y$12$ez5FM998RFyiTHIkAv.pTO.ucT4dVzrzNPwUEK85aLYXegn5i0isi', '+1-555-0108', NULL, NULL, 'active', NULL, NULL, '2026-07-24 06:34:05', '2026-07-25 01:19:03'),
(10, 3, 'Jennifer', 'Davis', 'jenniferd', 'jennifer@crmpro.com', '$2y$12$ez5FM998RFyiTHIkAv.pTO.ucT4dVzrzNPwUEK85aLYXegn5i0isi', '+1-555-0109', NULL, NULL, 'active', NULL, NULL, '2026-07-24 06:34:05', '2026-07-25 01:19:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_activity_user` (`user_id`),
  ADD KEY `idx_activity_module` (`module`),
  ADD KEY `idx_activity_created` (`created_at`);

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_attachments_module` (`module`,`record_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_audit_table` (`table_name`),
  ADD KEY `idx_audit_created` (`created_at`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_code` (`customer_code`),
  ADD KEY `assigned_to` (`assigned_to`),
  ADD KEY `idx_customers_email` (`email`),
  ADD KEY `idx_customers_status` (`status`),
  ADD KEY `idx_customers_code` (`customer_code`);

--
-- Indexes for table `customer_contacts`
--
ALTER TABLE `customer_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_contacts_customer` (`customer_id`);

--
-- Indexes for table `customer_documents`
--
ALTER TABLE `customer_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indexes for table `customer_tags`
--
ALTER TABLE `customer_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_tag_map`
--
ALTER TABLE `customer_tag_map`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_customer_tag` (`customer_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `deals`
--
ALTER TABLE `deals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `lead_id` (`lead_id`),
  ADD KEY `idx_deals_stage` (`stage_id`),
  ADD KEY `idx_deals_assigned` (`assigned_to`),
  ADD KEY `idx_deals_status` (`status`);

--
-- Indexes for table `deal_stages`
--
ALTER TABLE `deal_stages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_stages_pipeline` (`pipeline_id`),
  ADD KEY `idx_stages_order` (`sort_order`);

--
-- Indexes for table `email_logs`
--
ALTER TABLE `email_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `template_id` (`template_id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `quote_id` (`quote_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `idx_invoices_number` (`invoice_number`),
  ADD KEY `idx_invoices_status` (`status`),
  ADD KEY `idx_invoices_date` (`invoice_date`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `source_id` (`source_id`),
  ADD KEY `converted_customer_id` (`converted_customer_id`),
  ADD KEY `idx_leads_email` (`email`),
  ADD KEY `idx_leads_assigned` (`assigned_to`),
  ADD KEY `idx_leads_status` (`status_id`);

--
-- Indexes for table `lead_activities`
--
ALTER TABLE `lead_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_id` (`lead_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `lead_sources`
--
ALTER TABLE `lead_sources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lead_statuses`
--
ALTER TABLE `lead_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_login_user` (`user_id`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organizer_id` (`organizer_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `lead_id` (`lead_id`),
  ADD KEY `idx_meetings_date` (`meeting_date`),
  ADD KEY `idx_meetings_status` (`status`);

--
-- Indexes for table `meeting_attendees`
--
ALTER TABLE `meeting_attendees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_meeting_user` (`meeting_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `lead_id` (`lead_id`),
  ADD KEY `deal_id` (`deal_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_notifications_user` (`user_id`),
  ADD KEY `idx_notifications_read` (`is_read`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `idx_payments_invoice` (`invoice_id`),
  ADD KEY `idx_payments_date` (`payment_date`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_permissions_slug` (`slug`),
  ADD KEY `idx_permissions_module` (`module`);

--
-- Indexes for table `pipelines`
--
ALTER TABLE `pipelines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `idx_products_sku` (`sku`),
  ADD KEY `idx_products_status` (`status`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotes`
--
ALTER TABLE `quotes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `quote_number` (`quote_number`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `idx_quotes_number` (`quote_number`),
  ADD KEY `idx_quotes_status` (`status`);

--
-- Indexes for table `quote_items`
--
ALTER TABLE `quote_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quote_id` (`quote_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_roles_name` (`name`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_role_permission` (`role_id`,`permission_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `lead_id` (`lead_id`),
  ADD KEY `deal_id` (`deal_id`),
  ADD KEY `idx_tasks_assigned` (`assigned_to`),
  ADD KEY `idx_tasks_status` (`status`),
  ADD KEY `idx_tasks_due` (`due_date`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_number` (`ticket_number`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `assigned_to` (`assigned_to`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `idx_tickets_number` (`ticket_number`),
  ADD KEY `idx_tickets_status` (`status`);

--
-- Indexes for table `ticket_categories`
--
ALTER TABLE `ticket_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_users_email` (`email`),
  ADD KEY `idx_users_status` (`status`),
  ADD KEY `idx_users_role` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `customer_contacts`
--
ALTER TABLE `customer_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `customer_documents`
--
ALTER TABLE `customer_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_tags`
--
ALTER TABLE `customer_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer_tag_map`
--
ALTER TABLE `customer_tag_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `deals`
--
ALTER TABLE `deals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `deal_stages`
--
ALTER TABLE `deal_stages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `email_logs`
--
ALTER TABLE `email_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `lead_activities`
--
ALTER TABLE `lead_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lead_sources`
--
ALTER TABLE `lead_sources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `lead_statuses`
--
ALTER TABLE `lead_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `login_logs`
--
ALTER TABLE `login_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `meeting_attendees`
--
ALTER TABLE `meeting_attendees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `pipelines`
--
ALTER TABLE `pipelines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `quotes`
--
ALTER TABLE `quotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `quote_items`
--
ALTER TABLE `quote_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=497;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ticket_categories`
--
ALTER TABLE `ticket_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `attachments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `customer_contacts`
--
ALTER TABLE `customer_contacts`
  ADD CONSTRAINT `customer_contacts_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_documents`
--
ALTER TABLE `customer_documents`
  ADD CONSTRAINT `customer_documents_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_documents_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `customer_tag_map`
--
ALTER TABLE `customer_tag_map`
  ADD CONSTRAINT `customer_tag_map_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_tag_map_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `customer_tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `deals`
--
ALTER TABLE `deals`
  ADD CONSTRAINT `deals_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `deals_ibfk_2` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `deals_ibfk_3` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `deals_ibfk_4` FOREIGN KEY (`stage_id`) REFERENCES `deal_stages` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `deal_stages`
--
ALTER TABLE `deal_stages`
  ADD CONSTRAINT `deal_stages_ibfk_1` FOREIGN KEY (`pipeline_id`) REFERENCES `pipelines` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `email_logs`
--
ALTER TABLE `email_logs`
  ADD CONSTRAINT `email_logs_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `email_logs_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `email_logs_ibfk_3` FOREIGN KEY (`template_id`) REFERENCES `email_templates` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoices_ibfk_2` FOREIGN KEY (`quote_id`) REFERENCES `quotes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoices_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `leads`
--
ALTER TABLE `leads`
  ADD CONSTRAINT `leads_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `leads_ibfk_2` FOREIGN KEY (`source_id`) REFERENCES `lead_sources` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `leads_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `lead_statuses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `leads_ibfk_4` FOREIGN KEY (`converted_customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `lead_activities`
--
ALTER TABLE `lead_activities`
  ADD CONSTRAINT `lead_activities_ibfk_1` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lead_activities_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD CONSTRAINT `login_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `meetings`
--
ALTER TABLE `meetings`
  ADD CONSTRAINT `meetings_ibfk_1` FOREIGN KEY (`organizer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `meetings_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `meetings_ibfk_3` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `meeting_attendees`
--
ALTER TABLE `meeting_attendees`
  ADD CONSTRAINT `meeting_attendees_ibfk_1` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `meeting_attendees_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notes_ibfk_3` FOREIGN KEY (`deal_id`) REFERENCES `deals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notes_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `quotes`
--
ALTER TABLE `quotes`
  ADD CONSTRAINT `quotes_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `quotes_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `quote_items`
--
ALTER TABLE `quote_items`
  ADD CONSTRAINT `quote_items_ibfk_1` FOREIGN KEY (`quote_id`) REFERENCES `quotes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quote_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tasks_ibfk_3` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tasks_ibfk_4` FOREIGN KEY (`deal_id`) REFERENCES `deals` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tickets_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `ticket_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD CONSTRAINT `ticket_replies_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_replies_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
