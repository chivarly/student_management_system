-- ============================================================
-- Bicol University-Polangui Student Management System
-- Database schema and reference data
-- ------------------------------------------------------------
-- Generated from the project's working database.
-- Contains table structures, foreign keys, and the department,
-- course, and year-level reference data only. It contains no
-- student records, user accounts, usernames, or password hashes.
-- Import through phpMyAdmin (Import tab) on a fresh installation.
-- ============================================================


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `student_management_system` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `student_management_system`;
DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_code` varchar(20) NOT NULL,
  `course_name` varchar(150) NOT NULL,
  `department_id` int(11) NOT NULL,
  PRIMARY KEY (`course_id`),
  UNIQUE KEY `course_code` (`course_code`),
  KEY `fk_courses_department` (`department_id`),
  CONSTRAINT `fk_courses_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(100) NOT NULL,
  `department_code` varchar(20) NOT NULL,
  PRIMARY KEY (`department_id`),
  UNIQUE KEY `uq_department_code` (`department_code`),
  UNIQUE KEY `uq_department_name` (`department_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_number` varchar(30) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `course_id` int(11) NOT NULL,
  `year_level_id` int(11) NOT NULL,
  `block` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `student_number` (`student_number`),
  KEY `course_id` (`course_id`),
  KEY `year_level_id` (`year_level_id`),
  CONSTRAINT `students_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  CONSTRAINT `students_ibfk_2` FOREIGN KEY (`year_level_id`) REFERENCES `year_levels` (`year_level_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `year_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `year_levels` (
  `year_level_id` int(11) NOT NULL AUTO_INCREMENT,
  `year_name` varchar(50) NOT NULL,
  PRIMARY KEY (`year_level_id`),
  UNIQUE KEY `year_name` (`year_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;


-- ------------------------------------------------------------
-- Reference data
-- ------------------------------------------------------------
INSERT INTO `departments` (`department_id`, `department_name`, `department_code`) VALUES (1,'Education Department','EDUC');
INSERT INTO `departments` (`department_id`, `department_name`, `department_code`) VALUES (2,'Computer Studies Department','CSD');
INSERT INTO `departments` (`department_id`, `department_name`, `department_code`) VALUES (3,'Engineering Department','ENG');
INSERT INTO `departments` (`department_id`, `department_name`, `department_code`) VALUES (4,'Technology Department','TECH');
INSERT INTO `departments` (`department_id`, `department_name`, `department_code`) VALUES (5,'Nursing Department','NURS');
INSERT INTO `departments` (`department_id`, `department_name`, `department_code`) VALUES (6,'Entrepreneurship Department','ENTREP');
INSERT INTO `courses` (`course_id`, `course_code`, `course_name`, `department_id`) VALUES (1,'BSIT','Bachelor of Science in Information Technology',2);
INSERT INTO `courses` (`course_id`, `course_code`, `course_name`, `department_id`) VALUES (2,'BSCS','Bachelor of Science in Computer Science',2);
INSERT INTO `courses` (`course_id`, `course_code`, `course_name`, `department_id`) VALUES (3,'BSIS','Bachelor of Science in Information Systems',2);
INSERT INTO `courses` (`course_id`, `course_code`, `course_name`, `department_id`) VALUES (4,'BSCpE','Bachelor of Science in Computer Engineering',3);
INSERT INTO `courses` (`course_id`, `course_code`, `course_name`, `department_id`) VALUES (5,'BEEd','Bachelor of Elementary Education',1);
INSERT INTO `courses` (`course_id`, `course_code`, `course_name`, `department_id`) VALUES (6,'BSEd-ENG','Bachelor of Secondary Education Major in English',1);
INSERT INTO `courses` (`course_id`, `course_code`, `course_name`, `department_id`) VALUES (7,'BSEd-MATH','Bachelor of Secondary Education Major in Mathematics',1);
INSERT INTO `courses` (`course_id`, `course_code`, `course_name`, `department_id`) VALUES (8,'BTLEd','Bachelor of Technology and Livelihood Education',1);
INSERT INTO `courses` (`course_id`, `course_code`, `course_name`, `department_id`) VALUES (9,'ITANIM','Information Technology - Animation',2);
INSERT INTO `courses` (`course_id`, `course_code`, `course_name`, `department_id`) VALUES (10,'ECE','Bachelor of Science in Electronics Engineering',3);
INSERT INTO `courses` (`course_id`, `course_code`, `course_name`, `department_id`) VALUES (11,'BSAT','Bachelor of Science in Automotive Technology',4);
INSERT INTO `courses` (`course_id`, `course_code`, `course_name`, `department_id`) VALUES (12,'BSET-ELEC','Bachelor of Science in Electrical Technology',4);
INSERT INTO `courses` (`course_id`, `course_code`, `course_name`, `department_id`) VALUES (13,'BSET-ELT','Bachelor of Science in Electronics Technology',4);
INSERT INTO `courses` (`course_id`, `course_code`, `course_name`, `department_id`) VALUES (14,'BSMeT','Bachelor of Science in Mechanical Technology',4);
INSERT INTO `courses` (`course_id`, `course_code`, `course_name`, `department_id`) VALUES (15,'BSN','Bachelor of Science in Nursing',5);
INSERT INTO `courses` (`course_id`, `course_code`, `course_name`, `department_id`) VALUES (16,'BSEntrep','Bachelor of Science in Entrepreneurship',6);
INSERT INTO `year_levels` (`year_level_id`, `year_name`) VALUES (1,'First Year');
INSERT INTO `year_levels` (`year_level_id`, `year_name`) VALUES (4,'Fourth Year');
INSERT INTO `year_levels` (`year_level_id`, `year_name`) VALUES (2,'Second Year');
INSERT INTO `year_levels` (`year_level_id`, `year_name`) VALUES (3,'Third Year');

