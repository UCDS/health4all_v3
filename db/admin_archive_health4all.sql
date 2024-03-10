-- MySQL dump 10.16  Distrib 10.1.37-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: admin_archive_health4all
-- ------------------------------------------------------
-- Server version	10.1.37-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `helpline_call`
--

DROP TABLE IF EXISTS `helpline_call`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `helpline_call` (
  `call_id` int(11) NOT NULL AUTO_INCREMENT,
  `callsid` varchar(100) NOT NULL,
  `from_number` varchar(20) NOT NULL,
  `to_number` varchar(20) NOT NULL,
  `direction` varchar(20) NOT NULL,
  `dial_call_duration` time NOT NULL,
  `start_time` datetime NOT NULL,
  `current_server_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `call_type` varchar(20) NOT NULL,
  `recording_url` varchar(100) NOT NULL,
  `dial_whom_number` varchar(20) NOT NULL,
  `caller_type_id` int(11) NOT NULL,
  `call_category_id` int(11) NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `ip_op` varchar(2) NOT NULL,
  `visit_id` int(11) NOT NULL,
  `resolution_status_id` int(11) NOT NULL,
  `note` text NOT NULL,
  `create_date_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_date_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` tinyint(1) NOT NULL DEFAULT '0',
  `resolution_date_time` datetime NOT NULL,
  `call_group_id` int(11) NOT NULL,
  `language_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL COMMENT 'Stores the district on which call came from',
  `department_id` int(4) DEFAULT NULL,
  `archive_date` datetime NOT NULL,
  PRIMARY KEY (`call_id`),
  UNIQUE KEY `call_id` (`call_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1956355 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `patient_visit`
--

DROP TABLE IF EXISTS `patient_visit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patient_visit` (
  `visit_id` int(8) NOT NULL AUTO_INCREMENT,
  `hospital_id` int(11) NOT NULL,
  `admit_id` int(8) NOT NULL,
  `visit_type` varchar(8) NOT NULL,
  `visit_name_id` int(11) NOT NULL,
  `patient_id` int(8) NOT NULL,
  `hosp_file_no` int(8) NOT NULL,
  `admit_date` date NOT NULL,
  `admit_time` time NOT NULL,
  `department_id` int(4) NOT NULL,
  `unit` int(11) NOT NULL,
  `area` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `nurse` varchar(50) NOT NULL,
  `insurance_case` varchar(1) NOT NULL,
  `insurance_id` int(11) NOT NULL,
  `insurance_no` varchar(10) NOT NULL,
  `presenting_complaints` varchar(500) NOT NULL,
  `past_history` varchar(500) NOT NULL,
  `family_history` longtext NOT NULL,
  `admit_weight` int(6) NOT NULL,
  `pulse_rate` int(3) NOT NULL,
  `respiratory_rate` int(3) NOT NULL,
  `temperature` int(3) NOT NULL,
  `sbp` int(3) NOT NULL,
  `dbp` int(3) NOT NULL,
  `spo2` int(3) DEFAULT NULL,
  `blood_sugar` double NOT NULL,
  `hb` double NOT NULL,
  `hb1ac` double NOT NULL,
  `clinical_findings` longtext NOT NULL,
  `cvs` text NOT NULL,
  `rs` text NOT NULL,
  `pa` text NOT NULL,
  `cns` text NOT NULL,
  `cxr` text NOT NULL,
  `provisional_diagnosis` varchar(500) NOT NULL,
  `signed_consultation` int(11) NOT NULL,
  `final_diagnosis` varchar(500) NOT NULL,
  `decision` text NOT NULL,
  `advise` text NOT NULL,
  `icd_10` varchar(4) NOT NULL,
  `icd_10_ext` varchar(1) NOT NULL,
  `discharge_weight` int(3) NOT NULL,
  `outcome` varchar(11) NOT NULL,
  `outcome_date` date NOT NULL,
  `outcome_time` time NOT NULL,
  `ip_file_received` date NOT NULL,
  `mlc` tinyint(1) NOT NULL,
  `arrival_mode` varchar(25) DEFAULT NULL,
  `referral_by_hospital_id` int(11) DEFAULT NULL,
  `insert_by_user_id` int(11) NOT NULL,
  `update_by_user_id` int(11) NOT NULL,
  `insert_datetime` datetime NOT NULL,
  `update_datetime` datetime NOT NULL,
  `appointment_with` int(11) DEFAULT NULL,
  `appointment_time` datetime DEFAULT NULL,
  `appointment_update_by` int(11) DEFAULT NULL,
  `appointment_update_time` datetime DEFAULT NULL,
  `summary_sent_time` datetime DEFAULT NULL,
  `temp_visit_id` int(11) NOT NULL,
  `appointment_status_id` int(11) DEFAULT NULL,
  `appointment_status_update_by` int(11) DEFAULT NULL,
  `appointment_status_update_time` datetime DEFAULT NULL,
  `archive_date` datetime NOT NULL,
  PRIMARY KEY (`visit_id`),
  KEY `hospital_id` (`hospital_id`),
  KEY `admit_date` (`admit_date`),
  KEY `unit` (`unit`),
  KEY `department_id` (`department_id`),
  KEY `area` (`area`),
  KEY `patient_id` (`patient_id`),
  KEY `visit_type` (`visit_type`),
  KEY `hosp_file_no` (`hosp_file_no`)
) ENGINE=MyISAM AUTO_INCREMENT=20416181 DEFAULT CHARSET=latin1 COMMENT='All visits made by patients';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sms_helpline`
--

DROP TABLE IF EXISTS `sms_helpline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms_helpline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_helpline` varchar(20) NOT NULL,
  `to_receiver` varchar(20) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL,
  `date_sent` datetime DEFAULT NULL,
  `sms_type` varchar(20) NOT NULL,
  `sms_template_id` int(11) NOT NULL,
  `dlt_tid` varchar(20) NOT NULL,
  `sms_body` text CHARACTER SET utf8 NOT NULL,
  `sent_by_staff` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `status_code` varchar(20) NOT NULL,
  `detailed_status` varchar(100) NOT NULL,
  `detailed_status_code` varchar(10) DEFAULT NULL,
  `price` decimal(3,2) NOT NULL,
  `direction` varchar(10) NOT NULL,
  `sid` varchar(1000) NOT NULL COMMENT 'Unique SMS Id returned by telecom provider',
  `archive_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=310915 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-03-10 13:29:10
