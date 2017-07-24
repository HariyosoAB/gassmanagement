-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2017 at 04:25 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gassmanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `actype`
--

CREATE TABLE `actype` (
  `actype_id` int(11) NOT NULL,
  `actype_code` varchar(100) NOT NULL,
  `actype_description` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `actype`
--

INSERT INTO `actype` (`actype_id`, `actype_code`, `actype_description`) VALUES
(1, 'aok', 'afo');

-- --------------------------------------------------------

--
-- Table structure for table `airline`
--

CREATE TABLE `airline` (
  `airline_id` int(11) NOT NULL,
  `airline_type` varchar(100) NOT NULL,
  `airline_description` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `airline`
--

INSERT INTO `airline` (`airline_id`, `airline_type`, `airline_description`) VALUES
(1, 'garuda', 'ajfoia');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `equipment_id` int(11) NOT NULL,
  `equipment_lc` varchar(60) NOT NULL,
  `equipment_description` varchar(2000) NOT NULL,
  `equipment_model` varchar(100) NOT NULL,
  `equipment_no_inventory` varchar(100) NOT NULL,
  `equipment_part_number` varchar(100) NOT NULL,
  `equipment_status_on_service` int(11) NOT NULL,
  `equipment_serviceable` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`equipment_id`, `equipment_lc`, `equipment_description`, `equipment_model`, `equipment_no_inventory`, `equipment_part_number`, `equipment_status_on_service`, `equipment_serviceable`) VALUES
(1, 'aoife', 'faoi', 'aoifm', '2390', 'woefm', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `manpower`
--

CREATE TABLE `manpower` (
  `manpower_id` int(11) NOT NULL,
  `manpower_nama` varchar(200) NOT NULL,
  `manpower_no_pegawai` varchar(100) NOT NULL,
  `manpower_capability` int(11) NOT NULL,
  `manpower_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_f`
--

CREATE TABLE `order_f` (
  `order_id` int(11) NOT NULL,
  `order_user` int(11) NOT NULL,
  `order_swo` varchar(140) DEFAULT NULL,
  `order_equipment` int(11) NOT NULL,
  `order_start` datetime NOT NULL,
  `order_from` int(11) NOT NULL,
  `order_to` int(11) NOT NULL,
  `order_unit` varchar(10) NOT NULL,
  `order_ac_reg` int(11) NOT NULL,
  `order_ac_type` int(11) NOT NULL,
  `order_maintenance_type` int(11) NOT NULL,
  `order_urgency` int(11) DEFAULT NULL,
  `order_airline` int(11) NOT NULL,
  `order_address` varchar(500) NOT NULL,
  `order_note` varchar(2000) DEFAULT NULL,
  `order_end` datetime DEFAULT NULL,
  `order_status` int(11) NOT NULL,
  `order_operator` int(11) DEFAULT NULL,
  `order_wingman` int(11) DEFAULT NULL,
  `order_wingman2` int(11) DEFAULT NULL,
  `order_wingman3` int(11) DEFAULT NULL,
  `order_cancellation` varchar(2000) DEFAULT NULL,
  `order_delayed_until` datetime DEFAULT NULL,
  `order_execute_at` datetime DEFAULT NULL,
  `order_finished_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_f`
--

INSERT INTO `order_f` (`order_id`, `order_user`, `order_swo`, `order_equipment`, `order_start`, `order_from`, `order_to`, `order_unit`, `order_ac_reg`, `order_ac_type`, `order_maintenance_type`, `order_urgency`, `order_airline`, `order_address`, `order_note`, `order_end`, `order_status`, `order_operator`, `order_wingman`, `order_wingman2`, `order_wingman3`, `order_cancellation`, `order_delayed_until`, `order_execute_at`, `order_finished_at`) VALUES
(11, 2, 'asda', 1, '2017-07-21 12:00:00', 1, 1, '1', 1, 1, 1, 2, 1, 'as', 'ad', NULL, 9, NULL, NULL, NULL, NULL, 'saya kurang suka menunggu', NULL, NULL, NULL),
(12, 2, 'asda', 1, '2017-07-21 12:00:00', 1, 1, '1', 1, 1, 1, 1, 1, 'as', 'ad', NULL, 9, NULL, NULL, NULL, NULL, 'telat', NULL, NULL, NULL),
(13, 2, 'asda', 1, '2017-07-21 12:00:00', 1, 1, '1', 1, 1, 1, 3, 1, 'as', 'ad', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 2, NULL, 1, '2017-07-21 12:19:00', 1, 1, '1', 1, 1, 1, NULL, 1, 'oafjio', 'sijdoiad', NULL, 9, NULL, NULL, NULL, NULL, 'salah ketik', NULL, NULL, NULL),
(17, 2, NULL, 1, '2017-07-21 00:00:00', 1, 1, '1', 1, 1, 1, NULL, 1, 'ad', 'asid', NULL, 9, NULL, NULL, NULL, NULL, 'a', NULL, NULL, NULL),
(18, 2, NULL, 1, '2017-07-22 12:35:00', 1, 1, '1', 1, 1, 1, NULL, 1, 'oafjio', 'oke', NULL, 9, NULL, NULL, NULL, NULL, 'aa', NULL, NULL, NULL),
(19, 2, NULL, 1, '2017-07-24 21:00:00', 1, 1, '1', 1, 1, 1, NULL, 1, '1adda', 'ASDADA', NULL, 9, NULL, NULL, NULL, NULL, 'salah', NULL, NULL, NULL),
(20, 2, NULL, 1, '2017-07-24 21:00:00', 1, 1, '1', 1, 1, 1, NULL, 1, '1adda', 'ASDADA', NULL, 9, NULL, NULL, NULL, NULL, 'salah', NULL, NULL, NULL),
(22, 2, NULL, 1, '2017-07-07 00:00:00', 1, 1, '1', 1, 1, 1, NULL, 1, 'asdo', 'asda', NULL, 9, NULL, NULL, NULL, NULL, 'aa', NULL, NULL, NULL),
(23, 2, NULL, 1, '2017-07-07 00:00:00', 1, 1, '1', 1, 1, 1, NULL, 1, 'asdo', 'asda', NULL, 9, NULL, NULL, NULL, NULL, 'asda', NULL, NULL, NULL),
(24, 2, NULL, 1, '2017-07-24 16:15:00', 1, 1, '1', 1, 1, 1, NULL, 1, '1', 'jangan makin rusak ya', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `os_id` int(11) NOT NULL,
  `os_datetime` datetime NOT NULL,
  `os_status` int(11) NOT NULL,
  `os_order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`os_id`, `os_datetime`, `os_status`, `os_order_id`) VALUES
(2, '2017-07-24 01:53:36', 1, 24);

-- --------------------------------------------------------

--
-- Table structure for table `problem_tagging`
--

CREATE TABLE `problem_tagging` (
  `pt_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `pt_root_cause` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `root_cause`
--

CREATE TABLE `root_cause` (
  `rc_id` int(11) NOT NULL,
  `rc_name` varchar(100) NOT NULL,
  `rc_description` varchar(3000) NOT NULL,
  `rc_pemutihan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `urgency`
--

CREATE TABLE `urgency` (
  `urgency_id` int(11) NOT NULL,
  `urgency_description` varchar(2000) NOT NULL,
  `urgency_level` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `urgency`
--

INSERT INTO `urgency` (`urgency_id`, `urgency_description`, `urgency_level`) VALUES
(1, 'kdmoi', 'High'),
(2, 'adoi', 'Medium'),
(3, 'ioafj', 'Low');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_nama` varchar(140) NOT NULL,
  `user_no_pegawai` varchar(10) NOT NULL,
  `user_unit` varchar(10) NOT NULL,
  `user_subunit` varchar(10) NOT NULL,
  `user_telp` varchar(13) NOT NULL,
  `user_email` varchar(60) NOT NULL,
  `user_jabatan` varchar(50) NOT NULL,
  `user_role` int(11) NOT NULL,
  `password` varchar(60) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_nama`, `user_no_pegawai`, `user_unit`, `user_subunit`, `user_telp`, `user_email`, `user_jabatan`, `user_role`, `password`, `remember_token`) VALUES
(1, 'ario bimo', 'admin', 'GSE', 'PG', '0812221923', 'masgondi234@yahoo.com', 'management', 1, '$2y$10$sJ2V8gV6/QYqoi/6ASmlCuz/liZXaApEHmwKVfCYWDejk9cs.bpYm', 'gssFfC9vrvufMR2RkD0KVAo006DZAzfFNCGytvnRpmlpj348jdWIT7RqEimY'),
(2, 'Ario Bimo', '581582', 'GASS', 'PG', '08121034567', 'masgondi234@gmail.com', 'staff', 1, '$2y$10$l3kKAfI2EAU22P.Ph1nbWeI7cVPClOx5G.4VGs3laxsUIuzPWkUpq', 'msFaIV2EIZnUVO397H2HNDneKC7WfdH3r0zXyqf70eKyElNia5m8Lfi6V176'),
(3, 'Shafly Naufal', '581593', 'GASS', 'PG', '08132394834', 'shafly96@gmail.com', 'OCC', 2, '$2y$10$l3kKAfI2EAU22P.Ph1nbWeI7cVPClOx5G.4VGs3laxsUIuzPWkUpq', 'bTeE89fowZMtUd5u4vVlPtuqJMowiwUx7twQzImausStnB4EtWR0Rp2wgR4W');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actype`
--
ALTER TABLE `actype`
  ADD PRIMARY KEY (`actype_id`);

--
-- Indexes for table `airline`
--
ALTER TABLE `airline`
  ADD PRIMARY KEY (`airline_id`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`equipment_id`);

--
-- Indexes for table `manpower`
--
ALTER TABLE `manpower`
  ADD PRIMARY KEY (`manpower_id`);

--
-- Indexes for table `order_f`
--
ALTER TABLE `order_f`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order_equipment` (`order_equipment`),
  ADD KEY `order_ac_reg` (`order_ac_reg`),
  ADD KEY `order_ac_type` (`order_ac_type`),
  ADD KEY `order_operator` (`order_operator`),
  ADD KEY `order_wingman` (`order_wingman`),
  ADD KEY `order_wingman2` (`order_wingman2`),
  ADD KEY `order_wingman3` (`order_wingman3`),
  ADD KEY `order_urgency` (`order_urgency`),
  ADD KEY `order_user` (`order_user`),
  ADD KEY `order_airline` (`order_airline`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`os_id`),
  ADD KEY `os_order_id` (`os_order_id`),
  ADD KEY `os_status` (`os_status`);

--
-- Indexes for table `problem_tagging`
--
ALTER TABLE `problem_tagging`
  ADD PRIMARY KEY (`pt_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `pt_root_cause` (`pt_root_cause`);

--
-- Indexes for table `root_cause`
--
ALTER TABLE `root_cause`
  ADD PRIMARY KEY (`rc_id`);

--
-- Indexes for table `urgency`
--
ALTER TABLE `urgency`
  ADD PRIMARY KEY (`urgency_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_role` (`user_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actype`
--
ALTER TABLE `actype`
  MODIFY `actype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `airline`
--
ALTER TABLE `airline`
  MODIFY `airline_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `equipment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `manpower`
--
ALTER TABLE `manpower`
  MODIFY `manpower_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_f`
--
ALTER TABLE `order_f`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `os_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `problem_tagging`
--
ALTER TABLE `problem_tagging`
  MODIFY `pt_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `root_cause`
--
ALTER TABLE `root_cause`
  MODIFY `rc_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `urgency`
--
ALTER TABLE `urgency`
  MODIFY `urgency_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_f`
--
ALTER TABLE `order_f`
  ADD CONSTRAINT `order_f_ibfk_1` FOREIGN KEY (`order_urgency`) REFERENCES `urgency` (`urgency_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `order_f_ibfk_10` FOREIGN KEY (`order_user`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `order_f_ibfk_11` FOREIGN KEY (`order_airline`) REFERENCES `airline` (`airline_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `order_f_ibfk_3` FOREIGN KEY (`order_ac_type`) REFERENCES `actype` (`actype_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `order_f_ibfk_5` FOREIGN KEY (`order_equipment`) REFERENCES `equipment` (`equipment_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `order_f_ibfk_6` FOREIGN KEY (`order_operator`) REFERENCES `manpower` (`manpower_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `order_f_ibfk_7` FOREIGN KEY (`order_wingman`) REFERENCES `manpower` (`manpower_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_f_ibfk_8` FOREIGN KEY (`order_wingman2`) REFERENCES `manpower` (`manpower_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `order_f_ibfk_9` FOREIGN KEY (`order_wingman3`) REFERENCES `manpower` (`manpower_id`) ON DELETE NO ACTION;

--
-- Constraints for table `order_status`
--
ALTER TABLE `order_status`
  ADD CONSTRAINT `order_status_ibfk_1` FOREIGN KEY (`os_order_id`) REFERENCES `order_f` (`order_id`) ON DELETE CASCADE;

--
-- Constraints for table `problem_tagging`
--
ALTER TABLE `problem_tagging`
  ADD CONSTRAINT `problem_tagging_ibfk_2` FOREIGN KEY (`pt_root_cause`) REFERENCES `root_cause` (`rc_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `problem_tagging_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `order_f` (`order_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
