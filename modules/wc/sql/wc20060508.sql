/*
SQLyog - Free MySQL GUI v5.02
Host - 5.0.18-nt : Database - worldcup
*********************************************************************
Server version : 5.0.18-nt
*/


create database if not exists `worldcup`;

USE `worldcup`;

SET FOREIGN_KEY_CHECKS=0;

/*Table structure for table `wc_error_messages` */

DROP TABLE IF EXISTS `wc_error_messages`;

CREATE TABLE `wc_error_messages` (
  `error_id` int(5) NOT NULL auto_increment,
  `description` varchar(255) collate latin1_general_ci default NULL,
  `popup` tinyint(1) default NULL,
  PRIMARY KEY  (`error_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Table structure for table `wc_fixture_master` */

DROP TABLE IF EXISTS `wc_fixture_master`;

CREATE TABLE `wc_fixture_master` (
  `fixture_id` int(5) NOT NULL auto_increment,
  `team_id_1` int(5) default NULL,
  `team_id_2` int(5) default NULL,
  `date_fixture` datetime default NULL,
  `fixture_type_id` int(5) default NULL,
  `goals_team_1` smallint(1) default NULL,
  `goals_team_2` smallint(1) default NULL,
  `yellow_cards_team_1` smallint(1) default NULL,
  `yellow_cards_team_2` smallint(1) default NULL,
  `red_cards_team_1` smallint(1) default NULL,
  `red_cards_team_2` smallint(1) default NULL,
  `hatricks_team_1` smallint(1) default NULL,
  `hatricks_team_2` smallint(1) default NULL,
  PRIMARY KEY  (`fixture_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Table structure for table `wc_fixture_replacement_master` */

DROP TABLE IF EXISTS `wc_fixture_replacement_master`;

CREATE TABLE `wc_fixture_replacement_master` (
  `fixture_type_id` int(5) default NULL,
  `max_replacements` smallint(1) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Table structure for table `wc_fixture_result_details` */

DROP TABLE IF EXISTS `wc_fixture_result_details`;

CREATE TABLE `wc_fixture_result_details` (
  `fixture_id` int(5) default NULL,
  `player_id` int(5) default NULL,
  `result_type` varchar(20) collate latin1_general_ci default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Table structure for table `wc_fixture_type_master` */

DROP TABLE IF EXISTS `wc_fixture_type_master`;

CREATE TABLE `wc_fixture_type_master` (
  `fixture_type_id` int(5) NOT NULL auto_increment,
  `type_name` varchar(50) collate latin1_general_ci default NULL,
  `date_start` datetime default NULL,
  `date_end` datetime default NULL,
  `prediction_allow` char(1) collate latin1_general_ci default NULL,
  `prediction_total` tinyint(2) default NULL,
  `max_replacements` smallint(2) default NULL,
  `ordering` smallint(2) default NULL,
  `prediction_points` int(5) default NULL,
  PRIMARY KEY  (`fixture_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Table structure for table `wc_history` */

DROP TABLE IF EXISTS `wc_history`;

CREATE TABLE `wc_history` (
  `id` int(5) NOT NULL auto_increment,
  `description` varchar(255) collate latin1_general_ci default NULL,
  `user_id` int(5) default NULL,
  `task` varchar(20) collate latin1_general_ci default NULL,
  `date_captured` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `task` (`task`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Table structure for table `wc_logging` */

DROP TABLE IF EXISTS `wc_logging`;

CREATE TABLE `wc_logging` (
  `id` int(5) NOT NULL auto_increment,
  `url` varchar(255) collate latin1_general_ci default NULL,
  `date_hit` datetime default NULL,
  `session_id` varchar(255) collate latin1_general_ci default NULL,
  `user_id` int(5) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Table structure for table `wc_player_master` */

DROP TABLE IF EXISTS `wc_player_master`;

CREATE TABLE `wc_player_master` (
  `player_id` int(5) NOT NULL auto_increment,
  `team_id` int(5) default NULL,
  `player_name` varchar(50) collate latin1_general_ci default NULL,
  `position_id` int(5) default NULL,
  PRIMARY KEY  (`player_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Table structure for table `wc_points_master` */

DROP TABLE IF EXISTS `wc_points_master`;

CREATE TABLE `wc_points_master` (
  `points` smallint(3) default NULL,
  `fixture_type_id` int(5) default NULL,
  `position_id` int(5) default NULL,
  `points_type_id` int(5) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Table structure for table `wc_points_type_master` */

DROP TABLE IF EXISTS `wc_points_type_master`;

CREATE TABLE `wc_points_type_master` (
  `points_type_id` int(5) NOT NULL auto_increment,
  `description` varchar(100) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`points_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Table structure for table `wc_position_master` */

DROP TABLE IF EXISTS `wc_position_master`;

CREATE TABLE `wc_position_master` (
  `position_id` int(5) NOT NULL auto_increment,
  `position_name` varchar(50) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`position_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Table structure for table `wc_prediction_results` */

DROP TABLE IF EXISTS `wc_prediction_results`;

CREATE TABLE `wc_prediction_results` (
  `prediction_result_id` int(5) NOT NULL auto_increment,
  `fixture_type_id` int(5) default NULL,
  `team_id` int(5) default NULL,
  PRIMARY KEY  (`prediction_result_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Table structure for table `wc_role_master` */

DROP TABLE IF EXISTS `wc_role_master`;

CREATE TABLE `wc_role_master` (
  `role_id` int(5) NOT NULL auto_increment,
  `role_name` varchar(20) collate latin1_general_ci default NULL,
  `default_role` tinyint(1) default '0',
  PRIMARY KEY  (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Table structure for table `wc_role_priv` */

DROP TABLE IF EXISTS `wc_role_priv`;

CREATE TABLE `wc_role_priv` (
  `role_id` int(5) default NULL,
  `module` varchar(30) collate latin1_general_ci default NULL,
  `task` varchar(30) collate latin1_general_ci default NULL,
  `access` char(1) collate latin1_general_ci default 't'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Table structure for table `wc_sessions` */

DROP TABLE IF EXISTS `wc_sessions`;

CREATE TABLE `wc_sessions` (
  `session_id` varchar(255) NOT NULL default '',
  `session_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `session_data` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `wc_setup` */

DROP TABLE IF EXISTS `wc_setup`;

CREATE TABLE `wc_setup` (
  `id` int(5) NOT NULL auto_increment,
  `site_title` varchar(255) collate latin1_general_ci default NULL,
  `date_close_predictions` datetime default NULL,
  `team_setup` varchar(10) collate latin1_general_ci default NULL,
  `max_players_per_country` tinyint(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Table structure for table `wc_team_master` */

DROP TABLE IF EXISTS `wc_team_master`;

CREATE TABLE `wc_team_master` (
  `team_id` int(5) NOT NULL auto_increment,
  `team_name` varchar(50) collate latin1_general_ci default NULL,
  `logo_location` varchar(100) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`team_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Table structure for table `wc_user_master` */

DROP TABLE IF EXISTS `wc_user_master`;

CREATE TABLE `wc_user_master` (
  `user_id` int(5) NOT NULL auto_increment,
  `full_name` varchar(255) collate latin1_general_ci default NULL,
  `username` varchar(50) collate latin1_general_ci default NULL,
  `password` varchar(50) collate latin1_general_ci default NULL,
  `identity_number` varchar(100) collate latin1_general_ci default NULL,
  `tel_cellular` varchar(100) collate latin1_general_ci default NULL,
  `tel_home` varchar(100) collate latin1_general_ci default NULL,
  `address` varchar(255) collate latin1_general_ci default NULL,
  `session_id` varchar(32) collate latin1_general_ci default NULL,
  `language` varchar(20) collate latin1_general_ci default NULL,
  `editing_language` varchar(20) collate latin1_general_ci default NULL,
  `date_last_login` datetime default NULL,
  `email_address` varchar(100) collate latin1_general_ci default NULL,
  `role_id` int(5) default NULL,
  `date_created` datetime default NULL,
  `count_login` int(11) default NULL,
  `fixture_type_id_last_login` int(5) default NULL,
  `team_name` varchar(100) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Table structure for table `wc_user_points` */

DROP TABLE IF EXISTS `wc_user_points`;

CREATE TABLE `wc_user_points` (
  `user_id` int(5) default NULL,
  `points` int(5) default NULL,
  `description` varchar(255) collate latin1_general_ci default NULL,
  `points_type` varchar(30) collate latin1_general_ci default NULL,
  `fixture_id` int(5) default NULL,
  `fixture_type_id` int(5) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Table structure for table `wc_user_predictions` */

DROP TABLE IF EXISTS `wc_user_predictions`;

CREATE TABLE `wc_user_predictions` (
  `user_id` int(5) default NULL,
  `team_id` int(5) default NULL,
  `fixture_type_id` int(5) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Table structure for table `wc_user_team` */

DROP TABLE IF EXISTS `wc_user_team`;

CREATE TABLE `wc_user_team` (
  `user_id` int(5) NOT NULL default '0',
  `player_id` int(5) NOT NULL default '0',
  `fixture_type_id` int(5) NOT NULL default '0',
  `position_location` char(2) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`user_id`,`player_id`,`fixture_type_id`,`position_location`),
  KEY `user_id` (`user_id`),
  KEY `player_id` (`player_id`),
  KEY `fixture_type_id` (`fixture_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Table structure for table `wc_user_team_change_log` */

DROP TABLE IF EXISTS `wc_user_team_change_log`;

CREATE TABLE `wc_user_team_change_log` (
  `user_id` int(5) NOT NULL default '0',
  `fixture_type_id` int(5) NOT NULL default '0',
  `player_id` int(5) NOT NULL default '0',
  `status` char(3) collate latin1_general_ci NOT NULL default '',
  KEY `user_id` (`user_id`),
  KEY `player_id` (`player_id`),
  KEY `fixture_type_id` (`fixture_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

SET FOREIGN_KEY_CHECKS=1;
