-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2020 at 07:47 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kcengineering_v2`
--

-- --------------------------------------------------------

--
-- Table structure for table `assigned_grouping`
--

CREATE TABLE `assigned_grouping` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sp_grouping_id` int(11) NOT NULL,
  `assigned_to` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assigned_grouping`
--

INSERT INTO `assigned_grouping` (`id`, `created_at`, `updated_at`, `sp_grouping_id`, `assigned_to`) VALUES
(1, NULL, NULL, 1, 3),
(2, NULL, NULL, 3, 3),
(3, NULL, NULL, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `assigned_sp`
--

CREATE TABLE `assigned_sp` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sp_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `assigned_grouping` int(11) NOT NULL,
  `assigned_to` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'On-going'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assigned_sp`
--

INSERT INTO `assigned_sp` (`id`, `created_at`, `updated_at`, `sp_id`, `assigned_grouping`, `assigned_to`, `status`) VALUES
(1, NULL, '2020-01-01 22:26:43', '2018040003', 1, '2', 'Completed'),
(2, NULL, NULL, '29739', 3, '4', 'On-going'),
(3, NULL, NULL, '29737', 3, '4', 'On-going');

-- --------------------------------------------------------

--
-- Table structure for table `ceac`
--

CREATE TABLE `ceac` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sp_groupings` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sp_id` int(11) NOT NULL,
  `sp_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sp_category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sp_province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sp_municipality` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sp_brgy` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `municipal_orientation` datetime NOT NULL,
  `social_investagation` datetime NOT NULL,
  `first_ba` datetime NOT NULL,
  `psa_workshop` datetime NOT NULL,
  `second_ba` datetime NOT NULL,
  `psa_action_plan` datetime NOT NULL,
  `criteria_setting_workshop` datetime NOT NULL,
  `project_dev_workshop` datetime NOT NULL,
  `third_ba` datetime NOT NULL,
  `project_proposal` datetime NOT NULL,
  `miac_tech_review` datetime NOT NULL,
  `fourth_ba` datetime NOT NULL,
  `mdc_mtg_intergration` datetime NOT NULL,
  `fifth_ba` datetime NOT NULL,
  `capacity_building` datetime NOT NULL,
  `formation_community` datetime NOT NULL,
  `accountability_reporting` datetime NOT NULL,
  `sustainability_evaluation` datetime NOT NULL,
  `remarks` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `origin` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `created_at`, `updated_at`, `filename`, `path`, `origin`, `category`) VALUES
(1, '2019-11-27 00:58:20', '2019-11-27 00:58:20', '10101005628.jpg', 'profile/DAC/dac/Standard Drawing Plans/10101005628.jpg', 2, 'Standard Drawing Plans'),
(2, '2019-11-27 00:58:20', '2019-11-27 00:58:20', 'sheilo.jpg', 'profile/DAC/dac/Standard Drawing Plans/sheilo.jpg', 2, 'Standard Drawing Plans'),
(3, '2019-11-27 00:58:21', '2019-11-27 00:58:21', 'mikay.png', 'profile/DAC/dac/Standard Drawing Plans/mikay.png', 2, 'Standard Drawing Plans'),
(4, '2019-11-27 01:17:05', '2019-11-27 01:17:05', 'prew_eng3.jpg', 'profile/DAC/dac/Photo Documents/prew_eng3.jpg', 2, 'Photo Documents'),
(5, '2019-11-27 01:17:05', '2019-11-27 01:17:05', 'prew_eng2.jpg', 'profile/DAC/dac/Photo Documents/prew_eng2.jpg', 2, 'Photo Documents'),
(6, '2019-11-27 01:17:05', '2019-11-27 01:17:05', 'prew_eng1.jpg', 'profile/DAC/dac/Photo Documents/prew_eng1.jpg', 2, 'Photo Documents'),
(7, '2019-11-27 01:17:05', '2019-11-27 01:17:05', 'ranking.jpg', 'profile/DAC/dac/Photo Documents/ranking.jpg', 2, 'Photo Documents'),
(8, '2019-11-27 18:56:44', '2019-11-27 18:56:44', 'ENGINEERING WEBAPP.docx', 'profile/DAC/test_dac/Monitoring/ENGINEERING WEBAPP.docx', 4, 'Monitoring'),
(9, '2019-11-27 18:56:44', '2019-11-27 18:56:44', 'SPCR to be uploaded.xlsx', 'profile/DAC/test_dac/Monitoring/SPCR to be uploaded.xlsx', 4, 'Monitoring'),
(10, '2019-11-27 18:56:44', '2019-11-27 18:56:44', 'SP Completed.xls', 'profile/DAC/test_dac/Monitoring/SP Completed.xls', 4, 'Monitoring'),
(11, '2019-11-27 18:59:01', '2019-11-27 18:59:01', 'IMG_20180608_170727.jpg', 'profile/DAC/test_dac/Photo Documents/IMG_20180608_170727.jpg', 4, 'Photo Documents'),
(12, '2019-11-27 18:59:01', '2019-11-27 18:59:01', 'IMG_20180608_171825.jpg', 'profile/DAC/test_dac/Photo Documents/IMG_20180608_171825.jpg', 4, 'Photo Documents'),
(13, '2019-11-27 18:59:01', '2019-11-27 18:59:01', 'IMG_20180608_171825_1.jpg', 'profile/DAC/test_dac/Photo Documents/IMG_20180608_171825_1.jpg', 4, 'Photo Documents'),
(14, '2019-11-27 18:59:02', '2019-11-27 18:59:02', 'IMG_20180608_172012.jpg', 'profile/DAC/test_dac/Photo Documents/IMG_20180608_172012.jpg', 4, 'Photo Documents'),
(15, '2019-11-27 18:59:02', '2019-11-27 18:59:02', 'IMG_20180608_171719.jpg', 'profile/DAC/test_dac/Photo Documents/IMG_20180608_171719.jpg', 4, 'Photo Documents'),
(16, '2019-11-27 18:59:02', '2019-11-27 18:59:02', 'wp2063154.png', 'profile/DAC/test_dac/Photo Documents/wp2063154.png', 4, 'Photo Documents'),
(17, '2019-11-27 20:00:51', '2019-11-27 20:00:51', 'kalahi org chart.docx', 'profile/DAC/test_dac/O&M Feedback Report/kalahi org chart.docx', 4, 'O&M Feedback Report'),
(18, '2019-11-27 20:03:07', '2019-11-27 20:03:07', 'col.PNG', 'profile/DAC/test_dac/Geo-Tagged Photos/col.PNG', 4, 'Geo-Tagged Photos'),
(19, '2019-11-27 20:04:10', '2019-11-27 20:04:10', 'Dayaohay, Pilar, SDN.pdf', 'profile/DAC/test_dac/Field Report/Dayaohay, Pilar, SDN.pdf', 4, 'Field Report'),
(20, '2019-12-26 18:09:09', '2019-12-26 18:09:09', 'ENGINEERING WEBAPP.docx', 'profile/DAC/dac/SP_files/ENGINEERING WEBAPP.docx', 2, 'SP_files'),
(21, '2019-12-26 18:09:09', '2019-12-26 18:09:09', 'Scanned Files.pdf', 'profile/DAC/dac/SP_files/Scanned Files.pdf', 2, 'SP_files'),
(22, '2019-12-26 18:09:09', '2019-12-26 18:09:09', '2.jpg', 'profile/DAC/dac/SP_files/2.jpg', 2, 'SP_files'),
(23, '2019-12-26 18:09:10', '2019-12-26 18:09:10', 'Errorlog.txt', 'profile/DAC/dac/SP_files/Errorlog.txt', 2, 'SP_files'),
(24, '2019-12-26 18:09:10', '2019-12-26 18:09:10', 'RIO ll nov meeting.pptx', 'profile/DAC/dac/SP_files/RIO ll nov meeting.pptx', 2, 'SP_files'),
(25, '2019-12-26 18:09:10', '2019-12-26 18:09:10', '1.jpg', 'profile/DAC/dac/SP_files/1.jpg', 2, 'SP_files');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `album` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `gallery_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_10_23_020724_create_events_table', 1),
(4, '2019_11_07_072443_create_assigned_sp_table', 1),
(5, '2019_11_07_072443_create_ceac_table', 1),
(6, '2019_11_07_072443_create_gallery_images_table', 1),
(7, '2019_11_07_072443_create_gallery_table', 1),
(8, '2019_11_07_072443_create_sp_batch_table', 1),
(9, '2019_11_07_072443_create_sp_cycle_table', 1),
(10, '2019_11_07_072443_create_sp_logs_table', 1),
(11, '2019_11_07_072443_create_sp_table', 1),
(12, '2019_11_08_012224_create_sp_category_table', 1),
(13, '2019_11_08_012224_create_sp_groupings_table', 1),
(14, '2019_11_08_031342_create_sp_type_table', 1),
(15, '2019_11_08_085046_create_assigned_grouping_table', 1),
(16, '2019_11_13_053008_sms', 1),
(17, '2019_11_27_054400_create_files_table', 1),
(18, '2019_12_23_013454_create_sp_planned_logs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sp`
--

CREATE TABLE `sp` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sp_groupings` int(10) UNSIGNED NOT NULL,
  `sp_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sp_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sp_category` int(11) NOT NULL,
  `sp_province` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sp_municipality` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sp_brgy` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sp_building_permit` int(11) NOT NULL DEFAULT 0,
  `sp_physical_target` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sp_project_cost` double(10,2) NOT NULL,
  `sp_rfr_first_tranche_date` datetime NOT NULL,
  `sp_date_started` datetime NOT NULL,
  `sp_estimated_duration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sp_target_date_of_completion` datetime NOT NULL,
  `sp_days_suspended` int(255) NOT NULL DEFAULT 0,
  `sp_actual_date_completed` datetime NOT NULL,
  `sp_date_of_turnover` datetime NOT NULL,
  `sp_fullblown_proposal` int(11) NOT NULL DEFAULT 0,
  `sp_cycle` int(11) DEFAULT NULL,
  `sp_batch` int(11) DEFAULT NULL,
  `sp_type` int(11) NOT NULL,
  `sp_status` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'On-going'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sp`
--

INSERT INTO `sp` (`id`, `created_at`, `updated_at`, `sp_groupings`, `sp_id`, `sp_title`, `sp_category`, `sp_province`, `sp_municipality`, `sp_brgy`, `sp_building_permit`, `sp_physical_target`, `sp_project_cost`, `sp_rfr_first_tranche_date`, `sp_date_started`, `sp_estimated_duration`, `sp_target_date_of_completion`, `sp_days_suspended`, `sp_actual_date_completed`, `sp_date_of_turnover`, `sp_fullblown_proposal`, `sp_cycle`, `sp_batch`, `sp_type`, `sp_status`) VALUES
(1, NULL, '2020-01-01 22:26:43', 1, '2018040003', 'ABALONE, SPINY ROCK OYSTER AQUACULTURE AND BANGUS PRODUCTION', 3, 'SURIGAO DEL SUR', 'BAROBO', 'CABACUNGAN', 1, '1.00 lot', 1518260.00, '2019-10-27 00:00:00', '2019-10-29 00:00:00', '75', '2020-01-11 00:00:00', 0, '2020-01-01 00:00:00', '2020-01-20 00:00:00', 1, NULL, NULL, 29, 'Completed'),
(2, NULL, NULL, 3, '29739', 'CONSTRUCTION OF ONE UNIT TWO CLASSROOM SCHOOL BUILDING', 1, 'AGUSAN DEL SUR', 'PROSPERIDAD', 'MABUHAY', 0, '126 Sq.m.', 3010000.00, '2019-07-05 00:00:00', '2019-07-08 00:00:00', '120', '2019-11-04 00:00:00', 0, '2019-10-17 00:00:00', '2019-11-20 00:00:00', 0, 3, 2, 12, 'On-going'),
(3, NULL, NULL, 3, '29737', 'CONSTRUCTION OF BARANGAY HEALTH STATION', 1, 'AGUSAN DEL SUR', 'PROSPERIDAD', 'AWA', 0, '52.26 SQ.M.', 2140000.00, '2019-07-05 00:00:00', '2019-07-10 00:00:00', '90', '2019-10-07 00:00:00', 0, '2019-10-31 00:00:00', '2019-11-20 00:00:00', 1, 3, 2, 3, 'On-going');

-- --------------------------------------------------------

--
-- Table structure for table `sp_batch`
--

CREATE TABLE `sp_batch` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `batch` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sp_batch`
--

INSERT INTO `sp_batch` (`id`, `created_at`, `updated_at`, `batch`) VALUES
(1, NULL, NULL, 'BATCH 1'),
(2, NULL, NULL, 'BATCH 2'),
(3, NULL, NULL, 'BATCH 3'),
(4, NULL, NULL, 'BATCH 4'),
(5, NULL, NULL, 'BATCH 5');

-- --------------------------------------------------------

--
-- Table structure for table `sp_category`
--

CREATE TABLE `sp_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sp_category`
--

INSERT INTO `sp_category` (`id`, `created_at`, `updated_at`, `category`) VALUES
(1, NULL, NULL, 'PUBLIC GOODS'),
(2, NULL, NULL, 'ENVIRONMENTAL PROTECTION AND CONSERVATION'),
(3, NULL, NULL, 'ENTERPRISE');

-- --------------------------------------------------------

--
-- Table structure for table `sp_cycle`
--

CREATE TABLE `sp_cycle` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cycle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sp_cycle`
--

INSERT INTO `sp_cycle` (`id`, `created_at`, `updated_at`, `cycle`) VALUES
(1, NULL, NULL, 'CYCLE 1'),
(2, NULL, NULL, 'CYCLE 2'),
(3, NULL, NULL, 'CYCLE 3'),
(4, NULL, NULL, 'CYCLE 4'),
(5, NULL, NULL, 'CYCLE 5');

-- --------------------------------------------------------

--
-- Table structure for table `sp_groupings`
--

CREATE TABLE `sp_groupings` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `grouping` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sp_groupings`
--

INSERT INTO `sp_groupings` (`id`, `created_at`, `updated_at`, `grouping`) VALUES
(1, NULL, NULL, 'KKB'),
(2, NULL, NULL, 'MAKILAHOK'),
(3, NULL, NULL, 'NCDDP'),
(4, NULL, NULL, 'IP CDD'),
(5, NULL, NULL, 'CCL'),
(6, NULL, NULL, 'LandE');

-- --------------------------------------------------------

--
-- Table structure for table `sp_logs`
--

CREATE TABLE `sp_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `sp_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sp_logs_planned_target_date` date NOT NULL,
  `sp_logs_planned` decimal(10,2) DEFAULT NULL,
  `sp_logs_actual` decimal(10,2) DEFAULT NULL,
  `sp_logs_slippage` decimal(10,2) DEFAULT NULL,
  `sp_logs_variation_order` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `sp_logs_spcr` int(255) DEFAULT 0,
  `sp_logs_issues` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `sp_logs_analysis` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `sp_logs_remarks` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `sp_logs_esmr` int(255) DEFAULT 0,
  `sp_logs_csr` int(255) DEFAULT 0,
  `sp_logs_last_user_update` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sp_logs`
--

INSERT INTO `sp_logs` (`id`, `sp_id`, `created_at`, `updated_at`, `sp_logs_planned_target_date`, `sp_logs_planned`, `sp_logs_actual`, `sp_logs_slippage`, `sp_logs_variation_order`, `sp_logs_spcr`, `sp_logs_issues`, `sp_logs_analysis`, `sp_logs_remarks`, `sp_logs_esmr`, `sp_logs_csr`, `sp_logs_last_user_update`) VALUES
(1, '2018040003', '2019-12-26 14:01:13', '2019-12-26 14:01:43', '2020-01-02', '10.00', '9.00', '-1.00', NULL, NULL, 'fdf', 'fdfdf', 'fdfdd', NULL, NULL, '2'),
(2, '2018040003', '2019-12-26 14:01:13', '2019-12-26 14:02:10', '2020-01-09', '20.00', '22.00', '2.00', NULL, NULL, 'fdd', 'fdfdfd', 'fdfdfd', NULL, NULL, '2'),
(3, '2018040003', '2019-12-26 14:01:13', '2019-12-26 14:02:28', '2020-01-16', '30.00', '29.00', '-1.00', NULL, NULL, 'fdfdf', 'dffdfd', 'fdfdfdd', NULL, NULL, '2'),
(4, '2018040003', '2019-12-26 14:01:13', '2019-12-26 14:02:50', '2020-01-23', '40.00', '46.00', '6.00', NULL, NULL, 'fdfd', 'fdfd', 'fdfdfd', NULL, NULL, '2'),
(5, '2018040003', '2019-12-26 14:01:13', '2019-12-26 14:03:07', '2020-01-30', '50.00', '55.00', '5.00', NULL, NULL, 'ffd', 'dfdf', 'dfdfdfdf', NULL, NULL, '2'),
(6, '2018040003', '2019-12-26 14:01:13', '2019-12-26 14:03:23', '2020-02-06', '60.00', '58.00', '-2.00', NULL, NULL, 'fdfdf', 'dfdfd', 'fdfd', NULL, NULL, '2'),
(7, '2018040003', '2019-12-26 14:01:13', '2019-12-26 14:03:35', '2020-02-13', '70.00', '77.00', '7.00', NULL, NULL, 'fdf', 'dfdfdf', 'dfdfdd', NULL, NULL, '2'),
(8, '2018040003', '2019-12-26 14:01:13', '2019-12-26 14:03:49', '2020-02-20', '80.00', '89.00', '9.00', NULL, NULL, 'fdfd', 'fdfdff', 'dfdfdfd', NULL, NULL, '2'),
(9, '2018040003', '2019-12-26 14:01:13', '2019-12-27 00:56:46', '2020-02-27', '90.00', '88.00', '-2.00', NULL, NULL, 'dsdsd', 'sdsdsds', 'dsdsds', NULL, NULL, '2'),
(10, '2018040003', '2019-12-26 14:01:13', '2020-01-01 22:26:43', '2020-03-05', '100.00', '100.00', '0.00', NULL, NULL, 'undefined', 'undefined', 'undefined', NULL, NULL, '2');

-- --------------------------------------------------------

--
-- Table structure for table `sp_planned_logs`
--

CREATE TABLE `sp_planned_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sp_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `planned` double(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sp_type`
--

CREATE TABLE `sp_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sp_type`
--

INSERT INTO `sp_type` (`id`, `created_at`, `updated_at`, `type`) VALUES
(1, NULL, NULL, 'ROADS'),
(2, NULL, NULL, 'WATER SYSTEM'),
(3, NULL, NULL, 'BHS'),
(4, NULL, NULL, 'PATHWAY'),
(5, NULL, NULL, 'DRAINAGE'),
(6, NULL, NULL, 'EVACUATION CENTER'),
(7, NULL, NULL, 'FOOTBRIDGE'),
(8, NULL, NULL, 'SEA WALL'),
(9, NULL, NULL, 'MULTI PURPOSE BUILDING'),
(10, NULL, NULL, 'TRIBAL CENTER'),
(11, NULL, NULL, 'EPSL'),
(12, NULL, NULL, 'SCHOOL BUILDING'),
(13, NULL, NULL, 'CULVERTS'),
(14, NULL, NULL, 'SPSL'),
(15, NULL, NULL, 'DCC'),
(16, NULL, NULL, 'FLOOD CONTROL'),
(17, NULL, NULL, 'LATRINE'),
(18, NULL, NULL, 'SCHOOL BUILDING'),
(19, NULL, NULL, 'WHARF'),
(20, NULL, NULL, 'RIVER DIKE'),
(21, NULL, NULL, 'RICE MILL'),
(22, NULL, NULL, 'SLOPE PROTECTION'),
(23, NULL, NULL, 'STAIRWAY'),
(24, NULL, NULL, 'BRIDGES'),
(25, NULL, NULL, 'RIVERBANK PROTECTION'),
(26, NULL, NULL, 'RWH'),
(27, NULL, NULL, 'SOLAR DRYER'),
(28, NULL, NULL, 'LEARNING CENTER'),
(29, NULL, NULL, 'OTHERS');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Fname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Mname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Lname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthdate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `emp_id_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `Fname`, `Mname`, `Lname`, `birthdate`, `contact`, `email`, `email_verified_at`, `emp_id_no`, `username`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Jhon Paul', 'Amper', 'Quinal', '1995-11-19 00:00:00', '09568625630', 'radicaljhonpaul@gmail.com', NULL, '16-11678', 'dacit', '$2y$10$Qbcumg66QG5xvwyr3FmN7OZfqkuQrb6/rYbYXxeOzhaUGw5aiBQ2C', 'ADMIN', NULL, '2019-11-07 16:39:57', '2019-11-07 16:39:57'),
(2, 'John', 'Doe', 'Doe', '1995-12-11 00:00:00', '09465350273', 'johndoe@gmail.com', NULL, '16-11111', 'dac', '$2y$10$KnfZx1e1KRFDkywLnDDxLuXkblUrXTAqDg4gF.yZRkEOXD0emP.1S', 'DAC', NULL, '2019-11-07 16:45:01', '2019-11-07 16:45:01'),
(3, 'Jovenal', 'L', 'Bernat', '1892-12-11 00:00:00', '09568625630', 'jovenalbernat@gmail.com', NULL, '00-00000', 'rpmo', '$2y$10$CH4Y3kpVu4JsgzUYXQ.Xi.j6zOtgzwbaPIlbaJclYFfay1BAmjYTW', 'RPMO', NULL, '2019-11-07 16:46:51', '2019-11-07 16:46:51'),
(4, 'Testing', 'Testing', 'Testing', '1981-10-09 00:00:00', '09568625630', 'test@gmail.com', NULL, '16-22222', 'test_dac', '$2y$10$X8twVzRjes4cOPkifijdnOMfffBCrnHMPx68cbMcHEb2nived6qwu', 'DAC', NULL, '2019-11-18 23:51:47', '2019-11-18 23:51:47');

-- --------------------------------------------------------

--
-- Table structure for table `whereabouts`
--

CREATE TABLE `whereabouts` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `whereabouts`
--

INSERT INTO `whereabouts` (`id`, `title`, `description`, `location`, `start_date`, `end_date`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Travel 1', 'Travel Event 1', 'Hinatuan, SDS', '2019-10-10', '2019-10-15', 1, '2019-11-12 17:33:22', '2019-11-12 17:33:22'),
(2, 'Travel 2', 'Travel Event 2', 'San Francisco, ADS', '2019-10-11', '2019-10-16', 2, '2019-11-12 17:33:22', '2019-11-12 17:33:22'),
(3, 'Travel 1', 'Travel Event 3', 'Prosperidad, ADS', '2019-10-16', '2019-10-22', 2, '2019-11-12 17:33:22', '2019-11-12 17:33:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assigned_grouping`
--
ALTER TABLE `assigned_grouping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assigned_sp`
--
ALTER TABLE `assigned_sp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ceac`
--
ALTER TABLE `ceac`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp`
--
ALTER TABLE `sp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_batch`
--
ALTER TABLE `sp_batch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_category`
--
ALTER TABLE `sp_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_cycle`
--
ALTER TABLE `sp_cycle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_groupings`
--
ALTER TABLE `sp_groupings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_logs`
--
ALTER TABLE `sp_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_planned_logs`
--
ALTER TABLE `sp_planned_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_type`
--
ALTER TABLE `sp_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_emp_id_no_unique` (`emp_id_no`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indexes for table `whereabouts`
--
ALTER TABLE `whereabouts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assigned_grouping`
--
ALTER TABLE `assigned_grouping`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `assigned_sp`
--
ALTER TABLE `assigned_sp`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ceac`
--
ALTER TABLE `ceac`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `sp`
--
ALTER TABLE `sp`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sp_batch`
--
ALTER TABLE `sp_batch`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sp_category`
--
ALTER TABLE `sp_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sp_cycle`
--
ALTER TABLE `sp_cycle`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sp_groupings`
--
ALTER TABLE `sp_groupings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sp_logs`
--
ALTER TABLE `sp_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sp_planned_logs`
--
ALTER TABLE `sp_planned_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_type`
--
ALTER TABLE `sp_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `whereabouts`
--
ALTER TABLE `whereabouts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
