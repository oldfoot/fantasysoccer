/*
SQLyog Ultimate - MySQL GUI v8.2 
MySQL - 5.6.13 : Database - fantasysoccer
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`fantasysoccer` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `fantasysoccer`;

/*Table structure for table `wc_announcements` */

DROP TABLE IF EXISTS `wc_announcements`;

CREATE TABLE `wc_announcements` (
  `message_id` int(5) NOT NULL AUTO_INCREMENT,
  `message` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `wc_announcements` */

/*Table structure for table `wc_error_messages` */

DROP TABLE IF EXISTS `wc_error_messages`;

CREATE TABLE `wc_error_messages` (
  `error_id` int(5) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `popup` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`error_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `wc_error_messages` */

insert  into `wc_error_messages`(`error_id`,`description`,`popup`) values (1,'Login Successful',NULL),(2,'Login Failed',NULL),(3,'Password retrieval invalid email',NULL),(4,'Password retrieval invalid',NULL),(5,'Password retrieval in progress',NULL),(6,'Password retrieval success',NULL),(7,'Success',NULL),(8,'Failed',NULL),(9,'Message 9',NULL),(10,'Message 10',NULL),(11,'Message 11',NULL),(12,'Message 12',NULL),(13,'Message 13',NULL);

/*Table structure for table `wc_fixture_master` */

DROP TABLE IF EXISTS `wc_fixture_master`;

CREATE TABLE `wc_fixture_master` (
  `fixture_id` int(5) NOT NULL AUTO_INCREMENT,
  `team_id_1` int(5) DEFAULT NULL,
  `team_id_2` int(5) DEFAULT NULL,
  `date_fixture` datetime DEFAULT NULL,
  `fixture_type_id` int(5) DEFAULT NULL,
  `goals_team_1` smallint(1) DEFAULT NULL,
  `goals_team_2` smallint(1) DEFAULT NULL,
  `yellow_cards_team_1` smallint(1) DEFAULT NULL,
  `yellow_cards_team_2` smallint(1) DEFAULT NULL,
  `red_cards_team_1` smallint(1) DEFAULT NULL,
  `red_cards_team_2` smallint(1) DEFAULT NULL,
  `hatricks_team_1` smallint(1) DEFAULT NULL,
  `hatricks_team_2` smallint(1) DEFAULT NULL,
  PRIMARY KEY (`fixture_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `wc_fixture_master` */

insert  into `wc_fixture_master`(`fixture_id`,`team_id_1`,`team_id_2`,`date_fixture`,`fixture_type_id`,`goals_team_1`,`goals_team_2`,`yellow_cards_team_1`,`yellow_cards_team_2`,`red_cards_team_1`,`red_cards_team_2`,`hatricks_team_1`,`hatricks_team_2`) values (1,8,2,'2006-03-31 00:00:00',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,8,2,'2006-03-27 00:00:00',1,3,0,1,0,0,0,0,0),(7,30,29,'2006-03-31 00:00:00',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,27,3,'2006-03-31 00:00:00',1,0,3,0,1,0,0,0,0),(8,32,31,'2006-03-31 00:00:00',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,1,3,'2006-04-11 00:00:00',1,1,2,1,1,0,0,0,0);

/*Table structure for table `wc_fixture_replacement_master` */

DROP TABLE IF EXISTS `wc_fixture_replacement_master`;

CREATE TABLE `wc_fixture_replacement_master` (
  `fixture_type_id` int(5) DEFAULT NULL,
  `max_replacements` smallint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `wc_fixture_replacement_master` */

insert  into `wc_fixture_replacement_master`(`fixture_type_id`,`max_replacements`) values (1,0),(2,3),(3,3),(4,3),(5,3),(6,3);

/*Table structure for table `wc_fixture_result_details` */

DROP TABLE IF EXISTS `wc_fixture_result_details`;

CREATE TABLE `wc_fixture_result_details` (
  `fixture_id` int(5) DEFAULT NULL,
  `player_id` int(5) DEFAULT NULL,
  `result_type` varchar(20) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `wc_fixture_result_details` */

/*Table structure for table `wc_fixture_type_master` */

DROP TABLE IF EXISTS `wc_fixture_type_master`;

CREATE TABLE `wc_fixture_type_master` (
  `fixture_type_id` int(5) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `prediction_allow` char(1) COLLATE latin1_general_ci DEFAULT NULL,
  `prediction_total` tinyint(2) DEFAULT NULL,
  `max_replacements` smallint(2) DEFAULT NULL,
  `ordering` smallint(2) DEFAULT NULL,
  `prediction_points` int(5) DEFAULT NULL,
  PRIMARY KEY (`fixture_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `wc_fixture_type_master` */

insert  into `wc_fixture_type_master`(`fixture_type_id`,`type_name`,`date_start`,`date_end`,`prediction_allow`,`prediction_total`,`max_replacements`,`ordering`,`prediction_points`) values (1,'Round Robin','2015-03-18 00:00:00','2156-11-11 00:00:00','',0,NULL,1,NULL),(2,'Round of 16','2006-03-28 00:00:00','2006-03-28 00:00:00','y',16,3,2,NULL),(3,'Quarter Finals','2006-03-29 00:00:00','2006-03-29 00:00:00','y',8,3,3,NULL),(4,'Semi Finals','2006-03-30 00:00:00','2006-03-30 00:00:00','y',4,3,4,NULL),(6,'Final','2006-03-31 00:00:00','2006-03-31 00:00:00','y',2,3,5,NULL),(7,'Winner','2006-04-01 00:00:00','2006-04-01 00:00:00','y',1,0,6,NULL);

/*Table structure for table `wc_history` */

DROP TABLE IF EXISTS `wc_history`;

CREATE TABLE `wc_history` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `user_id` int(5) DEFAULT NULL,
  `task` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `date_captured` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `task` (`task`)
) ENGINE=MyISAM AUTO_INCREMENT=266 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `wc_history` */

insert  into `wc_history`(`id`,`description`,`user_id`,`task`,`date_captured`) values (1,'aa deleted',8,'teams','2006-03-16 14:39:13'),(2,'aa deleted',8,'teams','2006-03-16 14:39:14'),(3,'aa deleted',8,'teams','2006-03-16 14:39:14'),(4,'aa deleted',8,'teams','2006-03-16 14:39:15'),(5,'aa deleted',8,'teams','2006-03-16 14:39:15'),(6,'Angola edited',8,'teams','2006-03-16 14:39:19'),(7,'123 added',8,'teams','2006-03-16 14:39:21'),(8,'asdsad34$ added',8,'teams','2006-03-16 14:39:34'),(9,'12322 edited',8,'teams','2006-03-16 14:40:37'),(10,'12322&#039; edited',8,'teams','2006-03-16 14:40:41'),(11,'12322&#039; deleted',8,'teams','2006-03-16 14:41:08'),(12,'asdsad34$ deleted',8,'teams','2006-03-16 14:41:14'),(13,'1 added',8,'teams','2006-03-16 14:41:43'),(14,'122 edited',8,'teams','2006-03-16 14:41:46'),(15,'122 deleted',8,'teams','2006-03-16 14:41:54'),(16,'1 added',8,'positions','2006-03-18 10:01:44'),(17,'122 edited',8,'positions','2006-03-18 10:02:26'),(18,'122 deleted',8,'positions','2006-03-18 10:02:28'),(19,'111 added',8,'points_type','2006-03-18 10:13:54'),(20,'11111ww edited',8,'points_type','2006-03-18 10:14:16'),(21,'11111ww deleted',8,'points_type','2006-03-18 10:14:17'),(22,'22321 added',8,'roles','2006-03-18 10:21:23'),(23,'22321fff edited',8,'roles','2006-03-18 10:21:26'),(24,'22321fff deleted',8,'roles','2006-03-18 10:21:27'),(25,'Jim11 edited',8,'players','2006-03-18 10:45:40'),(26,'Jim11 edited',8,'players','2006-03-18 10:45:44'),(27,'Jim11 edited',8,'players','2006-03-18 10:45:47'),(28,'Round of 16 edited',8,'fixture_type','2006-03-18 12:13:16'),(29,'Participant edited',8,'roles','2006-03-20 14:16:37'),(30,'Manager added',8,'roles','2006-03-20 14:17:39'),(31,'Round of 16 edited',8,'fixture_type','2006-03-20 14:18:29'),(32,'Third Place edited',8,'fixture_type','2006-03-20 14:18:41'),(33,'Round Robin edited',8,'fixture_type','2006-03-20 14:19:12'),(34,'Final edited',8,'fixture_type','2006-03-20 14:19:22'),(35,'Semi Finals edited',8,'fixture_type','2006-03-20 14:19:26'),(36,'Quarter Finals edited',8,'fixture_type','2006-03-20 14:19:28'),(37,'Round Robin edited',8,'fixture_type','2006-03-20 14:21:18'),(38,'Round of 16 edited',8,'fixture_type','2006-03-20 14:21:33'),(39,'GK edited',8,'positions','2006-03-20 14:51:07'),(40,'DR edited',8,'positions','2006-03-20 14:51:13'),(41,'DC added',8,'positions','2006-03-20 14:51:16'),(42,'DefenderLeft added',8,'positions','2006-03-20 14:51:29'),(43,'DefenderCenter edited',8,'positions','2006-03-20 14:51:35'),(44,'DefenderRight edited',8,'positions','2006-03-20 14:51:41'),(45,'Goalkeeper edited',8,'positions','2006-03-20 14:51:46'),(46,'MidfieldLeft edited',8,'positions','2006-03-20 14:51:51'),(47,'MidfieldCenter added',8,'positions','2006-03-20 14:51:58'),(48,'MidfieldRight added',8,'positions','2006-03-20 14:52:03'),(49,'StrikerLeft edited',8,'positions','2006-03-20 14:52:07'),(50,'StrikerCenter added',8,'positions','2006-03-20 14:52:12'),(51,'StrikerRight added',8,'positions','2006-03-20 14:52:18'),(52,'DF added',8,'players','2006-03-20 14:57:00'),(53,'DC added',8,'players','2006-03-20 14:57:07'),(54,'DR added',8,'players','2006-03-20 14:57:14'),(55,'ML added',8,'players','2006-03-20 14:57:25'),(56,'MC added',8,'players','2006-03-20 14:57:32'),(57,'MR added',8,'players','2006-03-20 14:57:37'),(58,'SL added',8,'players','2006-03-20 14:57:46'),(59,'SC added',8,'players','2006-03-20 14:57:53'),(60,'SR added',8,'players','2006-03-20 14:57:59'),(61,'Joe deleted',8,'players','2006-03-20 14:58:02'),(62,'Jim11 deleted',8,'players','2006-03-20 14:58:03'),(63,'GK added',8,'players','2006-03-20 14:58:16'),(64,'StrikerRight deleted',8,'positions','2006-03-25 09:58:18'),(65,'StrikerLeft deleted',8,'positions','2006-03-25 09:58:19'),(66,'MidfieldRight deleted',8,'positions','2006-03-25 09:58:20'),(67,'MidfieldLeft deleted',8,'positions','2006-03-25 09:58:21'),(68,'DefenderRight deleted',8,'positions','2006-03-25 09:58:22'),(69,'DefenderLeft deleted',8,'positions','2006-03-25 09:58:23'),(70,'Defender edited',8,'positions','2006-03-25 09:59:03'),(71,'Midfield edited',8,'positions','2006-03-25 09:59:06'),(72,'Striker edited',8,'positions','2006-03-25 09:59:09'),(73,'D1 edited',8,'players','2006-03-25 09:59:45'),(74,'M1 edited',8,'players','2006-03-25 09:59:50'),(75,'S1 edited',8,'players','2006-03-25 09:59:53'),(76,'D2 added',8,'players','2006-03-25 10:00:01'),(77,'d3 added',8,'players','2006-03-25 10:00:05'),(78,'D3 edited',8,'players','2006-03-25 10:00:09'),(79,'M2 added',8,'players','2006-03-25 10:00:20'),(80,'M3 added',8,'players','2006-03-25 10:00:25'),(81,'s2 added',8,'players','2006-03-25 10:00:58'),(82,'S3 added',8,'players','2006-03-25 10:01:04'),(83,'S2 edited',8,'players','2006-03-25 10:01:08'),(84,' deleted',8,'my_team','2006-03-27 12:50:30'),(85,' deleted',8,'my_team','2006-03-27 12:50:41'),(86,' deleted',8,'my_team','2006-03-27 12:50:42'),(87,' deleted',8,'my_team','2006-03-27 12:50:43'),(88,' deleted',8,'my_team','2006-03-27 12:55:50'),(89,' deleted',8,'my_team','2006-03-27 12:55:53'),(90,' deleted',8,'my_team','2006-03-27 15:05:04'),(91,' deleted',8,'my_team','2006-03-27 15:05:05'),(92,' deleted',8,'my_team','2006-03-27 15:05:06'),(93,' deleted',8,'my_team','2006-03-27 15:05:07'),(94,' deleted',8,'my_team','2006-03-27 16:04:54'),(95,' deleted',8,'my_team','2006-03-27 16:04:55'),(96,' deleted',8,'my_team','2006-03-27 16:04:56'),(97,' deleted',8,'my_team','2006-03-27 16:04:56'),(98,' deleted',8,'my_team','2006-03-27 16:04:57'),(99,' deleted',8,'my_team','2006-03-27 16:05:52'),(100,'Third Place deleted',8,'fixture_type','2006-03-28 14:22:47'),(101,'Round Robin edited',8,'fixture_type','2006-03-28 14:23:13'),(102,'Round of 16 edited',8,'fixture_type','2006-03-28 14:23:28'),(103,'Quarter Finals edited',8,'fixture_type','2006-03-28 14:23:38'),(104,'Semi Finals edited',8,'fixture_type','2006-03-28 14:23:45'),(105,'Final edited',8,'fixture_type','2006-03-28 14:23:51'),(106,'Clean Sheet added',8,'points_type','2006-03-28 15:33:42'),(107,'1 Goal Against added',8,'points_type','2006-03-28 15:33:47'),(108,'1 Goal Against deleted',8,'points_type','2006-03-28 15:34:12'),(109,'Clean Sheet deleted',8,'points_type','2006-03-28 15:34:12'),(110,'Fixture on 2006-03-31 added',8,'fixtures','2006-03-30 12:01:55'),(111,'Fixture on 2006-03-31 added',8,'fixtures','2006-03-30 12:06:24'),(112,'Fixture on 2006-03-31 added',8,'fixtures','2006-03-30 12:12:46'),(113,'Fixture on 2006-03-31 00:00:00 deleted',8,'fixtures','2006-03-30 12:15:27'),(114,'Fixture on 2006-03-29 edited',8,'fixtures','2006-03-30 12:17:02'),(115,'Fixture on 2006-03-29 00:00:00 edited',8,'fixtures','2006-03-30 12:17:06'),(116,'Fixture on 2006-03-29 00:00:00 edited',8,'fixtures','2006-03-30 12:17:10'),(117,'Fixture on 2006-03-27 added',8,'fixtures','2006-03-30 12:19:09'),(118,'Fixture on 2006-04-01 added',8,'fixtures','2006-03-30 12:20:08'),(119,'Fixture on 2006-04-29 edited',8,'fixtures','2006-03-30 12:20:18'),(120,'Oliver Kahn edited',8,'players','2006-03-30 12:34:48'),(121,'Joe Cole edited',8,'players','2006-03-30 12:35:11'),(122,'Michael Owen edited',8,'players','2006-03-30 12:35:19'),(123,'James Beattie edited',8,'players','2006-03-30 12:35:35'),(124,'James Blake edited',8,'players','2006-03-30 12:36:43'),(125,'Nkomo edited',8,'players','2006-03-30 12:36:48'),(126,'Madusa edited',8,'players','2006-03-30 12:36:53'),(127,'Zonki edited',8,'players','2006-03-30 12:36:59'),(128,'Tsotsi edited',8,'players','2006-03-30 12:37:06'),(129,'Drogba edited',8,'players','2006-03-30 12:37:10'),(130,'1 added to prediction stage: 2',8,'my_predictions','2006-03-30 14:44:51'),(131,'1 added to prediction stage: 2',8,'my_predictions','2006-03-30 14:45:06'),(132,'3 added to prediction stage: 2',8,'my_predictions','2006-03-30 15:00:15'),(133,'2 added to prediction stage: 2',8,'my_predictions','2006-03-30 15:00:41'),(134,'8 added to prediction stage: 2',8,'my_predictions','2006-03-30 15:02:02'),(135,'8 added to prediction stage: 3',8,'my_predictions','2006-03-30 15:02:04'),(136,'3 added to prediction stage: 3',8,'my_predictions','2006-03-30 15:02:05'),(137,'1 added to prediction stage: 3',8,'my_predictions','2006-03-30 15:02:06'),(138,'2 added to prediction stage: 3',8,'my_predictions','2006-03-30 15:02:07'),(139,'8 added to prediction stage: 4',8,'my_predictions','2006-03-30 15:02:08'),(140,'3 added to prediction stage: 4',8,'my_predictions','2006-03-30 15:02:09'),(141,'1 added to prediction stage: 4',8,'my_predictions','2006-03-30 15:02:09'),(142,'2 added to prediction stage: 4',8,'my_predictions','2006-03-30 15:02:10'),(143,'1 added to prediction stage: 6',8,'my_predictions','2006-03-30 15:02:11'),(144,'3 added to prediction stage: 6',8,'my_predictions','2006-03-30 15:02:13'),(145,'2 added to prediction stage: 7',8,'my_predictions','2006-03-30 15:02:14'),(146,'2 added to prediction stage: 6',8,'my_predictions','2006-03-30 15:02:26'),(147,'8 added to prediction stage: 6',8,'my_predictions','2006-03-30 15:02:28'),(148,'8 added to prediction stage: 7',8,'my_predictions','2006-03-30 15:02:29'),(149,'3 added to prediction stage: 7',8,'my_predictions','2006-03-30 15:02:30'),(150,'1 added to prediction stage: 7',8,'my_predictions','2006-03-30 15:02:31'),(151,'8 added to prediction stage: 2',8,'my_predictions','2006-03-31 09:44:02'),(152,'2 added to prediction stage: 2',8,'my_predictions','2006-03-31 09:44:27'),(153,'8 deleted from prediction stage: 2',8,'my_predictions','2006-03-31 10:07:29'),(154,'2 deleted from prediction stage: 2',8,'my_predictions','2006-03-31 10:08:53'),(155,'8 deleted from prediction stage: 2',8,'my_predictions','2006-03-31 10:08:54'),(156,'8 deleted from prediction stage: 3',8,'my_predictions','2006-03-31 10:08:55'),(157,'8 deleted from prediction stage: 2',8,'my_predictions','2006-03-31 10:09:24'),(158,'8 deleted from prediction stage: 2',8,'my_predictions','2006-03-31 10:12:00'),(159,'3 deleted from prediction stage: 2',8,'my_predictions','2006-03-31 10:12:01'),(160,'8 deleted from prediction stage: 2',8,'my_predictions','2006-03-31 10:17:05'),(161,'3 deleted from prediction stage: 2',8,'my_predictions','2006-03-31 10:17:06'),(162,'2 deleted from prediction stage: 2',8,'my_predictions','2006-03-31 10:17:06'),(163,'1 deleted from prediction stage: 2',8,'my_predictions','2006-03-31 10:17:07'),(164,'Argentina added',1,'teams','2006-03-31 12:17:10'),(165,'Portugal added',1,'teams','2006-03-31 12:17:18'),(166,'Poland added',1,'teams','2006-03-31 12:17:22'),(167,'Korea added',1,'teams','2006-03-31 12:17:28'),(168,'Tunisia added',1,'teams','2006-03-31 12:17:34'),(169,'USA added',1,'teams','2006-03-31 12:17:38'),(170,'Fixture on 2006-04-01 00:00:00 deleted',1,'fixtures','2006-03-31 12:17:44'),(171,'Fixture on 2006-04-01 00:00:00 deleted',1,'fixtures','2006-03-31 12:17:46'),(172,'Fixture on 2006-03-31 added',1,'fixtures','2006-03-31 12:17:59'),(173,'Fixture on 2006-03-31 added',1,'fixtures','2006-03-31 12:18:23'),(174,'Fixture on 2006-03-31 added',1,'fixtures','2006-03-31 12:18:37'),(175,'Prediction result for fixture 2 for team 8 added',1,'prediction_results','2006-03-31 14:25:29'),(176,'1 deleted',1,'prediction_results','2006-03-31 14:34:02'),(177,'Prediction result for fixture 2 for team 8 added',1,'prediction_results','2006-03-31 14:34:08'),(178,'1 deleted from prediction stage: 7',8,'my_predictions','2006-04-08 22:09:39'),(179,'8 deleted from prediction stage: 4',8,'my_predictions','2006-04-08 22:09:40'),(180,'2 deleted from prediction stage: 4',8,'my_predictions','2006-04-08 22:09:40'),(181,'3 deleted from prediction stage: 4',8,'my_predictions','2006-04-08 22:09:41'),(182,'1 deleted from prediction stage: 4',8,'my_predictions','2006-04-08 22:09:41'),(183,'1 deleted from prediction stage: 3',8,'my_predictions','2006-04-08 22:09:42'),(184,'2 deleted from prediction stage: 3',8,'my_predictions','2006-04-08 22:09:43'),(185,'8 deleted from prediction stage: 3',8,'my_predictions','2006-04-08 22:09:43'),(186,'3 deleted from prediction stage: 3',8,'my_predictions','2006-04-08 22:09:44'),(187,'1 deleted from prediction stage: 2',8,'my_predictions','2006-04-08 22:09:44'),(188,'3 deleted from prediction stage: 2',8,'my_predictions','2006-04-08 22:09:44'),(189,'2 deleted from prediction stage: 2',8,'my_predictions','2006-04-08 22:09:45'),(190,'8 deleted from prediction stage: 2',8,'my_predictions','2006-04-08 22:09:45'),(191,'8 deleted from prediction stage: 6',8,'my_predictions','2006-04-08 22:09:46'),(192,'3 deleted from prediction stage: 6',8,'my_predictions','2006-04-08 22:09:48'),(193,'2 deleted from prediction stage: 6',8,'my_predictions','2006-04-08 22:09:49'),(194,'1 deleted from prediction stage: 6',8,'my_predictions','2006-04-08 22:09:50'),(195,'2 deleted from prediction stage: 7',8,'my_predictions','2006-04-08 22:09:52'),(196,'3 deleted from prediction stage: 7',8,'my_predictions','2006-04-08 22:09:53'),(197,'8 deleted from prediction stage: 7',8,'my_predictions','2006-04-08 22:09:54'),(198,'Round Robin edited',1,'fixture_type','2006-04-08 22:11:19'),(199,'Round Robin edited',1,'fixture_type','2006-04-08 22:11:25'),(200,'Round Robin edited',1,'fixture_type','2006-04-08 22:11:29'),(201,'Per goal conceded edited',1,'points_type','2006-04-08 22:38:33'),(202,'Per goal conceded by goalkeeper deleted',1,'points_type','2006-04-08 22:38:37'),(203,'Total points 5 added',1,'points','2006-04-08 22:47:42'),(204,'Total points 5 added',1,'points','2006-04-08 23:07:42'),(205,'Points 1-1-1 deleted',1,'points','2006-04-08 23:16:14'),(206,'Total points 10 added',1,'points','2006-04-08 23:23:23'),(207,'Total points 20 added',1,'points','2006-04-08 23:23:35'),(208,'Total points 30 added',1,'points','2006-04-08 23:23:43'),(209,'Round Robin edited',1,'fixture_type','2006-04-10 23:28:02'),(210,'Fixture on 2006-03-27 00:00:00 reset',1,'fixtures','2006-04-10 23:58:02'),(211,'Round Robin edited',1,'fixture_type','2006-04-11 00:00:21'),(212,'Points 6-6-8 deleted',1,'points','2006-04-11 00:00:55'),(213,'Total points 5 added',1,'points','2006-04-11 00:01:16'),(214,'Total points 10 added',1,'points','2006-04-11 00:01:23'),(215,'Total points 15 added',1,'points','2006-04-11 00:01:34'),(216,'Total points -5 added',1,'points','2006-04-11 00:01:56'),(217,'Total points -5 added',1,'points','2006-04-11 00:02:03'),(218,'Total points -5 added',1,'points','2006-04-11 00:02:47'),(219,'Total points -10 added',1,'points','2006-04-11 00:10:39'),(220,'Total points -15 added',1,'points','2006-04-11 00:10:48'),(221,'Points 1-8-2 deleted',1,'points','2006-04-11 00:10:58'),(222,'Total points -10 added',1,'points','2006-04-11 00:11:08'),(223,'Total points -10 added',1,'points','2006-04-11 00:11:15'),(224,'Fixture on 2006-03-31 00:00:00 reset',1,'fixtures','2006-04-11 00:12:44'),(225,'Fixture on 2006-03-27 00:00:00 reset',1,'fixtures','2006-04-11 00:12:56'),(226,'Fixture on 2006-03-31 00:00:00 reset',1,'fixtures','2006-04-11 00:16:36'),(227,'30 deleted from prediction stage: 7',1,'my_predictions','2006-04-11 16:10:33'),(228,'Fixture on 2006-04-11 added',1,'fixtures','2006-04-11 16:17:18'),(229,'Per goal conceded deleted',1,'points_type','2006-04-11 19:07:41'),(230,'Player on a losing team deleted',1,'points_type','2006-04-11 19:07:52'),(231,'Player on a winning team deleted',1,'points_type','2006-04-11 19:07:53'),(232,'Goalkeeper Clean Sheet edited',1,'points_type','2006-04-11 19:09:20'),(233,'Total points -1 added',1,'points','2006-04-11 19:31:42'),(234,'31 deleted from prediction stage: 2',1,'my_predictions','2006-04-11 23:02:57'),(235,'30 deleted from prediction stage: 2',1,'my_predictions','2006-04-11 23:02:58'),(236,'3 deleted from prediction stage: 2',1,'my_predictions','2006-04-11 23:02:59'),(237,'8 deleted from prediction stage: 2',1,'my_predictions','2006-04-11 23:03:00'),(238,'28 deleted from prediction stage: 2',1,'my_predictions','2006-04-11 23:03:01'),(239,'1 deleted from prediction stage: 2',1,'my_predictions','2006-04-11 23:03:01'),(240,'2 deleted from prediction stage: 2',1,'my_predictions','2006-04-11 23:03:02'),(241,'8 deleted from prediction stage: 3',1,'my_predictions','2006-04-11 23:03:03'),(242,'2 deleted from prediction stage: 3',1,'my_predictions','2006-04-11 23:03:04'),(243,'29 deleted from prediction stage: 3',1,'my_predictions','2006-04-11 23:03:05'),(244,'32 deleted from prediction stage: 3',1,'my_predictions','2006-04-11 23:03:05'),(245,'31 deleted from prediction stage: 3',1,'my_predictions','2006-04-11 23:03:06'),(246,'3 deleted from prediction stage: 3',1,'my_predictions','2006-04-11 23:03:06'),(247,'27 deleted from prediction stage: 3',1,'my_predictions','2006-04-11 23:03:07'),(248,'30 deleted from prediction stage: 3',1,'my_predictions','2006-04-11 23:03:08'),(249,'27 deleted from prediction stage: 4',1,'my_predictions','2006-04-11 23:03:09'),(250,'1 deleted from prediction stage: 4',1,'my_predictions','2006-04-11 23:03:11'),(251,'3 deleted from prediction stage: 4',1,'my_predictions','2006-04-11 23:03:12'),(252,'2 deleted from prediction stage: 4',1,'my_predictions','2006-04-11 23:03:14'),(253,'28 deleted from prediction stage: 6',1,'my_predictions','2006-04-11 23:03:15'),(254,'29 deleted from prediction stage: 6',1,'my_predictions','2006-04-11 23:03:17'),(255,'1 deleted from prediction stage: 7',1,'my_predictions','2006-04-11 23:03:19'),(256,'32 deleted from prediction stage: 3',1,'my_predictions','2006-04-11 23:05:01'),(257,'Fixture on 2006-04-11 00:00:00 reset',1,'fixtures','2006-04-11 23:05:48'),(258,'Total points -10 added',1,'points','2006-04-11 23:07:12'),(259,'Fixture on 2006-04-11 00:00:00 reset',1,'fixtures','2006-04-11 23:09:43'),(260,'Fixture on 2006-04-11 00:00:00 reset',1,'fixtures','2006-04-11 23:10:01'),(261,'Angola1 edited',12,'teams','2015-10-12 21:07:49'),(262,'Angola edited',12,'teams','2015-10-12 21:07:53'),(263,'South Africa added',12,'teams','2015-10-12 21:08:01'),(264,'John Terry added',12,'players','2015-10-12 21:08:37'),(265,'Lionel Messi added',12,'players','2015-10-12 21:08:49');

/*Table structure for table `wc_logging` */

DROP TABLE IF EXISTS `wc_logging`;

CREATE TABLE `wc_logging` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `date_hit` datetime DEFAULT NULL,
  `session_id` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `user_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `wc_logging` */

insert  into `wc_logging`(`id`,`url`,`date_hit`,`session_id`,`user_id`) values (1,'','2015-10-12 00:27:51','',0),(2,'','2015-10-12 00:29:13','',0),(3,'','2015-10-12 00:29:29','',0),(4,'module=signup','2015-10-12 00:29:34','',0),(5,'module=signup','2015-10-12 00:29:42','',0),(6,'','2015-10-12 00:29:55','',0),(7,'','2015-10-12 00:29:58','',0),(8,'module=wc&task=home&msg=2','2015-10-12 00:29:58','',0),(9,'','2015-10-12 00:30:25','',0),(10,'module=wc&task=home&msg=2','2015-10-12 00:30:25','',0),(11,'module=signup','2015-10-12 00:30:35','',0),(12,'module=signup','2015-10-12 00:30:51','',0),(13,'','2015-10-12 00:30:57','',0),(14,'','2015-10-12 00:30:59','',0),(15,'module=wc&task=home&msg=1','2015-10-12 00:30:59','',0),(16,'','2015-10-12 00:33:10','',0),(17,'','2015-10-12 00:33:13','',0),(18,'','2015-10-12 00:33:16','',0),(19,'module=wc&task=home&msg=1','2015-10-12 00:33:16','',0),(20,'','2015-10-12 00:34:10','',0),(21,'','2015-10-12 00:36:14','',0),(22,'module=wc&task=home&msg=1','2015-10-12 00:36:14','',0),(23,'module=wc&task=home&msg=1','2015-10-12 00:36:58','',0),(24,'','2015-10-12 17:59:16','',0),(25,'','2015-10-12 17:59:19','',0),(26,'module=wc&task=home&msg=2','2015-10-12 17:59:19','',0),(27,'','2015-10-12 17:59:27','',0),(28,'module=wc&task=home&msg=1','2015-10-12 17:59:27','',0),(29,'module=wc&task=home&msg=1','2015-10-12 18:01:44','',0),(30,'','2015-10-12 18:02:26','',0),(31,'module=wc&task=home&msg=1','2015-10-12 18:02:26','',0),(32,'module=wc&task=home&msg=1','2015-10-12 18:04:03','',0),(33,'module=wc&task=home&msg=1','2015-10-12 18:04:41','',0),(34,'','2015-10-12 18:04:48','',0),(35,'module=wc&task=home&msg=1','2015-10-12 18:04:52','',0),(36,'module=wc&task=home&msg=1','2015-10-12 18:05:11','',0),(37,'module=wc&task=home&msg=1','2015-10-12 18:05:51','',0),(38,'','2015-10-12 18:06:03','',0),(39,'module=wc&task=home&msg=1','2015-10-12 18:06:03','',0),(40,'','2015-10-12 18:06:24','',0),(41,'','2015-10-12 18:07:43','',0),(42,'','2015-10-12 18:08:09','',0),(43,'module=wc&task=home&msg=1','2015-10-12 18:08:09','',0),(44,'module=wc&task=home&msg=1','2015-10-12 18:09:01','',0),(45,'','2015-10-12 18:09:04','',0),(46,'','2015-10-12 18:11:24','',0),(47,'','2015-10-12 18:11:32','',0),(48,'module=wc&task=home&msg=1','2015-10-12 18:11:32','',0);

/*Table structure for table `wc_player_master` */

DROP TABLE IF EXISTS `wc_player_master`;

CREATE TABLE `wc_player_master` (
  `player_id` int(5) NOT NULL AUTO_INCREMENT,
  `team_id` int(5) DEFAULT NULL,
  `player_name` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `position_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`player_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `wc_player_master` */

insert  into `wc_player_master`(`player_id`,`team_id`,`player_name`,`position_id`) values (13,8,'Tsotsi',6),(12,1,'Oliver Kahn',1),(4,8,'Drogba',6),(7,2,'James Blake',8),(10,3,'Joe Cole',10),(14,8,'Zonki',6),(15,8,'Madusa',8),(16,8,'Nkomo',8),(17,3,'Michael Owen',10),(18,3,'James Beattie',10),(19,3,'John Terry',6),(20,32,'Lionel Messi',8);

/*Table structure for table `wc_points_master` */

DROP TABLE IF EXISTS `wc_points_master`;

CREATE TABLE `wc_points_master` (
  `points` smallint(3) DEFAULT NULL,
  `fixture_type_id` int(5) DEFAULT NULL,
  `position_id` int(5) DEFAULT NULL,
  `points_type_id` int(5) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `wc_points_master` */

insert  into `wc_points_master`(`points`,`fixture_type_id`,`position_id`,`points_type_id`) values (10,1,10,4),(5,1,4,1),(10,1,8,1),(5,1,10,1),(20,1,8,4),(30,1,6,4),(15,1,6,1),(-5,1,6,3),(-5,1,8,3),(-5,1,10,3),(-10,1,6,2),(-10,1,8,2),(-10,1,10,2),(-1,1,1,13),(-10,1,1,2);

/*Table structure for table `wc_points_type_master` */

DROP TABLE IF EXISTS `wc_points_type_master`;

CREATE TABLE `wc_points_type_master` (
  `points_type_id` int(5) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`points_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `wc_points_type_master` */

insert  into `wc_points_type_master`(`points_type_id`,`description`) values (1,'Goal'),(2,'Red Card'),(3,'Yellow Card'),(8,'Goalkeeper Clean Sheet'),(4,'Hatrick'),(13,'Goalkeeper per goal conceded');

/*Table structure for table `wc_position_master` */

DROP TABLE IF EXISTS `wc_position_master`;

CREATE TABLE `wc_position_master` (
  `position_id` int(5) NOT NULL AUTO_INCREMENT,
  `position_name` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`position_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `wc_position_master` */

insert  into `wc_position_master`(`position_id`,`position_name`) values (1,'Goalkeeper'),(6,'Defender'),(8,'Midfield'),(10,'Striker');

/*Table structure for table `wc_prediction_results` */

DROP TABLE IF EXISTS `wc_prediction_results`;

CREATE TABLE `wc_prediction_results` (
  `prediction_result_id` int(5) NOT NULL AUTO_INCREMENT,
  `fixture_type_id` int(5) DEFAULT NULL,
  `team_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`prediction_result_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `wc_prediction_results` */

insert  into `wc_prediction_results`(`prediction_result_id`,`fixture_type_id`,`team_id`) values (2,2,8);

/*Table structure for table `wc_role_master` */

DROP TABLE IF EXISTS `wc_role_master`;

CREATE TABLE `wc_role_master` (
  `role_id` int(5) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `default_role` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `wc_role_master` */

insert  into `wc_role_master`(`role_id`,`role_name`,`default_role`) values (1,'Participant',1),(2,'Administrator',0),(4,'Manager',0);

/*Table structure for table `wc_role_priv` */

DROP TABLE IF EXISTS `wc_role_priv`;

CREATE TABLE `wc_role_priv` (
  `role_id` int(5) DEFAULT NULL,
  `module` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `task` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `access` char(1) COLLATE latin1_general_ci DEFAULT 't'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `wc_role_priv` */

insert  into `wc_role_priv`(`role_id`,`module`,`task`,`access`) values (1,'wc','acl','f'),(2,'wc','acl','t'),(2,'wc','teams','t'),(1,'wc','teams','f'),(2,'wc','players','t'),(1,'wc','players','f'),(2,'wc','positions','t'),(1,'wc','positions','f'),(2,'wc','points_type','t'),(1,'wc','points_type','f'),(2,'wc','roles','t'),(1,'wc','roles','f'),(2,'wc','fixture_type','t'),(1,'wc','fixture_type','f'),(4,'wc','acl','f'),(4,'wc','fixture_type','f'),(2,'wc','my_team','t'),(4,'wc','my_team','t'),(1,'wc','my_team','t'),(4,'wc','players','f'),(4,'wc','points_type','f'),(4,'wc','positions','f'),(4,'wc','roles','f'),(4,'wc','teams','f'),(2,'wc','fixture_master','t'),(4,'wc','fixture_master','t'),(1,'wc','fixture_master','t'),(2,'wc','fixtures','t'),(4,'wc','fixtures','t'),(1,'wc','fixtures','f'),(2,'wc','my_predictions','t'),(4,'wc','my_predictions','t'),(1,'wc','my_predictions','t'),(2,'wc','prediction_results','t'),(4,'wc','prediction_results','f'),(1,'wc','prediction_results','f'),(2,'wc','points','t'),(4,'wc','points','t'),(1,'wc','points','t'),(2,'wc','results','t'),(4,'wc','results','t'),(1,'wc','results','f'),(2,'wc','my_points','t'),(4,'wc','my_points','t'),(1,'wc','my_points','t'),(2,'wc','home','t'),(4,'wc','home','t'),(1,'wc','home','t');

/*Table structure for table `wc_sessions` */

DROP TABLE IF EXISTS `wc_sessions`;

CREATE TABLE `wc_sessions` (
  `session_id` varchar(255) NOT NULL DEFAULT '',
  `session_data` varchar(255) NOT NULL DEFAULT '',
  `session_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `wc_sessions` */

insert  into `wc_sessions`(`session_id`,`session_data`,`session_time`) values ('ir7qf67no1ki3gjuivgusipij2','sid|s:32:\"880270a36fea8374f25990f872463818\";user_id|s:2:\"12\";','2015-10-12 21:09:11');

/*Table structure for table `wc_setup` */

DROP TABLE IF EXISTS `wc_setup`;

CREATE TABLE `wc_setup` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `site_title` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `date_close_predictions` datetime DEFAULT NULL,
  `team_setup` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `max_players_per_country` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `wc_setup` */

insert  into `wc_setup`(`id`,`site_title`,`date_close_predictions`,`team_setup`,`max_players_per_country`) values (1,'Fantasy Soccer','2015-12-12 00:00:00','y',10);

/*Table structure for table `wc_team_master` */

DROP TABLE IF EXISTS `wc_team_master`;

CREATE TABLE `wc_team_master` (
  `team_id` int(5) NOT NULL AUTO_INCREMENT,
  `team_name` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `logo_location` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`team_id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `wc_team_master` */

insert  into `wc_team_master`(`team_id`,`team_name`,`logo_location`) values (1,'Germany','modules/wc/images/flags/ger.gif'),(2,'Australia','modules/wc/images/flags/aus.gif'),(3,'England','modules/wc/images/flags/eng.gif'),(8,'Angola','modules/wc/images/flags/ang.gif'),(27,'Argentina','modules/wc/images/flags/arg.gif'),(28,'Portugal','modules/wc/images/flags/por.gif'),(29,'Poland','modules/wc/images/flags/pol.gif'),(30,'Korea','modules/wc/images/flags/kor.gif'),(31,'Tunisia','modules/wc/images/flags/tun.gif'),(32,'USA','modules/wc/images/flags/usa.gif'),(33,'South Africa',NULL);

/*Table structure for table `wc_user_master` */

DROP TABLE IF EXISTS `wc_user_master`;

CREATE TABLE `wc_user_master` (
  `user_id` int(5) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `username` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `password` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `identity_number` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `tel_cellular` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `tel_home` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `address` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `session_id` varchar(32) COLLATE latin1_general_ci DEFAULT NULL,
  `language` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `editing_language` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `date_last_login` datetime DEFAULT NULL,
  `email_address` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `role_id` int(5) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `count_login` int(11) DEFAULT NULL,
  `fixture_type_id_last_login` int(5) DEFAULT NULL,
  `team_name` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `test_user` char(1) COLLATE latin1_general_ci DEFAULT 'n',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `wc_user_master` */

insert  into `wc_user_master`(`user_id`,`full_name`,`username`,`password`,`identity_number`,`tel_cellular`,`tel_home`,`address`,`session_id`,`language`,`editing_language`,`date_last_login`,`email_address`,`role_id`,`date_created`,`count_login`,`fixture_type_id_last_login`,`team_name`,`test_user`) values (1,'Terence','terence','ff5390bde5a4cf0aa2006cf2198efd29','12345','','','','17c8629592d962866c9978b6b37c714e',NULL,NULL,'2006-04-11 23:00:54',NULL,2,NULL,NULL,1,'SuperFlies','n'),(2,'2','2','ff5390bde5a4cf0aa2006cf2198efd29','2','2','','2',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,'n'),(3,'3','3','ff5390bde5a4cf0aa2006cf2198efd29','3','3','','3',NULL,NULL,NULL,NULL,'3@3',1,NULL,NULL,NULL,NULL,'n'),(4,'4','4','ff5390bde5a4cf0aa2006cf2198efd29','4','4','','4',NULL,NULL,NULL,NULL,'4',1,NULL,NULL,NULL,NULL,'n'),(5,'5','5','ff5390bde5a4cf0aa2006cf2198efd29','5','5','','5',NULL,NULL,NULL,NULL,'5',1,NULL,NULL,NULL,NULL,'n'),(6,'6','6','ff5390bde5a4cf0aa2006cf2198efd29','6','6','','6',NULL,NULL,NULL,NULL,'6',1,NULL,NULL,NULL,NULL,'n'),(7,'7','7','ff5390bde5a4cf0aa2006cf2198efd29','7','7','','7',NULL,NULL,NULL,NULL,'7',1,NULL,NULL,NULL,NULL,'n'),(8,'Terence Le Grange','8','ff5390bde5a4cf0aa2006cf2198efd29','8','8','','8','9cf1c5e5aa4232b44d879f407036fa9e',NULL,NULL,'2006-04-10 22:12:54','8',1,NULL,NULL,6,NULL,'n'),(9,'9','9','ff5390bde5a4cf0aa2006cf2198efd29','9','9','','9','966e74db99434ffd353f20d545505aaa',NULL,NULL,NULL,'9',1,NULL,NULL,NULL,NULL,'n'),(10,'Joe Soap','joe','ff5390bde5a4cf0aa2006cf2198efd29','joe','','','','49162575c0675efa0da70ea74ad1e011',NULL,NULL,'2006-03-31 12:10:53','joe@joe.com',1,'2006-03-31 12:10:45',NULL,6,NULL,'n'),(11,'t','terence.legrange@gmail.comt','ff5390bde5a4cf0aa2006cf2198efd29','t','t','','t',NULL,NULL,NULL,NULL,'t',2,'2015-10-12 00:29:42',NULL,NULL,NULL,'n'),(12,'terence','terence_legrange@yahoo.com','ff5390bde5a4cf0aa2006cf2198efd29','123','123','','123','880270a36fea8374f25990f872463818',NULL,NULL,'2015-10-12 19:06:05','terence_legrange@yahoo.com',2,'2015-10-12 00:30:51',NULL,1,NULL,'n');

/*Table structure for table `wc_user_points` */

DROP TABLE IF EXISTS `wc_user_points`;

CREATE TABLE `wc_user_points` (
  `user_id` int(5) DEFAULT NULL,
  `points` int(5) DEFAULT NULL,
  `description` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `points_type` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `fixture_id` int(5) DEFAULT NULL,
  `fixture_type_id` int(5) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `wc_user_points` */

insert  into `wc_user_points`(`user_id`,`points`,`description`,`points_type`,`fixture_id`,`fixture_type_id`) values (1,-5,'Drogba','Yellow Card',4,1),(8,-5,'Drogba','Yellow Card',4,1),(1,15,'Drogba','Goal',4,1),(8,15,'Drogba','Goal',4,1),(1,15,'Drogba','Goal',4,1),(8,15,'Drogba','Goal',4,1),(1,15,'Drogba','Goal',4,1),(8,15,'Drogba','Goal',4,1),(1,-5,'James Beattie','Yellow Card',6,1),(1,5,'Joe Cole','Goal',6,1),(1,5,'Joe Cole','Goal',6,1),(1,5,'James Beattie','Goal',6,1),(1,0,'Michael Owen','Goalkeeper per goal conceded',9,1),(1,-5,'Michael Owen','Yellow Card',9,1),(1,5,'Joe Cole','Goal',9,1),(1,5,'James Beattie','Goal',9,1),(1,-1,'Oliver Kahn','Goalkeeper per goal conceded',9,1),(8,-1,'Oliver Kahn','Goalkeeper per goal conceded',9,1),(1,-1,'Oliver Kahn','Goalkeeper per goal conceded',9,1),(8,-1,'Oliver Kahn','Goalkeeper per goal conceded',9,1),(8,0,'Oliver Kahn','Yellow Card',9,1),(1,0,'Oliver Kahn','Yellow Card',9,1),(1,0,'Oliver Kahn','Goal',9,1),(8,0,'Oliver Kahn','Goal',9,1);

/*Table structure for table `wc_user_predictions` */

DROP TABLE IF EXISTS `wc_user_predictions`;

CREATE TABLE `wc_user_predictions` (
  `user_id` int(5) DEFAULT NULL,
  `team_id` int(5) DEFAULT NULL,
  `fixture_type_id` int(5) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `wc_user_predictions` */

insert  into `wc_user_predictions`(`user_id`,`team_id`,`fixture_type_id`) values (1,1,3),(1,2,6),(1,28,4),(1,8,3),(1,27,3),(1,1,4),(1,29,3),(1,31,4),(1,28,3),(1,27,2),(1,8,2),(1,3,2),(1,28,2),(1,31,3),(1,32,2),(1,3,3),(1,30,3),(1,30,4),(1,3,6),(1,29,2),(10,2,2),(10,2,3),(10,2,4),(10,3,6),(10,8,6),(10,3,4),(10,1,3),(10,3,2),(10,1,7),(10,2,7),(10,1,6),(10,1,4),(10,3,3),(10,8,2),(1,31,2),(1,2,2),(1,2,7),(12,8,2),(12,3,2),(12,27,3),(12,3,3),(12,2,3),(12,8,3),(12,30,3),(12,29,3),(12,28,3),(12,31,3),(12,2,2),(12,1,2),(12,29,2),(12,28,2),(12,31,2),(12,32,2),(12,30,2),(12,27,2),(12,27,4),(12,2,4),(12,3,4),(12,1,4),(12,8,6),(12,2,6),(12,8,7);

/*Table structure for table `wc_user_team` */

DROP TABLE IF EXISTS `wc_user_team`;

CREATE TABLE `wc_user_team` (
  `user_id` int(5) NOT NULL DEFAULT '0',
  `player_id` int(5) NOT NULL DEFAULT '0',
  `fixture_type_id` int(5) NOT NULL DEFAULT '0',
  `position_location` char(2) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`,`player_id`,`fixture_type_id`,`position_location`),
  KEY `user_id` (`user_id`),
  KEY `player_id` (`player_id`),
  KEY `fixture_type_id` (`fixture_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `wc_user_team` */

insert  into `wc_user_team`(`user_id`,`player_id`,`fixture_type_id`,`position_location`) values (1,4,1,'DC'),(1,7,1,'ML'),(1,10,1,'SL'),(1,12,1,'GK'),(1,13,1,'DL'),(1,14,1,'DR'),(1,15,1,'MC'),(1,16,1,'MR'),(1,17,1,'SC'),(1,18,1,'SR'),(8,4,1,'DC'),(8,4,2,'DC'),(8,4,6,'DL'),(8,10,2,'SR'),(8,10,4,'SR'),(8,12,1,'GK'),(8,12,2,'GK'),(8,12,4,'GK'),(8,12,6,'GK'),(8,13,1,'DL'),(8,13,2,'DL'),(8,14,1,'DR'),(8,14,2,'DR'),(8,14,6,'DC'),(8,17,2,'SL'),(8,17,4,'SL'),(8,18,2,'SC'),(10,7,6,'ML'),(10,10,6,'SR'),(10,12,6,'GK'),(12,4,1,'D2'),(12,7,1,'M2'),(12,10,1,'S1'),(12,12,1,'GK'),(12,13,1,'D3'),(12,14,1,'D1'),(12,15,1,'M3'),(12,16,1,'M4'),(12,17,1,'S2');

/*Table structure for table `wc_user_team_change_log` */

DROP TABLE IF EXISTS `wc_user_team_change_log`;

CREATE TABLE `wc_user_team_change_log` (
  `user_id` int(5) NOT NULL DEFAULT '0',
  `fixture_type_id` int(5) NOT NULL DEFAULT '0',
  `player_id` int(5) NOT NULL DEFAULT '0',
  `status` char(3) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  KEY `user_id` (`user_id`),
  KEY `player_id` (`player_id`),
  KEY `fixture_type_id` (`fixture_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `wc_user_team_change_log` */

insert  into `wc_user_team_change_log`(`user_id`,`fixture_type_id`,`player_id`,`status`) values (1,1,18,'add'),(1,1,17,'add'),(1,1,10,'add'),(1,1,16,'add'),(1,1,15,'add'),(1,1,7,'add'),(10,6,10,'add'),(10,6,7,'add'),(10,6,12,'add'),(8,6,14,'add'),(8,6,4,'add'),(8,6,12,'add'),(8,4,10,'add'),(8,4,17,'add'),(8,4,12,'add'),(8,2,17,'add'),(8,2,18,'add'),(8,2,10,'add'),(1,1,14,'add'),(1,1,4,'add'),(1,1,13,'add'),(1,1,12,'add'),(1,1,12,'del'),(1,1,12,'add'),(1,1,12,'del'),(1,1,12,'add'),(12,1,4,'add'),(12,1,12,'add'),(12,1,13,'add'),(12,1,14,'add'),(12,1,7,'add'),(12,1,15,'add'),(12,1,16,'add'),(12,1,10,'add'),(12,1,17,'add');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
