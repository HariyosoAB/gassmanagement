-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2017 at 04:07 AM
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
  `equipment_model` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`equipment_id`, `equipment_lc`, `equipment_description`, `equipment_model`) VALUES
(1, 'aoife', 'faoi', 'aoifm'),
(2, 'ATN', '"AIRCRAFT TOWING TRACTOR\r\n(ATT) NARROW BODY"', 'ATN');

-- --------------------------------------------------------

--
-- Table structure for table `equipment_many`
--

CREATE TABLE `equipment_many` (
  `em_id` int(11) NOT NULL,
  `em_no_inventory` varchar(100) NOT NULL,
  `em_part_number` varchar(100) NOT NULL,
  `em_status_on_service` int(11) NOT NULL,
  `em_servicable` int(11) NOT NULL,
  `em_equipment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `equipment_many`
--

INSERT INTO `equipment_many` (`em_id`, `em_no_inventory`, `em_part_number`, `em_status_on_service`, `em_servicable`, `em_equipment`) VALUES
(1, '203', '2012319', 0, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `maintenance_id` int(11) NOT NULL,
  `maintenance_type` varchar(100) NOT NULL,
  `maintenance_description` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `maintenance`
--

INSERT INTO `maintenance` (`maintenance_id`, `maintenance_type`, `maintenance_description`) VALUES
(1, 'Maintenance', 'Maintenance A');

-- --------------------------------------------------------

--
-- Table structure for table `manpower`
--

CREATE TABLE `manpower` (
  `manpower_id` int(11) NOT NULL,
  `manpower_nama` varchar(200) NOT NULL,
  `manpower_no_pegawai` varchar(100) NOT NULL,
  `manpower_capability` varchar(100) NOT NULL,
  `manpower_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manpower`
--

INSERT INTO `manpower` (`manpower_id`, `manpower_nama`, `manpower_no_pegawai`, `manpower_capability`, `manpower_status`) VALUES
(1, 'Ashfly Faunal', '592529', 'Towing', 0),
(2, 'Riyohaso Riao Mibo', '583591', 'Wingman', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_f`
--

CREATE TABLE `order_f` (
  `order_id` int(11) NOT NULL,
  `order_user` int(11) NOT NULL,
  `order_swo` varchar(140) DEFAULT NULL,
  `order_equipment` int(11) DEFAULT NULL,
  `order_em` int(11) DEFAULT NULL,
  `order_start` datetime NOT NULL,
  `order_from` varchar(100) NOT NULL,
  `order_to` varchar(100) NOT NULL,
  `order_unit` int(11) NOT NULL,
  `order_ac_reg` varchar(100) NOT NULL,
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

--
-- Dumping data for table `root_cause`
--

INSERT INTO `root_cause` (`rc_id`, `rc_name`, `rc_description`, `rc_pemutihan`) VALUES
(1, 'Equipment Capacity', '--', 0),
(2, 'Operator Capacity', '--', 0);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `unit_id` int(11) NOT NULL,
  `unit_name` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`unit_id`, `unit_name`) VALUES
(1, 'GASS');

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
(2, 'Ario Bimo', '581582', 'GASS', 'PG', '08121034567', 'masgondi234@gmail.com', 'staff', 1, '$2y$10$l3kKAfI2EAU22P.Ph1nbWeI7cVPClOx5G.4VGs3laxsUIuzPWkUpq', 'hIExp2oAweBYSFm9AcqXngEfLPzTXauNzzH9fpoPW1G1qidJecBMFPgpTZe3'),
(3, 'Shafly Naufal', '581593', 'GASS', 'PG', '08132394834', 'shafly96@gmail.com', 'OCC', 2, '$2y$10$l3kKAfI2EAU22P.Ph1nbWeI7cVPClOx5G.4VGs3laxsUIuzPWkUpq', 'zGVEMWmidDvCE3Yj84wIdrXWIMwIWjH10JafCVrPAwInRJ6WSXXBgvoamO9d');

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
-- Indexes for table `equipment_many`
--
ALTER TABLE `equipment_many`
  ADD PRIMARY KEY (`em_id`),
  ADD KEY `em_equipment` (`em_equipment`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`maintenance_id`);

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
  ADD KEY `order_ac_type` (`order_ac_type`),
  ADD KEY `order_operator` (`order_operator`),
  ADD KEY `order_wingman` (`order_wingman`),
  ADD KEY `order_wingman2` (`order_wingman2`),
  ADD KEY `order_wingman3` (`order_wingman3`),
  ADD KEY `order_urgency` (`order_urgency`),
  ADD KEY `order_user` (`order_user`),
  ADD KEY `order_airline` (`order_airline`),
  ADD KEY `order_start_2` (`order_start`),
  ADD KEY `order_em` (`order_em`),
  ADD KEY `order_unit` (`order_unit`),
  ADD KEY `order_maintenance_type` (`order_maintenance_type`);

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
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`unit_id`);

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
  MODIFY `equipment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `equipment_many`
--
ALTER TABLE `equipment_many`
  MODIFY `em_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `maintenance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `manpower`
--
ALTER TABLE `manpower`
  MODIFY `manpower_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `order_f`
--
ALTER TABLE `order_f`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `problem_tagging`
--
ALTER TABLE `problem_tagging`
  MODIFY `pt_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `root_cause`
--
ALTER TABLE `root_cause`
  MODIFY `rc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
-- Constraints for table `equipment_many`
--
ALTER TABLE `equipment_many`
  ADD CONSTRAINT `equipment_many_ibfk_1` FOREIGN KEY (`em_equipment`) REFERENCES `equipment` (`equipment_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_f`
--
ALTER TABLE `order_f`
  ADD CONSTRAINT `order_f_ibfk_1` FOREIGN KEY (`order_urgency`) REFERENCES `urgency` (`urgency_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `order_f_ibfk_10` FOREIGN KEY (`order_user`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `order_f_ibfk_11` FOREIGN KEY (`order_airline`) REFERENCES `airline` (`airline_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `order_f_ibfk_12` FOREIGN KEY (`order_em`) REFERENCES `equipment_many` (`em_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `order_f_ibfk_13` FOREIGN KEY (`order_equipment`) REFERENCES `equipment` (`equipment_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `order_f_ibfk_14` FOREIGN KEY (`order_maintenance_type`) REFERENCES `maintenance` (`maintenance_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `order_f_ibfk_3` FOREIGN KEY (`order_ac_type`) REFERENCES `actype` (`actype_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `order_f_ibfk_6` FOREIGN KEY (`order_operator`) REFERENCES `manpower` (`manpower_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `order_f_ibfk_7` FOREIGN KEY (`order_wingman`) REFERENCES `manpower` (`manpower_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_f_ibfk_8` FOREIGN KEY (`order_wingman2`) REFERENCES `manpower` (`manpower_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `order_f_ibfk_9` FOREIGN KEY (`order_wingman3`) REFERENCES `manpower` (`manpower_id`) ON DELETE NO ACTION;

--
-- Constraints for table `problem_tagging`
--
ALTER TABLE `problem_tagging`
  ADD CONSTRAINT `problem_tagging_ibfk_2` FOREIGN KEY (`pt_root_cause`) REFERENCES `root_cause` (`rc_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `problem_tagging_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `order_f` (`order_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
