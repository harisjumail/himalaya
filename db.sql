/*
SQLyog Professional v12.5.1 (64 bit)
MySQL - 10.4.20-MariaDB : Database - himalaya
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`himalaya` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `himalaya`;

/*Table structure for table `detailinvoice` */

DROP TABLE IF EXISTS `detailinvoice`;

CREATE TABLE `detailinvoice` (
  `iddetail` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idheader` varchar(20) DEFAULT NULL,
  `iditem` int(11) DEFAULT NULL,
  `qty` smallint(6) DEFAULT NULL,
  `ammount` int(11) DEFAULT NULL,
  PRIMARY KEY (`iddetail`),
  KEY `idheader` (`idheader`),
  KEY `idjob` (`iditem`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4;

/*Data for the table `detailinvoice` */

insert  into `detailinvoice`(`iddetail`,`idheader`,`iditem`,`qty`,`ammount`) values 
(54,'PSN202111181',1,1,NULL),
(55,'PSN202111181',2,1,NULL),
(56,'PSN202111192',1,2,NULL),
(57,'PSN202111192',2,1,NULL);

/*Table structure for table `headerinvoice` */

DROP TABLE IF EXISTS `headerinvoice`;

CREATE TABLE `headerinvoice` (
  `idheader` varchar(20) NOT NULL,
  `idtable` int(11) DEFAULT NULL,
  `issuedate` date DEFAULT NULL,
  `duedate` date DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `status` enum('y','n') DEFAULT 'y',
  `pelaku` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idheader`),
  KEY `idcustomer` (`idtable`),
  CONSTRAINT `headerinvoice_ibfk_1` FOREIGN KEY (`idtable`) REFERENCES `t_table` (`idtable`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `headerinvoice` */

insert  into `headerinvoice`(`idheader`,`idtable`,`issuedate`,`duedate`,`subject`,`status`,`pelaku`) values 
('PSN202111181',1,'2021-11-18',NULL,'ss','n','pelayan1'),
('PSN202111192',1,'2021-11-19',NULL,'sss','n','pelayan1');

/*Table structure for table `t_item` */

DROP TABLE IF EXISTS `t_item`;

CREATE TABLE `t_item` (
  `iditem` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `unitprice` int(11) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`iditem`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `t_item` */

insert  into `t_item`(`iditem`,`description`,`unitprice`,`subject`) values 
(1,'NASI',1000,NULL),
(2,'AYAM',5000,NULL),
(3,'CUMI',5000,NULL),
(4,'TERI',2500,NULL),
(5,'NILA',6000,NULL);

/*Table structure for table `t_table` */

DROP TABLE IF EXISTS `t_table`;

CREATE TABLE `t_table` (
  `idtable` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idtable`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `t_table` */

insert  into `t_table`(`idtable`,`nama`) values 
(1,'Table1'),
(2,'Table2'),
(3,'Table3'),
(4,'Table4');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`type`) values 
(1,'kasir1','21232f297a57a5a743894a0e4a801fc3','kasir'),
(2,'pelayan1','21232f297a57a5a743894a0e4a801fc3','pelayan'),
(3,'pelayan2','21232f297a57a5a743894a0e4a801fc3','pelayan');

/* Trigger structure for table `headerinvoice` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tr_deletedetail` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tr_deletedetail` AFTER DELETE ON `headerinvoice` FOR EACH ROW BEGIN
    
    CALL sp_deletedetail(OLD.idheader);

    END */$$


DELIMITER ;

/* Procedure structure for procedure `sp_deletedetail` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_deletedetail` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_deletedetail`(variable INT(6) )
BEGIN
	
	DELETE FROM detailinvoice WHERE idheader = variable;

	END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
