/*
SQLyog Enterprise - MySQL GUI v7.02 
MySQL - 5.5.8 : Database - dephut_hti
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `adendum_sk` */

DROP TABLE IF EXISTS `adendum_sk`;

CREATE TABLE `adendum_sk` (
  `id_adendum` int(11) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) DEFAULT NULL,
  `nomor_adendum` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `luas` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id_adendum`),
  KEY `FK_adendum_iuphhk` (`id_iuphhk`),
  CONSTRAINT `FK_adendum_iuphhk` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `adendum_sk` */

/*Table structure for table `administrasi` */

DROP TABLE IF EXISTS `administrasi`;

CREATE TABLE `administrasi` (
  `id_administrasi` int(11) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) DEFAULT NULL,
  `provinsi` int(2) unsigned DEFAULT NULL,
  `kabupaten` varchar(255) DEFAULT NULL,
  `kecamatan` varchar(255) DEFAULT NULL,
  `rph` varchar(255) DEFAULT NULL,
  `bkph` varchar(255) DEFAULT NULL,
  `kph` varchar(255) DEFAULT NULL,
  `dinhut_kab` varchar(255) DEFAULT NULL,
  `dinhut_prov` int(2) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_administrasi`),
  KEY `FK_administrasi_iuphhk` (`id_iuphhk`),
  KEY `FK_administrasi_prov` (`provinsi`),
  KEY `FK_dinhut_prov` (`dinhut_prov`),
  CONSTRAINT `FK_administrasi_iuphhk` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE,
  CONSTRAINT `FK_administrasi_prov` FOREIGN KEY (`provinsi`) REFERENCES `provinsi` (`id_provinsi`) ON DELETE CASCADE,
  CONSTRAINT `FK_dinhut_prov` FOREIGN KEY (`dinhut_prov`) REFERENCES `provinsi` (`id_provinsi`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `administrasi` */

/*Table structure for table `app_role` */

DROP TABLE IF EXISTS `app_role`;

CREATE TABLE `app_role` (
  `id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `nama_role` varchar(50) NOT NULL DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `app_role` */

insert  into `app_role`(`id`,`nama_role`,`created_at`,`modified_at`) values (1,'Administrator',NULL,NULL),(2,'Perusahaan',NULL,NULL);

/*Table structure for table `app_users` */

DROP TABLE IF EXISTS `app_users`;

CREATE TABLE `app_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_role` tinyint(2) NOT NULL DEFAULT '2',
  `id_perusahaan` int(11) DEFAULT NULL,
  `nama_user` varchar(100) DEFAULT NULL,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user_role` (`id_role`),
  KEY `FK_user_perusahaan` (`id_perusahaan`),
  CONSTRAINT `FK_user_perusahaan` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`) ON DELETE CASCADE,
  CONSTRAINT `FK_user_role` FOREIGN KEY (`id_role`) REFERENCES `app_role` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=288 DEFAULT CHARSET=latin1;

/*Data for the table `app_users` */

insert  into `app_users`(`id`,`id_role`,`id_perusahaan`,`nama_user`,`username`,`password`,`last_login`,`created_at`,`modified_at`) values (1,1,NULL,'Admin','admin','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq','2016-03-17 11:08:47','2015-12-15 22:00:38',NULL),(10,2,1,'PT. Rencong Pulp and Paper','rencong','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq','2016-03-17 16:43:01',NULL,NULL),(11,2,2,'PT. Aceh Nusa Indrapuri','aceh','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq','2016-03-16 14:37:30',NULL,NULL),(12,2,3,'PT. Rimba Timur Sentosa','rimbatimur','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq','2016-02-01 10:23:17',NULL,NULL),(13,2,4,'PT. Rimba Wawasan Permai','rimbawawasan','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq','2016-02-01 10:21:32',NULL,NULL),(14,2,5,'PT. Tusam Hutani Lestari','tusam','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq','2016-02-01 10:23:47',NULL,NULL),(15,2,6,'PT. Rimba Penyangga Utama','rimbapenyangga','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(16,2,7,'PT. Toba Pulp Lestari','toba','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq','2016-02-02 19:46:52',NULL,NULL),(17,2,8,'PT. Putra Lika Perkasa','putralika','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq','2016-02-02 11:13:54',NULL,NULL),(18,2,9,'PT. Sumatera Riang Lestari (Sumut)','sumaterariang','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(19,2,10,'PT. Sumatera Silva Lestari (Sumut)','sumaterasilva','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(20,2,11,'PT. Anugerah Rimba Makmur','anugerah','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq','2016-02-23 15:30:58',NULL,NULL),(21,2,12,'PT. Hutan Barumun Perkasa','hutanbarumun','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(22,2,13,'PT. Sinar Belantara Indah','sinarbelantara','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(23,2,14,'PT. Tanaman Industri Lestari Simalungun','tanaman','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(24,2,15,'PT. Bukit Raya Mudisa','mudisa','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(25,2,16,'PT. Dhara Silva Lestari','dhara','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(26,2,17,'PT. Inkud Agritama','inkud','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(27,2,18,'PT. Sukses Jaya Wood','sukses','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(28,2,19,'PT. Jebus Maju','jebus','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(29,2,20,'PT. Limbah Kayu Utama','limbah','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(30,2,21,'PT. Rimba Hutani Mas (Jambi)','rimbahutani','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(31,2,22,'PT. Wira Karya Sakti ','wira','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq','2016-02-11 10:13:57',NULL,NULL),(32,2,23,'PT. Tebo Multi Agro','tebo','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq','2016-02-01 12:18:57',NULL,NULL),(33,2,24,'PT. Mugitriman Int','mugitriman','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(34,2,25,'PT. Alam Lestari Nusantara','alamlestari','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(35,2,26,'PT. Malaka Agro Perkasa','malaka','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(36,2,27,'PT. Lestari Asri Jaya','lestariasri','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(37,2,28,'PT. Wanamukti Wisesa','wanamukti','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(38,2,29,'PT. Wanakasita Nusantara','wanakasita','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(39,2,30,'PT. Wana Perintis','wanaperintis','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(40,2,31,'PT. Hijau Artha Nusa','hijau','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(41,2,32,'PT. Agronusa Alam Sejahtera','agronusa','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(42,2,33,'PT. Arangan Hutani Lestari','arangan','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(43,2,34,'PT. Dyera Hutan Lestari','dyera','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(44,2,35,'PT. Samhutani','samhutani','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(45,2,36,'PT. Gading Karya Makmur','gading','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(46,2,37,'PT. Bumi Andalas Permai','bumiandalas','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(47,2,38,'PT. Bumi Mekar Hijau (Sumsel)','bumimekar','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(48,2,39,'PT. Bumi Persada Permai (2004)','bumipersada','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(49,2,40,'PT. SBA Wood Industries','sba','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(50,2,41,'PT. Sumber Hijau Permai','sumber','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(51,2,42,'PT. Ciptamas Bumi Subur','ciptamas','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(52,2,43,'PT. Rimba Hutani Mas (Sumsel)','rimbahutani1','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(53,2,44,'PT. Bumi Persada Permai','bumipersada1','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(54,2,45,'PT. Sentosa Bahagia Bersama','sentosabahagia','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(55,2,46,'PT. Wahana Agro Mulia','wahanaagro','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(56,2,47,'PT. Paramitra Mulia Langgeng','paramitra','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(57,2,48,'PT. Sumatera Alam Anugerah','sumateraalam','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(58,2,49,'PT. Wahana Lestari Makmur Sukses','wahanalestari','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(59,2,50,'PT. Buana Sriwijaya Sejahtera','buanasriwijaya','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(60,2,51,'PT. Tiesico Cahaya Pertiwi','tiesico','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(61,2,52,'PT. Tri Pupajaya','tri','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(62,2,53,'PT. Tunas Hutan Pratama','tunas','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(63,2,54,'PT. Musi Hutan Persada','musi','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(64,2,55,'PT. Lantabura Mentari Sejahtera','lantabura','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(65,2,56,'PT. Budi Lampung Sejahtera','budi','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(66,2,57,'PT. Allindo Embryo Agro','allindo','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(67,2,58,'PT. Inhutani V Way Rebang-Muara Dua','inhutanirebang','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(68,2,59,'PT. Silva Inhutani Lampung','silvainhutani','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(69,2,60,'PT. Bangkanesia','bangkanesia','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(70,2,61,'PT. Istana Kawi Kencana','istana','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(71,2,62,'PT. Agro Pratama Sejahtera','agro','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(72,2,63,'PT. Indosukses Lestari Makmur','indosukses','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(73,2,64,'PT. Bangun Rimba Sejahtera','bangun','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(74,2,65,'PT. Inhutani V','inhutani5','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(75,2,66,'PT. Agrindo Persada Lestari','agrindo','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(76,2,67,'PT. Industrial Forest Plantation','industrial','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(77,2,68,'PT. E-Greendo','egreendo','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(78,2,69,'PT. Woyla Raya Abadi','woyla','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(79,2,70,'PT. Wana Damai (PT. Khatulistiwa Lestari)','wanadamai','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(80,2,71,'PT. Pundiwana Semesta','pundiwana','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(81,2,72,'PT. Meranti Sembada','merantisembada','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(82,2,73,'PT. Pola Inti Rimba','pola','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(83,2,74,'PT. Rimba Berlian Hijau','rimbaberlian','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(84,2,75,'PT. Ceria Karya Pranawa','ceria','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(85,2,76,'PT. Bukit Beringin Makmur','bukitberingin','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(86,2,77,'PT. Korintiga Hutani','korintiga','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(87,2,78,'PT. Kusuma Perkasa Wana','kusumaperkasa','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(88,2,79,'PT. Parwata Rimba','parwata','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(89,2,80,'PT. Perintis Adiwana','perintis','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(90,2,81,'PT. Purwa Permai','purwa','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(91,2,82,'PT. Puspa Wana Cemerlang','puspa','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(92,2,83,'PT. Rimba Argamas','rimbaargamas','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(93,2,84,'PT. Rimba Elok','rimbaelok','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(94,2,85,'PT. Taiyoung Engreen','taiyoung','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(95,2,86,'PT. Grace Putri Perdana','grace','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(96,2,87,'PT. Kalanis Sumber Rezeki','kalanis','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(97,2,88,'PT. Baratama Putra Perkasa','baratama','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(98,2,89,'PT. Trikorindotama Wanakarya (Kalteng)','trikorindotama','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(99,2,90,'PT. Acacia Andalan Utama','acacia','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(100,2,91,'PT. Acacia Andalan Utama II','acacia1','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(101,2,92,'PT. Adindo Hutani Lestari','adindo','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(102,2,93,'PT. Bakayan Jaya Abadi','bakayan','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(103,2,94,'PT. Multi Kusuma Cemerlang','multi','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(104,2,95,'PT. Belantara Persada','belantarapersada','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(105,2,96,'PT. Belantara Pusaka','belantarapusaka','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(106,2,97,'PT. Belantara Subur','belantarasubur','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(107,2,98,'PT. Bhinneka Wana','bhinneka','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(108,2,99,'PT. Buana Inti Energi','buanainti','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(109,2,100,'PT. Cahaya Mitra Wiratama','cahaya','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(110,2,101,'PT. Fajar Surya Swadaya','fajarsurya','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(111,2,102,'PT. Hutan Kusuma','hutankusuma','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(112,2,103,'PT. Hutan Mahligai','hutanmahligai','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(113,2,104,'PT. Inhutani I Batuampar - Mentawir','inhutanibatubampar','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(114,2,105,'PT. Inhutani I Longnah','inhutanilongnah','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(115,2,106,'PT. Inhutani II Tanah Grogot','inhutanigrogot','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(116,2,107,'PT. Intraca Hutani Lestari','intraca','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(117,2,108,'PT. ITCI Hutani Manunggal','itci','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(118,2,109,'PT. Kayan Makmur Sejahtera','kayan','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(119,2,110,'PT. Kelawit Hutani Lestari','kelawithutani','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(120,2,111,'PT. Kelawit Wana Lestari I','kelawitwana','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(121,2,112,'PT. Kelawit Wana Lestari II','kelawitwana1','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(122,2,113,'PT. Mahakam Persada Sakti','mahakam','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(123,2,114,'PT. Oceanis Timber Product','oceanis','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(124,2,115,'PT. Permata Borneo Abadi','permata','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(125,2,116,'PT. Rimba Raya Lestari','rimbaraya','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(126,2,117,'PT. Santan Borneo Abadi','santan','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(127,2,118,'PT. Sendhawar Adhi Karya','sendhawar','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(128,2,119,'PT. Silva Rimba Lestari','silvarimba','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(129,2,120,'PT. Sumalindo Alam Lestari (Unit II)','sumalindoalam1','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(130,2,121,'PT. Sumalindo Hutani Jaya I','sumalindohutani','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(131,2,122,'PT. Sumalindo Hutani Jaya II','sumalindohutani1','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(132,2,123,'PT. Sumalindo Alam Lestari (Unit I)','sumalindoalam','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(133,2,124,'PT. Surya Hutani Jaya','surya','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(134,2,125,'PT. Swadaya Perkasa','swadaya','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(135,2,126,'PT. Sylvaduta Corporation','sylvaduta','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(136,2,127,'PT. Taman Daulat Wananusa','taman','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(137,2,128,'PT. Tanjung Redep Hutani','tanjung','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(138,2,129,'PT. Tirta Mahakam resources','tirta','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(139,2,130,'PT. Wana Kaltim Lestari','wanakaltim','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(140,2,131,'PT. Borneo Kutai Lestari','borneokutai','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(141,2,132,'PT. Dharma Hutani Lestari','dharma','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(142,2,133,'PT. Diva Perdana Pesona','diva','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(143,2,134,'PT. Borneo Utara Lestari','borneoutara','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(144,2,135,'PT. Indosubur Sukses Makmur','indosubur','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(145,2,136,'PT. Hutan Berau Lestari','hutanberau','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(146,2,137,'PT. Arara Abadi','arara','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(147,2,138,'PT. Bukit Batu Hutani Alam','bukitbatu','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(148,2,139,'PT. Ekawana Lestari Dharma','ekawana','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(149,2,140,'PT. Nusa Prima Manunggal','nusaprima','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(150,2,141,'PT. Perawang Sukses Perkasa Indonesia','perawang','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(151,2,142,'PT. Riau Andalan Pulp & Paper','riauandalan','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(152,2,143,'PT. Rimba Rokan Lestari','rimbarokanlestari','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(153,2,144,'PT. Satria Perkasa Agung (Merawang)','satria','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(154,2,145,'PT. Sekato Pratama Makmur','sekato','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(155,2,146,'PT. Selaras Abadi Utama','selarasabadi','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(156,2,147,'PT. Suntara Gajapati','suntara','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(157,2,148,'PT. Riau Indo Agropalma','riauindo','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(158,2,149,'PT. Mitra Hutani Jaya','mitrahutani','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(159,2,150,'PT. Satria Perkasa Agung (Serapung)','satria1','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(160,2,151,'PT. Putra Riau Perkasa','putrariau','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(161,2,152,'PT. Ruas Utama Jaya','ruas','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(162,2,153,'PT. Bina Duta Laksana','binaduta','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(163,2,154,'PT. Prima Bangun Sukses','primabangun','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(164,2,155,'PT. Rimba Rokan Perkasa','rimbarokanperkasa','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(165,2,156,'PT. Bina Daya Bentala','binadayabentala','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(166,2,157,'PT. Artellindo Wiratama','artellindo','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(167,2,158,'PT. Rimba Mandau Lestari','rimbamandau','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(168,2,159,'PT. Bukit Batabuh Sei Indah','bukitbatabuh','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(169,2,160,'PT. Citra Sumber Sejahtera','citrasumber','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(170,2,161,'PT. Mitra Kembang Selaras','mitrakembang','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(171,2,162,'PT. Bukit Raya Pelalawan','bukitraya','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(172,2,163,'PT. Merbau Pelalawan Lestari','merbau','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(173,2,164,'PT. Rimba Mutiara Permai','rimbamutiara','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(174,2,165,'PT. Mitra Tani Nusa Sejati','mitratani','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(175,2,166,'PT. Seraya Sumber Lestari','seraya','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(176,2,167,'PT. Balai Kayang Mandiri','balai','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(177,2,168,'PT. Bina Daya Bintara','binadayabintara','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(178,2,169,'PT. Satria Perkasa Agung','satria2','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(179,2,170,'PT. Perkasa Baru','perkasa','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(180,2,171,'PT. Nusantara Sentosa Raya','nusantara','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(181,2,172,'PT. Lestari Unggul Makmur','lestariunggul','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(182,2,173,'PT. Sumatera Silva Lestari (Riau)','sumaterasilva2','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(183,2,174,'PT. Peranap Timber (PT.Uniseraya)','peranap','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(184,2,175,'PT. Tuah Negeri','tuah','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(185,2,176,'PT. Wananugraha Bina Lestari','wananugraha','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(186,2,177,'PT. Sari Hijau Mutiara','sarihijau','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(187,2,178,'PT. Sumatera Riang Lestari (Riau)','sumaterariang1','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(188,2,179,'KUD Bina Jaya Langgam','binajaya','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(189,2,180,'CV. Alam Lestari','alam','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(190,2,181,'CV. Harapan Jaya','harapan','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(191,2,182,'CV. Mutiara Lestari','mutiara','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(192,2,183,'CV. Putri Lindung Bulan','putri','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(193,2,184,'PT. Madukoro','madukoro','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(194,2,185,'CV. Bhakti Praja Mulia','bhakti','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(195,2,186,'PT. Triomas FDI','triomas','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(196,2,187,'PT. Nusa Wana Raya','nusawana','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(197,2,188,'PT. Riau Abadi Lestari ','riauabadi','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(198,2,189,'PT. Rimba Lazuardi','rimbalazuardi','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(199,2,190,'PT. Rimba Peranap Indah ','rimbaperanap','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(200,2,191,'PT. Rimba Seraya Utama','rimbaseraya','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(201,2,192,'PT. Asia Tani Persada','asia','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(202,2,193,'PT. Bina Silva Nusa','binasilva','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(203,2,194,'PT. Boma Plantation','boma','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(204,2,195,'PT. Buana Megatama Jaya','buanamegatama','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(205,2,196,'PT. Bumi Mekar Hijau (Kalbar)','bumimekar1','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(206,2,197,'PT. Daya Tani Kalbar','daya','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(207,2,198,'PT. Fajar Wana Lestari','fajarwana','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(208,2,199,'PT. Finnantara Intiga','finnantara','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(209,2,200,'PT. Gapura Persada Khatulistiwa ','gapura','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(210,2,201,'PT. Garuda Kalimantan Lestari','garuda','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(211,2,202,'PT. Hutan Ketapang Industri (PT KBR)','hutanketapang','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(212,2,203,'PT. Inhutani III Unit Nanga Pinoh','inhutanipinoh','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(213,2,204,'PT. Kalimantan Subur Permai','kalimantan','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(214,2,205,'PT. Kusuma Puspawana','kusumapuspawana','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(215,2,206,'PT. Lahan Cakrawala','lahancakrawala','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(216,2,207,'PT. Lahan Sukses','lahansukses','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(217,2,208,'PT. Lembah Jati Mutiara','lembah','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(218,2,209,'PT. Mahkota Rimba Utama','mahkota','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(219,2,210,'PT. Mayangkara Tanaman Industri (I)','mayangkara','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(220,2,211,'PT. Mayangkara Tanaman Industri (II)','mayangkara1','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(221,2,212,'PT. Mayawana Persada','mayawana','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(222,2,213,'PT. Menggala Rambu Utama','menggala','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(223,2,214,'PT. Meranti Laksana','merantilaksana','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq','2016-03-17 17:01:43',NULL,NULL),(224,2,215,'PT. Meranti Lestari','merantilestari','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(225,2,216,'PT. Mitra Jaya Nusaindah','mitrajaya','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(226,2,217,'PT. Muara Sungai Landak','muara','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(227,2,218,'PT. Nityasa Idola','nityasa','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(228,2,219,'PT. Prima Bumi Sentosa','primabumi','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(229,2,220,'PT. Rimba Equator Permai','rimbaequator','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(230,2,221,'PT. Segah Bangun Persada','segah','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(231,2,222,'PT. Sinar Kalbar Raya','sinarkalbar','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(232,2,223,'PT. Unggul Karya Inti Jaya','unggul','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(233,2,224,'PT. Wana Hijau Pesaguan','wanahijau','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(234,2,225,'PT. Sari Bumi Kusuma (Wana Subur Lestari)','saribumi','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(235,2,226,'PT. Wanakerta Eka Lestari','wanakerta','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(236,2,227,'PT. Bhatara Alam Lestari','bhatara','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(237,2,228,'PT. Wana Subur Persada','wanasubur','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(238,2,229,'PT. Duta Andalan Sukses','dutaandalan','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(239,2,230,'PT. Gambaru Selaras Alam','gambaru','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(240,2,231,'PT. Alfa Borneo Hutan Lestari','alfa','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(241,2,232,'PT. Duta Bintang Gemilang','dutabintang','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(242,2,233,'PT. Citra Mulia Inti','citramulia','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(243,2,234,'PT. Aya Yayang Indonesia','aya','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(244,2,235,'PT. Batulicin Bumi Bersujud','batulicin','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(245,2,236,'PT. Dwima Intiga','dwima','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(246,2,237,'PT. Hutan Rindang Banua','hutanrindang','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(247,2,238,'PT. Hutan Sembada','hutansembada','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(248,2,239,'PT. Inhutani II Unit Pulau Laut (Semaras)','inhutanisemaras','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(249,2,240,'PT. Inhutani II Unit Senakin','inhutanisenakin','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(250,2,241,'PT. Inhutani III (eks PT. IHT III Riam Kiwa)','inhutani3','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(251,2,242,'PT. Inhutani III Unit Sebuhur - Pelaihari','inhutanipelaihari','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(252,2,243,'PT. Inni Joa','inni','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(253,2,244,'PT. Janggala Semesta','janggala','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(254,2,245,'PT. Kirana Chatulistiwa','kiranachatulistiwa','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(255,2,246,'PT. Kodeco Timber','kodeco','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(256,2,247,'PT. Prima Multi Buana','primamulti','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(257,2,248,'PT. Trikorindotama Wanakarya (Kalsel)','trikorindotama1','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(258,2,249,'PT. JohnLin Agro Mandiri','johnlin','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(259,2,250,'PT. Wana Dipa Perkasa','wanadipa','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(260,2,251,'PT. Kawanua Kahuripan Pantera','kawanua','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(261,2,252,'PT. Berkat Hutan Pusaka','berkat','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(262,2,253,'PT. Wana Rindang Lestari','wanarindang','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(263,2,254,'PT. Amal Nusantara','amal','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(264,2,255,'PT. Bio Energy Indoco','bio','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(265,2,256,'PT. Bara Indoco','bara','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(266,2,257,'PT. Inhutani I Unit Gowa Maros','inhutanigowa','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(267,2,258,'PT. Sele Raya Agri','sele','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(268,2,259,'PT. Sinar Ceria Sejati','sinarceria','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(269,2,260,'PT. Gorontalo Citra Lestari','gorontalo','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(270,2,261,'PT. Gema Nusantara Jaya','gema','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(271,2,262,'PT. Koin Nesia','koin','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(272,2,263,'PT. Usaha Tani Lestari (NTB)','usahatani','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(273,2,264,'PT. Sadhana Arif Nusa','sadhana','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(274,2,265,'PT. Usaha Tani Lestari (NTT)','usahatani1','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(275,2,266,'PT. Wono Indotani Niaga','wono','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(276,2,267,'PT. Sentosa Pratama','sentosapratama','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(277,2,268,'PT. Waenibe Wood Industries','waenibe','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(278,2,269,'PT. Kalpika Wanatama Unit I','kalpika','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(279,2,270,'PT. Kalpika Wanatama Unit II','kalpika1','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(280,2,271,'PT. Kirana Cakrawala','kiranacakrawala','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(281,2,272,'PT. Mangole Timber Producer','mangole','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(282,2,273,'PT. NNE Plantation','nne','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(283,2,274,'PT. Selaras Inti Semesta','selarasinti','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(284,2,275,'PT. Plasma Nutfah Marind Papua','plasma','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(285,2,276,'PT. Wanamulia Sukses Sejati Unit I dan II','wanamulia','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(286,2,277,'PT. Wahana Samudra Sentosa','wahanasamudra','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq',NULL,NULL,NULL),(287,2,278,'PT. Kesatuan Mas Abadi','kesatuan','$2y$13$kS7as.ozwIroavE044KAe.Byl1EJrbfr9g6ZOgm68xx8EmbqOpLEq','2016-02-02 11:25:48',NULL,NULL);

/*Table structure for table `aspek` */

DROP TABLE IF EXISTS `aspek`;

CREATE TABLE `aspek` (
  `id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `nama_aspek` varchar(50) NOT NULL DEFAULT '',
  `bobot` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `aspek` */

insert  into `aspek`(`id`,`nama_aspek`,`bobot`) values (1,'Proses Tata Batas',15),(2,'Persetujuan Rencana Kerja Usaha',15),(3,'Pengesahan RKT/BKT',10),(4,'Ketersediaan Tenaga Teknis Bersertifikat',15),(5,'Realisasi Penanaman',25),(6,'PHPL/SVLK',20);

/*Table structure for table `attachment` */

DROP TABLE IF EXISTS `attachment`;

CREATE TABLE `attachment` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Keterangan` varchar(1000) DEFAULT 'Berkas Lampiran',
  `Model` varchar(60) DEFAULT NULL,
  `Model_id` int(11) DEFAULT NULL,
  `File_Name` varchar(255) DEFAULT NULL,
  `File_Type` varchar(255) DEFAULT NULL,
  `File_Path` varchar(255) DEFAULT NULL,
  `File_Size` int(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Keterangan` (`Keterangan`(255)),
  KEY `File_Name` (`File_Name`),
  KEY `File_Type` (`File_Type`),
  KEY `File_Path` (`File_Path`),
  KEY `File_Size` (`File_Size`),
  KEY `created_at` (`created_at`),
  KEY `modified_at` (`modified_at`),
  KEY `Model` (`Model`),
  KEY `Model_id` (`Model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `attachment` */

/*Table structure for table `attachment_bak` */

DROP TABLE IF EXISTS `attachment_bak`;

CREATE TABLE `attachment_bak` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `model_id` int(11) DEFAULT NULL,
  `type_attachment` enum('foto_keadaan_hutan') NOT NULL DEFAULT 'foto_keadaan_hutan',
  `file_name` varchar(100) DEFAULT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `upload_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `attachment_bak` */

/*Table structure for table `blok_sektor` */

DROP TABLE IF EXISTS `blok_sektor`;

CREATE TABLE `blok_sektor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_perusahaan` int(11) DEFAULT NULL,
  `id_iuphhk` int(11) DEFAULT NULL,
  `id_sektor` int(11) DEFAULT NULL,
  `id_blok` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sektor_perusahaan` (`id_perusahaan`),
  KEY `FK_sektor_iuphhk` (`id_iuphhk`),
  KEY `FK_sektor_master` (`id_sektor`),
  KEY `FK_blok_master` (`id_blok`),
  CONSTRAINT `FK_blok_master` FOREIGN KEY (`id_blok`) REFERENCES `master_blok` (`id`),
  CONSTRAINT `FK_sektor_iuphhk` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE,
  CONSTRAINT `FK_sektor_master` FOREIGN KEY (`id_sektor`) REFERENCES `master_sektor` (`id`),
  CONSTRAINT `FK_sektor_perusahaan` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `blok_sektor` */

/*Table structure for table `direksi` */

DROP TABLE IF EXISTS `direksi`;

CREATE TABLE `direksi` (
  `id_direksi` int(11) NOT NULL AUTO_INCREMENT,
  `perusahaan_id` int(11) DEFAULT NULL,
  `nama_direksi` varchar(50) NOT NULL DEFAULT '',
  `jabatan` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_direksi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `direksi` */

/*Table structure for table `iuphhk` */

DROP TABLE IF EXISTS `iuphhk`;

CREATE TABLE `iuphhk` (
  `id_iuphhk` int(11) NOT NULL AUTO_INCREMENT,
  `id_perusahaan` int(11) DEFAULT NULL,
  `nomor` varchar(50) NOT NULL DEFAULT '',
  `tanggal` date DEFAULT NULL,
  `luas` float(16,2) DEFAULT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_iuphhk`),
  KEY `FK_iuphhk_perusahaan` (`id_perusahaan`),
  CONSTRAINT `FK_iuphhk_perusahaan` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk` */

/*Table structure for table `iuphhk_adm_pemangkuan_hutan` */

DROP TABLE IF EXISTS `iuphhk_adm_pemangkuan_hutan`;

CREATE TABLE `iuphhk_adm_pemangkuan_hutan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) DEFAULT NULL,
  `rph` varchar(50) DEFAULT NULL,
  `bkph` varchar(50) DEFAULT NULL,
  `id_kph` int(11) NOT NULL,
  `dinhut_kab` int(4) unsigned NOT NULL,
  `dinhut_prov` int(2) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_pem_hutan_iuphhk` (`id_iuphhk`),
  KEY `dinhut_kab` (`dinhut_kab`),
  KEY `dinhut_prov` (`dinhut_prov`),
  KEY `FK_iuphhk_adm_pemangkuan_hutan_master_jenis_kph` (`id_kph`),
  CONSTRAINT `FK_iuphhk_adm_pemangkuan_hutan_jenis_kph` FOREIGN KEY (`id_kph`) REFERENCES `master_jenis_kph` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_pem_hutan_iuphhk` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE,
  CONSTRAINT `iuphhk_adm_pemangkuan_hutan_ibfk_1` FOREIGN KEY (`dinhut_kab`) REFERENCES `kabupaten` (`id_kabupaten`) ON DELETE CASCADE,
  CONSTRAINT `iuphhk_adm_pemangkuan_hutan_ibfk_2` FOREIGN KEY (`dinhut_prov`) REFERENCES `provinsi` (`id_provinsi`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk_adm_pemangkuan_hutan` */

/*Table structure for table `iuphhk_adm_pemerintahan` */

DROP TABLE IF EXISTS `iuphhk_adm_pemerintahan`;

CREATE TABLE `iuphhk_adm_pemerintahan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) DEFAULT NULL,
  `provinsi` int(2) unsigned DEFAULT NULL,
  `kabupaten` int(4) unsigned DEFAULT NULL,
  `kecamatan` int(6) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_adm_p` (`id_iuphhk`),
  KEY `FK_adm_prov` (`provinsi`),
  KEY `FK_adm_kab` (`kabupaten`),
  KEY `kecamatan` (`kecamatan`),
  CONSTRAINT `FK_adm_kab` FOREIGN KEY (`kabupaten`) REFERENCES `kabupaten` (`id_kabupaten`) ON DELETE CASCADE,
  CONSTRAINT `FK_adm_p` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE,
  CONSTRAINT `FK_adm_prov` FOREIGN KEY (`provinsi`) REFERENCES `provinsi` (`id_provinsi`) ON DELETE CASCADE,
  CONSTRAINT `iuphhk_adm_pemerintahan_ibfk_1` FOREIGN KEY (`kecamatan`) REFERENCES `kecamatan` (`id_kecamatan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk_adm_pemerintahan` */

/*Table structure for table `iuphhk_agama` */

DROP TABLE IF EXISTS `iuphhk_agama`;

CREATE TABLE `iuphhk_agama` (
  `id_agama` int(11) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) DEFAULT NULL,
  `islam` int(11) DEFAULT NULL,
  `katolik` int(11) DEFAULT NULL,
  `kristen` int(11) DEFAULT NULL,
  `lainnya` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_agama`),
  KEY `id_iuphhk` (`id_iuphhk`),
  CONSTRAINT `iuphhk_agama_ibfk_1` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk_agama` */

/*Table structure for table `iuphhk_data_jalan` */

DROP TABLE IF EXISTS `iuphhk_data_jalan`;

CREATE TABLE `iuphhk_data_jalan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) DEFAULT NULL,
  `dalam_areal` float(16,2) DEFAULT NULL COMMENT 'KM',
  `luar_areal` float(16,2) DEFAULT NULL COMMENT 'KM',
  `keterangan` text,
  PRIMARY KEY (`id`),
  KEY `id_iuphhk` (`id_iuphhk`),
  CONSTRAINT `iuphhk_data_jalan_ibfk_1` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk_data_jalan` */

/*Table structure for table `iuphhk_data_penduduk` */

DROP TABLE IF EXISTS `iuphhk_data_penduduk`;

CREATE TABLE `iuphhk_data_penduduk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) NOT NULL,
  `id_kategori_penduduk` int(11) NOT NULL,
  `id_jenis_kelamin` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL COMMENT '> 55 Tahun',
  PRIMARY KEY (`id`),
  KEY `id_iuphhk` (`id_iuphhk`),
  KEY `FK_iuphhk_data_penduduk_kategori` (`id_kategori_penduduk`),
  KEY `FK_iuphhk_data_penduduk_kelamin` (`id_jenis_kelamin`),
  CONSTRAINT `FK_iuphhk_data_penduduk_kategori` FOREIGN KEY (`id_kategori_penduduk`) REFERENCES `master_kategori_penduduk` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_iuphhk_data_penduduk_kelamin` FOREIGN KEY (`id_jenis_kelamin`) REFERENCES `master_jenis_kelamin` (`id`) ON DELETE CASCADE,
  CONSTRAINT `iuphhk_data_penduduk_ibfk_1` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk_data_penduduk` */

/*Table structure for table `iuphhk_data_penduduk_bak` */

DROP TABLE IF EXISTS `iuphhk_data_penduduk_bak`;

CREATE TABLE `iuphhk_data_penduduk_bak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) DEFAULT NULL,
  `anak_laki` int(11) DEFAULT NULL COMMENT '=< 17 Tahun',
  `anak_perempuan` int(11) DEFAULT NULL COMMENT '=< 17 Tahun',
  `produktif_laki` int(11) DEFAULT NULL COMMENT '17 - 55 Tahun',
  `produktif_perempuan` int(11) DEFAULT NULL COMMENT '17 - 55 Tahun',
  `lansia_laki` int(11) DEFAULT NULL COMMENT '> 55 Tahun',
  `lansia_perempuan` int(11) DEFAULT NULL COMMENT '> 55 Tahun',
  PRIMARY KEY (`id`),
  KEY `id_iuphhk` (`id_iuphhk`),
  CONSTRAINT `iuphhk_data_penduduk_bak_ibfk_1` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk_data_penduduk_bak` */

/*Table structure for table `iuphhk_data_sungai` */

DROP TABLE IF EXISTS `iuphhk_data_sungai`;

CREATE TABLE `iuphhk_data_sungai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) DEFAULT NULL,
  `dalam_areal` float(16,2) DEFAULT NULL COMMENT 'KM',
  `luar_areal` float(16,2) DEFAULT NULL COMMENT 'KM',
  `keterangan` text,
  PRIMARY KEY (`id`),
  KEY `id_iuphhk` (`id_iuphhk`),
  CONSTRAINT `iuphhk_data_sungai_ibfk_1` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk_data_sungai` */

/*Table structure for table `iuphhk_hidrologi_mata_air` */

DROP TABLE IF EXISTS `iuphhk_hidrologi_mata_air`;

CREATE TABLE `iuphhk_hidrologi_mata_air` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) DEFAULT NULL,
  `nama_mata_air` varchar(100) DEFAULT NULL,
  `keterangan` text,
  PRIMARY KEY (`id`),
  KEY `id_iuphhk` (`id_iuphhk`),
  CONSTRAINT `iuphhk_hidrologi_mata_air_ibfk_1` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk_hidrologi_mata_air` */

/*Table structure for table `iuphhk_hidrologi_sungai` */

DROP TABLE IF EXISTS `iuphhk_hidrologi_sungai`;

CREATE TABLE `iuphhk_hidrologi_sungai` (
  `id_sungai` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) DEFAULT NULL,
  `nama_sungai` varchar(100) DEFAULT NULL,
  `keterangan` text,
  PRIMARY KEY (`id_sungai`),
  KEY `id_iuphhk` (`id_iuphhk`),
  CONSTRAINT `iuphhk_hidrologi_sungai_ibfk_1` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk_hidrologi_sungai` */

/*Table structure for table `iuphhk_hidrologi_waduk` */

DROP TABLE IF EXISTS `iuphhk_hidrologi_waduk`;

CREATE TABLE `iuphhk_hidrologi_waduk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) DEFAULT NULL,
  `nama_waduk` varchar(100) DEFAULT NULL,
  `keterangan` text,
  PRIMARY KEY (`id`),
  KEY `id_iuphhk` (`id_iuphhk`),
  CONSTRAINT `iuphhk_hidrologi_waduk_ibfk_1` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk_hidrologi_waduk` */

/*Table structure for table `iuphhk_iklim` */

DROP TABLE IF EXISTS `iuphhk_iklim`;

CREATE TABLE `iuphhk_iklim` (
  `id_iklim` int(11) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) DEFAULT NULL,
  `tipe_iklim` varchar(100) DEFAULT NULL,
  `curah_hujan` float(8,2) DEFAULT NULL,
  `hujan_terendah` float(8,2) DEFAULT NULL,
  `hujan_tertinggi` float(8,2) DEFAULT NULL,
  PRIMARY KEY (`id_iklim`),
  KEY `id_iuphhk` (`id_iuphhk`),
  CONSTRAINT `iuphhk_iklim_ibfk_1` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk_iklim` */

/*Table structure for table `iuphhk_jenis_batuan` */

DROP TABLE IF EXISTS `iuphhk_jenis_batuan`;

CREATE TABLE `iuphhk_jenis_batuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) DEFAULT NULL,
  `nama_batuan` varchar(100) DEFAULT NULL,
  `keterangan` text,
  PRIMARY KEY (`id`),
  KEY `id_iuphhk` (`id_iuphhk`),
  CONSTRAINT `iuphhk_jenis_batuan_ibfk_1` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk_jenis_batuan` */

/*Table structure for table `iuphhk_jenis_tanah` */

DROP TABLE IF EXISTS `iuphhk_jenis_tanah`;

CREATE TABLE `iuphhk_jenis_tanah` (
  `id_tanah` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) DEFAULT NULL,
  `nama` varchar(100) NOT NULL DEFAULT '',
  `keterangan` text,
  PRIMARY KEY (`id_tanah`),
  KEY `FK_jenisTanah_iuphhk` (`id_iuphhk`),
  CONSTRAINT `FK_jenisTanah_iuphhk` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk_jenis_tanah` */

/*Table structure for table `iuphhk_keadaan_hutan` */

DROP TABLE IF EXISTS `iuphhk_keadaan_hutan`;

CREATE TABLE `iuphhk_keadaan_hutan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) DEFAULT NULL,
  `rutr` varchar(255) DEFAULT NULL,
  `keterangan` text,
  PRIMARY KEY (`id`),
  KEY `id_iuphhk` (`id_iuphhk`),
  CONSTRAINT `iuphhk_keadaan_hutan_ibfk_1` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk_keadaan_hutan` */

/*Table structure for table `iuphhk_keadaan_lahan` */

DROP TABLE IF EXISTS `iuphhk_keadaan_lahan`;

CREATE TABLE `iuphhk_keadaan_lahan` (
  `id_keadaan_lahan` int(11) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) DEFAULT NULL,
  `lahan_kering` float(16,2) DEFAULT NULL,
  `basah` float(16,2) DEFAULT NULL,
  `payau` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id_keadaan_lahan`),
  KEY `FK_lahan_iuphhk` (`id_iuphhk`),
  CONSTRAINT `FK_lahan_iuphhk` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk_keadaan_lahan` */

/*Table structure for table `iuphhk_kelompok_hutan` */

DROP TABLE IF EXISTS `iuphhk_kelompok_hutan`;

CREATE TABLE `iuphhk_kelompok_hutan` (
  `id_kel_hutan` int(11) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_kel_hutan`),
  KEY `id_iuphhk` (`id_iuphhk`),
  CONSTRAINT `iuphhk_kelompok_hutan_ibfk_1` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk_kelompok_hutan` */

/*Table structure for table `iuphhk_pekerjaan_penduduk` */

DROP TABLE IF EXISTS `iuphhk_pekerjaan_penduduk`;

CREATE TABLE `iuphhk_pekerjaan_penduduk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) DEFAULT NULL,
  `bertani` int(11) DEFAULT NULL,
  `berdagang` int(11) DEFAULT NULL,
  `pns` int(11) DEFAULT NULL,
  `lainnya` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_iuphhk` (`id_iuphhk`),
  CONSTRAINT `iuphhk_pekerjaan_penduduk_ibfk_1` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk_pekerjaan_penduduk` */

/*Table structure for table `iuphhk_sarpras_komunikasi` */

DROP TABLE IF EXISTS `iuphhk_sarpras_komunikasi`;

CREATE TABLE `iuphhk_sarpras_komunikasi` (
  `id_sarpras_kom` int(11) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) DEFAULT NULL,
  `jenis` varchar(100) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_sarpras_kom`),
  KEY `id_iuphhk` (`id_iuphhk`),
  CONSTRAINT `iuphhk_sarpras_komunikasi_ibfk_1` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk_sarpras_komunikasi` */

/*Table structure for table `iuphhk_sarpras_laut` */

DROP TABLE IF EXISTS `iuphhk_sarpras_laut`;

CREATE TABLE `iuphhk_sarpras_laut` (
  `id_sarpras_laut` int(11) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) DEFAULT NULL,
  `pelabuhan` int(11) DEFAULT NULL,
  `kapal` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_sarpras_laut`),
  KEY `id_iuphhk` (`id_iuphhk`),
  CONSTRAINT `iuphhk_sarpras_laut_ibfk_1` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

/*Data for the table `iuphhk_sarpras_laut` */

/*Table structure for table `iuphhk_sarpras_udara` */

DROP TABLE IF EXISTS `iuphhk_sarpras_udara`;

CREATE TABLE `iuphhk_sarpras_udara` (
  `id_sarpras_udara` int(11) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) DEFAULT NULL,
  `landasan` int(11) DEFAULT NULL,
  `pesawat` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_sarpras_udara`),
  KEY `id_iuphhk` (`id_iuphhk`),
  CONSTRAINT `iuphhk_sarpras_udara_ibfk_1` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk_sarpras_udara` */

/*Table structure for table `iuphhk_satwa` */

DROP TABLE IF EXISTS `iuphhk_satwa`;

CREATE TABLE `iuphhk_satwa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) NOT NULL,
  `id_jenis` tinyint(3) NOT NULL,
  `nama_satwa` varchar(100) DEFAULT NULL,
  `keterangan` text,
  PRIMARY KEY (`id`),
  KEY `id_iuphhk` (`id_iuphhk`),
  KEY `id_jenis` (`id_jenis`),
  CONSTRAINT `iuphhk_satwa_ibfk_1` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE,
  CONSTRAINT `iuphhk_satwa_ibfk_2` FOREIGN KEY (`id_jenis`) REFERENCES `m_jenis_hewan` (`id_jenis_hewan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk_satwa` */

/*Table structure for table `iuphhk_tempat_ibadah` */

DROP TABLE IF EXISTS `iuphhk_tempat_ibadah`;

CREATE TABLE `iuphhk_tempat_ibadah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) DEFAULT NULL,
  `mesjid` int(11) DEFAULT NULL,
  `gereja` int(11) DEFAULT NULL,
  `lainnya` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_iuphhk` (`id_iuphhk`),
  CONSTRAINT `iuphhk_tempat_ibadah_ibfk_1` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk_tempat_ibadah` */

/*Table structure for table `iuphhk_tempat_pendidikan` */

DROP TABLE IF EXISTS `iuphhk_tempat_pendidikan`;

CREATE TABLE `iuphhk_tempat_pendidikan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) DEFAULT NULL,
  `sd` int(11) DEFAULT NULL,
  `sltp` int(11) DEFAULT NULL,
  `sma` int(11) DEFAULT NULL,
  `pt` int(11) DEFAULT NULL COMMENT 'Perguruan Tinggi',
  `lainnya` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_iuphhk` (`id_iuphhk`),
  CONSTRAINT `iuphhk_tempat_pendidikan_ibfk_1` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk_tempat_pendidikan` */

/*Table structure for table `iuphhk_topografi` */

DROP TABLE IF EXISTS `iuphhk_topografi`;

CREATE TABLE `iuphhk_topografi` (
  `id_topografi` int(11) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) DEFAULT NULL,
  `datar` float(16,2) DEFAULT NULL,
  `landai` float(16,2) DEFAULT NULL,
  `agak_curam` float(16,2) DEFAULT NULL,
  `curam` float(16,2) DEFAULT NULL,
  `sangat_curam` float(16,2) DEFAULT NULL,
  `ketinggian` float(16,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_topografi`),
  UNIQUE KEY `id_iuphhk` (`id_iuphhk`),
  CONSTRAINT `FK_topografi_iuphhk` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk_topografi` */

/*Table structure for table `iuphhk_tutup_lahan` */

DROP TABLE IF EXISTS `iuphhk_tutup_lahan`;

CREATE TABLE `iuphhk_tutup_lahan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_iuphhk` int(11) NOT NULL,
  `id_penutupan_lahan` int(11) NOT NULL,
  `hpt` float(16,2) DEFAULT NULL,
  `hp` float(16,2) DEFAULT NULL,
  `hpk` float(16,2) DEFAULT NULL,
  `apl` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_iuphhk_tutup_lahan_iuphhk` (`id_iuphhk`),
  KEY `FK_iuphhk_tutup_lahan_master_jenis_tutup_lahan` (`id_penutupan_lahan`),
  CONSTRAINT `FK_iuphhk_tutup_lahan_iuphhk` FOREIGN KEY (`id_iuphhk`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE,
  CONSTRAINT `FK_iuphhk_tutup_lahan_master_jenis_tutup_lahan` FOREIGN KEY (`id_penutupan_lahan`) REFERENCES `master_jenis_tutup_lahan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iuphhk_tutup_lahan` */

/*Table structure for table `kabupaten` */

DROP TABLE IF EXISTS `kabupaten`;

CREATE TABLE `kabupaten` (
  `id_kabupaten` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `provinsi_id` int(2) unsigned DEFAULT NULL COMMENT 'Provinsi',
  `nama` varchar(255) NOT NULL COMMENT 'Nama Kabupaten',
  PRIMARY KEY (`id_kabupaten`),
  KEY `nama` (`nama`),
  KEY `FK_kabupaten_propinsi` (`provinsi_id`),
  CONSTRAINT `FK_kabupaten_provinsi` FOREIGN KEY (`provinsi_id`) REFERENCES `provinsi` (`id_provinsi`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9216 DEFAULT CHARSET=utf8;

/*Data for the table `kabupaten` */

insert  into `kabupaten`(`id_kabupaten`,`provinsi_id`,`nama`) values (1101,11,'Kab. Aceh Selatan'),(1102,11,'Kab. Aceh Tenggara'),(1103,11,'Kab. Aceh Timur'),(1104,11,'Kab. Aceh Tengah'),(1105,11,'Kab. Aceh Barat'),(1106,11,'Kab. Aceh Besar'),(1107,11,'Kab. Pidie'),(1108,11,'Kab. Aceh Utara'),(1109,11,'Kab. Simeulue'),(1110,11,'Kab. Aceh Singkil'),(1111,11,'Kab. Bireuen'),(1112,11,'Kab. Aceh Barat Daya'),(1113,11,'Kab. Gayo Lues'),(1114,11,'Kab. Aceh Jaya'),(1115,11,'Kab. Nagan Raya'),(1116,11,'Kab. Aceh Tamiang'),(1117,11,'Kab. Bener Meriah'),(1118,11,'Kab. Pidie Jaya'),(1171,11,'Kota Banda Aceh'),(1172,11,'Kota Sabang'),(1173,11,'Kota Lhokseumawe'),(1174,11,'Kota Langsa'),(1175,11,'Kota Subulussalam'),(1201,12,'Kab. Tapanuli Tengah'),(1202,12,'Kab. Tapanuli Utara'),(1203,12,'Kab. Tapanuli Selatan'),(1204,12,'Kab. Nias'),(1205,12,'Kab. Langkat'),(1206,12,'Kab. Karo'),(1207,12,'Kab. Deli Serdang'),(1208,12,'Kab. Simalungun'),(1209,12,'Kab. Asahan'),(1210,12,'Kab. Labuhanbatu'),(1211,12,'Kab. Dairi'),(1212,12,'Kab. Toba Samosir'),(1213,12,'Kab. Mandailing Natal'),(1214,12,'Kab. Nias Selatan'),(1215,12,'Kab. Pakpak Bharat'),(1216,12,'Kab. Humbang Hasundutan'),(1217,12,'Kab. Samosir'),(1218,12,'Kab. Serdang Bedagai'),(1219,12,'Kab. Batu Bara'),(1220,12,'Kab. Padang Lawas Utara'),(1221,12,'Kab. Padang Lawas'),(1222,12,'Kab. Labuhanbatu Selatan'),(1223,12,'Kab. Labuhanbatu Utara'),(1224,12,'Kab. Nias Utara'),(1225,12,'Kab. Nias Barat'),(1271,12,'Kota Medan'),(1272,12,'Kota Pematang Siantar'),(1273,12,'Kota Sibolga'),(1274,12,'Kota Tanjung Balai'),(1275,12,'Kota Binjai'),(1276,12,'Kota Tebing Tinggi'),(1277,12,'Kota Padangsidimpuan'),(1278,12,'Kota Gunungsitoli'),(1301,13,'Kab. Pesisir Selatan'),(1302,13,'Kab. Solok'),(1303,13,'Kab. Sijunjung'),(1304,13,'Kab. Tanah Datar'),(1305,13,'Kab. Padang Pariaman'),(1306,13,'Kab. Agam'),(1307,13,'Kab. Lima Puluh Kota'),(1308,13,'Kab. Pasaman'),(1309,13,'Kab. Kepulauan Mentawai'),(1310,13,'Kab. Dharmasraya'),(1311,13,'Kab. Solok Selatan'),(1312,13,'Kab. Pasaman Barat'),(1371,13,'Kota Padang'),(1372,13,'Kota Solok'),(1373,13,'Kota Sawahlunto'),(1374,13,'Kota Padang Panjang'),(1375,13,'Kota Bukittinggi'),(1376,13,'Kota Payakumbuh'),(1377,13,'Kota Pariaman'),(1401,14,'Kab. Kampar'),(1402,14,'Kab. Indragiri Hulu'),(1403,14,'Kab. Bengkalis'),(1404,14,'Kab. Indragiri Hilir'),(1405,14,'Kab.  Pelalawan'),(1406,14,'Kab.  Rokan Hulu'),(1407,14,'Kab.  Rokan Hilir'),(1408,14,'Kab.  Siak'),(1409,14,'Kab. Kuantan Singingi'),(1410,14,'Kab. Kepulauan Meranti'),(1471,14,'Kota Pekanbaru'),(1472,14,'Kota Dumai'),(1501,15,'Kab.  Kerinci'),(1502,15,'Kab.  Merangin'),(1503,15,'Kab. Sarolangun'),(1504,15,'Kab. Batanghari'),(1505,15,'Kab.  Muaro Jambi'),(1506,15,'Kab. Tanjung Jabung Barat'),(1507,15,'Kab. Tanjung Jabung Timur'),(1508,15,'Kab. Bungo'),(1509,15,'Kab. Tebo'),(1571,15,'Kota Jambi'),(1572,15,'Kota Sungai Penuh'),(1601,16,'Kab. Ogan Komering Ulu'),(1603,16,'Kab. Muara Enim'),(1604,16,'Kab. Lahat'),(1605,16,'Kab. Musi Rawas'),(1606,16,'Kab. Musi Banyuasin'),(1607,16,'Kab. Banyuasin'),(1608,16,'Kab. Oku Timur'),(1609,16,'Kab. Oku Selatan'),(1610,16,'Kab. Ogan Ilir'),(1611,16,'Kab. Empat Lawang'),(1671,16,'Kota Palembang'),(1672,16,'Kota Pagar Alam'),(1673,16,'Kota Lubuk Linggau'),(1674,16,'Kota Prabumulih'),(1701,17,'Kab. Bengkulu Selatan'),(1702,17,'Kab. Rejang Lebong'),(1703,17,'Kab. Bengkulu Utara'),(1704,17,'Kab. Kaur'),(1705,17,'Kab. Seluma'),(1706,17,'Kab. Muko Muko'),(1707,17,'Kab. Lebong'),(1708,17,'Kab. Kepahiang'),(1709,17,'Kab. Bengkulu Tengah'),(1771,17,'Kota Bengkulu'),(1801,18,'Kab. Lampung Selatan'),(1802,18,'Kab. Lampung Tengah'),(1803,18,'Kab. Lampung Utara'),(1804,18,'Kab. Lampung Barat'),(1806,18,'Kab. Tanggamus'),(1807,18,'Kab. Lampung Timur'),(1808,18,'Kab. Way Kanan'),(1809,18,'Kab. Pesawaran'),(1810,18,'Kab. Pringsewu'),(1811,18,'Kab. Mesuji'),(1812,18,'Kab. Tulang Bawang Barat'),(1871,18,'Kota Bandar Lampung'),(1872,18,'Kota Metro'),(1901,19,'Kab. Bangka'),(1902,19,'Kab. Belitung'),(1903,19,'Kab. Bangka Selatan'),(1904,19,'Kab. Bangka Tengah'),(1905,19,'Kab. Bangka Barat'),(1906,19,'Kab. Belitung Timur'),(1971,19,'Kota Pangkal Pinang'),(2101,21,'Kab. Bintan'),(2102,21,'Kab. Karimun'),(2103,21,'Kab. Natuna'),(2104,21,'Kab. Lingga'),(2105,21,'Kab. Kepulauan Anambas'),(2171,21,'Kota Batam'),(2172,21,'Kota Tanjung Pinang'),(3101,31,'Kab. Adm. Kep. Seribu'),(3171,31,'Kota Adm. Jakarta Pusat'),(3172,31,'Kota Adm. Jakarta Utara'),(3173,31,'Kota Adm. Jakarta Barat'),(3174,31,'Kota Adm. Jakarta Selatan'),(3175,31,'Kota Adm. Jakarta Timur'),(3201,32,'Kab. Bogor'),(3202,32,'Kab. Sukabumi'),(3203,32,'Kab. Cianjur'),(3204,32,'Kab. Bandung'),(3205,32,'Kab. Garut'),(3206,32,'Kab. Tasikmalaya'),(3207,32,'Kab. Ciamis'),(3208,32,'Kab. Kuningan'),(3209,32,'Kab. Cirebon'),(3210,32,'Kab. Majalengka'),(3211,32,'Kab. Sumedang'),(3212,32,'Kab. Indramayu'),(3213,32,'Kab. Subang'),(3214,32,'Kab. Purwakarta'),(3215,32,'Kab. Karawang'),(3216,32,'Kab. Bekasi'),(3217,32,'Kab. Bandung Barat'),(3271,32,'Kota Bogor'),(3272,32,'Kota Sukabumi'),(3273,32,'Kota Bandung'),(3274,32,'Kota Cirebon'),(3275,32,'Kota Bekasi'),(3276,32,'Kota Depok'),(3277,32,'Kota Cimahi'),(3278,32,'Kota Tasikmalaya'),(3279,32,'Kota Banjar'),(3301,33,'Kab. Cilacap'),(3302,33,'Kab. Banyumas'),(3303,33,'Kab. Purbalingga'),(3304,33,'Kab. Banjarnegara'),(3305,33,'Kab. Kebumen'),(3306,33,'Kab. Purworejo'),(3307,33,'Kab. Wonosobo'),(3308,33,'Kab. Magelang'),(3309,33,'Kab. Boyolali'),(3310,33,'Kab. Klaten'),(3311,33,'Kab. Sukoharjo'),(3312,33,'Kab. Wonogiri'),(3313,33,'Kab. Karanganyar'),(3314,33,'Kab. Sragen'),(3315,33,'Kab. Grobogan'),(3316,33,'Kab. Blora'),(3317,33,'Kab. Rembang'),(3318,33,'Kab. Pati'),(3319,33,'Kab. Kudus'),(3320,33,'Kab. Jepara'),(3321,33,'Kab. Demak'),(3322,33,'Kab. Semarang'),(3323,33,'Kab. Temanggung'),(3324,33,'Kab. Kendal'),(3325,33,'Kab. Batang'),(3326,33,'Kab. Pekalongan'),(3327,33,'Kab. Pemalang'),(3328,33,'Kab. Tegal'),(3329,33,'Kab. Brebes'),(3371,33,'Kota Magelang'),(3372,33,'Kota Surakarta'),(3373,33,'Kota Salatiga'),(3374,33,'Kota Semarang'),(3375,33,'Kota Pekalongan'),(3376,33,'Kota Tegal'),(3401,34,'Kab. Kulon Progo'),(3402,34,'Kab. Bantul'),(3403,34,'Kab. Gunung Kidul'),(3404,34,'Kab. Sleman'),(3471,34,'Kota Yogyakarta'),(3501,35,'Kab. Pacitan'),(3502,35,'Kab. Ponorogo'),(3503,35,'Kab. Trenggalek'),(3504,35,'Kab. Tulungagung'),(3505,35,'Kab. Blitar'),(3506,35,'Kab. Kediri'),(3507,35,'Kab. Malang'),(3508,35,'Kab. Lumajang'),(3509,35,'Kab. Jember'),(3510,35,'Kab. Banyuwangi'),(3511,35,'Kab. Bondowoso'),(3512,35,'Kab. Situbondo'),(3513,35,'Kab. Probolinggo'),(3514,35,'Kab. Pasuruan'),(3515,35,'Kab. Sidoarjo'),(3516,35,'Kab. Mojokerto'),(3517,35,'Kab. Jombang'),(3518,35,'Kab. Nganjuk'),(3519,35,'Kab. Madiun'),(3520,35,'Kab. Magetan'),(3521,35,'Kab. Ngawi'),(3522,35,'Kab. Bojonegoro'),(3523,35,'Kab. Tuban'),(3524,35,'Kab. Lamongan'),(3525,35,'Kab. Gresik'),(3526,35,'Kab. Bangkalan'),(3527,35,'Kab. Sampang'),(3528,35,'Kab. Pamekasan'),(3529,35,'Kab. Sumenep'),(3571,35,'Kota Kediri'),(3572,35,'Kota Blitar'),(3573,35,'Kota Malang'),(3574,35,'Kota Probolinggo'),(3575,35,'Kota Pasuruan'),(3576,35,'Kota Mojokerto'),(3577,35,'Kota Madiun'),(3578,35,'Kota Surabaya'),(3579,35,'Kota Batu'),(3601,36,'Kab. Pandeglang'),(3602,36,'Kab. Lebak'),(3603,36,'Kab. Tangerang'),(3604,36,'Kab. Serang'),(3671,36,'Kota Tangerang'),(3672,36,'Kota Cilegon'),(3673,36,'Kota Serang'),(3674,36,'Kota Tangerang Selatan'),(5101,51,'Kab. Jembrana'),(5102,51,'Kab. Tabanan'),(5103,51,'Kab. Badung'),(5104,51,'Kab. Gianyar'),(5105,51,'Kab. Klungkung'),(5106,51,'Kab. Bangli'),(5107,51,'Kab. Karangasem'),(5108,51,'Kab. Buleleng'),(5171,51,'Kota Denpasar'),(5201,52,'Kab. Lombok Barat'),(5202,52,'Kab. Lombok Tengah'),(5203,52,'Kab. Lombok Timur'),(5204,52,'Kab. Sumbawa'),(5205,52,'Kab. Dompu'),(5206,52,'Kab. Bima'),(5207,52,'Kab. Sumbawa Barat'),(5208,52,'Kab. Lombok Utara'),(5271,52,'Kota Mataram'),(5272,52,'Kota Bima'),(5301,53,'Kab. Kupang'),(5302,53,'Kab Timor Tengah Selatan'),(5303,53,'Kab. Timor Tengah Utara'),(5304,53,'Kab. Belu'),(5305,53,'Kab. Alor'),(5306,53,'Kab. Flores Timur'),(5307,53,'Kab. Sikka'),(5308,53,'Kab. Ende'),(5309,53,'Kab. Ngada'),(5310,53,'Kab. Manggarai'),(5311,53,'Kab. Sumba Timur'),(5312,53,'Kab. Sumba Barat'),(5313,53,'Manggarai'),(5314,53,'Kab. Rote Ndao'),(5315,53,'Kab. Manggarai Barat'),(5316,53,'Kab. Nagekeo'),(5317,53,'Kab. Sumba Tengah'),(5318,53,'Kab. Sumba Barat Daya'),(5319,53,'Kab. Manggarai Timur'),(5320,53,'Kab. Sabu Raijua'),(5371,53,'Kota Kupang'),(6101,61,'Kab. Sambas'),(6102,61,'Kab. Pontianak'),(6103,61,'Kab. Sanggau'),(6104,61,'Kab. Ketapang'),(6105,61,'Kab. Sintang'),(6106,61,'Kab. Kapuas Hulu'),(6107,61,'Kab. Bengkayang'),(6108,61,'Kab. Landak'),(6109,61,'Kab. Sekadau'),(6110,61,'Kab. Melawi'),(6111,61,'Kab. Kayong Utara'),(6112,61,'Kab. Kubu Raya'),(6171,61,'Kota Pontianak'),(6172,61,'Kota Singkawang'),(6201,62,'Kab. Kotawaringin Barat'),(6202,62,'Kab. Kotawaringin Timur'),(6203,62,'Kab. Kapuas'),(6204,62,'Kab. Barito Selatan'),(6205,62,'Kab. Barito Utara'),(6206,62,'Kab. Katingan'),(6207,62,'Kab. Seruyan'),(6208,62,'Kab. Sukamara'),(6209,62,'Kab. Lamandau'),(6210,62,'Kab. Gunung Mas'),(6211,62,'Kab. Pulang Pisau'),(6212,62,'Kab. Murung Raya'),(6213,62,'Kab. Barito Timur'),(6271,62,'Kota Palangkaraya'),(6301,63,'Kab. Tanah Laut'),(6302,63,'Kab. Kotabaru'),(6303,63,'Kab. Banjar'),(6304,63,'Kab. Barito Kuala'),(6305,63,'Kab. Tapin'),(6306,63,'Kab. Hulu Sungai Selatan'),(6307,63,'Kab. Hulu Sungai Tengah'),(6308,63,'Kab. Hulu Sungai Utara'),(6309,63,'Kab. Tabalong'),(6310,63,'Kab. Tanah Bumbu'),(6311,63,'Kab. Balangan'),(6371,63,'Kota Banjarmasin'),(6372,63,'Kota Banjarbaru'),(6401,64,'Kab. Paser'),(6402,64,'Kab. Kutai Kartanegara'),(6403,64,'Kab. Berau'),(6404,64,'Kab. Bulungan'),(6405,64,'Kab. Nunukan'),(6406,64,'Kab. Malinau'),(6407,64,'Kab. Kutai Barat'),(6408,64,'Kab. Kutai Timur'),(6409,64,'Kab Penajam Paser Utara'),(6410,64,'Kab Tana Tidung'),(6471,64,'Kota Balikpapan'),(6472,64,'Kota Samarinda'),(6473,64,'Kota Tarakan'),(6474,64,'Kota Bontang'),(7101,71,'Kab. Bolaang Mongondow'),(7102,71,'Kab. Minahasa'),(7103,71,'Kab. Kepulauan Sangihe'),(7104,71,'Kab. Kepulauan Talaud'),(7105,71,'Kab. Minahasa Selatan'),(7106,71,'Kab. Minahasa Utara'),(7107,71,'Kab. Minahasa Tenggara'),(7108,71,'Kab. Bolaang Mongondow Ut'),(7109,71,'Kab. Kep. Siau Tagulandang B'),(7110,71,'Kab. Bolaang Mongondow Ti'),(7111,71,'Kab. Bolaang Mongondow Se'),(7171,71,'Kota Manado'),(7172,71,'Kota Bitung'),(7173,71,'Kota Tomohon'),(7174,71,'Kota Kotamobagu'),(7201,72,'Kab. Banggai'),(7202,72,'Kab. Poso'),(7204,72,'Kab. Toli Toli'),(7205,72,'Kab. Buol'),(7206,72,'Kab. Morowali'),(7207,72,'Kab. Banggai Kepulauan'),(7208,72,'Kab. Parigi Moutong'),(7209,72,'Kab. Tojo Una Una'),(7210,72,'Kab. Sigi'),(7271,72,'Kota Palu'),(7301,73,'Kab. Kepulauan Selayar'),(7302,73,'Kab. Bulukumba'),(7303,73,'Kab. Bantaeng'),(7304,73,'Kab. Jeneponto'),(7305,73,'Kab. Takalar'),(7306,73,'Kab. Gowa'),(7307,73,'Kab. Sinjai'),(7308,73,'Kab. Bone'),(7309,73,'Kab. Maros'),(7310,73,'Kab. Pangkajene Kepulauan'),(7311,73,'Kab. Barru'),(7312,73,'Kab. Soppeng'),(7313,73,'Kab. Wajo'),(7314,73,'Kab. Sidenreng Rappang'),(7315,73,'Kab. Pinrang'),(7316,73,'Kab. Enrekang'),(7317,73,'Kab. Luwu'),(7318,73,'Kab. Tana Toraja'),(7322,73,'Kab. Luwu Utara'),(7324,73,'Kab. Luwu Timur'),(7326,73,'Kab. Toraja Utara'),(7371,73,'Kota Makassar'),(7372,73,'Kota Pare Pare'),(7373,73,'Kota Palopo'),(7401,74,'Kab. Kolaka'),(7402,74,'Kab. Konawe'),(7403,74,'Kab. Muna'),(7404,74,'Kab. Buton'),(7405,74,'Kab. Konawe Selatan'),(7406,74,'Kab. Bombana'),(7407,74,'Kab. Wakatobi'),(7408,74,'Kab. Kolaka Utara'),(7409,74,'Kab. Konawe Utara'),(7410,74,'Kab. Buton Utara'),(7471,74,'Kota Kendari'),(7472,74,'Kota Bau Bau'),(7501,75,'Kab. Gorontalo'),(7502,75,'Kab. Boalemo'),(7503,75,'Kab. Bone Bolango'),(7504,75,'Kab. Pahuwato'),(7505,75,'Kab. Gorontalo Utara'),(7571,75,'Kota Gorontalo'),(7601,76,'Kab. Mamuju Utara'),(7602,76,'Kab. Mamuju'),(7603,76,'Kab. Mamasa'),(7604,76,'Kab. Polewali Mandar'),(7605,76,'Kab. Majene'),(8101,81,'Kab. Maluku Tengah'),(8102,81,'Kab. Maluku Tenggara'),(8103,81,'Kab Maluku Tenggara Barat'),(8104,81,'Kab. Buru'),(8105,81,'Kab. Seram Bagian Timur'),(8106,81,'Kab. Seram Bagian Barat'),(8107,81,'Kab. Kepulauan Aru'),(8108,81,'Kab. Maluku Barat Daya'),(8109,81,'Kab. Buru Selatan'),(8171,81,'Kota Ambon'),(8172,81,'Kota Tual'),(8201,82,'Kab. Halmahera Barat'),(8202,82,'Kab. Halmahera Tengah'),(8203,82,'Kab. Halmahera Utara'),(8204,82,'Kab. Halmahera Selatan'),(8205,82,'Kab. Kepulauan Sula'),(8206,82,'Kab. Halmahera Timur'),(8207,82,'Kab. Pulau Morotai'),(8271,82,'Kota Ternate'),(8272,82,'Kota Tidore Kepulauan'),(9101,91,'Kab. Merauke'),(9102,91,'Kab. Jayawijaya'),(9103,91,'Kab. Jayapura'),(9104,91,'Kab. Nabire'),(9105,91,'Kab. Kepulauan Yapen'),(9106,91,'Kab. Biak Numfor'),(9107,91,'Kab. Puncak Jaya'),(9108,91,'Kab. Paniai'),(9109,91,'Kab. Mimika'),(9110,91,'Kab. Sarmi'),(9111,91,'Kab. Keerom'),(9112,91,'Kab Pegunungan Bintang'),(9113,91,'Kab. Yahukimo'),(9114,91,'Kab. Tolikara'),(9115,91,'Kab. Waropen'),(9116,91,'Kab. Boven Digoel'),(9117,91,'Kab. Mappi'),(9118,91,'Kab. Asmat'),(9119,91,'Kab. Supiori'),(9120,91,'Kab. Mamberamo Raya'),(9121,91,'Kab. Mamberamo Tengah'),(9122,91,'Kab. Yalimo'),(9123,91,'Kab. Lanny Jaya'),(9124,91,'Kab. Nduga'),(9125,91,'Kab. Puncak'),(9126,91,'Kab. Dogiyai'),(9127,91,'Kab. Intan Jaya'),(9128,91,'Kab. Deiyai'),(9171,91,'Kota Jayapura'),(9201,92,'Kab. Sorong'),(9203,92,'Kab. Fak Fak'),(9204,92,'Kab. Sorong Selatan'),(9205,92,'Kab. Raja Ampat'),(9206,92,'Kab. Teluk Bintuni'),(9207,92,'Kab. Teluk Wondama'),(9208,92,'Kab. Kaimana'),(9209,92,'Kab. Tambrauw'),(9210,92,'Kab. Maybrat'),(9211,93,'Kab. Nunukan'),(9212,93,'Kab. Malinau'),(9213,93,'Kab. Bulungan'),(9214,93,'Kab. Tana Tidung'),(9215,93,'Kota Tarakan');

/*Table structure for table `kecamatan` */

DROP TABLE IF EXISTS `kecamatan`;

CREATE TABLE `kecamatan` (
  `id_kecamatan` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `kabupaten_id` int(4) unsigned DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_kecamatan`),
  KEY `kabupaten_id` (`kabupaten_id`),
  CONSTRAINT `kecamatan_ibfk_1` FOREIGN KEY (`kabupaten_id`) REFERENCES `kabupaten` (`id_kabupaten`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=921020 DEFAULT CHARSET=latin1;

/*Data for the table `kecamatan` */

insert  into `kecamatan`(`id_kecamatan`,`kabupaten_id`,`nama`) values (110101,1101,'Bakongan'),(110102,1101,'Kluet Utara'),(110103,1101,'Kluet Selatan'),(110104,1101,'Labuhan Haji'),(110105,1101,'Meukek'),(110106,1101,'Samadua'),(110107,1101,'Sawang'),(110108,1101,'Tapaktuan'),(110109,1101,'Trumon'),(110110,1101,'Pasi Raja'),(110111,1101,'Labuhan Haji Timur'),(110112,1101,'Labuhan Haji Barat'),(110113,1101,'Kluet Tengah'),(110114,1101,'Kluet Timur'),(110115,1101,'Bakongan Timur'),(110116,1101,'Trumon Timur'),(110117,1101,'Kota Bahagia'),(110118,1101,'Trumon Tengah'),(110201,1102,'Lawe Alas'),(110202,1102,'Lawe Sigala-Gala'),(110203,1102,'Bambel'),(110204,1102,'Babussalam'),(110205,1102,'Badar'),(110206,1102,'Babul Makmur'),(110207,1102,'Darul Hasanah'),(110208,1102,'Lawe Bulan'),(110209,1102,'Bukit Tusam'),(110210,1102,'Semadam'),(110211,1102,'Babul Rahmah'),(110212,1102,'Ketambe'),(110213,1102,'Deleng Pokhkisen'),(110214,1102,'Lawe Sumur'),(110215,1102,'Tanoh Alas'),(110216,1102,'Leuser'),(110301,1103,'Darul Aman'),(110302,1103,'Julok'),(110303,1103,'Idi Rayeuk'),(110304,1103,'Birem Bayeun'),(110305,1103,'Serbajadi'),(110306,1103,'Nurussalam'),(110307,1103,'Peureulak'),(110308,1103,'Rantau Selamat'),(110309,1103,'Simpang Ulim'),(110310,1103,'Rantau Peureulak'),(110311,1103,'Pante Bidari'),(110312,1103,'Madat'),(110313,1103,'Indra Makmu'),(110314,1103,'Idi Tunong'),(110315,1103,'Banda Alam'),(110316,1103,'Peudawa'),(110317,1103,'Peureulak Timur'),(110318,1103,'Peureulak Barat'),(110319,1103,'Sungai Raya'),(110320,1103,'Simpang Jernih'),(110321,1103,'Darul Ihsan'),(110322,1103,'Darul Falah'),(110323,1103,'Idi Timur'),(110324,1103,'Peunaron'),(110401,1104,'Linge'),(110402,1104,'Silih Nara'),(110403,1104,'Bebesen'),(110407,1104,'Pegasing'),(110408,1104,'Bintang'),(110410,1104,'Ketol'),(110411,1104,'Kebayakan'),(110412,1104,'Kute Panang'),(110413,1104,'Celala'),(110417,1104,'Laut Tawar'),(110418,1104,'Atu Lintang'),(110419,1104,'Jagong Jeget'),(110420,1104,'Bies'),(110421,1104,'Rusip Antara'),(110501,1105,'Johan Pahwalan'),(110502,1105,'Kaway XVI'),(110503,1105,'Sungai Mas'),(110504,1105,'Woyla'),(110505,1105,'Samatiga'),(110506,1105,'Bubon'),(110507,1105,'Arongan Lambalek'),(110508,1105,'Pante Ceureumen'),(110509,1105,'Meureubo'),(110510,1105,'Woyla Barat'),(110511,1105,'Woyla Timur'),(110512,1105,'Panton Reu'),(110601,1106,'Lhoong'),(110602,1106,'Lhoknga'),(110603,1106,'Indrapuri'),(110604,1106,'Seulimeum'),(110605,1106,'Montasik'),(110606,1106,'Sukamakmur'),(110607,1106,'Darul Imarah'),(110608,1106,'Peukan Bada'),(110609,1106,'Mesjid Raya'),(110610,1106,'Ingin Jaya'),(110611,1106,'Kuta Baro'),(110612,1106,'Darussalam'),(110613,1106,'Pulo Aceh'),(110614,1106,'Lembah Seulawah'),(110615,1106,'Kota Jantho'),(110616,1106,'Kota Cot Glie'),(110617,1106,'Kuta Malaka'),(110618,1106,'Simpang Tiga'),(110619,1106,'Darul Kamal'),(110620,1106,'Baitussalam'),(110621,1106,'Krueng Barona Jaya'),(110622,1106,'Leupung'),(110623,1106,'Blang Bintang'),(110703,1107,'Batee'),(110704,1107,'Delima'),(110705,1107,'Geumpang'),(110706,1107,'Geulumpang Tiga'),(110707,1107,'Indra Jaya'),(110708,1107,'Kembang Tanjong'),(110709,1107,'Kota Sigli'),(110711,1107,'Mila'),(110712,1107,'Muara Tiga'),(110713,1107,'Mutiara'),(110714,1107,'Padang Tiji'),(110715,1107,'Peukan Baro'),(110716,1107,'Pidie'),(110717,1107,'Sakti'),(110718,1107,'Simpang Tiga'),(110719,1107,'Tangse'),(110721,1107,'Tiro/Truseb'),(110722,1107,'Keumala'),(110724,1107,'Mutiara Timur'),(110725,1107,'Grong-grong'),(110727,1107,'Mane'),(110729,1107,'Glumpang Baro'),(110731,1107,'Titeue'),(110801,1108,'Baktiya'),(110802,1108,'Dewantara'),(110803,1108,'Kuta Makmur'),(110804,1108,'Lhoksukon'),(110805,1108,'Matangkuli'),(110806,1108,'Muara Batu'),(110807,1108,'Meurah Mulia'),(110808,1108,'Samudera'),(110809,1108,'Seunuddon'),(110810,1108,'Syamtalira Aron'),(110811,1108,'Syamtalira Bayu'),(110812,1108,'Tanah Luas'),(110813,1108,'Tanah Pasir'),(110814,1108,'T. Jambo Aye'),(110815,1108,'Sawang'),(110816,1108,'Nisam'),(110817,1108,'Cot Girek'),(110818,1108,'Langkahan'),(110819,1108,'Baktiya Barat'),(110820,1108,'Paya Bakong'),(110821,1108,'Nibong'),(110822,1108,'Simpang Kramat'),(110823,1108,'Lapang'),(110824,1108,'Pirak Timur'),(110825,1108,'Geuredong Pase'),(110826,1108,'Banda Baro'),(110827,1108,'Nisam Antara'),(110901,1109,'Simeulue Tengah'),(110902,1109,'Salang'),(110903,1109,'Teupah Barat'),(110904,1109,'Simeulue Timur'),(110905,1109,'Teluk Dalam'),(110906,1109,'Simeulue Barat'),(110907,1109,'Teupah Selatan'),(110908,1109,'Alapan'),(110909,1109,'Teupah Tengah'),(110910,1109,'Simeulue Cut'),(111001,1110,'Pulau Banyak'),(111002,1110,'Simpang Kanan'),(111004,1110,'Singkil'),(111006,1110,'Gunung Meriah'),(111009,1110,'Kota Baharu'),(111010,1110,'Singkil Utara'),(111011,1110,'Danau Paris'),(111012,1110,'Suro Makmur'),(111013,1110,'Singkohor'),(111014,1110,'Kuala Baru'),(111016,1110,'Pulau Banyak Barat'),(111101,1111,'Samalanga'),(111102,1111,'Jeunieb'),(111103,1111,'Peudada'),(111104,1111,'Jeumpa'),(111105,1111,'Peusangan'),(111106,1111,'Makmur'),(111107,1111,'Gandapura'),(111108,1111,'Pandrah'),(111109,1111,'Juli'),(111110,1111,'Jangka'),(111111,1111,'Simpang Mamplam'),(111112,1111,'Peulimbang'),(111113,1111,'Kota Juang'),(111114,1111,'Kuala'),(111115,1111,'Peusangan Siblah Krueng'),(111116,1111,'Peusangan Selatan'),(111117,1111,'Kuta Blang'),(111201,1112,'Blang Pidie'),(111202,1112,'Tangan-Tangan'),(111203,1112,'Manggeng'),(111204,1112,'Susoh'),(111205,1112,'Kuala Batee'),(111206,1112,'Babah Rot'),(111207,1112,'Setia'),(111208,1112,'Jeumpa'),(111209,1112,'Lembah Sabil'),(111301,1113,'Blangkejeren'),(111302,1113,'Kutapanjang'),(111303,1113,'Rikit Gaib'),(111304,1113,'Terangun'),(111305,1113,'Pining'),(111306,1113,'Blangpegayon'),(111307,1113,'Puteri Betung'),(111308,1113,'Dabun Gelang'),(111309,1113,'Blangjerango'),(111310,1113,'Teripe Jaya'),(111311,1113,'Pantan Cuaca'),(111401,1114,'Teunom'),(111402,1114,'Krueng Sabee'),(111403,1114,'Setia Bhakti'),(111404,1114,'Sampoiniet'),(111405,1114,'Jaya'),(111406,1114,'Keude Panga'),(111407,1114,'Indra Jaya'),(111408,1114,'Darul Hikmah'),(111409,1114,'Pasie Raya'),(111501,1115,'Kuala'),(111502,1115,'Seunagan'),(111503,1115,'Seunagan Timur'),(111504,1115,'Beutong'),(111505,1115,'Darul Makmur'),(111506,1115,'Suka Makmue'),(111507,1115,'Kuala Pesisir'),(111508,1115,'Tadu Raya'),(111509,1115,'Tripa Makmur'),(111510,1115,'Beutong Ateuh Banggalang'),(111601,1116,'Manyak Payed'),(111602,1116,'Bendahara'),(111603,1116,'Karang Baru'),(111604,1116,'Seruway'),(111605,1116,'Kota Kualasinpang'),(111606,1116,'Kejuruan Muda'),(111607,1116,'Tamiang Hulu'),(111608,1116,'Rantau'),(111609,1116,'Banda Mulia'),(111610,1116,'Bandar Pusaka'),(111611,1116,'Tenggulun'),(111612,1116,'Sekerak'),(111701,1117,'Pintu Rime Gayo'),(111702,1117,'Permata'),(111703,1117,'Syiah Utama'),(111704,1117,'Bandar'),(111705,1117,'Bukit'),(111706,1117,'Wih Pesam'),(111707,1117,'Timang gajah'),(111708,1117,'Bener Kelipah'),(111709,1117,'Mesidah'),(111710,1117,'Gajah Putih'),(111801,1118,'Meureudu'),(111802,1118,'Ulim'),(111803,1118,'Jangka Buaya'),(111804,1118,'Bandar Dua'),(111805,1118,'Meurah Dua'),(111806,1118,'Bandar Baru'),(111807,1118,'Panteraja'),(111808,1118,'Trienggadeng'),(117101,1171,'Baiturrahman'),(117102,1171,'Kuta Alam'),(117103,1171,'Meuraxa'),(117104,1171,'Syiah Kuala'),(117105,1171,'Lueng Bata'),(117106,1171,'Kuta Raja'),(117107,1171,'Banda Raya'),(117108,1171,'Jaya Baru'),(117109,1171,'Ulee Kareng'),(117201,1172,'Sukakarya'),(117202,1172,'Sukajaya'),(117301,1173,'Muara Dua'),(117302,1173,'Banda Sakti'),(117303,1173,'Blang Mangat'),(117304,1173,'Muara Satu'),(117401,1174,'Langsa Timur'),(117402,1174,'Langsa Barat'),(117403,1174,'Langsa Kota'),(117404,1174,'Langsa Lama'),(117405,1174,'Langsa Baro'),(117501,1175,'Simpang Kiri'),(117502,1175,'Penanggalan'),(117503,1175,'Rundeng'),(117504,1175,'Sultan Daulat'),(117505,1175,'Longkib'),(120101,1201,'Barus'),(120102,1201,'Sorkam'),(120103,1201,'Pandan'),(120104,1201,'Pinangsori'),(120105,1201,'Manduamas'),(120106,1201,'Kolang'),(120107,1201,'Tapian Nauli'),(120108,1201,'Sibabangun'),(120109,1201,'Sosor Gadong'),(120110,1201,'Sorkam Barat'),(120111,1201,'Sirandorung'),(120112,1201,'Andam Dewi'),(120113,1201,'Sitahuis'),(120114,1201,'Tukka'),(120115,1201,'Badiri'),(120116,1201,'Pasaribu Tobing'),(120117,1201,'Barus Utara'),(120118,1201,'Suka Bangun'),(120119,1201,'Lumut'),(120120,1201,'Sarudik'),(120201,1202,'Tarutung'),(120202,1202,'Siatas Barita'),(120203,1202,'Adian Koting'),(120204,1202,'Sipoholon'),(120205,1202,'Pahae Julu'),(120206,1202,'Pahae Jae'),(120207,1202,'Simangumban'),(120208,1202,'Purba Tua'),(120209,1202,'Siborong-Borong'),(120210,1202,'Pagaran'),(120211,1202,'Parmonangan'),(120212,1202,'Sipahutar'),(120213,1202,'Pangaribuan'),(120214,1202,'Garoga'),(120215,1202,'Muara'),(120301,1203,'Angkola Barat'),(120302,1203,'Batang Toru'),(120303,1203,'Angkola Timur'),(120304,1203,'Sipirok'),(120305,1203,'Saipar Dolok Hole'),(120306,1203,'Angkola Selatan'),(120307,1203,'Batang Angkola'),(120314,1203,'Arse'),(120320,1203,'Marancar'),(120321,1203,'Sayur Matinggi'),(120322,1203,'Aek Bilah'),(120329,1203,'Muara Batang Toru'),(120330,1203,'Tano Tombangan Angkola'),(120331,1203,'Angkola Sangkunur'),(120405,1204,'Hiliduho'),(120406,1204,'Gido'),(120410,1204,'Idano Gawo'),(120411,1204,'Bawolato'),(120420,1204,'Hiliserangkai'),(120421,1204,'Botomuzoi'),(120427,1204,'Ulugawo'),(120428,1204,'Ma\'u'),(120429,1204,'Somolo-Molo'),(120435,1204,'Sogae\'adu'),(120501,1205,'Bahorok'),(120502,1205,'Salapian'),(120503,1205,'Kuala'),(120504,1205,'Sei Bingei'),(120505,1205,'Binjai'),(120506,1205,'Selesai'),(120507,1205,'Stabat'),(120508,1205,'Wampu'),(120509,1205,'Secanggang'),(120510,1205,'Hinai'),(120511,1205,'Tanjung Pura'),(120512,1205,'Padang Tualang'),(120513,1205,'Gebang'),(120514,1205,'Babalan'),(120515,1205,'Pangkalan Susu'),(120516,1205,'Besitang'),(120517,1205,'Sei Lepan'),(120518,1205,'Brandan Barat'),(120519,1205,'Batang Serangan'),(120520,1205,'Sawit Seberang'),(120521,1205,'Sirapit'),(120522,1205,'Kutambaru'),(120523,1205,'Pematang Jaya'),(120601,1206,'Kabanjahe'),(120602,1206,'Berastagi'),(120603,1206,'Barusjahe'),(120604,1206,'Tigapanah'),(120605,1206,'Merek'),(120606,1206,'Munte'),(120607,1206,'Juhar'),(120608,1206,'Tigabinanga'),(120609,1206,'Laubaleng'),(120610,1206,'Mardingding'),(120611,1206,'Payung'),(120612,1206,'Simpang Empat'),(120613,1206,'Kutabuluh'),(120614,1206,'Dolat Rayat'),(120615,1206,'Merdeka'),(120616,1206,'Naman Teran'),(120617,1206,'Tiganderket'),(120701,1207,'Gunung Meriah'),(120702,1207,'Tanjung Morawa'),(120703,1207,'Sibolangit'),(120704,1207,'Kutalimbaru'),(120705,1207,'Pancur Batu'),(120706,1207,'Namorambe'),(120707,1207,'Sibiru-biru'),(120708,1207,'STM Hilir'),(120709,1207,'Bangun Purba'),(120719,1207,'Galang'),(120720,1207,'STM Hulu'),(120721,1207,'Patumbak'),(120722,1207,'Deli Tua'),(120723,1207,'Sunggal'),(120724,1207,'Hamparan Perak'),(120725,1207,'Labuhan Deli'),(120726,1207,'Percut Sei Tuan'),(120727,1207,'Batang Kuis'),(120728,1207,'Lubuk Pakam'),(120731,1207,'Pagar Merbau'),(120732,1207,'Pantai Labu'),(120733,1207,'Beringin'),(120801,1208,'Siantar'),(120802,1208,'Gunung Malela'),(120803,1208,'Gunung Maligas'),(120804,1208,'Panei'),(120805,1208,'Panombeian Pane'),(120806,1208,'Jorlang Hataran'),(120807,1208,'Raya Kahean'),(120808,1208,'Bosar Maligas'),(120809,1208,'Sidamanik'),(120810,1208,'Pematang Sidamanik'),(120811,1208,'Tanah Jawa'),(120812,1208,'Hatonduhan'),(120813,1208,'Dolok Panribuan'),(120814,1208,'Purba'),(120815,1208,'Haranggaol Horison'),(120816,1208,'Girsang Sipangan Bolon'),(120817,1208,'Dolok Batu Nanggar'),(120818,1208,'Huta Bayu Raja'),(120819,1208,'Jawa Maraja Bah Jambi'),(120820,1208,'Dolok Pardamean'),(120821,1208,'Pematang Bandar'),(120822,1208,'Bandar Huluan'),(120823,1208,'Bandar'),(120824,1208,'Bandar Masilam'),(120825,1208,'Silimakuta'),(120826,1208,'Dolok Silau'),(120827,1208,'Silou Kahean'),(120828,1208,'Tapian Dolok'),(120829,1208,'Raya'),(120830,1208,'Ujung Padang'),(120831,1208,'Pamatang Silima Huta'),(120908,1209,'Meranti'),(120909,1209,'Air Joman'),(120910,1209,'Tanjung Balai'),(120911,1209,'Sei Kepayang'),(120912,1209,'Simpang Empat'),(120913,1209,'Air Batu'),(120914,1209,'Pulau Rakyat'),(120915,1209,'Bandar Pulau'),(120916,1209,'Buntu Pane'),(120917,1209,'Bandar Pasir Mandoge'),(120918,1209,'Aek Kuasan'),(120919,1209,'Kota Kisaran Barat'),(120920,1209,'Kota Kisaran Timur'),(120921,1209,'Aek Songsongan'),(120922,1209,'Rahunig'),(120923,1209,'Sei Dadap'),(120924,1209,'Sei Kepayang Barat'),(120925,1209,'Sei Kepayang Timur'),(120926,1209,'Tinggi Raja'),(120927,1209,'Setia Janji'),(120928,1209,'Silau Laut'),(120929,1209,'Rawang Panca Arga'),(120930,1209,'Pulo Bandring'),(120931,1209,'Teluk Dalam'),(120932,1209,'Aek Ledong'),(121001,1210,'Rantau Utara'),(121002,1210,'Rantau Selatan'),(121007,1210,'Bilah Barat'),(121008,1210,'Bilah Hilir'),(121009,1210,'Bilah Hulu'),(121014,1210,'Pangkatan'),(121018,1210,'Panai Tengah'),(121019,1210,'Panai Hilir'),(121020,1210,'Panai Hulu'),(121101,1211,'Sidikalang'),(121102,1211,'Sumbul'),(121103,1211,'Tigalingga'),(121104,1211,'Siempat Nempu'),(121105,1211,'Silima Pungga Punga'),(121106,1211,'Tanah Pinem'),(121107,1211,'Siempat Nempu Hulu'),(121108,1211,'Siempat Nempu Hilir'),(121109,1211,'Pegagan Hilir'),(121110,1211,'Parbuluan'),(121111,1211,'Lae Parira'),(121112,1211,'Gunung Sitember'),(121113,1211,'Brampu'),(121114,1211,'Silahisabungan'),(121115,1211,'Sitinjo'),(121201,1212,'Balige'),(121202,1212,'Laguboti'),(121203,1212,'Silaen'),(121204,1212,'Habinsaran'),(121205,1212,'Pintu Pohan Meranti'),(121206,1212,'Borbor'),(121207,1212,'Porsea'),(121208,1212,'Ajibata'),(121209,1212,'Lumban Julu'),(121210,1212,'Uluan'),(121219,1212,'Sigumpar'),(121220,1212,'Siantar Narumonda'),(121221,1212,'Nassau'),(121222,1212,'Tampahan'),(121223,1212,'Bonatua Lunasi'),(121224,1212,'Parmaksian'),(121301,1213,'Panyabungan Kota'),(121302,1213,'Panyabungan Utara'),(121303,1213,'Panyabungan Timur'),(121304,1213,'Panyabungan Selatan'),(121305,1213,'Panyabungan Barat'),(121306,1213,'Siabu'),(121307,1213,'Bukit Malintang'),(121308,1213,'Kotanopan'),(121309,1213,'Lembah Sorik Marapi'),(121310,1213,'Tambangan'),(121311,1213,'Ulu Pungkut'),(121312,1213,'Muara Sipongi'),(121313,1213,'Batang Natal'),(121314,1213,'Lingga Bayu'),(121315,1213,'Batahan'),(121316,1213,'Natal'),(121317,1213,'Muara Batang Gadis'),(121318,1213,'Ranto Baek'),(121319,1213,'Huta Bargot'),(121320,1213,'Puncak Sorik Marapi'),(121321,1213,'Pakantan'),(121322,1213,'Sinunukan'),(121323,1213,'Naga Juang'),(121401,1214,'Lolomatua'),(121402,1214,'Gomo'),(121403,1214,'Lahusa'),(121404,1214,'Hibala'),(121405,1214,'Pulau-Pulau Batu'),(121406,1214,'Teluk Dalam'),(121407,1214,'Amandraya'),(121408,1214,'Lalowa\'u'),(121409,1214,'Susua'),(121410,1214,'Maniamolo'),(121411,1214,'Hilimegai'),(121412,1214,'Toma'),(121413,1214,'Mazino'),(121414,1214,'Umbunasi'),(121415,1214,'Aramo'),(121416,1214,'Pulau-Pulau Batu Timur'),(121417,1214,'Mazo'),(121418,1214,'Fanayama'),(121419,1214,'Ulunoyo'),(121420,1214,'Huruna'),(121421,1214,'O\'o\'u'),(121422,1214,'Onohazumba'),(121423,1214,'Hilisalawa\'ahe'),(121424,1214,'Ulususua'),(121425,1214,'Sidua\'ori'),(121426,1214,'Somambawa'),(121427,1214,'Boronadu'),(121428,1214,'Simuk'),(121429,1214,'Pulau-Pulau Batu Barat'),(121430,1214,'Pulau-Pulau Batu Utara'),(121431,1214,'Tanah Masa'),(121501,1215,'Sitelu Tali Urang Jehe'),(121502,1215,'Kerajaan'),(121503,1215,'Salak'),(121504,1215,'Sitelu Tali Urang Julu'),(121505,1215,'Pergetteng Getteng Sengkut'),(121506,1215,'Pagindar'),(121507,1215,'Tinada'),(121508,1215,'Siempat Rube'),(121601,1216,'Parlilitan'),(121602,1216,'Pollung'),(121603,1216,'Baktiraja'),(121604,1216,'Paranginan'),(121605,1216,'Lintong Nihuta'),(121606,1216,'Dolok Sanggul'),(121607,1216,'Sijamapolang'),(121608,1216,'Onan Ganjang'),(121609,1216,'Pakkat'),(121610,1216,'Tarabintang'),(121701,1217,'Simanindo'),(121702,1217,'Onan Runggu'),(121703,1217,'Nainggolan'),(121704,1217,'Palipi'),(121705,1217,'Harian'),(121706,1217,'Sianjar Mula Mula'),(121707,1217,'Ronggur Nihuta'),(121708,1217,'Pangururan'),(121709,1217,'Sitio-tio'),(121801,1218,'Pantai Cermin'),(121802,1218,'Perbaungan'),(121803,1218,'Teluk Mengkudu'),(121804,1218,'Sei. Rampah'),(121805,1218,'Tanjung Beringin'),(121806,1218,'Bandar Khalifah'),(121807,1218,'Dolok Merawan'),(121808,1218,'Sipispis'),(121809,1218,'Dolok Masihul'),(121810,1218,'Kotarih'),(121811,1218,'Silinda'),(121812,1218,'Serba Jadi'),(121813,1218,'Tebing Tinggi'),(121814,1218,'Pegajahan'),(121815,1218,'Sei Bamban'),(121816,1218,'Tebing Syahbandar'),(121817,1218,'Bintang Bayu'),(121901,1219,'Medang Deras'),(121902,1219,'Sei Suka'),(121903,1219,'Air Putih'),(121904,1219,'Lima Puluh'),(121905,1219,'Talawi'),(121906,1219,'Tanjung Tiram'),(121907,1219,'Sei Balai'),(122001,1220,'Dolok Sigompulon'),(122002,1220,'Dolok'),(122003,1220,'Halongonan'),(122004,1220,'Padang Bolak'),(122005,1220,'Padang Bolak Julu'),(122006,1220,'Portibi'),(122007,1220,'Batang Onang'),(122008,1220,'Simangambat'),(122009,1220,'Hulu Sihapas'),(122101,1221,'Sosopan'),(122102,1221,'Barumun Tengah'),(122103,1221,'Huristak'),(122104,1221,'Lubuk Barumun'),(122105,1221,'Huta Raja Tinggi'),(122106,1221,'Ulu Barumun'),(122107,1221,'Barumun'),(122108,1221,'Sosa'),(122109,1221,'Batang Lubu Sutam'),(122110,1221,'Barumun Selatan'),(122111,1221,'Aek Nabara Barumun'),(122112,1221,'Sihapas Barumun'),(122201,1222,'Kotapinang'),(122202,1222,'Kampung Rakyat'),(122203,1222,'Torgamba'),(122204,1222,'Sungai Kanan'),(122205,1222,'Silangkitang'),(122301,1223,'Kualuh Hulu'),(122302,1223,'Kualuh Leidong'),(122303,1223,'Kualuh Hilir'),(122304,1223,'Aek Kuo'),(122305,1223,'Marbau'),(122306,1223,'Na IX - X'),(122307,1223,'Aek Natas'),(122308,1223,'Kualuh Selatan'),(122401,1224,'Lotu'),(122402,1224,'Sawo'),(122403,1224,'Tuhemberua'),(122404,1224,'Sitolu Ori'),(122405,1224,'Namohalu Esiwa'),(122406,1224,'Alasa Talumuzoi'),(122407,1224,'Alasa'),(122408,1224,'Tugala Oyo'),(122409,1224,'Afulu'),(122410,1224,'Lahewa'),(122411,1224,'Lahewa Timur'),(122501,1225,'Lahomi'),(122502,1225,'Sirombu'),(122503,1225,'Mandrehe Barat'),(122504,1225,'Moro\'o'),(122505,1225,'Mandrehe'),(122506,1225,'Mandrehe Utara'),(122507,1225,'Lolofitu Moi'),(122508,1225,'Ulu Moro\'o'),(127101,1271,'Medan Kota'),(127102,1271,'Medan Sunggal'),(127103,1271,'Medan Helvetia'),(127104,1271,'Medan Denai'),(127105,1271,'Medan Barat'),(127106,1271,'Medan Deli'),(127107,1271,'Medan Tuntungan'),(127108,1271,'Medan Belawan'),(127109,1271,'Medan Amplas'),(127110,1271,'Medan Area'),(127111,1271,'Medan Johor'),(127112,1271,'Medan Marelan'),(127113,1271,'Medan Labuhan'),(127114,1271,'Medan Tembung'),(127115,1271,'Medan Maimun'),(127116,1271,'Medan Polonia'),(127117,1271,'Medan Baru'),(127118,1271,'Medan Perjuangan'),(127119,1271,'Medan Petisah'),(127120,1271,'Medan Timur'),(127121,1271,'Medan Selayang'),(127201,1272,'Siantar Timur'),(127202,1272,'Siantar Barat'),(127203,1272,'Siantar Utara'),(127204,1272,'Siantar Selatan'),(127205,1272,'Siantar Marihat'),(127206,1272,'Siantar Martoba'),(127207,1272,'Siantar Sitalasari'),(127208,1272,'Siantar Marimbun'),(127301,1273,'Sibolga Utara'),(127302,1273,'Sibolga Kota'),(127303,1273,'Sibolga Selatan'),(127304,1273,'Sibolga Sambas'),(127401,1274,'Tanjung Balai Selatan'),(127402,1274,'Tanjung Balai Utara'),(127403,1274,'Sei Tualang Raso'),(127404,1274,'Teluk Nibung'),(127405,1274,'Datuk Bandar'),(127406,1274,'Datuk Bandar Timur'),(127501,1275,'Binjai Utara'),(127502,1275,'Binjai Kota'),(127503,1275,'Binjai Barat'),(127504,1275,'Binjai Timur'),(127505,1275,'Binjai Selatan'),(127601,1276,'Padang Hulu'),(127602,1276,'Rambutan'),(127603,1276,'Padang Hilir'),(127604,1276,'Bajenis'),(127605,1276,'Tebing Tinggi Kota'),(127701,1277,'Padangsidimpuan Utara'),(127702,1277,'Padangsidimpuan Selatan'),(127703,1277,'Padangsidimpuan Batunadua'),(127704,1277,'Padangsidimpuan Hutaimbaru'),(127705,1277,'Padangsidimpuan Tenggara'),(127706,1277,'Padangsidimpuan Angkola Julu'),(127801,1278,'Gunungsitoli'),(127802,1278,'Gunungsitoli Selatan'),(127803,1278,'Gunungsitoli Utara'),(127804,1278,'Gunungsitoli Idanoi'),(127805,1278,'Gunungsitoli Alo\'oa'),(127806,1278,'Gunungsitoli Barat'),(130101,1301,'Pancung Soal'),(130102,1301,'Ranah Pesisir'),(130103,1301,'Lengayang'),(130104,1301,'Batang Kapas'),(130105,1301,'IV Jurai'),(130106,1301,'Bayang'),(130107,1301,'Koto XI Tarusan'),(130108,1301,'Sutera'),(130109,1301,'Linggo Sari Baganti'),(130110,1301,'Lunang'),(130111,1301,'Basa Ampek Balai Tapan'),(130112,1301,'IV Nagari Bayang Utara'),(130113,1301,'Airpura'),(130114,1301,'Ranah Ampek Hulu Tapan'),(130115,1301,'Silaut'),(130203,1302,'Pantai Cermin'),(130204,1302,'Lembah Gumanti'),(130205,1302,'Payung Sekaki'),(130206,1302,'Lembang Jaya'),(130207,1302,'Gunung Talang'),(130208,1302,'Bukit Sundi'),(130209,1302,'IX Koto Sei Lasi'),(130210,1302,'Kubung'),(130211,1302,'X Koto Singkarak'),(130212,1302,'X Koto Diatas'),(130213,1302,'Junjung Siri'),(130217,1302,'Hiliran Gumanti'),(130218,1302,'Tigo Lurah'),(130219,1302,'Danau Kembar'),(130303,1303,'Tanjung Gadang'),(130304,1303,'Sijunjung'),(130305,1303,'IV Nagari'),(130306,1303,'Kamang Baru'),(130307,1303,'Lubuak Tarok'),(130308,1303,'Koto VII'),(130309,1303,'Sumpur Kudus'),(130310,1303,'Kupitan'),(130401,1304,'X Koto'),(130402,1304,'Batipuh'),(130403,1304,'Rambatan'),(130404,1304,'Lima Kaum'),(130405,1304,'Tanjung Emas'),(130406,1304,'Lintau Buo'),(130407,1304,'Sungayang'),(130408,1304,'Sungai Tarab'),(130409,1304,'Pariangan'),(130410,1304,'Salimpauang'),(130411,1304,'Padang Ganting'),(130412,1304,'Tanjuang Baru'),(130413,1304,'Lintau Buo Utara'),(130414,1304,'Batipuah Selatan'),(130501,1305,'Lubuk Alung'),(130502,1305,'Batang Anai'),(130503,1305,'Nan Sabaris'),(130504,1305,'2 x 11 Enam Lingkuang'),(130505,1305,'VII Koto Sungai Sarik'),(130506,1305,'V Koto Kampung Dalam'),(130507,1305,'Sungai Garingging'),(130508,1305,'Sungai Limau'),(130509,1305,'IV Koto Aur Malintang'),(130510,1305,'Ulakan Tapakih'),(130511,1305,'Sintuak Toboh Gadang'),(130512,1305,'Padang Sago'),(130513,1305,'Batang Gasan'),(130514,1305,'V Koto Timur'),(130515,1305,'2 x 11 Kayu Tanam'),(130516,1305,'Patamuan'),(130517,1305,'Enam Lingkung'),(130601,1306,'Tanjung Mutiara'),(130602,1306,'Lubuk Basung'),(130603,1306,'Tanjung Raya'),(130604,1306,'Matur'),(130605,1306,'IV Koto'),(130606,1306,'Banuhampu'),(130607,1306,'IV Angkat Candung'),(130608,1306,'Baso'),(130609,1306,'Tilatang Kamang'),(130610,1306,'Palupuh'),(130611,1306,'Pelembayan'),(130612,1306,'Sungai Pua'),(130613,1306,'Ampek Nagari'),(130614,1306,'Candung'),(130615,1306,'Kamang Magek'),(130616,1306,'Malalak'),(130701,1307,'Suliki'),(130702,1307,'Guguak'),(130703,1307,'Payakumbuh'),(130704,1307,'Luak'),(130705,1307,'Harau'),(130706,1307,'Pangkalan Koto Baru'),(130707,1307,'Kapur IX'),(130708,1307,'Gunuang Omeh'),(130709,1307,'Lareh Sago Halaban'),(130710,1307,'Situjuah Limo Nagari'),(130711,1307,'Mungka'),(130712,1307,'Bukik Barisan'),(130713,1307,'Akabiluru'),(130804,1308,'Bonjol'),(130805,1308,'Lubuk Sikaping'),(130807,1308,'Panti'),(130808,1308,'Mapat Tunggul'),(130812,1308,'Duo Koto'),(130813,1308,'Tigo Nagari'),(130814,1308,'Rao'),(130815,1308,'Mapat Tunggul Selatan'),(130816,1308,'Simpang Alahan Mati'),(130817,1308,'Padang Gelugur'),(130818,1308,'Rao Utara'),(130819,1308,'Rao Selatan'),(130901,1309,'Pagai Utara'),(130902,1309,'Sipora Selatan'),(130903,1309,'Siberut Selatan'),(130904,1309,'Siberut Utara'),(130905,1309,'Siberut Barat'),(130906,1309,'Siberut Barat Daya'),(130907,1309,'Siberut Tengah'),(130908,1309,'Sipora Utara'),(130909,1309,'Sikakap'),(130910,1309,'Pagai Selatan'),(131001,1310,'Koto Baru'),(131002,1310,'Pulau Punjung'),(131003,1310,'Sungai Rumbai'),(131004,1310,'Sitiung'),(131005,1310,'Sembilan Koto'),(131006,1310,'Timpeh'),(131007,1310,'Koto Salak'),(131008,1310,'Tiumang'),(131009,1310,'Padang Laweh'),(131010,1310,'Asam Jujuhan'),(131011,1310,'Koto Besar'),(131101,1311,'Sangir'),(131102,1311,'Sungai Pagu'),(131103,1311,'Koto Parik Gadang Diateh'),(131104,1311,'Sangir Jujuan'),(131105,1311,'Sangir Batang Hari'),(131106,1311,'Pauh Duo'),(131107,1311,'Sangir Balai Janggo'),(131201,1312,'Sungaiberemas'),(131202,1312,'Lembah Melintang'),(131203,1312,'Pasaman'),(131204,1312,'Talamau'),(131205,1312,'Kinali'),(131206,1312,'Gunungtuleh'),(131207,1312,'Ranah Batahan'),(131208,1312,'Koto Balingka'),(131209,1312,'Sungaiaur'),(131210,1312,'Luhak Nan Duo'),(131211,1312,'Sasak Ranah Pesisir'),(137101,1371,'Padang Selatan'),(137102,1371,'Padang Timur'),(137103,1371,'Padang Barat'),(137104,1371,'Padang Utara'),(137105,1371,'Bungus Teluk Kabung'),(137106,1371,'Lubuk Begalung'),(137107,1371,'Lubuk Kilangan'),(137108,1371,'Pauh'),(137109,1371,'Kuranji'),(137110,1371,'Nanggalo'),(137111,1371,'Koto Tangah'),(137201,1372,'Lubuk Sikarah'),(137202,1372,'Tanjung Harapan'),(137301,1373,'Lembah Segar'),(137302,1373,'Barangin'),(137303,1373,'Silungkang'),(137304,1373,'Talawi'),(137401,1374,'Padang Panjang Timur'),(137402,1374,'Padang Panjang Barat'),(137501,1375,'Guguak Panjang'),(137502,1375,'Mandiangin K. Selayan'),(137503,1375,'Aur Birugo Tigo Baleh'),(137601,1376,'Payakumbuh Barat'),(137602,1376,'Payakumbuh Utara'),(137603,1376,'Payakumbuh Timur'),(137604,1376,'Lamposi Tigo Nagori'),(137605,1376,'Payakumbuh Selatan'),(137701,1377,'Pariaman Tengah'),(137702,1377,'Pariaman Utara'),(137703,1377,'Pariaman Selatan'),(137704,1377,'Pariaman Timur'),(140101,1401,'Bangkinang'),(140102,1401,'Kampar'),(140103,1401,'Tambang'),(140104,1401,'XIII Koto Kampar'),(140105,1401,'Kuok'),(140106,1401,'Siak Hulu'),(140107,1401,'Kampar Kiri'),(140108,1401,'Kampar Kiri Hilir'),(140109,1401,'Kampar Kiri Hulu'),(140110,1401,'Tapung'),(140111,1401,'Tapung Hilir'),(140112,1401,'Tapung Hulu'),(140113,1401,'Salo'),(140114,1401,'Rumbio Jaya'),(140115,1401,'Bangkinang Seberang'),(140116,1401,'Perhentian Raja'),(140117,1401,'Kampar Timur'),(140118,1401,'Kampar Utara'),(140119,1401,'Kampar Kiri Tengah'),(140120,1401,'Gunung Sahilan'),(140121,1401,'Koto Kampar Hulu'),(140201,1402,'Rengat'),(140202,1402,'Rengat Barat'),(140203,1402,'Kelayang'),(140204,1402,'Pasir Penyu'),(140205,1402,'Peranap'),(140206,1402,'Siberida'),(140207,1402,'Batang Cenaku'),(140208,1402,'Batang Gangsal'),(140209,1402,'Lirik'),(140210,1402,'Kuala Cenaku'),(140211,1402,'Sungai Lala'),(140212,1402,'Lubuk Batu Jaya'),(140213,1402,'Rakit Kulim'),(140214,1402,'Batang Peranap'),(140301,1403,'Bengkalis'),(140302,1403,'Bantan'),(140303,1403,'Bukit Batu'),(140309,1403,'Mandau'),(140310,1403,'Rupat'),(140311,1403,'Rupat Utara'),(140312,1403,'Siak Kecil'),(140313,1403,'Pinggir'),(140401,1404,'Reteh'),(140402,1404,'Enok'),(140403,1404,'Kuala Indragiri'),(140404,1404,'Tembilahan'),(140405,1404,'Tempuling'),(140406,1404,'Gaung Anak Serka'),(140407,1404,'Mandah'),(140408,1404,'Kateman'),(140409,1404,'Keritang'),(140410,1404,'Tanah Merah'),(140411,1404,'Batang Tuaka'),(140412,1404,'Gaung'),(140413,1404,'Tembilahan Hulu'),(140414,1404,'Kemuning'),(140415,1404,'Pelangiran'),(140416,1404,'Teluk Belengkong'),(140417,1404,'Pulau Burung'),(140418,1404,'Concong'),(140419,1404,'Kempas'),(140420,1404,'Sungai Batang'),(140501,1405,'Ukui'),(140502,1405,'Pangkalan Kerinci'),(140503,1405,'Pangkalan Kuras'),(140504,1405,'Pangkalan Lesung'),(140505,1405,'Langgam'),(140506,1405,'Pelalawan'),(140507,1405,'Kerumutan'),(140508,1405,'Bunut'),(140509,1405,'Teluk Meranti'),(140510,1405,'Kuala Kampar'),(140511,1405,'Bandar Sei Kijang'),(140512,1405,'Bandar Petalangan'),(140601,1406,'Ujung Batu'),(140602,1406,'Rokan IV Koto'),(140603,1406,'Rambah'),(140604,1406,'Tambusai'),(140605,1406,'Kepenuhan'),(140606,1406,'Kunto Darussalam'),(140607,1406,'Rambah Samo'),(140608,1406,'Rambah Hilir'),(140609,1406,'Tambusai Utara'),(140610,1406,'Bangun Purba'),(140611,1406,'Tandun'),(140612,1406,'Kabun'),(140613,1406,'Bonai Darussalam'),(140614,1406,'Pagaran Tapah Darussalam'),(140615,1406,'Kepenuhan Hulu'),(140616,1406,'Pendalian IV Koto'),(140701,1407,'Kubu'),(140702,1407,'Bangko'),(140703,1407,'Tanah Putih'),(140704,1407,'Rimba Melintang'),(140705,1407,'Bagan Sinembah'),(140706,1407,'Pasir Limau Kapas'),(140707,1407,'Sinaboi'),(140708,1407,'Pujud'),(140709,1407,'Tanah Putih Tanjung Melawan'),(140710,1407,'Bangko Pusako'),(140711,1407,'Simpang Kanan'),(140712,1407,'Batu Hampar'),(140713,1407,'Rantau Kopar'),(140714,1407,'Pekaitan'),(140715,1407,'Kubu Babussalam'),(140801,1408,'Siak'),(140802,1408,'Sungai Apit'),(140803,1408,'Minas'),(140804,1408,'Tualang'),(140805,1408,'Sungai Mandau'),(140806,1408,'Dayun'),(140807,1408,'Kerinci Kanan'),(140808,1408,'Bunga Raya'),(140809,1408,'Koto Gasib'),(140810,1408,'Kandis'),(140811,1408,'Lubuk Dalam'),(140812,1408,'Sabak Auh'),(140813,1408,'Mempura'),(140814,1408,'Pusako'),(140901,1409,'Kuantan Mudik'),(140902,1409,'Kuantan Tengah'),(140903,1409,'Singingi'),(140904,1409,'Kuantan Hilir'),(140905,1409,'Cerenti'),(140906,1409,'Benai'),(140907,1409,'Gunungtoar'),(140908,1409,'Singingi Hilir'),(140909,1409,'Pangean'),(140910,1409,'Logas Tanah Darat'),(140911,1409,'Inuman'),(140912,1409,'Hulu Kuantan'),(140913,1409,'Kuantan Hilir Seberang'),(140914,1409,'Sentajo Raya'),(140915,1409,'Pucuk Rantau'),(141001,1410,'Tebing Tinggi'),(141002,1410,'Rangsang Barat'),(141003,1410,'Rangsang'),(141004,1410,'Tebing Tinggi Barat'),(141005,1410,'Merbau'),(141006,1410,'Pulaumerbau'),(141007,1410,'Tebing Tinggi Timur'),(141008,1410,'Tasik Putri Puyu'),(141009,1410,'Rangsang Pesisir'),(147101,1471,'Sukajadi'),(147102,1471,'Pekanbaru Kota'),(147103,1471,'Sail'),(147104,1471,'Lima Puluh'),(147105,1471,'Senapelan'),(147106,1471,'Rumbai'),(147107,1471,'Bukit Raya'),(147108,1471,'Tampan'),(147109,1471,'Marpoyan Damai'),(147110,1471,'Tenayan Raya'),(147111,1471,'Payung Sekaki'),(147112,1471,'Rumbai Pesisir'),(147201,1472,'Dumai Barat'),(147202,1472,'Dumai Timur'),(147203,1472,'Bukit Kapur'),(147204,1472,'Sungai Sembilan'),(147205,1472,'Medang Kampai'),(147206,1472,'Dumai Kota'),(147207,1472,'Dumai Selatan'),(150101,1501,'Gunung Raya'),(150102,1501,'Danau Kerinci'),(150104,1501,'Sitinjau Laut'),(150105,1501,'Air Hangat'),(150106,1501,'Gunung Kerinci'),(150107,1501,'Batang Merangin'),(150108,1501,'Keliling Danau'),(150109,1501,'Kayu Aro'),(150111,1501,'Air Hangat Timur'),(150115,1501,'Gunung Tujuh'),(150116,1501,'Siulak'),(150117,1501,'Depati Tujuh'),(150118,1501,'Siulak Mukai'),(150119,1501,'Kayu Aro Barat'),(150120,1501,'Bukitkerman'),(150121,1501,'Air Hangat Barat'),(150201,1502,'Jangkat'),(150202,1502,'Bangko'),(150203,1502,'Muara Siau'),(150204,1502,'Sungai Manau'),(150205,1502,'Tabir'),(150206,1502,'Pamenang'),(150207,1502,'Tabir Ulu'),(150208,1502,'Tabir Selatan'),(150209,1502,'Lembah Masurai'),(150210,1502,'Bangko  Barat'),(150211,1502,'Nalo Tatan'),(150212,1502,'Batang Masumai'),(150213,1502,'Pamenang Barat'),(150214,1502,'Tabir Ilir'),(150215,1502,'Tabir Timur'),(150216,1502,'Renah Pembarap'),(150217,1502,'Pangkalan Jambu'),(150218,1502,'Sungai Tenang'),(150219,1502,'Renah Pamenang'),(150220,1502,'Pamenang Selatan'),(150221,1502,'Margo Tabir'),(150222,1502,'Tabir Lintas'),(150223,1502,'Tabir Barat'),(150224,1502,'Tiang Pumpung'),(150301,1503,'Batang Asai'),(150302,1503,'Limun'),(150303,1503,'Sarolangun'),(150304,1503,'Pauh'),(150305,1503,'Pelawan'),(150306,1503,'Mandiangin'),(150307,1503,'Air Hitam'),(150308,1503,'Bathin VIII'),(150309,1503,'Singkut'),(150310,1503,'Cermin Nan Gedang'),(150401,1504,'Mersam'),(150402,1504,'Muara Tembesi'),(150403,1504,'Muara Bulian'),(150404,1504,'Batin XXIV'),(150405,1504,'Pemayung'),(150406,1504,'Maro Sebo Ulu'),(150407,1504,'Bajubang'),(150408,1504,'Maro Sebo Ilir'),(150501,1505,'Jambi Luar Kota'),(150502,1505,'Sekernan'),(150503,1505,'Kumpeh'),(150504,1505,'Maro Sebo'),(150505,1505,'Mestong'),(150506,1505,'Kumpeh Ulu'),(150507,1505,'Sungai Bahar'),(150508,1505,'Sungai Gelam'),(150509,1505,'Bahar Utara'),(150510,1505,'Bahar Selatan'),(150511,1505,'Taman Rajo'),(150601,1506,'Tungkal Ulu'),(150602,1506,'Tungkal Ilir'),(150603,1506,'Pengabuan'),(150604,1506,'Betara'),(150605,1506,'Merlung'),(150606,1506,'Tebing Tinggi'),(150607,1506,'Batang Asam'),(150608,1506,'Renah Mendaluh'),(150609,1506,'Muara Papalik'),(150610,1506,'Seberang Kota'),(150611,1506,'Bram Itam'),(150612,1506,'Kuala Betara'),(150613,1506,'Senyerang'),(150701,1507,'Muara Sabak Timur'),(150702,1507,'Nipah Panjang'),(150703,1507,'Mendahara'),(150704,1507,'Rantau Rasau'),(150705,1507,'S a d u'),(150706,1507,'Dendang'),(150707,1507,'Muara Sabak Barat'),(150708,1507,'Kuala Jambi'),(150709,1507,'Mendahara Ulu'),(150710,1507,'Geragai'),(150711,1507,'Berbak'),(150801,1508,'Tanah Tumbuh'),(150802,1508,'Rantau Pandan'),(150803,1508,'Pasar Muaro Bungo'),(150804,1508,'Jujuhan'),(150805,1508,'Tanah Sepenggal'),(150806,1508,'Pelepat'),(150807,1508,'Limbur Lubuk Mengkuang'),(150808,1508,'Muko-muko Bathin VII'),(150809,1508,'Pelepat Ilir'),(150810,1508,'Batin II Babeko'),(150811,1508,'Bathin III'),(150812,1508,'Bungo Dani'),(150813,1508,'Rimbo Tengah'),(150814,1508,'Bathin III Ulu'),(150815,1508,'Bathin II Pelayang'),(150816,1508,'Jujuhan Ilir'),(150817,1508,'Tanah Sepenggal Lintas'),(150901,1509,'Tebo Tengah'),(150902,1509,'Tebo Ilir'),(150903,1509,'Tebo Ulu'),(150904,1509,'Rimbo Bujang'),(150905,1509,'Sumay'),(150906,1509,'VII Koto'),(150907,1509,'Rimbo Ulu'),(150908,1509,'Rimbo Ilir'),(150909,1509,'Tengah Ilir'),(150910,1509,'Serai Serumpun'),(150911,1509,'VII Koto Ilir'),(150912,1509,'Muara Tabir'),(157101,1571,'Telanaipura'),(157102,1571,'Jambi Selatan'),(157103,1571,'Jambi Timur'),(157104,1571,'Pasar Jambi'),(157105,1571,'Pelayangan'),(157106,1571,'Danau Teluk'),(157107,1571,'Kota Baru'),(157108,1571,'Jelutung'),(157201,1572,'Sungaipenuh'),(157202,1572,'Pesisir Bukit'),(157203,1572,'Hamparan Rawang'),(157204,1572,'Tanah Kampung'),(157205,1572,'Kumun Debai'),(157206,1572,'Pondok Tinggi'),(157207,1572,'Koto Baru'),(157208,1572,'Sungaibungkal'),(160214,1601,'Air Sugihan'),(160215,1601,'Sungai Menang'),(160217,1601,'Jejawi'),(160218,1601,'Cengal'),(160219,1601,'Pangkalan Lampam'),(160220,1601,'Mesuji Makmur'),(160221,1601,'Mesuji Raya'),(160222,1601,'Lempuing Jaya'),(160223,1601,'Teluk Gelam'),(160224,1601,'Pedamaran Timur'),(160301,1603,'Tanjung Agung'),(160302,1603,'Muara Enim'),(160303,1603,'Rambang Dangku'),(160304,1603,'Gunung Megang'),(160305,1603,'Talang Ubi'),(160306,1603,'Gelumbang'),(160307,1603,'Lawang Kidul'),(160308,1603,'Semende Darat Laut'),(160309,1603,'Semende Darat Tengah'),(160310,1603,'Semende Darat Ulu'),(160311,1603,'Ujan Mas'),(160312,1603,'Tanah Abang'),(160313,1603,'Penukal'),(160314,1603,'Lubai'),(160315,1603,'Rambang'),(160316,1603,'Sungai Rotan'),(160317,1603,'Lembak'),(160318,1603,'Penukal Utara'),(160319,1603,'Benakat'),(160320,1603,'Abab'),(160321,1603,'Kelekar'),(160322,1603,'Muara Belida'),(160401,1604,'Tanjungsakti Pumu'),(160406,1604,'Jarai'),(160407,1604,'Kota Agung'),(160408,1604,'Pulaupinang'),(160409,1604,'Merapi Barat'),(160410,1604,'Lahat'),(160412,1604,'Pajar Bulan'),(160415,1604,'Mulak Ulu'),(160416,1604,'Kikim Selatan'),(160417,1604,'Kikim Timur'),(160418,1604,'Kikim Tengah'),(160419,1604,'Kikim Barat'),(160420,1604,'Pseksu'),(160421,1604,'Gumay Talang'),(160422,1604,'Pagar Gunung'),(160423,1604,'Merapi Timur'),(160424,1604,'Tanjung Sakti Pumi'),(160425,1604,'Gumay Ulu'),(160426,1604,'Merapi Selatan'),(160427,1604,'Tanjungtebat'),(160428,1604,'Muarapayang'),(160429,1604,'Sukamerindu'),(160501,1605,'Tugumulyo'),(160502,1605,'Muara Lakitan'),(160503,1605,'Muara Kelingi'),(160504,1605,'Rawas Ilir'),(160505,1605,'Rawas Ulu'),(160506,1605,'Ulu Rawas'),(160507,1605,'Rupit'),(160508,1605,'Jayaloka'),(160509,1605,'Muara Beliti'),(160510,1605,'STL Ulu Terawas'),(160511,1605,'Selangit'),(160512,1605,'Megang Sakti'),(160513,1605,'Purwodadi'),(160514,1605,'BTS. Ulu'),(160515,1605,'Karang Jaya'),(160516,1605,'Nibung'),(160517,1605,'Karang Dapo'),(160518,1605,'Tiang Pumpung Kepungut'),(160519,1605,'Sumber Harta'),(160520,1605,'Tuah Negeri'),(160521,1605,'Suka Karya'),(160601,1606,'Sekayu'),(160602,1606,'Lais'),(160603,1606,'Sungai Keruh'),(160604,1606,'Batang Hari Leko'),(160605,1606,'Sanga Desa'),(160606,1606,'Babat Toman'),(160607,1606,'Sungai Lilin'),(160608,1606,'Keluang'),(160609,1606,'Bayung Lencir'),(160610,1606,'Plakat Tinggi'),(160611,1606,'Lalan'),(160612,1606,'Tungkal Jaya'),(160613,1606,'Lawang Wetan'),(160614,1606,'Babat Supat'),(160701,1607,'Banyuasin I'),(160702,1607,'Banyuasin II'),(160703,1607,'Banyuasin III'),(160704,1607,'Pulau Rimau'),(160705,1607,'Betung'),(160706,1607,'Rambutan'),(160707,1607,'Muara Padang'),(160708,1607,'Muara Telang'),(160709,1607,'Makarti Jaya'),(160710,1607,'Talang Kelapa'),(160711,1607,'Rantau Bayur'),(160712,1607,'Tanjung Lago'),(160713,1607,'Muara Sugihan'),(160714,1607,'Air Salek'),(160715,1607,'Tungkal Ilir'),(160716,1607,'Suak Tapeh'),(160717,1607,'Sembawa'),(160718,1607,'Sumber Marga Telang'),(160719,1607,'Air Kumbang'),(160801,1608,'Martapura'),(160802,1608,'Buay Madang'),(160803,1608,'Belitang'),(160804,1608,'Cempaka'),(160805,1608,'Buay Pemuka Peliung'),(160806,1608,'Madang Suku II'),(160807,1608,'Madang Suku I'),(160808,1608,'Semendawai Suku III'),(160809,1608,'Belitang II'),(160810,1608,'Belitang III'),(160811,1608,'Bunga Mayang'),(160812,1608,'Buay Madang Timur'),(160813,1608,'Madang Suku III'),(160814,1608,'Semendawai Barat'),(160815,1608,'Semendawai Timur'),(160816,1608,'Jayapura'),(160817,1608,'Belitang Jaya'),(160818,1608,'Belitang Madang Raya'),(160819,1608,'Belitang Mulya'),(160820,1608,'Buay Pemuka Bangsa Raja'),(160901,1609,'Muara Dua'),(160902,1609,'Pulau Beringin'),(160903,1609,'Banding Agung'),(160904,1609,'Muara Dua Kisam'),(160905,1609,'Simpang'),(160906,1609,'Buay Sandang Aji'),(160907,1609,'Buay Runjung'),(160908,1609,'Mekakau Ilir'),(160909,1609,'Buay Pemaca'),(160910,1609,'Kisam Tinggi'),(160911,1609,'Kisam Ilir'),(160912,1609,'Buay Pematang Ribu Ranau Tengah'),(160913,1609,'Warkuk Ranau Selatan'),(160914,1609,'Runjung Agung'),(160915,1609,'Sungai Are'),(160916,1609,'Sindang Danau'),(160917,1609,'Buana Pemaca'),(160918,1609,'Tiga Dihaji'),(160919,1609,'Buay Rawan'),(161001,1610,'Muara Kuang'),(161002,1610,'Tanjung Batu'),(161003,1610,'Tanjung Raja'),(161004,1610,'Indralaya'),(161005,1610,'Pemulutan'),(161006,1610,'Rantau Alai'),(161007,1610,'Indralaya Utara'),(161008,1610,'Indralaya Selatan'),(161009,1610,'Pemulutan Selatan'),(161010,1610,'Pemulutan Barat'),(161011,1610,'Rantau Panjang'),(161012,1610,'Sungai Pinang'),(161013,1610,'Kandis'),(161014,1610,'Rambang Kuang'),(161015,1610,'Lubuk Keliat'),(161016,1610,'Payaraman'),(161101,1611,'Muara Pinang'),(161102,1611,'Pendopo'),(161103,1611,'Ulu Musi'),(161104,1611,'Tebing Tinggi'),(161105,1611,'Lintang Kanan'),(161106,1611,'Talang Padang'),(161107,1611,'Pasemah Air Keruh'),(161108,1611,'Sikap Dalam'),(161109,1611,'Saling'),(161110,1611,'Pendopo Barat'),(167101,1671,'Ilir Barat II'),(167102,1671,'Seberang Ulu I'),(167103,1671,'Seberang Ulu II'),(167104,1671,'Ilir Barat I'),(167105,1671,'Ilir Timur I'),(167106,1671,'Ilir Timur II'),(167107,1671,'Sukarami'),(167108,1671,'Sako'),(167109,1671,'Kemuning'),(167110,1671,'Kalidoni'),(167111,1671,'Bukit Kecil'),(167112,1671,'Gandus'),(167113,1671,'Kertapati'),(167114,1671,'Plaju'),(167115,1671,'Alang-alang Lebar'),(167116,1671,'Sematang Borang'),(167201,1672,'Pagar Alam Utara'),(167202,1672,'Pagar Alam Selatan'),(167203,1672,'Dempo Utara'),(167204,1672,'Dempo Selatan'),(167205,1672,'Dempo Tengah'),(167301,1673,'Lubuk Linggau Timur I'),(167302,1673,'Lubuk Linggau Barat I'),(167303,1673,'Lubuk Linggau Selatan I'),(167304,1673,'Lubuk Linggau Utara I'),(167305,1673,'Lubuk Linggau Timur II'),(167306,1673,'Lubuk Linggau Barat II'),(167307,1673,'Lubuk Linggau Selatan II'),(167308,1673,'Lubuk Linggau Utara II'),(167401,1674,'Prabumulih Barat'),(167402,1674,'Prabumulih Timur'),(167403,1674,'Cambai'),(167404,1674,'Rambang Kpk Tengah'),(167405,1674,'Prabumulih Utara'),(167406,1674,'Prabumulih Selatan'),(170101,1701,'Kedurang'),(170102,1701,'Seginim'),(170103,1701,'Pino'),(170104,1701,'Manna'),(170105,1701,'Kota Manna'),(170106,1701,'Pino Raya'),(170107,1701,'Kedurang Ilir'),(170108,1701,'Air Nipis'),(170109,1701,'Ulu Manna'),(170110,1701,'Bunga Mas'),(170111,1701,'Pasar Manna'),(170206,1702,'Kota Padang'),(170207,1702,'Padang Ulak Tanding'),(170208,1702,'Sindang Kelingi'),(170209,1702,'Curup'),(170210,1702,'Bermani Ulu'),(170211,1702,'Selupu Rejang'),(170216,1702,'Curup Utara'),(170217,1702,'Curup Timur'),(170218,1702,'Curup Selatan'),(170219,1702,'Curup Tengah'),(170220,1702,'Binduriang'),(170221,1702,'Sindang Beliti Ulu'),(170222,1702,'Sindang Dataran'),(170223,1702,'Sindang Beliti Ilir'),(170224,1702,'Bermani Ulu Raya'),(170301,1703,'Enggano'),(170306,1703,'Kerkap'),(170307,1703,'Arga Makmur'),(170308,1703,'Giri Mulya'),(170309,1703,'Padang Jaya'),(170310,1703,'Lais'),(170311,1703,'Batik Nau'),(170312,1703,'Ketahun'),(170313,1703,'Napal Putih'),(170314,1703,'Putri Hijau'),(170315,1703,'Air Besi'),(170316,1703,'Air Napal'),(170319,1703,'Hulu Palik'),(170320,1703,'Air Padang'),(170321,1703,'Arma Jaya'),(170322,1703,'Tanjungagung Palik'),(170323,1703,'Ulok Kupai'),(170401,1704,'Kinal'),(170402,1704,'Tanjung Kemuning'),(170403,1704,'Kaur Utara'),(170404,1704,'Kaur Tengah'),(170405,1704,'Kaur Selatan'),(170406,1704,'Maje'),(170407,1704,'Nasal'),(170408,1704,'Semidang Gumay'),(170409,1704,'Kelam Tengah'),(170410,1704,'Luas'),(170411,1704,'Muara Sahung'),(170412,1704,'Tetap'),(170413,1704,'Lungkang Kule'),(170414,1704,'Padang Guci Hilir'),(170415,1704,'Padang Guci Hulu'),(170501,1705,'Sukaraja'),(170502,1705,'Seluma'),(170503,1705,'Talo'),(170504,1705,'Semidang Alas'),(170505,1705,'Semidang Alas Maras'),(170506,1705,'Air Periukan'),(170507,1705,'Lubuk Sandi'),(170508,1705,'Seluma Barat'),(170509,1705,'Seluma Timur'),(170510,1705,'Seluma Utara'),(170511,1705,'Seluma Selatan'),(170512,1705,'Talo Kecil'),(170513,1705,'Ulu Talo'),(170514,1705,'Ilir Talo'),(170601,1706,'Lubuk Pinang'),(170602,1706,'Kota Mukomuko'),(170603,1706,'Teras Terunjam'),(170604,1706,'Pondok Suguh'),(170605,1706,'Ipuh'),(170606,1706,'Malin Deman'),(170607,1706,'Air Rami'),(170608,1706,'Teramang Jaya'),(170609,1706,'Selagan Raya'),(170610,1706,'Penarik'),(170611,1706,'XIV Koto'),(170612,1706,'V Koto'),(170613,1706,'Air Majunto'),(170614,1706,'Air Dikit'),(170615,1706,'Sungai Rumbai'),(170701,1707,'Lebong Utara'),(170702,1707,'Lebong Atas'),(170703,1707,'Lebong Tengah'),(170704,1707,'Lebong Selatan'),(170705,1707,'Rimbo Pengadang'),(170706,1707,'Topos'),(170707,1707,'Bingin Kuning'),(170708,1707,'Lebong Sakti'),(170709,1707,'Pelabai'),(170710,1707,'Amen'),(170711,1707,'Uram Jaya'),(170712,1707,'Pinang Belapis'),(170801,1708,'Bermani Ilir'),(170802,1708,'Ujan Mas'),(170803,1708,'Tebat Karai'),(170804,1708,'Kepahiang'),(170805,1708,'Merigi'),(170806,1708,'Kebawetan'),(170807,1708,'Seberang Musi'),(170808,1708,'Muara Kemumu'),(170901,1709,'Karang Tinggi'),(170902,1709,'Talang Empat'),(170903,1709,'Pondok Kelapa'),(170904,1709,'Pematang Tiga'),(170905,1709,'Pagar Jati'),(170906,1709,'Taba Penanjung'),(170907,1709,'Merigi Kelindang'),(170908,1709,'Merigi Sakti'),(170909,1709,'Pondok Kubang'),(170910,1709,'Bang Haji'),(177101,1771,'Selebar'),(177102,1771,'Gading Cempaka'),(177103,1771,'Teluk Segara'),(177104,1771,'Muara Bangka Hulu'),(177105,1771,'Kampung Melayu'),(177106,1771,'Ratu Agung'),(177107,1771,'Ratu Samban'),(177108,1771,'Sungai Serut'),(177109,1771,'Singaran Pati'),(180104,1801,'Natar'),(180105,1801,'Tanjung Bintang'),(180106,1801,'Kalianda'),(180107,1801,'Sidomulyo'),(180108,1801,'Katibung'),(180109,1801,'Penengahan'),(180110,1801,'Palas'),(180113,1801,'Jati Agung'),(180114,1801,'Ketapang'),(180115,1801,'Sragi'),(180116,1801,'Raja Basa'),(180117,1801,'Candipuro'),(180118,1801,'Merbau Mataram'),(180121,1801,'Bakauheni'),(180122,1801,'Tanjung Sari'),(180123,1801,'Way Sulan'),(180124,1801,'Way Panji'),(180201,1802,'Kalirejo'),(180202,1802,'Bangun Rejo'),(180203,1802,'Padang Ratu'),(180204,1802,'Gunung Sugih'),(180205,1802,'Trimurjo'),(180206,1802,'Punggur'),(180207,1802,'Terbanggi Besar'),(180208,1802,'Seputih Raman'),(180209,1802,'Rumbia'),(180210,1802,'Seputih Banyak'),(180211,1802,'Seputih Mataram'),(180212,1802,'Seputih Surabaya'),(180213,1802,'Terusan Nunyai'),(180214,1802,'Bumi Ratu Nuban'),(180215,1802,'Bekri'),(180216,1802,'Seputih Agung'),(180217,1802,'Way Pangubuan'),(180218,1802,'Bandar Mataram'),(180219,1802,'Pubian'),(180220,1802,'Selagai Lingga'),(180221,1802,'Anak Tuha'),(180222,1802,'Sendang Agung'),(180223,1802,'Kota Gajah'),(180224,1802,'Bumi Nabung'),(180225,1802,'Way Seputih'),(180226,1802,'Bandar Surabaya'),(180227,1802,'Anak Ratu Aji'),(180228,1802,'Putra Rumbia'),(180301,1803,'Bukit Kemuning'),(180302,1803,'Kotabumi'),(180303,1803,'Sungkai Selatan'),(180304,1803,'Tanjung Raja'),(180305,1803,'Abung Timur'),(180306,1803,'Abung Barat'),(180307,1803,'Abung Selatan'),(180308,1803,'Sungkai Utara'),(180309,1803,'Kotabumi Utara'),(180310,1803,'Kotabumi Selatan'),(180311,1803,'Abung Tengah'),(180312,1803,'Abung Tinggi'),(180313,1803,'Abung Semuli'),(180314,1803,'Abung Surakarta'),(180315,1803,'Muara Sungkai'),(180316,1803,'Bunga Mayang'),(180317,1803,'Hulu Sungkai'),(180318,1803,'Sungkai Tengah'),(180319,1803,'Abung Pekurun'),(180320,1803,'Sungkai Jaya'),(180321,1803,'Sungkai Barat'),(180322,1803,'Abung Kunang'),(180323,1803,'Blambangan Pagar'),(180401,1804,'Pesisir Selatan'),(180402,1804,'Pesisir Tengah'),(180403,1804,'Pesisir Utara'),(180404,1804,'Balik Bukit'),(180405,1804,'Sumber Jaya'),(180406,1804,'Belalau'),(180407,1804,'Way Tenong'),(180408,1804,'Sekincau'),(180409,1804,'Suoh'),(180410,1804,'Batu Brak'),(180411,1804,'Sukau'),(180412,1804,'Karya Penggawa'),(180526,1804,'Meraksa Aji'),(180527,1804,'Gedung Aji Baru'),(180529,1804,'Banjar Baru'),(180530,1804,'Menggala Timur'),(180601,1806,'Kota Agung'),(180602,1806,'Talang Padang'),(180603,1806,'Wonosobo'),(180604,1806,'Pulau Panggung'),(180609,1806,'Cukuh Balak'),(180611,1806,'Pugung'),(180612,1806,'Semaka'),(180613,1806,'Sumber Rejo'),(180615,1806,'Ulu Belu'),(180616,1806,'Pematang Sawa'),(180617,1806,'Klumbayan'),(180618,1806,'Kota Agung Barat'),(180619,1806,'Kota Agung Timur'),(180620,1806,'Gisting'),(180621,1806,'Gunung Alip'),(180624,1806,'Limau'),(180625,1806,'Bandar Negeri Semuong'),(180626,1806,'Air Naningan'),(180627,1806,'Bulok'),(180628,1806,'Klumbayan Barat'),(180701,1807,'Sukadana'),(180702,1807,'Labuhan Maringgai'),(180703,1807,'Jabung'),(180704,1807,'Pekalongan'),(180705,1807,'Sekampung'),(180706,1807,'Batanghari'),(180707,1807,'Way Jepara'),(180708,1807,'Purbolinggo'),(180709,1807,'Raman Utara'),(180710,1807,'Metro Kibang'),(180711,1807,'Marga Tiga'),(180712,1807,'Sekampung Udik'),(180713,1807,'Batanghari Nuban'),(180714,1807,'Bumi Agung'),(180715,1807,'Bandar Sribhawono'),(180716,1807,'Mataram Baru'),(180717,1807,'Melinting'),(180718,1807,'Gunung Pelindung'),(180719,1807,'Pasir Sakti'),(180720,1807,'Waway Karya'),(180721,1807,'Labuhan Ratu'),(180722,1807,'Braja Selebah'),(180723,1807,'Way Bungur'),(180724,1807,'Marga Sekampung'),(180801,1808,'Blambangan Umpu'),(180802,1808,'Kasui'),(180803,1808,'Banjit'),(180804,1808,'Baradatu'),(180805,1808,'Bahuga'),(180806,1808,'Pakuan Ratu'),(180807,1808,'Negeri Agung'),(180808,1808,'Way Tuba'),(180809,1808,'Rebang Tangkas'),(180810,1808,'Gunung Labuhan'),(180811,1808,'Negara Batin'),(180812,1808,'Negeri Besar'),(180813,1808,'Buay Bahuga'),(180814,1808,'Bumi Agung'),(180901,1809,'Gedong Tataan'),(180902,1809,'Negeri Katon'),(180903,1809,'Tegineneng'),(180904,1809,'Way Lima'),(180905,1809,'Padang Cermin'),(180906,1809,'Punduh Pidada'),(180907,1809,'Kedondong'),(180908,1809,'Marga Punduh'),(180909,1809,'Way Khilau'),(181001,1810,'Pringsewu'),(181002,1810,'Gading Rejo'),(181003,1810,'Ambarawa'),(181004,1810,'Pardasuka'),(181005,1810,'Pagelaran'),(181006,1810,'Banyumas'),(181007,1810,'Adiluwih'),(181008,1810,'Sukoharjo'),(181009,1810,'Pagelaran Utara'),(181101,1811,'Mesuji'),(181102,1811,'Mesuji Timur'),(181103,1811,'Rawa Jitu Utara'),(181104,1811,'Way Serdang'),(181105,1811,'Simpang Pematang'),(181106,1811,'Panca Jaya'),(181107,1811,'Tanjung Raya'),(181201,1812,'Tulang Bawang Tengah'),(181202,1812,'Tumijajar'),(181203,1812,'Tulang Bawang Udik'),(181204,1812,'Gunung Terang'),(181205,1812,'Gunung Agung'),(181206,1812,'Way Kenanga'),(181207,1812,'Lambu Kibang'),(181208,1812,'Pagar Dewa'),(187101,1871,'Kedaton'),(187102,1871,'Sukarame'),(187103,1871,'Tanjungkarang Barat'),(187104,1871,'Panjang'),(187105,1871,'Tanjungkarang Timur'),(187106,1871,'Tanjungkarang Pusat'),(187107,1871,'Telukbetung Selatan'),(187108,1871,'Telukbetung Barat'),(187109,1871,'Telukbetung Utara'),(187110,1871,'Rajabasa'),(187111,1871,'Tanjung Senang'),(187112,1871,'Sukabumi'),(187113,1871,'Kemiling'),(187114,1871,'Labuhan Ratu'),(187115,1871,'Way Halim'),(187116,1871,'Langkapura'),(187117,1871,'Enggal'),(187118,1871,'Kedamaian'),(187119,1871,'Telukbetung Timur'),(187120,1871,'Bumi Waras'),(187201,1872,'Metro Pusat'),(187202,1872,'Metro Utara'),(187203,1872,'Metro Barat'),(187204,1872,'Metro Timur'),(187205,1872,'Metro Selatan'),(190101,1901,'Sungailiat'),(190102,1901,'Belinyu'),(190103,1901,'Merawang'),(190104,1901,'Mendo Barat'),(190105,1901,'Pemali'),(190106,1901,'Bakam'),(190107,1901,'Riau Silip'),(190108,1901,'Puding Besar'),(190201,1902,'Tanjung Pandan'),(190202,1902,'Membalong'),(190203,1902,'Selat Nasik'),(190204,1902,'Sijuk'),(190205,1902,'Badau'),(190301,1903,'Toboali'),(190302,1903,'Lepar Pongok'),(190303,1903,'Air Gegas'),(190304,1903,'Simpang Rimba'),(190305,1903,'Payung'),(190306,1903,'Tukak Sadai'),(190307,1903,'Pulaubesar'),(190308,1903,'Kepulauan Pongok'),(190401,1904,'Koba'),(190402,1904,'Pangkalan Baru'),(190403,1904,'Sungai Selan'),(190404,1904,'Simpang Katis'),(190405,1904,'Namang'),(190406,1904,'Lubuk Besar'),(190501,1905,'Mentok'),(190502,1905,'Simpang Teritip'),(190503,1905,'Jebus'),(190504,1905,'Kelapa'),(190505,1905,'Tempilang'),(190506,1905,'Parittiga'),(190601,1906,'Manggar'),(190602,1906,'Gantung'),(190603,1906,'Dendang'),(190604,1906,'Kelapa Kampit'),(190605,1906,'Damar'),(190606,1906,'Simpang Renggiang'),(190607,1906,'Simpang Pesak'),(197101,1971,'Bukitintan'),(197102,1971,'Taman Sari'),(197103,1971,'Pangkal Balam'),(197104,1971,'Rangkui'),(197105,1971,'Gerunggang'),(197106,1971,'Gabek'),(197107,1971,'Girimaya'),(210104,2101,'Gunung Kijang'),(210106,2101,'Bintan Timur'),(210107,2101,'Bintan Utara'),(210108,2101,'Teluk Bintan'),(210109,2101,'Tambelan'),(210110,2101,'Telok Sebong'),(210112,2101,'Toapaya'),(210113,2101,'Mantang'),(210114,2101,'Bintan Pesisir'),(210115,2101,'Seri Kuala Lobam'),(210201,2102,'Moro'),(210202,2102,'Kundur'),(210203,2102,'Karimun'),(210204,2102,'Meral'),(210205,2102,'Tebing'),(210206,2102,'Buru'),(210207,2102,'Kundur Utara'),(210208,2102,'Kundur Barat'),(210209,2102,'Durai'),(210210,2102,'Meral Barat'),(210211,2102,'Ungar'),(210212,2102,'Belat'),(210304,2103,'Midai'),(210305,2103,'Bunguran Barat'),(210306,2103,'Serasan'),(210307,2103,'Bunguran Timur'),(210308,2103,'Bunguran Utara'),(210309,2103,'Subi'),(210310,2103,'Pulau Laut'),(210311,2103,'Pulau Tiga'),(210315,2103,'Bunguran Timur Laut'),(210316,2103,'Bunguran Tengah'),(210318,2103,'Bunguran Selatan'),(210319,2103,'Serasan Timur'),(210401,2104,'Singkep'),(210402,2104,'Lingga'),(210403,2104,'Senayang'),(210404,2104,'Singkep Barat'),(210405,2104,'Lingga Utara'),(210406,2104,'Singkep Pesisir'),(210407,2104,'Lingga Timur'),(210408,2104,'Selayar'),(210501,2105,'Siantan'),(210502,2105,'Palmatak'),(210503,2105,'Siantan Timur'),(210504,2105,'Siantan Selatan'),(210505,2105,'Jemaja Timur'),(210506,2105,'Jemaja'),(210507,2105,'Siantan Tengah'),(217101,2171,'Belakang Padang'),(217102,2171,'Batu Ampar'),(217103,2171,'Sekupang'),(217104,2171,'Nongsa'),(217105,2171,'Bulang'),(217106,2171,'Lubuk Baja'),(217107,2171,'Sei Beduk'),(217108,2171,'Galang'),(217109,2171,'Bengkong'),(217110,2171,'Batam Kota'),(217111,2171,'Sagulung'),(217112,2171,'Batu Aji'),(217201,2172,'Tanjung Pinang Barat'),(217202,2172,'Tanjung Pinang Timur'),(217203,2172,'Tanjung Pinang Kota'),(217204,2172,'Bukit Bestari'),(310101,3101,'Kepulauan Seribu Utara'),(310102,3101,'Kepulauan Seribu Selatan.'),(317101,3171,'Gambir'),(317102,3171,'Sawah Besar'),(317103,3171,'Kemayoran'),(317104,3171,'Senen'),(317105,3171,'Cempaka Putih'),(317106,3171,'Menteng'),(317107,3171,'Tanah Abang'),(317108,3171,'Johar Baru'),(317201,3172,'Penjaringan'),(317202,3172,'Tanjung Priok'),(317203,3172,'Koja'),(317204,3172,'Cilincing'),(317205,3172,'Pademangan'),(317206,3172,'Kelapa Gading'),(317301,3173,'Cengkareng'),(317302,3173,'Grogol Petamburan'),(317303,3173,'Taman Sari'),(317304,3173,'Tambora'),(317305,3173,'Kebon Jeruk'),(317306,3173,'Kalideres'),(317307,3173,'Pal Merah'),(317308,3173,'Kembangan'),(317401,3174,'Tebet'),(317402,3174,'Setiabudi'),(317403,3174,'Mampang Prapatan'),(317404,3174,'Pasar Minggu'),(317405,3174,'Kebayoran Lama'),(317406,3174,'Cilandak'),(317407,3174,'Kebayoran Baru'),(317408,3174,'Pancoran'),(317409,3174,'Jagakarsa'),(317410,3174,'Pesanggrahan'),(317501,3175,'Matraman'),(317502,3175,'Pulogadung'),(317503,3175,'Jatinegara'),(317504,3175,'Kramatjati'),(317505,3175,'Pasar Rebo'),(317506,3175,'Cakung'),(317507,3175,'Duren Sawit'),(317508,3175,'Makasar'),(317509,3175,'Ciracas'),(317510,3175,'Cipayung'),(320101,3201,'Cibinong'),(320102,3201,'Gunung Putri'),(320103,3201,'Citeureup'),(320104,3201,'Sukaraja'),(320105,3201,'Babakan Madang'),(320106,3201,'Jonggol'),(320107,3201,'Cileungsi'),(320108,3201,'Cariu'),(320109,3201,'Sukamakmur'),(320110,3201,'Parung'),(320111,3201,'Gunung Sindur'),(320112,3201,'Kemang'),(320113,3201,'Bojong Gede'),(320114,3201,'Leuwiliang'),(320115,3201,'Ciampea'),(320116,3201,'Cibungbulang'),(320117,3201,'Pamijahan'),(320118,3201,'Rumpin'),(320119,3201,'Jasinga'),(320120,3201,'Parung Panjang'),(320121,3201,'Nanggung'),(320122,3201,'Cigudeg'),(320123,3201,'Tenjo'),(320124,3201,'Ciawi'),(320125,3201,'Cisarua'),(320126,3201,'Megamendung'),(320127,3201,'Caringin'),(320128,3201,'Cijeruk'),(320129,3201,'Ciomas'),(320130,3201,'Dramaga'),(320131,3201,'Tamansari'),(320132,3201,'Klapanunggal'),(320133,3201,'Ciseeng'),(320134,3201,'Ranca Bungur'),(320135,3201,'Sukajaya'),(320136,3201,'Tanjungsari'),(320137,3201,'Tajurhalang'),(320138,3201,'Cigombong'),(320139,3201,'Leuwisadeng'),(320140,3201,'Tenjolaya'),(320201,3202,'Pelabuhan Ratu'),(320202,3202,'Simpenan'),(320203,3202,'Cikakak'),(320204,3202,'Bantar Gadung'),(320205,3202,'Cisolok'),(320206,3202,'Cikidang'),(320207,3202,'Lengkong'),(320208,3202,'Jampang Tengah'),(320209,3202,'Warung Kiara'),(320210,3202,'Cikembar'),(320211,3202,'Cibadak'),(320212,3202,'Nagrak'),(320213,3202,'Parung Kuda'),(320214,3202,'Bojong Genteng'),(320215,3202,'Parakan Salak'),(320216,3202,'Cicurug'),(320217,3202,'Cidahu'),(320218,3202,'Kalapa Nunggal'),(320219,3202,'Kabandungan'),(320220,3202,'Waluran'),(320221,3202,'Jampang Kulon'),(320222,3202,'Ciemas'),(320223,3202,'Kalibunder'),(320224,3202,'Surade'),(320225,3202,'Cibitung'),(320226,3202,'Ciracap'),(320227,3202,'Gunung Guruh'),(320228,3202,'Cicantayan'),(320229,3202,'Cisaat'),(320230,3202,'Kadudampit'),(320231,3202,'Caringin'),(320232,3202,'Sukabumi'),(320233,3202,'Sukaraja'),(320234,3202,'Kebon Pedes'),(320235,3202,'Cireunghas'),(320236,3202,'Sukalarang'),(320237,3202,'Pabuaran'),(320238,3202,'Purabaya'),(320239,3202,'Nyalindung'),(320240,3202,'Geger Bitung'),(320241,3202,'Sagaranten'),(320242,3202,'Curug Kembar'),(320243,3202,'Cidolog'),(320244,3202,'Cidadap'),(320245,3202,'Tegalbuleud'),(320246,3202,'Cimanggu'),(320247,3202,'Ciambar'),(320301,3203,'Cianjur'),(320302,3203,'Warungkondang'),(320303,3203,'Cibeber'),(320304,3203,'Cilaku'),(320305,3203,'Ciranjang'),(320306,3203,'Bojongpicung'),(320307,3203,'Karangtengah'),(320308,3203,'Mande'),(320309,3203,'Sukaluyu'),(320310,3203,'Pacet'),(320311,3203,'Cugenang'),(320312,3203,'Cikalongkulon'),(320313,3203,'Sukaresmi'),(320314,3203,'Sukanagara'),(320315,3203,'Campaka'),(320316,3203,'Takokak'),(320317,3203,'Kadupandak'),(320318,3203,'Pagelaran'),(320319,3203,'Tanggeung'),(320320,3203,'Cibinong'),(320321,3203,'Sindangbarang'),(320322,3203,'Agrabinta'),(320323,3203,'Cidaun'),(320324,3203,'Naringgul'),(320325,3203,'Campakamulya'),(320326,3203,'Cikadu'),(320327,3203,'Gekbrong'),(320328,3203,'Cipanas'),(320329,3203,'Cijati'),(320330,3203,'Leles'),(320331,3203,'Haurwangi'),(320332,3203,'Pasirkuda'),(320405,3204,'Cileunyi'),(320406,3204,'Cimenyan'),(320407,3204,'Cilengkrang'),(320408,3204,'Bojongsoang'),(320409,3204,'Margahayu'),(320410,3204,'Margaasih'),(320411,3204,'Katapang'),(320412,3204,'Dayeuhkolot'),(320413,3204,'Banjaran'),(320414,3204,'Pameungpeuk'),(320415,3204,'Pangalengan'),(320416,3204,'Arjasari'),(320417,3204,'Cimaung'),(320425,3204,'Cicalengka'),(320426,3204,'Nagreg'),(320427,3204,'Cikancung'),(320428,3204,'Rancaekek'),(320429,3204,'Ciparay'),(320430,3204,'Pacet'),(320431,3204,'Kertasari'),(320432,3204,'Baleendah'),(320433,3204,'Majalaya'),(320434,3204,'Solokanjeruk'),(320435,3204,'Paseh'),(320436,3204,'Ibun'),(320437,3204,'Soreang'),(320438,3204,'Pasirjambu'),(320439,3204,'Ciwidey'),(320440,3204,'Rancabali'),(320444,3204,'Cangkuang'),(320446,3204,'Kutawaringin'),(320501,3205,'Garut Kota'),(320502,3205,'Karangpawitan'),(320503,3205,'Wanaraja'),(320504,3205,'Tarogong Kaler'),(320505,3205,'Tarogong Kidul'),(320506,3205,'Banyuresmi'),(320507,3205,'Samarang'),(320508,3205,'Pasirwangi'),(320509,3205,'Leles'),(320510,3205,'Kadungora'),(320511,3205,'Leuwigoong'),(320512,3205,'Cibatu'),(320513,3205,'Kersamanah'),(320514,3205,'Malangbong'),(320515,3205,'Sukawening'),(320516,3205,'Karangtengah'),(320517,3205,'Bayongbong'),(320518,3205,'Cigedug'),(320519,3205,'Cilawu'),(320520,3205,'Cisurupan'),(320521,3205,'Sukaresmi'),(320522,3205,'Cikajang'),(320523,3205,'Banjarwangi'),(320524,3205,'Singajaya'),(320525,3205,'Cihurip'),(320526,3205,'Peundeuy'),(320527,3205,'Pameungpeuk'),(320528,3205,'Cisompet'),(320529,3205,'Cibalong'),(320530,3205,'Cikelet'),(320531,3205,'Bungbulang'),(320532,3205,'Mekarmukti'),(320533,3205,'Pakenjeng'),(320534,3205,'Pamulihan'),(320535,3205,'Cisewu'),(320536,3205,'Caringin'),(320537,3205,'Talegong'),(320538,3205,'Bl. Limbangan'),(320539,3205,'Selaawi'),(320540,3205,'Cibiuk'),(320541,3205,'Pangatikan'),(320542,3205,'Sucinaraja'),(320601,3206,'Cipatujah'),(320602,3206,'Karangnunggal'),(320603,3206,'Cikalong'),(320604,3206,'Panca Tengah'),(320605,3206,'Cikatomas'),(320606,3206,'Cibalong'),(320607,3206,'Parungponteng'),(320608,3206,'Bantarkalong'),(320609,3206,'Bojongasih'),(320610,3206,'Culamega'),(320611,3206,'Bojonggambir'),(320612,3206,'Sodonghilir'),(320613,3206,'Taraju'),(320614,3206,'Salawu'),(320615,3206,'Puspahiang'),(320616,3206,'Tanjungjaya'),(320617,3206,'Sukaraja'),(320618,3206,'Salopa'),(320619,3206,'Jatiwaras'),(320620,3206,'Cineam'),(320621,3206,'Karang Jaya'),(320622,3206,'Manonjaya'),(320623,3206,'Gunung Tanjung'),(320624,3206,'Singaparna'),(320625,3206,'Mangunreja'),(320626,3206,'Sukarame'),(320627,3206,'Cigalontang'),(320628,3206,'Leuwisari'),(320629,3206,'Padakembang'),(320630,3206,'Sariwangi'),(320631,3206,'Sukaratu'),(320632,3206,'Cisayong'),(320633,3206,'Sukahening'),(320634,3206,'Rajapolah'),(320635,3206,'Jamanis'),(320636,3206,'Ciawi'),(320637,3206,'Kadipaten'),(320638,3206,'Pagerageung'),(320639,3206,'Sukaresik'),(320701,3207,'Ciamis'),(320702,3207,'Cikoneng'),(320703,3207,'Cijeungjing'),(320704,3207,'Sadananya'),(320705,3207,'Cidolog'),(320706,3207,'Cihaurbeuti'),(320707,3207,'Panumbangan'),(320708,3207,'Panjalu'),(320709,3207,'Kawali'),(320710,3207,'Panawangan'),(320711,3207,'Cipaku'),(320712,3207,'Jatinagara'),(320713,3207,'Rajadesa'),(320714,3207,'Sukadana'),(320715,3207,'Rancah'),(320716,3207,'Tambaksari'),(320717,3207,'Lakbok'),(320718,3207,'Banjarsari'),(320719,3207,'Pamarican'),(320720,3207,'Padaherang'),(320721,3207,'Kalipucang'),(320722,3207,'Pangandaran'),(320723,3207,'Sidamulih'),(320724,3207,'Parigi'),(320725,3207,'Cijulang'),(320726,3207,'Cimerak'),(320727,3207,'Cigugur'),(320728,3207,'Langkaplancar'),(320729,3207,'Cimaragas'),(320730,3207,'Cisaga'),(320731,3207,'Sindangkasih'),(320732,3207,'Baregbeg'),(320733,3207,'Sukamantri'),(320734,3207,'Lumbung'),(320735,3207,'Purwadadi'),(320736,3207,'Mangunjaya'),(320801,3208,'Kadugede'),(320802,3208,'Ciniru'),(320803,3208,'Subang'),(320804,3208,'Ciwaru'),(320805,3208,'Cibingbin'),(320806,3208,'Luragung'),(320807,3208,'Lebakwangi'),(320808,3208,'Garawangi'),(320809,3208,'Kuningan'),(320810,3208,'Ciawigebang'),(320811,3208,'Cidahu'),(320812,3208,'Jalaksana'),(320813,3208,'Cilimus'),(320814,3208,'Mandirancan'),(320815,3208,'Selajambe'),(320816,3208,'Kramatmulya'),(320817,3208,'Darma'),(320818,3208,'Cigugur'),(320819,3208,'Pasawahan'),(320820,3208,'Nusaherang'),(320821,3208,'Cipicung'),(320822,3208,'Pancalang'),(320823,3208,'Japara'),(320824,3208,'Cimahi'),(320825,3208,'Cilebak'),(320826,3208,'Hantara'),(320827,3208,'Kalimanggis'),(320828,3208,'Cibeureum'),(320829,3208,'Karang Kancana'),(320830,3208,'Maleber'),(320831,3208,'Sindang Agung'),(320832,3208,'Cigandamekar'),(320901,3209,'Waled'),(320902,3209,'Ciledug'),(320903,3209,'Losari'),(320904,3209,'Pabedilan'),(320905,3209,'Babakan'),(320906,3209,'Karangsembung'),(320907,3209,'Lemahabang'),(320908,3209,'Susukan Lebak'),(320909,3209,'Sedong'),(320910,3209,'Astanajapura'),(320911,3209,'Pangenan'),(320912,3209,'Mundu'),(320913,3209,'Beber'),(320914,3209,'Talun'),(320915,3209,'Sumber'),(320916,3209,'Dukupuntang'),(320917,3209,'Palimanan'),(320918,3209,'Plumbon'),(320919,3209,'Weru'),(320920,3209,'Kedawung'),(320921,3209,'Gunung Jati'),(320922,3209,'Kapetakan'),(320923,3209,'Klangenan'),(320924,3209,'Arjawinangun'),(320925,3209,'Panguragan'),(320926,3209,'Ciwaringin'),(320927,3209,'Susukan'),(320928,3209,'Gegesik'),(320929,3209,'Kaliwedi'),(320930,3209,'Gebang'),(320931,3209,'Depok'),(320932,3209,'Pasaleman'),(320933,3209,'Pabuaran'),(320934,3209,'Karangwareng'),(320935,3209,'Tengah Tani'),(320936,3209,'Plered'),(320937,3209,'Gempol'),(320938,3209,'Greged'),(320939,3209,'Suranenggala'),(320940,3209,'Jamblang'),(321001,3210,'Lemahsugih'),(321002,3210,'Bantarujeg'),(321003,3210,'Cikijing'),(321004,3210,'Talaga'),(321005,3210,'Argapura'),(321006,3210,'Maja'),(321007,3210,'Majalengka'),(321008,3210,'Sukahaji'),(321009,3210,'Rajagaluh'),(321010,3210,'Leuwimunding'),(321011,3210,'Jatiwangi'),(321012,3210,'Dawuan'),(321013,3210,'Kadipaten'),(321014,3210,'Kertajati'),(321015,3210,'Jatitujuh'),(321016,3210,'Ligung'),(321017,3210,'Sumberjaya'),(321018,3210,'Panyingkiran'),(321019,3210,'Palasah'),(321020,3210,'Cigasong'),(321021,3210,'Sindangwangi'),(321022,3210,'Banjaran'),(321023,3210,'Cingambul'),(321024,3210,'Kasokandel'),(321025,3210,'Sindang'),(321026,3210,'Malausma'),(321101,3211,'Wado'),(321102,3211,'Jatinunggal'),(321103,3211,'Darmaraja'),(321104,3211,'Cibugel'),(321105,3211,'Cisitu'),(321106,3211,'Situraja'),(321107,3211,'Conggeang'),(321108,3211,'Paseh'),(321109,3211,'Surian'),(321110,3211,'Buahdua'),(321111,3211,'Tanjungsari'),(321112,3211,'Sukasari'),(321113,3211,'Pamulihan'),(321114,3211,'Cimanggung'),(321115,3211,'Jatinangor'),(321116,3211,'Rancakalong'),(321117,3211,'Sumedang Selatan'),(321118,3211,'Sumedang Utara'),(321119,3211,'Ganeas'),(321120,3211,'Tanjungkerta'),(321121,3211,'Tanjungmedar'),(321122,3211,'Cimalaka'),(321123,3211,'Cisarua'),(321124,3211,'Tomo'),(321125,3211,'Ujungjaya'),(321126,3211,'Jatigede'),(321201,3212,'Haurgeulis'),(321202,3212,'Kroya'),(321203,3212,'Gabuswetan'),(321204,3212,'Cikedung'),(321205,3212,'Lelea'),(321206,3212,'Bangodua'),(321207,3212,'Widasari'),(321208,3212,'Kertasemaya'),(321209,3212,'Krangkeng'),(321210,3212,'Karangampel'),(321211,3212,'Juntinyuat'),(321212,3212,'Sliyeg'),(321213,3212,'Jatibarang'),(321214,3212,'Balongan'),(321215,3212,'Indramayu'),(321216,3212,'Sindang'),(321217,3212,'Cantigi'),(321218,3212,'Lohbener'),(321219,3212,'Arahan'),(321220,3212,'Losarang'),(321221,3212,'Kandanghaur'),(321222,3212,'Bongas'),(321223,3212,'Anjatan'),(321224,3212,'Sukra'),(321225,3212,'Gantar'),(321226,3212,'Trisi'),(321227,3212,'Sukagumiwang'),(321228,3212,'Kedokan Bunder'),(321229,3212,'Pasekan'),(321230,3212,'Tukdana'),(321231,3212,'Patrol'),(321301,3213,'Sagalaherang'),(321302,3213,'Cisalak'),(321303,3213,'Subang'),(321304,3213,'Kalijati'),(321305,3213,'Pabuaran'),(321306,3213,'Purwadadi'),(321307,3213,'Pagaden'),(321308,3213,'Binong'),(321309,3213,'Ciasem'),(321310,3213,'Pusakanagara'),(321311,3213,'Pamanukan'),(321312,3213,'Jalancagak'),(321313,3213,'Blanakan'),(321314,3213,'Tanjungsiang'),(321315,3213,'Compreng'),(321316,3213,'Patokbeusi'),(321317,3213,'Cibogo'),(321318,3213,'Cipunagara'),(321319,3213,'Cijambe'),(321320,3213,'Cipeunduey'),(321321,3213,'Legonkulon'),(321322,3213,'Cikaum'),(321323,3213,'Serangpanjang'),(321324,3213,'Sukasari'),(321325,3213,'Tambakdahan'),(321326,3213,'Kasomalang'),(321327,3213,'Dawuan'),(321328,3213,'Pagaden Barat'),(321329,3213,'Ciater'),(321330,3213,'Pusakajaya'),(321401,3214,'Purwakarta'),(321402,3214,'Campaka'),(321403,3214,'Jatiluhur'),(321404,3214,'Plered'),(321405,3214,'Sukatani'),(321406,3214,'Darangdan'),(321407,3214,'Maniis'),(321408,3214,'Tegalwaru'),(321409,3214,'Wanayasa'),(321410,3214,'Pasawahan'),(321411,3214,'Bojong'),(321412,3214,'Babakancikao'),(321413,3214,'Bungursari'),(321414,3214,'Cibatu'),(321415,3214,'Sukasari'),(321416,3214,'Pondoksalam'),(321417,3214,'Kiarapedes'),(321501,3215,'Karawang Barat'),(321502,3215,'Pangkalan'),(321503,3215,'Telukjambe Timur'),(321504,3215,'Ciampel'),(321505,3215,'Klari'),(321506,3215,'Rengasdengklok'),(321507,3215,'Kutawaluya'),(321508,3215,'Batujaya'),(321509,3215,'Tirtajaya'),(321510,3215,'Pedes'),(321511,3215,'Cibuaya'),(321512,3215,'Pakisjaya'),(321513,3215,'Cikampek'),(321514,3215,'Jatisari'),(321515,3215,'Cilamaya Wetan'),(321516,3215,'Tirtamulya'),(321517,3215,'Telagasari'),(321518,3215,'Rawamerta'),(321519,3215,'Lemahabang'),(321520,3215,'Tempuran'),(321521,3215,'Majalaya'),(321522,3215,'Jayakerta'),(321523,3215,'Cilamaya Kulon'),(321524,3215,'Banyusari'),(321525,3215,'Kota Baru'),(321526,3215,'Karawang Timur'),(321527,3215,'Telukjambe Barat'),(321528,3215,'Tegalwaru'),(321529,3215,'Purwasari'),(321530,3215,'Cilebar'),(321601,3216,'Tarumajaya'),(321602,3216,'Babelan'),(321603,3216,'Sukawangi'),(321604,3216,'Tambelang'),(321605,3216,'Tambun Utara'),(321606,3216,'Tambun Selatan'),(321607,3216,'Cibitung'),(321608,3216,'Cikarang Barat'),(321609,3216,'Cikarang Utara'),(321610,3216,'Karang Bahagia'),(321611,3216,'Cikarang Timur'),(321612,3216,'Kedung Waringin'),(321613,3216,'Pebayuran'),(321614,3216,'Sukakarya'),(321615,3216,'Sukatani'),(321616,3216,'Cabangbungin'),(321617,3216,'Muaragembong'),(321618,3216,'Setu'),(321619,3216,'Cikarang Selatan'),(321620,3216,'Cikarang Pusat'),(321621,3216,'Serang Baru'),(321622,3216,'Cibarusah'),(321623,3216,'Bojongmangu'),(321701,3217,'Lembang'),(321702,3217,'Parongpong'),(321703,3217,'Cisarua'),(321704,3217,'Cikalongwetan'),(321705,3217,'Cipeundeuy'),(321706,3217,'Ngamprah'),(321707,3217,'Cipatat'),(321708,3217,'Padalarang'),(321709,3217,'Batujajar'),(321710,3217,'Cihampelas'),(321711,3217,'Cililin'),(321712,3217,'Cipongkor'),(321713,3217,'Rongga'),(321714,3217,'Sindangkerta'),(321715,3217,'Gununghalu'),(321716,3217,'Saguling'),(327101,3271,'Bogor Selatan'),(327102,3271,'Bogor Timur'),(327103,3271,'Bogor Tengah'),(327104,3271,'Bogor Barat'),(327105,3271,'Bogor Utara'),(327106,3271,'Tanah Sareal'),(327201,3272,'Gunung Puyuh'),(327202,3272,'Cikole'),(327203,3272,'Citamiang'),(327204,3272,'Warudoyong'),(327205,3272,'Baros'),(327206,3272,'Lembursitu'),(327207,3272,'Cibeureum'),(327301,3273,'Sukasari'),(327302,3273,'Coblong'),(327303,3273,'Babakan Ciparay'),(327304,3273,'Bojongloa Kaler'),(327305,3273,'Andir'),(327306,3273,'Cicendo'),(327307,3273,'Sukajadi'),(327308,3273,'Cidadap'),(327309,3273,'Bandung Wetan'),(327310,3273,'Astana Anyar'),(327311,3273,'Regol'),(327312,3273,'Batununggal'),(327313,3273,'Lengkong'),(327314,3273,'Cibeunying Kidul'),(327315,3273,'Bandung Kulon'),(327316,3273,'Kiaracondong'),(327317,3273,'Bojongloa Kidul'),(327318,3273,'Cibeunying Kaler'),(327319,3273,'Sumur Bandung'),(327320,3273,'Antapani'),(327321,3273,'Bandung Kidul'),(327322,3273,'Buahbatu'),(327323,3273,'Rancasari'),(327324,3273,'Arcamanik'),(327325,3273,'Cibiru'),(327326,3273,'Ujung Berung'),(327327,3273,'Gedebage'),(327328,3273,'Panyileukan'),(327329,3273,'Cinambo'),(327330,3273,'Mandalajati'),(327401,3274,'Kejaksan'),(327402,3274,'Lemah Wungkuk'),(327403,3274,'Harjamukti'),(327404,3274,'Pekalipan'),(327405,3274,'Kesambi'),(327501,3275,'Bekasi Timur'),(327502,3275,'Bekasi Barat'),(327503,3275,'Bekasi Utara'),(327504,3275,'Bekasi Selatan'),(327505,3275,'Rawa Lumbu'),(327506,3275,'Medan Satria'),(327507,3275,'Bantar Gebang'),(327508,3275,'Pondok Gede'),(327509,3275,'Jatiasih'),(327510,3275,'Jati Sempurna'),(327511,3275,'Mustika Jaya'),(327512,3275,'Pondok Melati'),(327601,3276,'Pancoran Mas'),(327602,3276,'Cimanggis'),(327603,3276,'Sawangan'),(327604,3276,'Limo'),(327605,3276,'Sukmajaya'),(327606,3276,'Beji'),(327607,3276,'Cipayung'),(327608,3276,'Cilodong'),(327609,3276,'Cinere'),(327610,3276,'Tapos'),(327611,3276,'Bojongsari'),(327701,3277,'Cimahi Selatan'),(327702,3277,'Cimahi Tengah'),(327703,3277,'Cimahi Utara'),(327801,3278,'Cihideung'),(327802,3278,'Cipedes'),(327803,3278,'Tawang'),(327804,3278,'Indihiang'),(327805,3278,'Kawalu'),(327806,3278,'Cibeureum'),(327807,3278,'Tamansari'),(327808,3278,'Mangkubumi'),(327809,3278,'Bungursari'),(327810,3278,'Purbaratu'),(327901,3279,'Banjar'),(327902,3279,'Pataruman'),(327903,3279,'Purwaharja'),(327904,3279,'Langen Sari'),(330101,3301,'Kedungreja'),(330102,3301,'Kesugihan'),(330103,3301,'Adipala'),(330104,3301,'Binangun'),(330105,3301,'Nusawungu'),(330106,3301,'Kroya'),(330107,3301,'Maos'),(330108,3301,'Jeruklegi'),(330109,3301,'Kawunganten'),(330110,3301,'Gandrungmangu'),(330111,3301,'Sidareja'),(330112,3301,'Karangpucung'),(330113,3301,'Cimanggu'),(330114,3301,'Majenang'),(330115,3301,'Wanareja'),(330116,3301,'Dayeuhluhur'),(330117,3301,'Sampang'),(330118,3301,'Cipari'),(330119,3301,'Patimuan'),(330120,3301,'Bantarsari'),(330121,3301,'Cilacap Selatan'),(330122,3301,'Cilacap Tengah'),(330123,3301,'Cilacap Utara'),(330124,3301,'Kampung Laut'),(330201,3302,'Lumbir'),(330202,3302,'Wangon'),(330203,3302,'Jatilawang'),(330204,3302,'Rawalo'),(330205,3302,'Kebasen'),(330206,3302,'Kemranjen'),(330207,3302,'Sumpiuh'),(330208,3302,'Tambak'),(330209,3302,'Somagede'),(330210,3302,'Kalibagor'),(330211,3302,'Banyumas'),(330212,3302,'Patikraja'),(330213,3302,'Purwojati'),(330214,3302,'Ajibarang'),(330215,3302,'Gumelar'),(330216,3302,'Pekuncen'),(330217,3302,'Cilongok'),(330218,3302,'Karang Lewas'),(330219,3302,'Sokaraja'),(330220,3302,'Kembaran'),(330221,3302,'Sumbang'),(330222,3302,'Baturaden'),(330223,3302,'Kedung Banteng'),(330224,3302,'Purwokerto Selatan'),(330225,3302,'Purwokerto Barat'),(330226,3302,'Purwokerto Timur'),(330227,3302,'Purwokerto Utara'),(330301,3303,'Kemangkon'),(330302,3303,'Bukateja'),(330303,3303,'Kejobong'),(330304,3303,'Kaligondang'),(330305,3303,'Purbalingga'),(330306,3303,'Kalimanah'),(330307,3303,'Kutasari'),(330308,3303,'Mrebet'),(330309,3303,'Bobotsari'),(330310,3303,'Karangreja'),(330311,3303,'Karanganyar'),(330312,3303,'Karangmoncol'),(330313,3303,'Rembang'),(330314,3303,'Bojongsari'),(330315,3303,'Padamara'),(330316,3303,'Pengadegan'),(330317,3303,'Karangjambu'),(330318,3303,'Kertanegara'),(330401,3304,'Susukan'),(330402,3304,'Purworejo Klampok'),(330403,3304,'Mandiraja'),(330404,3304,'Purwonegoro'),(330405,3304,'Bawang'),(330406,3304,'Banjarnegara'),(330407,3304,'Sigaluh'),(330408,3304,'Madukara'),(330409,3304,'Banjarmangu'),(330410,3304,'Wanadadi'),(330411,3304,'Rakit'),(330412,3304,'Punggelan'),(330413,3304,'Karangkobar'),(330414,3304,'Pagentan'),(330415,3304,'Pejawaran'),(330416,3304,'Batur'),(330417,3304,'Wanayasa'),(330418,3304,'Kalibening'),(330419,3304,'Pandanarum'),(330420,3304,'Pagedongan'),(330501,3305,'Ayah'),(330502,3305,'Buayan'),(330503,3305,'Puring'),(330504,3305,'Petanahan'),(330505,3305,'Klirong'),(330506,3305,'Buluspesantren'),(330507,3305,'Ambal'),(330508,3305,'Mirit'),(330509,3305,'Prembun'),(330510,3305,'Kutowinangun'),(330511,3305,'Alian'),(330512,3305,'Kebumen'),(330513,3305,'Pejagoan'),(330514,3305,'Sruweng'),(330515,3305,'Adimulyo'),(330516,3305,'Kuwarasan'),(330517,3305,'Rowokele'),(330518,3305,'Sempor'),(330519,3305,'Gombong'),(330520,3305,'Karanganyar'),(330521,3305,'Karanggayam'),(330522,3305,'Sadang'),(330523,3305,'Bonorowo'),(330524,3305,'Padureso'),(330525,3305,'Poncowarno'),(330526,3305,'Karangsambung'),(330601,3306,'Grabag'),(330602,3306,'Ngombol'),(330603,3306,'Purwodadi'),(330604,3306,'Bagelen'),(330605,3306,'Kaligesing'),(330606,3306,'Purworejo'),(330607,3306,'Banyu Urip'),(330608,3306,'Bayan'),(330609,3306,'Kutoarjo'),(330610,3306,'Butuh'),(330611,3306,'Pituruh'),(330612,3306,'Kemiri'),(330613,3306,'Bruno'),(330614,3306,'Gebang'),(330615,3306,'Loano'),(330616,3306,'Bener'),(330701,3307,'Wadaslintang'),(330702,3307,'Kepil'),(330703,3307,'Sapuran'),(330704,3307,'Kaliwiro'),(330705,3307,'Leksono'),(330706,3307,'Selomerto'),(330707,3307,'Kalikajar'),(330708,3307,'Kertek'),(330709,3307,'Wonosobo'),(330710,3307,'Watumalang'),(330711,3307,'Mojotengah'),(330712,3307,'Garung'),(330713,3307,'Kejajar'),(330714,3307,'Sukoharjo'),(330715,3307,'Kalibawang'),(330801,3308,'Salaman'),(330802,3308,'Borobudur'),(330803,3308,'Ngluwar'),(330804,3308,'Salam'),(330805,3308,'Srumbung'),(330806,3308,'Dukun'),(330807,3308,'Sawangan'),(330808,3308,'Muntilan'),(330809,3308,'Mungkid'),(330810,3308,'Mertoyudan'),(330811,3308,'Tempuran'),(330812,3308,'Kajoran'),(330813,3308,'Kaliangkrik'),(330814,3308,'Bandongan'),(330815,3308,'Candimulyo'),(330816,3308,'Pakis'),(330817,3308,'Ngablak'),(330818,3308,'Grabag'),(330819,3308,'Tegalrejo'),(330820,3308,'Secang'),(330821,3308,'Windusari'),(330901,3309,'Selo'),(330902,3309,'Ampel'),(330903,3309,'Cepogo'),(330904,3309,'Musuk'),(330905,3309,'Boyolali'),(330906,3309,'Mojosongo'),(330907,3309,'Teras'),(330908,3309,'Sawit'),(330909,3309,'Banyudono'),(330910,3309,'Sambi'),(330911,3309,'Ngemplak'),(330912,3309,'Nogosari'),(330913,3309,'Simo'),(330914,3309,'Karanggede'),(330915,3309,'Klego'),(330916,3309,'Andong'),(330917,3309,'Kemusu'),(330918,3309,'Wonosegoro'),(330919,3309,'Juwangi'),(331001,3310,'Prambanan'),(331002,3310,'Gantiwarno'),(331003,3310,'Wedi'),(331004,3310,'Bayat'),(331005,3310,'Cawas'),(331006,3310,'Trucuk'),(331007,3310,'Kebonarum'),(331008,3310,'Jogonalan'),(331009,3310,'Manisrenggo'),(331010,3310,'Karangnongko'),(331011,3310,'Ceper'),(331012,3310,'Pedan'),(331013,3310,'Karangdowo'),(331014,3310,'Juwiring'),(331015,3310,'Wonosari'),(331016,3310,'Delanggu'),(331017,3310,'Polanharjo'),(331018,3310,'Karanganom'),(331019,3310,'Tulung'),(331020,3310,'Jatinom'),(331021,3310,'Kemalang'),(331022,3310,'Ngawen'),(331023,3310,'Kalikotes'),(331024,3310,'Klaten Utara'),(331025,3310,'Klaten Tengah'),(331026,3310,'Klaten Selatan'),(331101,3311,'Weru'),(331102,3311,'Bulu'),(331103,3311,'Tawangsari'),(331104,3311,'Sukoharjo'),(331105,3311,'Nguter'),(331106,3311,'Bendosari'),(331107,3311,'Polokarto'),(331108,3311,'Mojolaban'),(331109,3311,'Grogol'),(331110,3311,'Baki'),(331111,3311,'Gatak'),(331112,3311,'Kartasura'),(331201,3312,'Pracimantoro'),(331202,3312,'Giritontro'),(331203,3312,'Giriwoyo'),(331204,3312,'Batuwarno'),(331205,3312,'Tirtomoyo'),(331206,3312,'Nguntoronadi'),(331207,3312,'Baturetno'),(331208,3312,'Eromoko'),(331209,3312,'Wuryantoro'),(331210,3312,'Manyaran'),(331211,3312,'Selogiri'),(331212,3312,'Wonogiri'),(331213,3312,'Ngadirojo'),(331214,3312,'Sidoarjo'),(331215,3312,'Jatiroto'),(331216,3312,'Kismantoro'),(331217,3312,'Purwantoro'),(331218,3312,'Bulukerto'),(331219,3312,'Slogohimo'),(331220,3312,'Jatisrono'),(331221,3312,'Jatipurno'),(331222,3312,'Girimarto'),(331223,3312,'Karangtengah'),(331224,3312,'Paranggupito'),(331225,3312,'Puhpelem'),(331301,3313,'Jatipuro'),(331302,3313,'Jatiyoso'),(331303,3313,'Jumapolo'),(331304,3313,'Jumantono'),(331305,3313,'Matesih'),(331306,3313,'Tawangmangu'),(331307,3313,'Ngargoyoso'),(331308,3313,'Karangpandan'),(331309,3313,'Karanganyar'),(331310,3313,'Tasikmadu'),(331311,3313,'Jaten'),(331312,3313,'Colomadu'),(331313,3313,'Gondangrejo'),(331314,3313,'Kebakkramat'),(331315,3313,'Mojogedang'),(331316,3313,'Kerjo'),(331317,3313,'Jenawi'),(331401,3314,'Kalijambe'),(331402,3314,'Plupuh'),(331403,3314,'Masaran'),(331404,3314,'Kedawung'),(331405,3314,'Sambirejo'),(331406,3314,'Gondang'),(331407,3314,'Sambungmacan'),(331408,3314,'Ngrampal'),(331409,3314,'Karangmalang'),(331410,3314,'Sragen'),(331411,3314,'Sidoharjo'),(331412,3314,'Tanon'),(331413,3314,'Gemolong'),(331414,3314,'Miri'),(331415,3314,'Sumberlawang'),(331416,3314,'Mondokan'),(331417,3314,'Sukodono'),(331418,3314,'Gesi'),(331419,3314,'Tangen'),(331420,3314,'Jenar'),(331501,3315,'Kedungjati'),(331502,3315,'Karangrayung'),(331503,3315,'Penawangan'),(331504,3315,'Toroh'),(331505,3315,'Geyer'),(331506,3315,'Pulokulon'),(331507,3315,'Kradenan'),(331508,3315,'Gabus'),(331509,3315,'Ngaringan'),(331510,3315,'Wirosari'),(331511,3315,'Tawangharjo'),(331512,3315,'Grobogan'),(331513,3315,'Purwodadi'),(331514,3315,'Brati'),(331515,3315,'Klambu'),(331516,3315,'Godong'),(331517,3315,'Gubug'),(331518,3315,'Tegowanu'),(331519,3315,'Tanggungharjo'),(331601,3316,'Jati'),(331602,3316,'Randublatung'),(331603,3316,'Kradenan'),(331604,3316,'KedungTuban'),(331605,3316,'Cepu'),(331606,3316,'Sambong'),(331607,3316,'Jiken'),(331608,3316,'Jepon'),(331609,3316,'Blora'),(331610,3316,'Tunjungan'),(331611,3316,'Banjarejo'),(331612,3316,'Ngawen'),(331613,3316,'Kunduran'),(331614,3316,'Todanan'),(331615,3316,'Bogorejo'),(331616,3316,'Japah'),(331701,3317,'Sumber'),(331702,3317,'Bulu'),(331703,3317,'Gunem'),(331704,3317,'Sale'),(331705,3317,'Sarang'),(331706,3317,'Sedan'),(331707,3317,'Pamotan'),(331708,3317,'Sulang'),(331709,3317,'Kaliori'),(331710,3317,'Rembang'),(331711,3317,'Pancur'),(331712,3317,'Kragan'),(331713,3317,'Sluke'),(331714,3317,'Lasem'),(331801,3318,'Sukolilo'),(331802,3318,'Kayen'),(331803,3318,'Tambakromo'),(331804,3318,'Winong'),(331805,3318,'Pucakwangi'),(331806,3318,'Jaken'),(331807,3318,'Batangan'),(331808,3318,'Juwana'),(331809,3318,'Jakenan'),(331810,3318,'Pati'),(331811,3318,'Gabus'),(331812,3318,'Margorejo'),(331813,3318,'Gembong'),(331814,3318,'Tlogowungu'),(331815,3318,'Wedarijaksa'),(331816,3318,'Margoyoso'),(331817,3318,'Gunungwungkal'),(331818,3318,'Cluwak'),(331819,3318,'Tayu'),(331820,3318,'Dukuhseti'),(331821,3318,'Trangkil'),(331901,3319,'Kaliwungu'),(331902,3319,'Kudus'),(331903,3319,'Jati'),(331904,3319,'Undaan'),(331905,3319,'Mejobo'),(331906,3319,'Jekulo'),(331907,3319,'Bae'),(331908,3319,'Gebog'),(331909,3319,'Dawe'),(332001,3320,'Kedung'),(332002,3320,'Pecangaan'),(332003,3320,'Welahan'),(332004,3320,'Mayong'),(332005,3320,'Batealit'),(332006,3320,'Jepara'),(332007,3320,'Mlonggo'),(332008,3320,'Bangsri'),(332009,3320,'Keling'),(332010,3320,'Karimun Jawa'),(332011,3320,'Tahunan'),(332012,3320,'Nalumsari'),(332013,3320,'Kalinyamatan'),(332014,3320,'Kembang'),(332015,3320,'Pakis Aji'),(332016,3320,'Donorojo'),(332101,3321,'Mranggen'),(332102,3321,'Karangawen'),(332103,3321,'Guntur'),(332104,3321,'Sayung'),(332105,3321,'Karangtengah'),(332106,3321,'Wonosalam'),(332107,3321,'Dempet'),(332108,3321,'Gajah'),(332109,3321,'Karanganyar'),(332110,3321,'Mijen'),(332111,3321,'Demak'),(332112,3321,'Bonang'),(332113,3321,'Wedung'),(332114,3321,'Kebonagung'),(332201,3322,'Getasan'),(332202,3322,'Tengaran'),(332203,3322,'Susukan'),(332204,3322,'Suruh'),(332205,3322,'Pabelan'),(332206,3322,'Tuntang'),(332207,3322,'Banyubiru'),(332208,3322,'Jambu'),(332209,3322,'Sumowono'),(332210,3322,'Ambarawa'),(332211,3322,'Bawen'),(332212,3322,'Bringin'),(332213,3322,'Bergas'),(332215,3322,'Pringapus'),(332216,3322,'Bancak'),(332217,3322,'Kaliwungu'),(332218,3322,'Ungaran Barat'),(332219,3322,'Ungaran Timur'),(332220,3322,'Bandungan'),(332301,3323,'Bulu'),(332302,3323,'Tembarak'),(332303,3323,'Temanggung'),(332304,3323,'Pringsurat'),(332305,3323,'Kaloran'),(332306,3323,'Kandangan'),(332307,3323,'Kedu'),(332308,3323,'Parakan'),(332309,3323,'Ngadirejo'),(332310,3323,'Jumo'),(332311,3323,'Tretep'),(332312,3323,'Candiroto'),(332313,3323,'Kranggan'),(332314,3323,'Tlogomulyo'),(332315,3323,'Selopampang'),(332316,3323,'Bansari'),(332317,3323,'Kledung'),(332318,3323,'Bejen'),(332319,3323,'Wonoboyo'),(332320,3323,'Gemawang'),(332401,3324,'Plantungan'),(332402,3324,'Pageruyung'),(332403,3324,'Sukorejo'),(332404,3324,'Patean'),(332405,3324,'Singorojo'),(332406,3324,'Limbangan'),(332407,3324,'Boja'),(332408,3324,'Kaliwungu'),(332409,3324,'Brangsong'),(332410,3324,'Pegandon'),(332411,3324,'Gemuh'),(332412,3324,'Weleri'),(332413,3324,'Cepiring'),(332414,3324,'Patebon'),(332415,3324,'Kendal'),(332416,3324,'Rowosari'),(332417,3324,'Kangkung'),(332418,3324,'Ringinarum'),(332419,3324,'Ngampel'),(332420,3324,'Kaliwungu Selatan'),(332501,3325,'Wonotunggal'),(332502,3325,'Bandar'),(332503,3325,'Blado'),(332504,3325,'Reban'),(332505,3325,'Bawang'),(332506,3325,'Tersono'),(332507,3325,'Gringsing'),(332508,3325,'Limpung'),(332509,3325,'Subah'),(332510,3325,'Tulis'),(332511,3325,'Batang'),(332512,3325,'Warungasem'),(332513,3325,'Kandeman'),(332514,3325,'Pencalungan'),(332515,3325,'Banyuputih'),(332601,3326,'Kandangserang'),(332602,3326,'Paninggaran'),(332603,3326,'Lebakbarang'),(332604,3326,'Petungkriyono'),(332605,3326,'Talun'),(332606,3326,'Doro'),(332607,3326,'Karanganyar'),(332608,3326,'Kajen'),(332609,3326,'Kesesi'),(332610,3326,'Sragi'),(332611,3326,'Bojong'),(332612,3326,'Wonopringgo'),(332613,3326,'Kedungwuni'),(332614,3326,'Buaran'),(332615,3326,'Tirto'),(332616,3326,'Wiradesa'),(332617,3326,'Siwalan'),(332618,3326,'Karangdadap'),(332619,3326,'Wonokerto'),(332701,3327,'Moga'),(332702,3327,'Pulosari'),(332703,3327,'Belik'),(332704,3327,'Watukumpul'),(332705,3327,'Bodeh'),(332706,3327,'Bantarbolang'),(332707,3327,'Randudongkal'),(332708,3327,'Pemalang'),(332709,3327,'Taman'),(332710,3327,'Petarukan'),(332711,3327,'Ampelgading'),(332712,3327,'Comal'),(332713,3327,'Ulujami'),(332714,3327,'Warungpring'),(332801,3328,'Margasari'),(332802,3328,'Bumijawa'),(332803,3328,'Bojong'),(332804,3328,'Balapulang'),(332805,3328,'Pagerbarang'),(332806,3328,'Lebaksiu'),(332807,3328,'Jatinegara'),(332808,3328,'Kedungbanteng'),(332809,3328,'Pangkah'),(332810,3328,'Slawi'),(332811,3328,'Adiwerna'),(332812,3328,'Talang'),(332813,3328,'Dukuhturi'),(332814,3328,'Tarub'),(332815,3328,'Kramat'),(332816,3328,'Suradadi'),(332817,3328,'Warureja'),(332818,3328,'Dukuhwaru'),(332901,3329,'Salem'),(332902,3329,'Bantarkawung'),(332903,3329,'Bumiayu'),(332904,3329,'Paguyangan'),(332905,3329,'Sirampog'),(332906,3329,'Tonjong'),(332907,3329,'Jatibarang'),(332908,3329,'Wanasari'),(332909,3329,'Brebes'),(332910,3329,'Songgom'),(332911,3329,'Kersana'),(332912,3329,'Losari'),(332913,3329,'Tanjung'),(332914,3329,'Bulakamba'),(332915,3329,'Larangan'),(332916,3329,'Ketanggungan'),(332917,3329,'Banjarharjo'),(337101,3371,'Magelang Selatan'),(337102,3371,'Magelang Utara'),(337103,3371,'Magelang Tengah'),(337201,3372,'Laweyan'),(337202,3372,'Serengan'),(337203,3372,'Pasar Kliwon'),(337204,3372,'Jebres'),(337205,3372,'Banjarsari'),(337301,3373,'Sidorejo'),(337302,3373,'Tingkir'),(337303,3373,'Argomulyo'),(337304,3373,'Sidomukti'),(337401,3374,'Semarang Tengah'),(337402,3374,'Semarang Utara'),(337403,3374,'Semarang Timur'),(337404,3374,'Gayam Sari'),(337405,3374,'Genuk'),(337406,3374,'Pedurungan'),(337407,3374,'Semarang Selatan'),(337408,3374,'Candisari'),(337409,3374,'Gajah Mungkur'),(337410,3374,'Tembalang'),(337411,3374,'Banyumanik'),(337412,3374,'Gunungpati'),(337413,3374,'Semarang Barat'),(337414,3374,'Mijen'),(337415,3374,'Ngaliyan'),(337416,3374,'Tugu'),(337501,3375,'Pekalongan Barat'),(337502,3375,'Pekalongan Timur'),(337503,3375,'Pekalongan Utara'),(337504,3375,'Pekalongan Selatan'),(337601,3376,'Tegal Barat'),(337602,3376,'Tegal Timur'),(337603,3376,'Tegal Selatan'),(337604,3376,'Margadana'),(340101,3401,'Temon'),(340102,3401,'Wates'),(340103,3401,'Panjatan'),(340104,3401,'Galur'),(340105,3401,'Lendah'),(340106,3401,'Sentolo'),(340107,3401,'Pengasih'),(340108,3401,'Kokap'),(340109,3401,'Girimulyo'),(340110,3401,'Nanggulan'),(340111,3401,'Samigaluh'),(340112,3401,'Kalibawang'),(340201,3402,'Srandakan'),(340202,3402,'Sanden'),(340203,3402,'Kretek'),(340204,3402,'Pundong'),(340205,3402,'Bambang Lipuro'),(340206,3402,'Pandak'),(340207,3402,'Pajangan'),(340208,3402,'Bantul'),(340209,3402,'Jetis'),(340210,3402,'Imogiri'),(340211,3402,'Dlingo'),(340212,3402,'Banguntapan'),(340213,3402,'Pleret'),(340214,3402,'Piyungan'),(340215,3402,'Sewon'),(340216,3402,'Kasihan'),(340217,3402,'Sedayu'),(340301,3403,'Wonosari'),(340302,3403,'Nglipar'),(340303,3403,'Playen'),(340304,3403,'Patuk'),(340305,3403,'Paliyan'),(340306,3403,'Panggang'),(340307,3403,'Tepus'),(340308,3403,'Semanu'),(340309,3403,'Karangmojo'),(340310,3403,'Ponjong'),(340311,3403,'Rongkop'),(340312,3403,'Semin'),(340313,3403,'Ngawen'),(340314,3403,'Gedangsari'),(340315,3403,'Saptosari'),(340316,3403,'Girisubo'),(340317,3403,'Tanjungsari'),(340318,3403,'Purwosari'),(340401,3404,'Gamping'),(340402,3404,'Godean'),(340403,3404,'Moyudan'),(340404,3404,'Minggir'),(340405,3404,'Seyegan'),(340406,3404,'Mlati'),(340407,3404,'Depok'),(340408,3404,'Berbah'),(340409,3404,'Prambanan'),(340410,3404,'Kalasan'),(340411,3404,'Ngemplak'),(340412,3404,'Ngaglik'),(340413,3404,'Sleman'),(340414,3404,'Tempel'),(340415,3404,'Turi'),(340416,3404,'Pakem'),(340417,3404,'Cangkringan'),(347101,3471,'Tegalrejo'),(347102,3471,'Jetis'),(347103,3471,'Gondokusuman'),(347104,3471,'Danurejan'),(347105,3471,'Gedongtengen'),(347106,3471,'Ngampilan'),(347107,3471,'Wirobrajan'),(347108,3471,'Mantrijeron'),(347109,3471,'Kraton'),(347110,3471,'Gondomanan'),(347111,3471,'Pakualaman'),(347112,3471,'Mergangsan'),(347113,3471,'Umbulharjo'),(347114,3471,'Kotagede'),(350101,3501,'Donorojo'),(350102,3501,'Pringkuku'),(350103,3501,'Punung'),(350104,3501,'Pacitan'),(350105,3501,'Kebonagung'),(350106,3501,'Arjosari'),(350107,3501,'Nawangan'),(350108,3501,'Bandar'),(350109,3501,'Tegalombo'),(350110,3501,'Tulakan'),(350111,3501,'Ngadirojo'),(350112,3501,'Sudimoro'),(350201,3502,'Slahung'),(350202,3502,'Ngrayun'),(350203,3502,'Bungkal'),(350204,3502,'Sambit'),(350205,3502,'Sawoo'),(350206,3502,'Sooko'),(350207,3502,'Pulung'),(350208,3502,'Mlarak'),(350209,3502,'Jetis'),(350210,3502,'Siman'),(350211,3502,'Balong'),(350212,3502,'Kauman'),(350213,3502,'Badegan'),(350214,3502,'Sampung'),(350215,3502,'Sukorejo'),(350216,3502,'Babadan'),(350217,3502,'Ponorogo'),(350218,3502,'Jenangan'),(350219,3502,'Ngebel'),(350220,3502,'Jambon'),(350221,3502,'Pudak'),(350301,3503,'Panggul'),(350302,3503,'Munjungan'),(350303,3503,'Pule'),(350304,3503,'Dongko'),(350305,3503,'Tugu'),(350306,3503,'Karangan'),(350307,3503,'Kampak'),(350308,3503,'Watulimo'),(350309,3503,'Bendungan'),(350310,3503,'Gandusari'),(350311,3503,'Trenggalek'),(350312,3503,'Pogalan'),(350313,3503,'Durenan'),(350314,3503,'Suruh'),(350401,3504,'Tulungagung'),(350402,3504,'Boyolangu'),(350403,3504,'Kedungwaru'),(350404,3504,'Ngantru'),(350405,3504,'Kauman'),(350406,3504,'Pagerwojo'),(350407,3504,'Sendang'),(350408,3504,'Karangrejo'),(350409,3504,'Gondang'),(350410,3504,'Sumbergempol'),(350411,3504,'Ngunut'),(350412,3504,'Pucanglaban'),(350413,3504,'Rejotangan'),(350414,3504,'Kalidawir'),(350415,3504,'Besuki'),(350416,3504,'Campurdarat'),(350417,3504,'Bandung'),(350418,3504,'Pakel'),(350419,3504,'Tanggunggunung'),(350501,3505,'Wonodadi'),(350502,3505,'Udanawu'),(350503,3505,'Srengat'),(350504,3505,'Kademangan'),(350505,3505,'Bakung'),(350506,3505,'Ponggok'),(350507,3505,'Sanankulon'),(350508,3505,'Wonotirto'),(350509,3505,'Nglegok'),(350510,3505,'Kanigoro'),(350511,3505,'Garum'),(350512,3505,'Sutojayan'),(350513,3505,'Panggungrejo'),(350514,3505,'Talun'),(350515,3505,'Gandusari'),(350516,3505,'Binangun'),(350517,3505,'Wlingi'),(350518,3505,'Doko'),(350519,3505,'Kesamben'),(350520,3505,'Wates'),(350521,3505,'Selorejo'),(350522,3505,'Selopuro'),(350601,3506,'Semen'),(350602,3506,'Mojo'),(350603,3506,'Kras'),(350604,3506,'Ngadiluwih'),(350605,3506,'Kandat'),(350606,3506,'Wates'),(350607,3506,'Ngancar'),(350608,3506,'Puncu'),(350609,3506,'Plosoklaten'),(350610,3506,'Gurah'),(350611,3506,'Pagu'),(350612,3506,'Gampengrejo'),(350613,3506,'Grogol'),(350614,3506,'Papar'),(350615,3506,'Purwoasri'),(350616,3506,'Plemahan'),(350617,3506,'Pare'),(350618,3506,'Kepung'),(350619,3506,'Kandangan'),(350620,3506,'Tarokan'),(350621,3506,'Kunjang'),(350622,3506,'Banyakan'),(350623,3506,'Ringinrejo'),(350624,3506,'Kayen Kidul'),(350625,3506,'Ngasem'),(350626,3506,'Badas'),(350701,3507,'Donomulyo'),(350702,3507,'Pagak'),(350703,3507,'Bantur'),(350704,3507,'Sumbermanjing Wetan'),(350705,3507,'Dampit'),(350706,3507,'Ampelgading'),(350707,3507,'Poncokusumo'),(350708,3507,'Wajak'),(350709,3507,'Turen'),(350710,3507,'Gondanglegi'),(350711,3507,'Kalipare'),(350712,3507,'Sumberpucung'),(350713,3507,'Kepanjen'),(350714,3507,'Bululawang'),(350715,3507,'Tajinan'),(350716,3507,'Tumpang'),(350717,3507,'Jabung'),(350718,3507,'Pakis'),(350719,3507,'Pakisaji'),(350720,3507,'Ngajung'),(350721,3507,'Wagir'),(350722,3507,'Dau'),(350723,3507,'Karang Ploso'),(350724,3507,'Singosari'),(350725,3507,'Lawang'),(350726,3507,'Pujon'),(350727,3507,'Ngantang'),(350728,3507,'Kasembon'),(350729,3507,'Gedangan'),(350730,3507,'Tirtoyudo'),(350731,3507,'Kromengan'),(350732,3507,'Wonosari'),(350733,3507,'Pagelaran'),(350801,3508,'Tempursari'),(350802,3508,'Pronojiwo'),(350803,3508,'Candipuro'),(350804,3508,'Pasirian'),(350805,3508,'Tempeh'),(350806,3508,'Kunir'),(350807,3508,'Yosowilangun'),(350808,3508,'Rowokangkung'),(350809,3508,'Tekung'),(350810,3508,'Lumajang'),(350811,3508,'Pasrujambe'),(350812,3508,'Senduro'),(350813,3508,'Gucialit'),(350814,3508,'Padang'),(350815,3508,'Sukodono'),(350816,3508,'Kedungjajang'),(350817,3508,'Jatiroto'),(350818,3508,'Randuagung'),(350819,3508,'Klakah'),(350820,3508,'Ranuyoso'),(350821,3508,'Sumbersuko'),(350901,3509,'Jombang'),(350902,3509,'Kencong'),(350903,3509,'Sumberbaru'),(350904,3509,'Gumukmas'),(350905,3509,'Umbulsari'),(350906,3509,'Tanggul'),(350907,3509,'Semboro'),(350908,3509,'Puger'),(350909,3509,'Bangsalsari'),(350910,3509,'Balung'),(350911,3509,'Wuluhan'),(350912,3509,'Ambulu'),(350913,3509,'Rambipuji'),(350914,3509,'Panti'),(350915,3509,'Sukorambi'),(350916,3509,'Jenggawah'),(350917,3509,'Ajung'),(350918,3509,'Tempurejo'),(350919,3509,'Kaliwates'),(350920,3509,'Patrang'),(350921,3509,'Sumbersari'),(350922,3509,'Arjasa'),(350923,3509,'Mumbulsari'),(350924,3509,'Pakusari'),(350925,3509,'Jelbuk'),(350926,3509,'Mayang'),(350927,3509,'Kalisat'),(350928,3509,'Ledokombo'),(350929,3509,'Sukowono'),(350930,3509,'Silo'),(350931,3509,'Sumberjambe'),(351001,3510,'Pesanggaran'),(351002,3510,'Bangorejo'),(351003,3510,'Purwoharjo'),(351004,3510,'Tegaldlimo'),(351005,3510,'Muncar'),(351006,3510,'Cluring'),(351007,3510,'Gambiran'),(351008,3510,'Srono'),(351009,3510,'Genteng'),(351010,3510,'Glenmore'),(351011,3510,'Kalibaru'),(351012,3510,'Singojuruh'),(351013,3510,'Rogojampi'),(351014,3510,'Kabat'),(351015,3510,'Glagah'),(351016,3510,'Banyuwangi'),(351017,3510,'Giri'),(351018,3510,'Wongsorejo'),(351019,3510,'Songgon'),(351020,3510,'Sempu'),(351021,3510,'Kalipuro'),(351022,3510,'Siliragung'),(351023,3510,'Tegalsari'),(351024,3510,'Licin'),(351101,3511,'Maesan'),(351102,3511,'Tamanan'),(351103,3511,'Tlogosari'),(351104,3511,'Sukosari'),(351105,3511,'Pujer'),(351106,3511,'Grujugan'),(351107,3511,'Curahdami'),(351108,3511,'Tenggarang'),(351109,3511,'Wonosari'),(351110,3511,'Tapen'),(351111,3511,'Bondowoso'),(351112,3511,'Wringin'),(351113,3511,'Tegalampel'),(351114,3511,'Klabang'),(351115,3511,'Cermee'),(351116,3511,'Prajekan'),(351117,3511,'Pakem'),(351118,3511,'Sumberwringin'),(351119,3511,'Sempol'),(351120,3511,'Binakal'),(351121,3511,'Taman Krocok'),(351122,3511,'Botolinggo'),(351123,3511,'Jambesari Darus Sholah'),(351201,3512,'Jatibanteng'),(351202,3512,'Besuki'),(351203,3512,'Suboh'),(351204,3512,'Mlandingan'),(351205,3512,'Kendit'),(351206,3512,'Panarukan'),(351207,3512,'Situbondo'),(351208,3512,'Panji'),(351209,3512,'Mangaran'),(351210,3512,'Kapongan'),(351211,3512,'Arjasa'),(351212,3512,'Jangkar'),(351213,3512,'Asembagus'),(351214,3512,'Banyuputih'),(351215,3512,'Sumbermalang'),(351216,3512,'Banyuglugur'),(351217,3512,'Bungatan'),(351301,3513,'Sukapura'),(351302,3513,'Sumber'),(351303,3513,'Kuripan'),(351304,3513,'Bantaran'),(351305,3513,'Leces'),(351306,3513,'Banyuanyar'),(351307,3513,'Tiris'),(351308,3513,'Krucil'),(351309,3513,'Gading'),(351310,3513,'Pakuniran'),(351311,3513,'Kotaanyar'),(351312,3513,'Paiton'),(351313,3513,'Besuk'),(351314,3513,'Kraksaan'),(351315,3513,'Krejengan'),(351316,3513,'Pejarakan'),(351317,3513,'Maron'),(351318,3513,'Gending'),(351319,3513,'Dringu'),(351320,3513,'Tegalsiwalan'),(351321,3513,'Sumberasih'),(351322,3513,'Wonomerto'),(351323,3513,'Tongas'),(351324,3513,'Lumbang'),(351401,3514,'Purwodadi'),(351402,3514,'Tutur'),(351403,3514,'Puspo'),(351404,3514,'Lumbang'),(351405,3514,'Pasrepan'),(351406,3514,'Kejayan'),(351407,3514,'Wonorejo'),(351408,3514,'Purwosari'),(351409,3514,'Sukorejo'),(351410,3514,'Prigen'),(351411,3514,'Pandaan'),(351412,3514,'Gempol'),(351413,3514,'Beji'),(351414,3514,'Bangil'),(351415,3514,'Rembang'),(351416,3514,'Kraton'),(351417,3514,'Pohjentrek'),(351418,3514,'Gondangwetan'),(351419,3514,'Winongan'),(351420,3514,'Grati'),(351421,3514,'Nguling'),(351422,3514,'Lekok'),(351423,3514,'Rejoso'),(351424,3514,'Tosari'),(351501,3515,'Tarik'),(351502,3515,'Prambon'),(351503,3515,'Krembung'),(351504,3515,'Porong'),(351505,3515,'Jabon'),(351506,3515,'Tanggulangin'),(351507,3515,'Candi'),(351508,3515,'Sidoarjo'),(351509,3515,'Tulangan'),(351510,3515,'Wonoayu'),(351511,3515,'Krian'),(351512,3515,'Balongbendo'),(351513,3515,'Taman'),(351514,3515,'Sukodono'),(351515,3515,'Buduran'),(351516,3515,'Gedangan'),(351517,3515,'Sedati'),(351518,3515,'Waru'),(351601,3516,'Jatirejo'),(351602,3516,'Gondang'),(351603,3516,'Pacet'),(351604,3516,'Trawas'),(351605,3516,'Ngoro'),(351606,3516,'Pungging'),(351607,3516,'Kutorejo'),(351608,3516,'Mojosari'),(351609,3516,'Dlanggu'),(351610,3516,'Bangsal'),(351611,3516,'Puri'),(351612,3516,'Trowulan'),(351613,3516,'Sooko'),(351614,3516,'Gedeg'),(351615,3516,'Kemlagi'),(351616,3516,'Jetis'),(351617,3516,'Dawarblandong'),(351618,3516,'Mojoanyar'),(351701,3517,'Perak'),(351702,3517,'Gudo'),(351703,3517,'Ngoro'),(351704,3517,'Bareng'),(351705,3517,'Wonosalam'),(351706,3517,'Mojoagung'),(351707,3517,'Mojowarno'),(351708,3517,'Diwek'),(351709,3517,'Jombang'),(351710,3517,'Peterongan'),(351711,3517,'Sumobito'),(351712,3517,'Kesamben'),(351713,3517,'Tembelang'),(351714,3517,'Ploso'),(351715,3517,'Plandaan'),(351716,3517,'Kabuh'),(351717,3517,'Kudu'),(351718,3517,'Bandarkedungmulyo'),(351719,3517,'Jogoroto'),(351720,3517,'Megaluh'),(351721,3517,'Ngusikan'),(351801,3518,'Sawahan'),(351802,3518,'Ngetos'),(351803,3518,'Berbek'),(351804,3518,'Loceret'),(351805,3518,'Pace'),(351806,3518,'Prambon'),(351807,3518,'Ngronggot'),(351808,3518,'Kertosono'),(351809,3518,'Patianrowo'),(351810,3518,'Baron'),(351811,3518,'Tanjunganom'),(351812,3518,'Sukomoro'),(351813,3518,'Nganjuk'),(351814,3518,'Bagor'),(351815,3518,'Wilangan'),(351816,3518,'Rejoso'),(351817,3518,'Gondang'),(351818,3518,'Ngluyu'),(351819,3518,'Lengkong'),(351820,3518,'Jatikalen'),(351901,3519,'Kebon Sari'),(351902,3519,'Dolopo'),(351903,3519,'Geger'),(351904,3519,'Dagangan'),(351905,3519,'Kare'),(351906,3519,'Gemarang'),(351907,3519,'Wungu'),(351908,3519,'Madiun'),(351909,3519,'Jiwan'),(351910,3519,'Balerejo'),(351911,3519,'Mejayan'),(351912,3519,'Saradan'),(351913,3519,'Pilangkenceng'),(351914,3519,'Sawahan'),(351915,3519,'Wonoasri'),(352001,3520,'Poncol'),(352002,3520,'Parang'),(352003,3520,'Lembeyan'),(352004,3520,'Takeran'),(352005,3520,'Kawedanan'),(352006,3520,'Magetan'),(352007,3520,'Plaosan'),(352008,3520,'Panekan'),(352009,3520,'Sukomoro'),(352010,3520,'Bendo'),(352011,3520,'Maospati'),(352012,3520,'Barat'),(352013,3520,'Karangrejo'),(352014,3520,'Karas'),(352015,3520,'Kartoharjo'),(352016,3520,'Ngariboyo'),(352017,3520,'Nguntoronadi'),(352018,3520,'Sidorejo'),(352101,3521,'Sine'),(352102,3521,'Ngrambe'),(352103,3521,'Jogorogo'),(352104,3521,'Kendal'),(352105,3521,'Geneng'),(352106,3521,'Kwadungan'),(352107,3521,'Karangjati'),(352108,3521,'Padas'),(352109,3521,'Ngawi'),(352110,3521,'Paron'),(352111,3521,'Kedunggalar'),(352112,3521,'Widodaren'),(352113,3521,'Mantingan'),(352114,3521,'Pangkur'),(352115,3521,'Bringin'),(352116,3521,'Pitu'),(352117,3521,'Karanganyar'),(352118,3521,'Gerih'),(352119,3521,'Kasreman'),(352201,3522,'Ngraho'),(352202,3522,'Tambakrejo'),(352203,3522,'Ngambon'),(352204,3522,'Ngasem'),(352205,3522,'Bubulan'),(352206,3522,'Dander'),(352207,3522,'Sugihwaras'),(352208,3522,'Kedungadem'),(352209,3522,'Kepoh Baru'),(352210,3522,'Baureno'),(352211,3522,'Kanor'),(352212,3522,'Sumberejo'),(352213,3522,'Balen'),(352214,3522,'Kapas'),(352215,3522,'Bojonegoro'),(352216,3522,'Kalitidu'),(352217,3522,'Malo'),(352218,3522,'Purwosari'),(352219,3522,'Padangan'),(352220,3522,'Kasiman'),(352221,3522,'Temayang'),(352222,3522,'Margomulyo'),(352223,3522,'Trucuk'),(352224,3522,'Sukosewu'),(352225,3522,'Kedewan'),(352226,3522,'Gondang'),(352227,3522,'Sekar'),(352228,3522,'Gayam'),(352301,3523,'Kenduruan'),(352302,3523,'Jatirogo'),(352303,3523,'Bangilan'),(352304,3523,'Bancar'),(352305,3523,'Senori'),(352306,3523,'Tambakboyo'),(352307,3523,'Singgahan'),(352308,3523,'Kerek'),(352309,3523,'Parengan'),(352310,3523,'Montong'),(352311,3523,'Soko'),(352312,3523,'Jenu'),(352313,3523,'Merakurak'),(352314,3523,'Rengel'),(352315,3523,'Semanding'),(352316,3523,'Tuban'),(352317,3523,'Plumpang'),(352318,3523,'Palang'),(352319,3523,'Widang'),(352320,3523,'Grabagan'),(352401,3524,'Sukorame'),(352402,3524,'Bluluk'),(352403,3524,'Modo'),(352404,3524,'Ngimbang'),(352405,3524,'Babat'),(352406,3524,'Kedungpring'),(352407,3524,'Brondong'),(352408,3524,'Laren'),(352409,3524,'Sekaran'),(352410,3524,'Maduran'),(352411,3524,'Sambeng'),(352412,3524,'Sugio'),(352413,3524,'Pucuk'),(352414,3524,'Paciran'),(352415,3524,'Solokuro'),(352416,3524,'Mantup'),(352417,3524,'Sukodadi'),(352418,3524,'Karanggeneng'),(352419,3524,'Kembangbahu'),(352420,3524,'Kalitengah'),(352421,3524,'Turi'),(352422,3524,'Lamongan'),(352423,3524,'Tikung'),(352424,3524,'Karangbinangun'),(352425,3524,'Deket'),(352426,3524,'Glagah'),(352427,3524,'Sarirejo'),(352501,3525,'Dukun'),(352502,3525,'Balongpanggang'),(352503,3525,'Panceng'),(352504,3525,'Benjeng'),(352505,3525,'Duduksampeyan'),(352506,3525,'Wringinanom'),(352507,3525,'Ujungpangkah'),(352508,3525,'Kedamean'),(352509,3525,'Sidayu'),(352510,3525,'Manyar'),(352511,3525,'Cerme'),(352512,3525,'Bungah'),(352513,3525,'Menganti'),(352514,3525,'Kebomas'),(352515,3525,'Driyorejo'),(352516,3525,'Gresik'),(352517,3525,'Sangkapura'),(352518,3525,'Tambak'),(352601,3526,'Bangkalan'),(352602,3526,'Socah'),(352603,3526,'Burneh'),(352604,3526,'Kamal'),(352605,3526,'Arosbaya'),(352606,3526,'Geger'),(352607,3526,'Klampis'),(352608,3526,'Sepulu'),(352609,3526,'Tanjung Bumi'),(352610,3526,'Kokop'),(352611,3526,'Kwanyar'),(352612,3526,'Labang'),(352613,3526,'Tanah Merah'),(352614,3526,'Tragah'),(352615,3526,'Blega'),(352616,3526,'Modung'),(352617,3526,'Konang'),(352618,3526,'Galis'),(352701,3527,'Sreseh'),(352702,3527,'Torjun'),(352703,3527,'Sampang'),(352704,3527,'Camplong'),(352705,3527,'Omben'),(352706,3527,'Kedungdung'),(352707,3527,'Jrengik'),(352708,3527,'Tambelangan'),(352709,3527,'Banyuates'),(352710,3527,'Robatal'),(352711,3527,'Sokobanah'),(352712,3527,'Ketapang'),(352713,3527,'Pangarengan'),(352714,3527,'Karangpenang'),(352801,3528,'Tlanakan'),(352802,3528,'Pademawu'),(352803,3528,'Galis'),(352804,3528,'Pamekasan'),(352805,3528,'Proppo'),(352806,3528,'Palenga\"an'),(352807,3528,'Pegantenan'),(352808,3528,'Larangan'),(352809,3528,'Pakong'),(352810,3528,'Waru'),(352811,3528,'Batumarmar'),(352812,3528,'Kadur'),(352813,3528,'Pasean'),(352901,3529,'Kota Sumenep'),(352902,3529,'Kalianget'),(352903,3529,'Manding'),(352904,3529,'Talango'),(352905,3529,'Bluto'),(352906,3529,'Saronggi'),(352907,3529,'Lenteng'),(352908,3529,'Gili Ginting'),(352909,3529,'Guluk-Guluk'),(352910,3529,'Ganding'),(352911,3529,'Pragaan'),(352912,3529,'Ambunten'),(352913,3529,'Pasongsongan'),(352914,3529,'Dasuk'),(352915,3529,'Rubaru'),(352916,3529,'Batang Batang'),(352917,3529,'Batu Putih'),(352918,3529,'Dungkek'),(352919,3529,'Gapura'),(352920,3529,'Gayam'),(352921,3529,'Nonggunong'),(352922,3529,'Ra\"as'),(352923,3529,'Masalembu'),(352924,3529,'Arjasa'),(352925,3529,'Sapeken'),(352926,3529,'Batuan'),(352927,3529,'Kangayan'),(357101,3571,'Mojoroto'),(357102,3571,'Kota'),(357103,3571,'Pesantren'),(357201,3572,'Kepanjenkidul'),(357202,3572,'Sukorejo'),(357203,3572,'Sananwetan'),(357301,3573,'Blimbing'),(357302,3573,'Klojen'),(357303,3573,'Kedungkandang'),(357304,3573,'Sukun'),(357305,3573,'Lowokwaru'),(357401,3574,'Kademangan'),(357402,3574,'Wonoasih'),(357403,3574,'Mayangan'),(357404,3574,'Kanigaran'),(357405,3574,'Kedopak'),(357501,3575,'Gadingrejo'),(357502,3575,'Purworejo'),(357503,3575,'Bugul Kidul'),(357504,3575,'Panggungrejo'),(357601,3576,'Prajurit Kulon'),(357602,3576,'Magersari'),(357701,3577,'Kartoharjo'),(357702,3577,'Manguharjo'),(357703,3577,'Taman'),(357801,3578,'Karangpilang'),(357802,3578,'Wonocolo'),(357803,3578,'Rungkut'),(357804,3578,'Wonokromo'),(357805,3578,'Tegalsari'),(357806,3578,'Sawahan'),(357807,3578,'Genteng'),(357808,3578,'Gubeng'),(357809,3578,'Sukolilo'),(357810,3578,'Tambaksari'),(357811,3578,'Simokerto'),(357812,3578,'Pabean Cantikan'),(357813,3578,'Bubutan'),(357814,3578,'Tandes'),(357815,3578,'Krembangan'),(357816,3578,'Semampir'),(357817,3578,'Kenjeran'),(357818,3578,'Lakarsantri'),(357819,3578,'Benowo'),(357820,3578,'Wiyung'),(357821,3578,'Dukuhpakis'),(357822,3578,'Gayungan'),(357823,3578,'Jambangan'),(357824,3578,'Tenggilis Mejoyo'),(357825,3578,'Gunung Anyar'),(357826,3578,'Mulyorejo'),(357827,3578,'Sukomanunggal'),(357828,3578,'Asem Rowo'),(357829,3578,'Bulak'),(357830,3578,'Pakal'),(357831,3578,'Sambikerep'),(357901,3579,'Batu'),(357902,3579,'Bumiaji'),(357903,3579,'Junrejo'),(360101,3601,'Sumur'),(360102,3601,'Cimanggu'),(360103,3601,'Cibaliung'),(360104,3601,'Cikeusik'),(360105,3601,'Cigeulis'),(360106,3601,'Panimbang'),(360107,3601,'Angsana'),(360108,3601,'Munjul'),(360109,3601,'Pagelaran'),(360110,3601,'Bojong'),(360111,3601,'Picung'),(360112,3601,'Labuan'),(360113,3601,'Menes'),(360114,3601,'Saketi'),(360115,3601,'Cipeucang'),(360116,3601,'Jiput'),(360117,3601,'Mandalawangi'),(360118,3601,'Cimanuk'),(360119,3601,'Kaduhejo'),(360120,3601,'Banjar'),(360121,3601,'Pandeglang'),(360122,3601,'Cadasari'),(360123,3601,'Cisata'),(360124,3601,'Patia'),(360125,3601,'Karang Tanjung'),(360126,3601,'Cikedal'),(360127,3601,'Cibitung'),(360128,3601,'Carita'),(360129,3601,'Sukaresmi'),(360130,3601,'Mekarjaya'),(360131,3601,'Sindangresmi'),(360132,3601,'Pulosari'),(360133,3601,'Koroncong'),(360134,3601,'Majasari'),(360135,3601,'Sobang'),(360201,3602,'Malingping'),(360202,3602,'Panggarangan'),(360203,3602,'Bayah'),(360204,3602,'Cipanas'),(360205,3602,'Muncang'),(360206,3602,'Leuwidamar'),(360207,3602,'Bojongmanik'),(360208,3602,'Gunungkencana'),(360209,3602,'Banjarsari'),(360210,3602,'Cileles'),(360211,3602,'Cimarga'),(360212,3602,'Sajira'),(360213,3602,'Maja'),(360214,3602,'Rangkasbitung'),(360215,3602,'Warunggunung'),(360216,3602,'Cijaku'),(360217,3602,'Cikulur'),(360218,3602,'Cibadak'),(360219,3602,'Cibeber'),(360220,3602,'Cilograng'),(360221,3602,'Wanasalam'),(360222,3602,'Sobang'),(360223,3602,'Curug bitung'),(360224,3602,'Kalanganyar'),(360225,3602,'Lebakgedong'),(360226,3602,'Cihara'),(360227,3602,'Cirinten'),(360228,3602,'Cigemlong'),(360301,3603,'Balaraja'),(360302,3603,'Jayanti'),(360303,3603,'Tigaraksa'),(360304,3603,'Jambe'),(360305,3603,'Cisoka'),(360306,3603,'Kresek'),(360307,3603,'Kronjo'),(360308,3603,'Mauk'),(360309,3603,'Kemiri'),(360310,3603,'Sukadiri'),(360311,3603,'Rajeg'),(360312,3603,'Pasar Kemis'),(360313,3603,'Teluknaga'),(360314,3603,'Kosambi'),(360315,3603,'Pakuhaji'),(360316,3603,'Sepatan'),(360317,3603,'Curug'),(360318,3603,'Cikupa'),(360319,3603,'Panongan'),(360320,3603,'Legok'),(360322,3603,'Pagedangan'),(360323,3603,'Cisauk'),(360327,3603,'Sukamulya'),(360328,3603,'Kelapa Dua'),(360329,3603,'Sindang Jaya'),(360330,3603,'Sepatan Timur'),(360331,3603,'Solear'),(360332,3603,'Gunung Kaler'),(360333,3603,'Mekar Baru'),(360405,3604,'Kramatwatu'),(360406,3604,'Waringinkurung'),(360407,3604,'Bojonegara'),(360408,3604,'Pulo Ampel'),(360409,3604,'Ciruas'),(360411,3604,'Kragilan'),(360412,3604,'Pontang'),(360413,3604,'Tirtayasa'),(360414,3604,'Tanara'),(360415,3604,'Cikande'),(360416,3604,'Kibin'),(360417,3604,'Carenang'),(360418,3604,'Binuang'),(360419,3604,'Petir'),(360420,3604,'Tunjung Teja'),(360422,3604,'Baros'),(360423,3604,'Cikeusal'),(360424,3604,'Pamarayan'),(360425,3604,'Kopo'),(360426,3604,'Jawilan'),(360427,3604,'Ciomas'),(360428,3604,'Pabuaran'),(360429,3604,'Padarincang'),(360430,3604,'Anyar'),(360431,3604,'Cinangka'),(360432,3604,'Mancak'),(360433,3604,'Gunung Sari'),(360434,3604,'Bandung'),(360435,3604,'Lebak Wangi'),(367101,3671,'Tangerang'),(367102,3671,'Jatiuwung'),(367103,3671,'Batuceper'),(367104,3671,'Benda'),(367105,3671,'Cipondoh'),(367106,3671,'Ciledug'),(367107,3671,'Karawaci'),(367108,3671,'Periuk'),(367109,3671,'Cibodas'),(367110,3671,'Neglasari'),(367111,3671,'Pinang'),(367112,3671,'Karang Tengah'),(367113,3671,'Larangan'),(367201,3672,'Cibeber'),(367202,3672,'Cilegon'),(367203,3672,'Pulomerak'),(367204,3672,'Ciwandan'),(367205,3672,'Jombang'),(367206,3672,'Gerogol'),(367207,3672,'Purwakarta'),(367208,3672,'Citangkil'),(367301,3673,'Serang'),(367302,3673,'Kasemen'),(367303,3673,'Walantaka'),(367304,3673,'Curug'),(367305,3673,'Cipocok Jaya'),(367306,3673,'Taktakan'),(367401,3674,'Serpong'),(367402,3674,'Serpong Utara'),(367403,3674,'Pondok Aren'),(367404,3674,'Ciputat'),(367405,3674,'Ciputat Timur'),(367406,3674,'Pamulang'),(367407,3674,'Setu'),(510101,5101,'Negara'),(510102,5101,'Mendoyo'),(510103,5101,'Pekutatan'),(510104,5101,'Melaya'),(510105,5101,'Jembrana'),(510201,5102,'Selemadeg'),(510202,5102,'Salamadeg Timur'),(510203,5102,'Salemadeg Barat'),(510204,5102,'Kerambitan'),(510205,5102,'Tabanan'),(510206,5102,'Kediri'),(510207,5102,'Marga'),(510208,5102,'Penebel'),(510209,5102,'Baturiti'),(510210,5102,'Pupuan'),(510301,5103,'Kuta'),(510302,5103,'Mengwi'),(510303,5103,'Abiansemal'),(510304,5103,'Petang'),(510305,5103,'Kuta Selatan'),(510306,5103,'Kuta Utara'),(510401,5104,'Sukawati'),(510402,5104,'Blahbatuh'),(510403,5104,'Gianyar'),(510404,5104,'Tampaksiring'),(510405,5104,'Ubud'),(510406,5104,'Tegalallang'),(510407,5104,'Payangan'),(510501,5105,'Nusa Penida'),(510502,5105,'Banjarangkan'),(510503,5105,'Klungkung'),(510504,5105,'Dawan'),(510601,5106,'Susut'),(510602,5106,'Bangli'),(510603,5106,'Tembuku'),(510604,5106,'Kintamani'),(510701,5107,'Rendang'),(510702,5107,'Sidemen'),(510703,5107,'Manggis'),(510704,5107,'Karangasem'),(510705,5107,'Abang'),(510706,5107,'Bebandem'),(510707,5107,'Selat'),(510708,5107,'Kubu'),(510801,5108,'Gerokgak'),(510802,5108,'Seririt'),(510803,5108,'Busung biu'),(510804,5108,'Banjar'),(510805,5108,'Sukasada'),(510806,5108,'Buleleng'),(510807,5108,'Sawan'),(510808,5108,'Kubutambahan'),(510809,5108,'Tejakula'),(517101,5171,'Denpasar Selatan'),(517102,5171,'Denpasar Timur'),(517103,5171,'Denpasar Barat'),(517104,5171,'Denpasar Utara'),(520101,5201,'Gerung'),(520102,5201,'Kediri'),(520103,5201,'Narmada'),(520107,5201,'Sekotong'),(520108,5201,'Labuapi'),(520109,5201,'Gunungsari'),(520112,5201,'Lingsar'),(520113,5201,'Lembar'),(520114,5201,'Batu Layar'),(520115,5201,'Kuripan'),(520201,5202,'Praya'),(520202,5202,'Jonggat'),(520203,5202,'Batukliang'),(520204,5202,'Pujut'),(520205,5202,'Praya Barat'),(520206,5202,'Praya Timur'),(520207,5202,'Janapria'),(520208,5202,'Pringgarata'),(520209,5202,'Kopang'),(520210,5202,'Praya Tengah'),(520211,5202,'Praya Barat Daya'),(520212,5202,'Batukliang Utara'),(520301,5203,'Keruak'),(520302,5203,'Sakra'),(520303,5203,'Terara'),(520304,5203,'Sikur'),(520305,5203,'Masbagik'),(520306,5203,'Sukamulia'),(520307,5203,'Selong'),(520308,5203,'Pringgabaya'),(520309,5203,'Aikmel'),(520310,5203,'Sambelia'),(520311,5203,'Montong Gading'),(520312,5203,'Pringgasela'),(520313,5203,'Suralaga'),(520314,5203,'Wanasaba'),(520315,5203,'Sembalun'),(520316,5203,'Suwela'),(520317,5203,'Labuhan Haji'),(520318,5203,'Sakra Timur'),(520319,5203,'Sakra Barat'),(520320,5203,'Jerowaru'),(520402,5204,'Lunyuk'),(520405,5204,'Alas'),(520406,5204,'Utan'),(520407,5204,'Batu Lanteh'),(520408,5204,'Sumbawa'),(520409,5204,'Moyo Hilir'),(520410,5204,'Moyo Hulu'),(520411,5204,'Ropang'),(520412,5204,'Lape'),(520413,5204,'Plampang'),(520414,5204,'Empang'),(520417,5204,'Alas Barat'),(520418,5204,'Labuhan Badas'),(520419,5204,'Labangka'),(520420,5204,'Buer'),(520421,5204,'Rhee'),(520422,5204,'Unter Iwes'),(520423,5204,'Moyo Utara'),(520424,5204,'Maronge'),(520425,5204,'Tarano'),(520426,5204,'Lopok'),(520427,5204,'Lenangguar'),(520428,5204,'Orong Telu'),(520429,5204,'Lantung'),(520501,5205,'Dompu'),(520502,5205,'Kempo'),(520503,5205,'Hu\'u'),(520504,5205,'Kilo'),(520505,5205,'Woja'),(520506,5205,'Pekat'),(520507,5205,'Manggalewa'),(520508,5205,'Pajo'),(520601,5206,'Monta'),(520602,5206,'Bolo'),(520603,5206,'Woha'),(520604,5206,'Belo'),(520605,5206,'Wawo'),(520606,5206,'Sape'),(520607,5206,'Wera'),(520608,5206,'Donggo'),(520609,5206,'Sanggar'),(520610,5206,'Ambalawi'),(520611,5206,'Langgudu'),(520612,5206,'Lambu'),(520613,5206,'Madapangga'),(520614,5206,'Tambora'),(520615,5206,'Soromandi'),(520616,5206,'Parado'),(520617,5206,'Lambitu'),(520618,5206,'Palibelo'),(520701,5207,'Jereweh'),(520702,5207,'Taliwang'),(520703,5207,'Seteluk'),(520704,5207,'Sekongkang'),(520705,5207,'Brang Rea'),(520706,5207,'Poto Tano'),(520707,5207,'Brang Ene'),(520708,5207,'Maluk'),(520801,5208,'Tanjung'),(520802,5208,'Gangga'),(520803,5208,'Kayangan'),(520804,5208,'Bayan'),(520805,5208,'Pemenang'),(527101,5271,'Ampenan'),(527102,5271,'Mataram'),(527103,5271,'Cakranegara'),(527104,5271,'Sekarbela'),(527105,5271,'Selaprang'),(527106,5271,'Sandubaya'),(527201,5272,'RasanaE Barat'),(527202,5272,'RasanaE Timur'),(527203,5272,'Asakota'),(527204,5272,'Raba'),(527205,5272,'Mpunda'),(530104,5301,'Semau'),(530105,5301,'Kupang Barat'),(530106,5301,'Kupang Timur'),(530107,5301,'Sulamu'),(530108,5301,'Kupang Tengah'),(530109,5301,'Amarasi'),(530110,5301,'Fatuleu'),(530111,5301,'Takari'),(530112,5301,'Amfoang Selatan'),(530113,5301,'Amfoang Utara'),(530116,5301,'Nekamese'),(530117,5301,'Amarasi Barat'),(530118,5301,'Amarasi Selatan'),(530119,5301,'Amarasi Timur'),(530120,5301,'Amabi Oefeto Timur'),(530121,5301,'Amfoang Barat Daya'),(530122,5301,'Amfoang Barat Laut'),(530123,5301,'Semau Selatan'),(530124,5301,'Taebenu'),(530125,5301,'Amabi Oefeto'),(530126,5301,'Amfoang Timur'),(530127,5301,'Fatuleu Barat'),(530128,5301,'Fatuleu Tengah'),(530130,5301,'Amfoang Tengah'),(530201,5302,'Kota Soe'),(530202,5302,'Mollo Selatan'),(530203,5302,'Mollo Utara'),(530204,5302,'Amanuban Timur'),(530205,5302,'Amanuban Tengah'),(530206,5302,'Amanuban Selatan'),(530207,5302,'Amanuban Barat'),(530208,5302,'Amanatun Selatan'),(530209,5302,'Amanatun Utara'),(530210,5302,'KI\'E'),(530211,5302,'Kuanfatu'),(530212,5302,'Fatumnasi'),(530213,5302,'Polen'),(530214,5302,'Batu Putih'),(530215,5302,'Boking'),(530216,5302,'Toianas'),(530217,5302,'Nunkolo'),(530218,5302,'Oenino'),(530219,5302,'Kolbano'),(530220,5302,'Kot olin'),(530221,5302,'Kualin'),(530222,5302,'Mollo Barat'),(530223,5302,'Kok Baun'),(530224,5302,'Noebana'),(530225,5302,'Santian'),(530226,5302,'Noebeba'),(530227,5302,'Kuatnana'),(530228,5302,'Fautmolo'),(530229,5302,'Fatukopa'),(530230,5302,'Mollo Tengah'),(530231,5302,'Tobu'),(530232,5302,'Nunbena'),(530301,5303,'Miomafo Timur'),(530302,5303,'Miomafo Barat'),(530303,5303,'Biboki Selatan'),(530304,5303,'Noemuti'),(530305,5303,'Kota Kefamenanu'),(530306,5303,'Biboki Utara'),(530307,5303,'Biboki Anleu'),(530308,5303,'Insana'),(530309,5303,'Insana Utara'),(530310,5303,'Noemuti Timur'),(530311,5303,'Miomaffo Tengah'),(530312,5303,'Musi'),(530313,5303,'Mutis'),(530314,5303,'Bikomi Selatan'),(530315,5303,'Bikomi Tengah'),(530316,5303,'Bikomi Nilulat'),(530317,5303,'Bikomi Utara'),(530318,5303,'Naibenu'),(530319,5303,'Insana Fafinesu'),(530320,5303,'Insana Barat'),(530321,5303,'Insana Tengah'),(530322,5303,'Biboki Tan Pah'),(530323,5303,'Biboki Moenleu'),(530324,5303,'Biboki Feotleu'),(530401,5304,'Lamaknen'),(530402,5304,'TasifetoTimur'),(530403,5304,'Raihat'),(530404,5304,'Tasifeto Barat'),(530405,5304,'Kakuluk Mesak'),(530406,5304,'Malaka Timur'),(530407,5304,'Kobalima'),(530408,5304,'Malaka Tengah'),(530409,5304,'Sasitamean'),(530410,5304,'Malaka Barat'),(530411,5304,'Rinhat'),(530412,5304,'Kota Atambua'),(530413,5304,'Raimanuk'),(530414,5304,'Laen Manen'),(530415,5304,'Wewiku'),(530416,5304,'Weliman'),(530417,5304,'Lasiolat'),(530418,5304,'Lamaknen Selatan'),(530419,5304,'Io Kufeu'),(530420,5304,'Botin Leo Bele'),(530421,5304,'Atambua Barat'),(530422,5304,'Atambua Selatan'),(530423,5304,'Nanaet Duabesi'),(530424,5304,'Kobalima Timur'),(530501,5305,'Teluk Mutiara'),(530502,5305,'Alor Barat Laut'),(530503,5305,'Alor Barat Daya'),(530504,5305,'Alor Selatan'),(530505,5305,'Alor Timur'),(530506,5305,'Pantar'),(530507,5305,'Alor Tengah Utara'),(530508,5305,'Alor Timur Laut'),(530509,5305,'Pantar Barat'),(530510,5305,'Kabola'),(530511,5305,'Pulau Pura'),(530512,5305,'Mataru'),(530513,5305,'Pureman'),(530514,5305,'Pantar Timur'),(530515,5305,'Lembur'),(530516,5305,'Pantar Tengah'),(530517,5305,'Pantar Baru Laut'),(530601,5306,'Wulanggitang'),(530602,5306,'Titehena'),(530603,5306,'Larantuka'),(530604,5306,'Ile Mandiri'),(530605,5306,'Tanjung Bunga'),(530606,5306,'Solor Barat'),(530607,5306,'Solor Timur'),(530608,5306,'Adonara Barat'),(530609,5306,'Wotan Ulumando'),(530610,5306,'Adonara Timur'),(530611,5306,'Kelubagolit'),(530612,5306,'Witihama'),(530613,5306,'Ile Boleng'),(530614,5306,'Demon Pagong'),(530615,5306,'Lewolema'),(530616,5306,'Ile Bura'),(530617,5306,'Adonara'),(530618,5306,'Adonara Tengah'),(530619,5306,'Solor Selatan'),(530701,5307,'Paga'),(530702,5307,'Mego'),(530703,5307,'Lela'),(530704,5307,'Nita'),(530705,5307,'Alok'),(530706,5307,'Palue'),(530707,5307,'Nelle'),(530708,5307,'Talibura'),(530709,5307,'Waigete'),(530710,5307,'Kewapante'),(530711,5307,'Bola'),(530712,5307,'Magepanda'),(530713,5307,'Waiblama'),(530714,5307,'Alok Barat'),(530715,5307,'Alok Timur'),(530716,5307,'Koting'),(530717,5307,'Tana Wawo'),(530718,5307,'Hewokloang'),(530719,5307,'Kangae'),(530720,5307,'Doreng'),(530721,5307,'Mapitara'),(530801,5308,'Nangapanda'),(530802,5308,'Pulau Ende'),(530803,5308,'Ende'),(530804,5308,'Ende Selatan'),(530805,5308,'Ndona'),(530806,5308,'Detusoko'),(530807,5308,'Wewaria'),(530808,5308,'Wolowaru'),(530809,5308,'Wolojita'),(530810,5308,'Maurole'),(530811,5308,'Maukaro'),(530812,5308,'Lio Timur'),(530813,5308,'Kota Baru'),(530814,5308,'Kelimutu'),(530815,5308,'Detukeli'),(530816,5308,'Ndona Timur'),(530817,5308,'Ndori'),(530818,5308,'Ende Utara'),(530819,5308,'Ende Tengah'),(530820,5308,'Ende Timur'),(530821,5308,'Lepembusu Kelisoke'),(530901,5309,'Aimere'),(530902,5309,'Golewa'),(530906,5309,'Bajawa'),(530907,5309,'Soa'),(530909,5309,'Riung'),(530912,5309,'Jerebuu'),(530914,5309,'Riung Barat'),(530915,5309,'Bajawa Utara'),(530916,5309,'Wolomeze'),(530918,5309,'Golewa Selatan'),(530919,5309,'Golewa Barat'),(530920,5309,'Inerie'),(531001,5310,'Wae Rii'),(531003,5310,'Ruteng'),(531005,5310,'Satar Mese'),(531006,5310,'Cibal'),(531011,5310,'Reok'),(531012,5310,'Langke Rembong'),(531013,5310,'Satar Mese Barat'),(531014,5310,'Rahong Utara'),(531015,5310,'Lelak'),(531016,5310,'Reok Barat'),(531017,5310,'Cibal barat'),(531101,5311,'Kota Waingapu'),(531102,5311,'Haharu'),(531103,5311,'Lewa'),(531104,5311,'Nggaha Ori Angu'),(531105,5311,'Tabundung'),(531106,5311,'Pinu Pahar'),(531107,5311,'Pandawai'),(531108,5311,'Umalulu'),(531109,5311,'Rindi'),(531110,5311,'Pahunga Lodu'),(531111,5311,'Wulla Waijelu'),(531112,5311,'Paberiwai'),(531113,5311,'Karera'),(531114,5311,'Kahaungu Eti'),(531115,5311,'Matawai La Pawu'),(531116,5311,'Kambera'),(531117,5311,'Kambata Mapambuhang'),(531118,5311,'Lewa Tidahu'),(531119,5311,'Katala Hamu Lingu'),(531120,5311,'Kanatang'),(531121,5311,'Ngadu Ngala'),(531122,5311,'Mahu'),(531204,5312,'Tana Righu'),(531210,5312,'Loli'),(531211,5312,'Wanokaka'),(531212,5312,'Lamboya'),(531215,5312,'Kota Waikabubak'),(531218,5312,'Laboya Barat'),(531301,5313,'Naga Wutung'),(531302,5312,'Atadei'),(531303,5312,'Ile Ape'),(531304,5312,'Lebatukan'),(531305,5312,'Nubatukan'),(531306,5312,'Omesuri'),(531307,5312,'Buyasuri'),(531308,5312,'Wulandoni'),(531309,5312,'Ile Ape Timur'),(531401,5314,'Rote Barat Daya'),(531402,5314,'Rote Barat Laut'),(531403,5314,'Lobalain'),(531404,5314,'Rote Tengah'),(531405,5314,'Pantai Baru'),(531406,5314,'Rote Timur'),(531407,5314,'Rote Barat'),(531408,5314,'Rote  Selatan'),(531409,5314,'Ndao Nuse'),(531410,5314,'Landu Leko'),(531501,5315,'Macang Pacar'),(531502,5315,'Kuwus'),(531503,5315,'Lembor'),(531504,5315,'Sano Nggoang'),(531505,5315,'Komodo'),(531506,5315,'Boleng'),(531507,5315,'Welak'),(531508,5315,'Ndoso'),(531509,5315,'Lembor Selatan'),(531510,5315,'Mbeliling'),(531601,5316,'Aesesa'),(531602,5316,'Nangaroro'),(531603,5316,'Boawae'),(531604,5316,'Mauponggo'),(531605,5316,'Wolowae'),(531606,5316,'Keo Tengah'),(531607,5316,'Aesesa Selatan'),(531701,5317,'Katiku Tana'),(531702,5317,'Umbu Ratu Nggay Barat'),(531703,5317,'Mamboro'),(531704,5317,'Umbu Ratu Nggay'),(531705,5317,'Katiku Tana Selatan'),(531801,5318,'Loura'),(531802,5318,'Wewewa Utara'),(531803,5318,'Wewewa Timur'),(531804,5318,'Wewewa Barat'),(531805,5318,'Wewewa Selatan'),(531806,5318,'Kodi Bangedo'),(531807,5318,'Kodi'),(531808,5318,'Kodi Utara'),(531809,5318,'Kota Tambolaka'),(531810,5318,'Wewewa Tengah'),(531811,5318,'Kodi Balaghar'),(531901,5319,'Borong'),(531902,5319,'Poco Ranaka'),(531903,5319,'Lamba Leda'),(531904,5319,'Sambi Rampas'),(531905,5319,'Elar'),(531906,5319,'Kota Komba'),(531907,5319,'Rana Mese'),(531908,5319,'Poco Ranaka Timur'),(531909,5319,'Elar Selatan'),(532001,5320,'Sabu Barat'),(532002,5320,'Sabu Tengah'),(532003,5320,'Sabu Timur'),(532004,5320,'Sabu Liae'),(532005,5320,'Hawu Mehara'),(532006,5320,'Raijua'),(537101,5371,'Alak'),(537102,5371,'Maulafa'),(537103,5371,'Kelapa Lima'),(537104,5371,'Oebobo'),(537105,5371,'Kota Raja'),(537106,5371,'Kota Lama'),(610101,6101,'Sambas'),(610102,6101,'Teluk Keramat'),(610103,6101,'Jawai'),(610104,6101,'Tebas'),(610105,6101,'Pemangkat'),(610106,6101,'Sejangkung'),(610107,6101,'Selakau'),(610108,6101,'Paloh'),(610109,6101,'Sajingan Besar'),(610110,6101,'Subah'),(610111,6101,'Galing'),(610112,6101,'Tekarang'),(610113,6101,'Semparuk'),(610114,6101,'Sajad'),(610115,6101,'Sebawi'),(610116,6101,'Jawai Selatan'),(610117,6101,'Tangaran'),(610118,6101,'Salatiga'),(610119,6101,'Selakau Timur'),(610201,6102,'Mempawah Hilir'),(610206,6102,'Toho'),(610207,6102,'Sungai Pinyuh'),(610208,6102,'Siantan'),(610212,6102,'Sungai Kunyit'),(610215,6103,'Segedong'),(610216,6103,'Anjongan'),(610217,6103,'Sadaniang'),(610218,6103,'Mempawah Timur'),(610301,6103,'Kapuas'),(610302,6103,'Mukok'),(610303,6103,'Noyan'),(610304,6103,'Jangkang'),(610305,6103,'Bonti'),(610306,6103,'Beduai'),(610307,6103,'Sekayam'),(610308,6103,'Kembayan'),(610309,6103,'Parindu'),(610310,6103,'Tayan Hulu'),(610311,6103,'Tayan Hilir'),(610312,6104,'Balai'),(610313,6104,'Toba'),(610320,6104,'Meliau'),(610321,6104,'Entikong'),(610401,6104,'Matan Hilir Utara'),(610402,6104,'Marau'),(610403,6104,'Manis Mata'),(610404,6104,'Kendawangan'),(610405,6104,'Sandai'),(610407,6104,'Sungai Laur'),(610408,6104,'Simpang Hulu'),(610411,6104,'Nanga Tayap'),(610412,6104,'Matan Hilir Selatan'),(610413,6104,'Tumbang Titi'),(610414,6104,'Jelai Hulu'),(610416,6104,'Delta Pawan'),(610417,6104,'Muara Pawan'),(610418,6104,'Benua Kayong'),(610419,6104,'Hulu Sungai'),(610420,6104,'Simpang Dua'),(610421,6105,'Air Upas'),(610422,6105,'Singkup'),(610424,6105,'Pemahan'),(610425,6105,'Sungai Melayu Rayak'),(610501,6105,'Sintang'),(610502,6105,'Tempunak'),(610503,6105,'Sepauk'),(610504,6105,'Ketungau Hilir'),(610505,6105,'Ketungau Tengah'),(610506,6105,'Ketungau Hulu'),(610507,6105,'Dedai'),(610508,6105,'Kayan Hilir'),(610509,6105,'Kayan Hulu'),(610514,6105,'Serawai'),(610515,6106,'Ambalau'),(610519,6106,'Kelam Permai'),(610520,6106,'Sungai Tebelian'),(610521,6106,'Binjai Hulu'),(610601,6106,'Putussibau Utara'),(610602,6106,'Bika'),(610603,6106,'Embaloh Hilir'),(610604,6106,'Embaloh Hulu'),(610605,6106,'Bunut Hilir'),(610606,6106,'Bunut Hulu'),(610607,6106,'Jongkong'),(610608,6106,'Hulu Gurung'),(610609,6106,'Selimbau'),(610610,6106,'Semitau'),(610611,6106,'Seberuang'),(610612,6106,'Batang Lupar'),(610613,6106,'Empanang'),(610614,6106,'Badau'),(610615,6106,'Silat Hilir'),(610616,6106,'Silat Hulu'),(610617,6106,'Putussibau Selatan'),(610618,6106,'Kalis'),(610619,6106,'Boyan Tanjung'),(610620,6107,'Mentebah'),(610621,6107,'Pengkadan'),(610622,6107,'Suhaid'),(610623,6107,'Puring Kencana'),(610701,6107,'Sungai Raya'),(610702,6107,'Samalantan'),(610703,6107,'Ledo'),(610704,6107,'Bengkayang'),(610705,6107,'Seluas'),(610706,6107,'Sanggau Ledo'),(610707,6107,'Jagoi Babang'),(610708,6107,'Monterado'),(610709,6107,'Teriak'),(610710,6107,'Suti Semarang'),(610711,6107,'Capkala'),(610712,6107,'Siding'),(610713,6107,'Lumar'),(610714,6108,'Sungai Betung'),(610715,6108,'Sungai Raya Kepulauan'),(610716,6108,'Lembah Bawang'),(610717,6108,'Tujuh Belas'),(610801,6108,'Ngabang'),(610802,6108,'Mempawah Hulu'),(610803,6108,'Menjalin'),(610804,6108,'Mandor'),(610805,6108,'Air Besar'),(610806,6108,'Menyuke'),(610807,6108,'Sengah Temila'),(610808,6108,'Meranti'),(610809,6108,'Kuala Behe'),(610810,6109,'Sebangki'),(610811,6109,'Jelimpo'),(610812,6109,'Banyuke Hulu'),(610813,6109,'Sompak'),(610901,6109,'Sekadau Hilir'),(610902,6109,'Sekadau Hulu'),(610903,6109,'Nanga Taman'),(610904,6110,'Nanga Mahap'),(610905,6110,'Belitang Hilir'),(610906,6110,'Belitang Hulu'),(610907,6110,'Belitang'),(611001,6110,'Belimbing'),(611002,6110,'Nanga Pinoh'),(611003,6110,'Ella Hilir'),(611004,6110,'Menukung'),(611005,6110,'Sayan'),(611006,6110,'Tanah Pinoh'),(611007,6110,'Sokan'),(611008,6111,'Pinoh Utara'),(611009,6111,'Pinoh Selatan'),(611010,6111,'Belimbing Hulu'),(611011,6111,'Tanah Pinoh Barat'),(611101,6111,'Sukadana'),(611102,6111,'Simpang Hilir'),(611103,6112,'Teluk Batang'),(611104,6112,'Pulau Maya'),(611105,6112,'Seponti'),(611106,6112,'Kepulauan Karimata'),(611201,6112,'Sungai Raya'),(611202,6112,'Kuala Mandor B'),(611203,6112,'Sungai Ambawang'),(611204,6112,'Terentang'),(611205,6112,'Batu Ampar'),(611206,6171,'Kubu'),(611207,6171,'Rasau Jaya'),(611208,6171,'Teluk Pakedai'),(611209,6171,'Sungai Kakap'),(617101,6171,'Pontianak Selatan'),(617102,6171,'Pontianak Timur'),(617103,6172,'Pontianak Barat'),(617104,6172,'Pontianak Utara'),(617105,6172,'Pontianak Kota'),(617106,6172,'Pontianak Tenggara'),(617201,6172,'Singkawang Tengah'),(617202,6201,'Singkawang Barat'),(617203,6201,'Singkawang Timur'),(617204,6201,'Singkawang Utara'),(617205,6201,'Singkawang Selatan'),(620101,6201,'Kumai'),(620102,6201,'Arut Selatan'),(620103,6202,'Kotawaringin Lama'),(620104,6202,'Arut Utara'),(620105,6202,'Pangkalan Lada'),(620106,6202,'Pangkalan Banteng'),(620201,6202,'Kota Besi'),(620202,6202,'Cempaga'),(620203,6202,'Mentaya Hulu'),(620204,6202,'Parenggean'),(620205,6202,'Baamang'),(620206,6202,'Mentawa Baru Ketapang'),(620207,6202,'Mentaya Hilir Utara'),(620208,6202,'Mentaya Hilir Selatan'),(620209,6202,'Pulau Hanaut'),(620210,6202,'Antang Kalang'),(620211,6202,'Teluk Sampit'),(620212,6202,'Seranau'),(620213,6202,'Cempaga Hulu'),(620214,6203,'Telawang'),(620215,6203,'Bukit Santuai'),(620216,6203,'Tualan Hulu'),(620217,6203,'Telaga Antang'),(620301,6203,'Selat'),(620302,6203,'Kapuas Hilir'),(620303,6203,'Kapuas Timur'),(620304,6203,'Kapuas Kuala'),(620305,6203,'Kapuas Barat'),(620306,6203,'Pulau Petak'),(620307,6203,'Kapuas Murung'),(620308,6203,'Basarang'),(620309,6203,'Mantangai'),(620310,6203,'Timpah'),(620311,6203,'Kapuas Tengah'),(620312,6203,'Kapuas Hulu'),(620313,6203,'Tamban Catur'),(620314,6204,'Pasak Talawang'),(620315,6204,'Mandau Talawang'),(620316,6204,'Dadahup'),(620317,6204,'Bataguh'),(620401,6204,'Jenamas'),(620402,6204,'Dusun Hilir'),(620403,6205,'Karau Kuala'),(620404,6205,'Dusun Utara'),(620405,6205,'Gn. Bintang Awai'),(620406,6205,'Dusun Selatan'),(620501,6205,'Montallat'),(620502,6205,'Gunung Timang'),(620503,6205,'Gunung Purei'),(620504,6205,'Teweh Timur'),(620505,6205,'Teweh Tengah'),(620506,6206,'Lahei'),(620507,6206,'Teweh Baru'),(620508,6206,'Teweh Selatan'),(620509,6206,'Lahei Barat'),(620601,6206,'Kampiang'),(620602,6206,'Katingan Hilir'),(620603,6206,'Tewang Sangalang Garing'),(620604,6206,'Pulau Malan'),(620605,6206,'Katingan Tengah'),(620606,6206,'Sanaman Mantikei'),(620607,6206,'Marikit'),(620608,6206,'Katingan Hulu'),(620609,6206,'Mendawai'),(620610,6207,'Katingan Kuala'),(620611,6207,'Tasik Payawan'),(620612,6207,'Petak Malai'),(620613,6207,'Bukit Raya'),(620701,6207,'Seruyan Hilir'),(620702,6207,'Seruyan Tengah'),(620703,6207,'Danau Sembuluh'),(620704,6207,'Hanau'),(620705,6207,'Seruyan Hulu'),(620706,6207,'Seruyan Hilir Timur'),(620707,6208,'Seruyan Raya'),(620708,6208,'Danau Seluluk'),(620709,6208,'Batu Ampar'),(620710,6208,'Suling Tambun'),(620801,6208,'Sukamara'),(620802,6209,'Jelai'),(620803,6209,'Balai Riam'),(620804,6209,'Pantai Lunci'),(620805,6209,'Permata Kecubung'),(620901,6209,'Lamandau'),(620902,6209,'Delang'),(620903,6209,'Bulik'),(620904,6209,'Bulik Timur'),(620905,6210,'Menthobi Raya'),(620906,6210,'Sematu Jaya'),(620907,6210,'Belantikan Raya'),(620908,6210,'Batang Kawa'),(621001,6210,'Sepang Simin'),(621002,6210,'Kurun'),(621003,6210,'Tewah'),(621004,6210,'Kahayan Hulu Utara'),(621005,6210,'Rungan'),(621006,6210,'Manuhing'),(621007,6210,'Mihing Raya'),(621008,6210,'Damang Batu'),(621009,6211,'Miri Manasa'),(621010,6211,'Rungan Hulu'),(621011,6211,'Mahuning Raya'),(621012,6211,'Rungan Barat'),(621101,6211,'Pandih Batu'),(621102,6211,'Kahayan Kuala'),(621103,6211,'Kahayan Tengah'),(621104,6211,'Banama Tingang'),(621105,6212,'Kahayan Hilir'),(621106,6212,'Maliku'),(621107,6212,'Jabiren'),(621108,6212,'Sebangau Kuala'),(621201,6212,'Murung'),(621202,6212,'Tanah Siang'),(621203,6212,'Laung Tuhup'),(621204,6212,'Permata Intan'),(621205,6212,'Sumber Barito'),(621206,6212,'Barito Tuhup Raya'),(621207,6213,'Tanah Siang Selatan'),(621208,6213,'Sungai Babuat'),(621209,6213,'Seribu Riam'),(621210,6213,'Uut Murung'),(621301,6213,'Dusun Timur'),(621302,6213,'Banua Lima'),(621303,6213,'Patangkep Tutui'),(621304,6213,'Awang'),(621305,6213,'Dusun Tengah'),(621306,6213,'Pematang Karau'),(621307,6271,'Paju Epat'),(621308,6271,'Raren Batuah'),(621309,6271,'Paku'),(621310,6271,'Karusen Janang'),(627101,6271,'Pahandut'),(627102,6301,'Bukit Batu'),(627103,6301,'Jekan Raya'),(627104,6301,'Sabangau'),(627105,6301,'Rakumpit'),(630101,6301,'Takisung'),(630102,6301,'Jorong'),(630103,6301,'Pelaihari'),(630104,6301,'Kurau'),(630105,6301,'Bati Bati'),(630106,6301,'Panyipatan'),(630107,6301,'Kintap'),(630108,6302,'Tambang Ulang'),(630109,6302,'Batu Ampar'),(630110,6302,'Bajuin'),(630111,6302,'Bumi Makmur'),(630201,6302,'Pulausembilan'),(630202,6302,'Pulaulaut Barat'),(630203,6302,'Pulaulaut Selatan'),(630204,6302,'Pulaulaut Timur'),(630205,6302,'Pulausebuku'),(630206,6302,'Pulaulaut Utara'),(630207,6302,'Kelumpang Selatan'),(630208,6302,'Kelumpang Hulu'),(630209,6302,'Kelumpang Tengah'),(630210,6302,'Kelumpang Utara'),(630211,6302,'Pamukan Selatan'),(630212,6302,'Sampanahan'),(630213,6302,'Pamukan Utara'),(630214,6302,'Hampang'),(630215,6302,'Sungaidurian'),(630216,6302,'Pulaulaut Tengah'),(630217,6302,'Kelumpang Hilir'),(630218,6303,'Kelumpang Barat'),(630219,6303,'Pamukan Barat'),(630220,6303,'Pulaulaut Kepulauan'),(630221,6303,'Pulaulaut Tanjung Selayar'),(630301,6303,'Aluh Aluh'),(630302,6303,'Kertak Hanyar'),(630303,6303,'Gambut'),(630304,6303,'Sungai Tabuk'),(630305,6303,'Martapura'),(630306,6303,'Karang Intan'),(630307,6303,'Astambul'),(630308,6303,'Simpang Empat'),(630309,6303,'Pengarom'),(630310,6303,'Sungai Pinang'),(630311,6303,'Aranio'),(630312,6303,'Mataraman'),(630313,6303,'Beruntung Baru'),(630314,6303,'Martapura Barat'),(630315,6303,'Martapura Timur'),(630316,6304,'Sambung Makmur'),(630317,6304,'Paramasan'),(630318,6304,'Telaga Bauntung'),(630319,6304,'Tatah Makmur'),(630401,6304,'Tabunganen'),(630402,6304,'Tamban'),(630403,6304,'Anjir Pasar'),(630404,6304,'Anjir Muara'),(630405,6304,'Alalak'),(630406,6304,'Mandastana'),(630407,6304,'Rantau Badauh'),(630408,6304,'Belawang'),(630409,6304,'Cerbon'),(630410,6304,'Bakumpai'),(630411,6304,'Kuripan'),(630412,6304,'Tabukan'),(630413,6304,'Mekarsari'),(630414,6305,'Barambai'),(630415,6305,'Marabahan'),(630416,6305,'Wanaraya'),(630417,6305,'Jejangkit'),(630501,6305,'Binuang'),(630502,6305,'Tapin Selatan'),(630503,6305,'Tapin Tengah'),(630504,6305,'Tapin Utara'),(630505,6305,'Candi Laras Selatan'),(630506,6305,'Candi Laras Utara'),(630507,6305,'Bakarangan'),(630508,6305,'Piani'),(630509,6306,'Bungur'),(630510,6306,'Lokpaikat'),(630511,6306,'Salam Babaris'),(630512,6306,'Hatungun'),(630601,6306,'Sungai Raya'),(630602,6306,'Padang Batung'),(630603,6306,'Telaga Langsat'),(630604,6306,'Angkinang'),(630605,6306,'Kandangan'),(630606,6306,'Simpur'),(630607,6306,'Daha Selatan'),(630608,6307,'Daha Utara'),(630609,6307,'Kalumpang'),(630610,6307,'Loksado'),(630611,6307,'Daha Barat'),(630701,6307,'Haruyan'),(630702,6307,'Batu Benawa'),(630703,6307,'Labuan Amas Selatan'),(630704,6307,'Labuan Amas Utara'),(630705,6307,'Pandawan'),(630706,6307,'Barabai'),(630707,6307,'Batang Alai Selatan'),(630708,6308,'Batang Alai Utara'),(630709,6308,'Hantakan'),(630710,6308,'Batang Alai Timur'),(630711,6308,'Limpasu'),(630801,6308,'Danau Panggang'),(630802,6308,'Babirik'),(630803,6308,'Sungai Pandan'),(630804,6308,'Amuntai Selatan'),(630805,6308,'Amuntai Tengah'),(630806,6308,'Amuntai Utara'),(630807,6309,'Banjang'),(630808,6309,'Haur Gading'),(630809,6309,'Paminggir'),(630810,6309,'Sungai Tabukan'),(630901,6309,'Banua Lawas'),(630902,6309,'Kelua'),(630903,6309,'Tanta'),(630904,6309,'Tanjung'),(630905,6309,'Haruai'),(630906,6309,'Murung Pudak'),(630907,6309,'Muara Uya'),(630908,6309,'Muara Harus'),(630909,6310,'Pugaan'),(630910,6310,'Upau'),(630911,6310,'Jaro'),(630912,6310,'Bintang Ara'),(631001,6310,'Batu Licin'),(631002,6310,'Kusan Hilir'),(631003,6310,'Sungai Loban'),(631004,6310,'Satui'),(631005,6310,'Kusan Hulu'),(631006,6310,'Simpang Empat'),(631007,6311,'Karang Bintang'),(631008,6311,'Mantewe'),(631009,6311,'Angsana'),(631010,6311,'Kuranji'),(631101,6311,'Juai'),(631102,6311,'Halong'),(631103,6311,'Awayan'),(631104,6311,'Batu Mandi'),(631105,6371,'Lampihong'),(631106,6371,'Paringin'),(631107,6371,'Paringin Selatan'),(631108,6371,'Tebing Tinggi'),(637101,6371,'Banjarmasin Selatan'),(637102,6372,'Banjarmasin Timur'),(637103,6372,'Banjarmasin Barat'),(637104,6372,'Banjarmasin Utara'),(637105,6372,'Banjarmasin Tengah'),(637202,6372,'Landasan Ulin'),(637203,6401,'Cempaka'),(637204,6401,'Banjarbaru Utara'),(637205,6401,'Banjarbaru Selatan'),(637206,6401,'Liang Anggang'),(640101,6401,'Batu Sopang'),(640102,6401,'Tanjung Harapan'),(640103,6401,'Pasir Balengkong'),(640104,6401,'Tanah Grogot'),(640105,6401,'Kuaro'),(640106,6401,'Long Ikis'),(640107,6402,'Muara Komam'),(640108,6402,'Long Kali'),(640109,6402,'Batu Engau'),(640110,6402,'Muara Samu'),(640201,6402,'Muara Muntai'),(640202,6402,'Loa Kulu'),(640203,6402,'Loa Janan'),(640204,6402,'Anggana'),(640205,6402,'Muara Badak'),(640206,6402,'Tenggarong'),(640207,6402,'Sebulu'),(640208,6402,'Kota Bangun'),(640209,6402,'Kenohan'),(640210,6402,'Kembang Janggut'),(640211,6402,'Muara Kaman'),(640212,6402,'Tabang'),(640213,6402,'Samboja'),(640214,6402,'Muara Jawa'),(640215,6403,'Sanga Sanga'),(640216,6403,'Tenggarong Seberang'),(640217,6403,'Marang Kayu'),(640218,6403,'Muara Wis'),(640301,6403,'Kelay'),(640302,6403,'Talisayan'),(640303,6403,'Sambaliung'),(640304,6403,'Segah'),(640305,6403,'Tanjung Redeb'),(640306,6403,'Gunung Tabur'),(640307,6403,'Pulau Derawan'),(640308,6403,'Biduk-Biduk'),(640309,6403,'Teluk Bayur'),(640310,6404,'Tabalar'),(640311,6404,'Maratua'),(640312,6404,'Batu Putih'),(640313,6404,'Biatan'),(640401,6404,'Tanjung Palas'),(640402,6404,'Tanjung Palas Barat'),(640403,6404,'Tanjung Palas Utara'),(640404,6404,'Tanjung Palas Timur'),(640405,6404,'Tanjung Selor'),(640406,6404,'Tanjung Palas Tengah'),(640407,6405,'Peso'),(640408,6405,'Peso Ilir'),(640409,6405,'Sekatak'),(640412,6405,'Bunyu'),(640501,6405,'Sebatik'),(640502,6405,'Nunukan'),(640503,6405,'Sembakung'),(640504,6405,'Lumbis'),(640505,6405,'Krayan'),(640506,6405,'Sebuku'),(640507,6405,'Krayan Selatan'),(640508,6405,'Sebatik Barat'),(640509,6405,'Nunukan Selatan'),(640510,6405,'Sebatik Timur'),(640511,6405,'Sebatik Utara'),(640512,6406,'Sebatik Tengah'),(640513,6406,'Sei Menggaris'),(640514,6406,'Tulin Onsoi'),(640515,6406,'Lumbis Ogong'),(640601,6406,'Mentarang'),(640602,6406,'Malinau Kota'),(640603,6406,'Pujungan'),(640604,6406,'Kayan Hilir'),(640605,6406,'Kayan Hulu'),(640606,6406,'Malinau Selatan'),(640607,6406,'Malinau Utara'),(640608,6406,'Malinau Barat'),(640609,6406,'Sungai Boh'),(640610,6406,'Kayan Selatan'),(640611,6406,'Bahau Hulu'),(640612,6407,'Mentarang Hulu'),(640613,6407,'Malinau Selatan Hilir'),(640614,6407,'Malinau Selatan Hulu'),(640615,6407,'Sungai Tubu'),(640701,6407,'Long Apari'),(640702,6407,'Long Pahangai'),(640703,6407,'Long Bagun'),(640704,6407,'Long Hubung'),(640705,6407,'Long Iram'),(640706,6407,'Melak'),(640707,6407,'Barong Tongkok'),(640708,6407,'Damai'),(640709,6407,'Muara Lawa'),(640710,6407,'Muara Pahu'),(640711,6407,'Jempang'),(640712,6407,'Bongan'),(640713,6407,'Penyinggahan'),(640714,6407,'Bentian Besar'),(640715,6407,'Linggang Bigung'),(640716,6407,'Nyuatan'),(640717,6407,'Siluq Ngurai'),(640718,6408,'Mook Manaar Bulatn'),(640719,6408,'Tering'),(640720,6408,'Sekolaq Darat'),(640721,6408,'Laham'),(640801,6408,'Muara Ancalong'),(640802,6408,'Muara Wahau'),(640803,6408,'Muara Bengkal'),(640804,6408,'Sangatta Utara'),(640805,6408,'Sangkulirang'),(640806,6408,'Busang'),(640807,6408,'Telen'),(640808,6408,'Kombeng'),(640809,6408,'Bengalon'),(640810,6408,'Kaliorang'),(640811,6408,'Sandaran'),(640812,6408,'Sangatta Selatan'),(640813,6408,'Teluk Pandan'),(640814,6408,'Rantau Pulung'),(640815,6409,'Kaubun'),(640816,6409,'Karangan'),(640817,6409,'Batu Ampar'),(640818,6409,'Long Mesangat'),(640901,6410,'Penajam'),(640902,6410,'Waru'),(640903,6410,'Babulu'),(640904,6410,'Sepaku'),(641001,6471,'Sesayap'),(641002,6471,'Sesayap Hilir'),(641003,6471,'Tana Lia'),(641004,6471,'Betayau'),(647101,6471,'Balikpapan Timur'),(647102,6471,'Balikpapan Barat'),(647103,6472,'Balikpapan Utara'),(647104,6472,'Balikpapan Tengah'),(647105,6472,'Balikpapan Selatan'),(647106,6472,'Balikpapan Kota'),(647201,6472,'Palaran'),(647202,6472,'Samarinda Seberang'),(647203,6472,'Samarinda Ulu'),(647204,6472,'Samarinda Ilir'),(647205,6472,'Samarinda Utara'),(647206,6472,'Sungai Kunjang'),(647207,6473,'Sambutan'),(647208,6473,'Sungai Pinang'),(647209,6473,'Samarinda Kota'),(647210,6473,'Loa Janan Ilir'),(647301,6474,'Tarakan Barat'),(647302,6474,'Tarakan Tengah'),(647303,6474,'Tarakan Timur'),(647304,7101,'Tarakan Utara'),(647401,7101,'Bontang Utara'),(647402,7101,'Bontang Selatan'),(647403,7101,'Bontang Barat'),(710105,7101,'Sang Tombolang'),(710109,7101,'Dumoga Barat'),(710110,7101,'Dumoga Timur'),(710111,7101,'Dumoga Utara'),(710112,7101,'Lolak'),(710113,7101,'Bolaang'),(710114,7101,'Lolayan'),(710119,7101,'Passi Barat'),(710120,7101,'Poigar'),(710122,7101,'Passi Timur'),(710131,7101,'Bolaang Timur'),(710132,7102,'Bilalang'),(710133,7102,'Dumoga'),(710134,7102,'Dumoga Tenggara'),(710135,7102,'Dumoga Tengah'),(710201,7102,'Tondano Barat'),(710202,7102,'Tondano Timur'),(710203,7102,'Eris'),(710204,7102,'Kombi'),(710205,7102,'Lembean Timur'),(710206,7102,'Kakas'),(710207,7102,'Tompaso'),(710208,7102,'Remboken'),(710209,7102,'Langowan Timur'),(710210,7102,'Langowan Barat'),(710211,7102,'Sonder'),(710212,7102,'Kawangkoan'),(710213,7102,'Pineleng'),(710214,7102,'Tombulu'),(710215,7102,'Tombariri'),(710216,7102,'Tondano Utara'),(710217,7102,'Langowan Selatan'),(710218,7102,'Tondano Selatan'),(710219,7102,'Langowan Utara'),(710220,7102,'Kakas Barat'),(710221,7102,'Kawangkoan Utara'),(710222,7103,'Kawangkoan Barat'),(710223,7103,'Mandolang'),(710224,7103,'Tombariri Timur'),(710225,7103,'Tompaso Barat'),(710308,7103,'Tabukan Utara'),(710309,7103,'Nusa Tabukan'),(710310,7103,'Manganitu Selatan'),(710311,7103,'Tatoareng'),(710312,7103,'Tamako'),(710313,7103,'Manganitu'),(710314,7103,'Tabukan Tengah'),(710315,7103,'Tabukan Selatan'),(710316,7103,'Kendahe'),(710317,7103,'Tahuna'),(710319,7103,'Tabukan Selatan Tengah'),(710320,7104,'Tabukan Selatan Tenggara'),(710323,7104,'Tahuna Barat'),(710324,7104,'Tahuna Timur'),(710325,7104,'Kepulauan Marore'),(710401,7104,'Lirung'),(710402,7104,'Beo'),(710403,7104,'Rainis'),(710404,7104,'Essang'),(710405,7104,'Nanusa'),(710406,7104,'Kabaruan'),(710407,7104,'Melonguane'),(710408,7104,'Gemeh'),(710409,7104,'Damau'),(710410,7104,'Tampan\' Amma'),(710411,7104,'Salibabu'),(710412,7104,'Kalongan'),(710413,7104,'Miangas'),(710414,7104,'Beo Utara'),(710415,7104,'Pulutan'),(710416,7105,'Melonguane Timur'),(710417,7105,'Moronge'),(710418,7105,'Beo Selatan'),(710419,7105,'Essang Selatan'),(710501,7105,'Modoinding'),(710502,7105,'Tompaso Baru'),(710503,7105,'Ranoyapo'),(710507,7105,'Motoling'),(710508,7105,'Sinonsayang'),(710509,7105,'Tenga'),(710510,7105,'Amurang'),(710512,7105,'Tumpaan'),(710513,7105,'Tareran'),(710515,7105,'Kumelembuai'),(710516,7105,'Maesaan'),(710517,7105,'Amurang Barat'),(710518,7105,'Amurang Timur'),(710519,7106,'Tatapaan'),(710521,7106,'Motoling Barat'),(710522,7106,'Motoling Timur'),(710523,7106,'Suluun Tareran'),(710601,7106,'Kema'),(710602,7106,'Kauditan'),(710603,7106,'Airmadidi'),(710604,7106,'Wori'),(710605,7106,'Dimembe'),(710606,7106,'Likupang Barat'),(710607,7107,'Likupang Timur'),(710608,7107,'Kalawat'),(710609,7107,'Talawaan'),(710610,7107,'Likupang Selatan'),(710701,7107,'Ratahan'),(710702,7107,'Pusomaen'),(710703,7107,'Belang'),(710704,7107,'Ratatotok'),(710705,7107,'Tombatu'),(710706,7107,'Touluaan'),(710707,7107,'Touluaan Selatan'),(710708,7107,'Silian Raya'),(710709,7108,'Tombatu Timur'),(710710,7108,'Tombatu Utara'),(710711,7108,'Pasan'),(710712,7108,'Ratahan Timur'),(710801,7108,'Sangkub'),(710802,7108,'Bintauna'),(710803,7109,'Bolangitang Timur'),(710804,7109,'Bolangitang Barat'),(710805,7109,'Kaidipang'),(710806,7109,'Pinogaluman'),(710901,7109,'Siau Timur'),(710902,7109,'Siau Barat'),(710903,7109,'Tagulandang'),(710904,7109,'Siau Timur Selatan'),(710905,7109,'Siau Barat Selatan'),(710906,7109,'Tagulandang Utara'),(710907,7110,'Biaro'),(710908,7110,'Siau Barat Utara'),(710909,7110,'Siau Tengah'),(710910,7110,'Tagulandang Selatan'),(711001,7110,'Tutuyan'),(711002,7111,'Kotabunan'),(711003,7111,'Nuangan'),(711004,7111,'Modayag'),(711005,7111,'Modayag Barat'),(711101,7111,'Bolaang Uki'),(711102,7171,'Posigadan'),(711103,7171,'Pinolosian'),(711104,7171,'Pinolosian Tengah'),(711105,7171,'Pinolosian Timur'),(717101,7171,'Bunaken'),(717102,7171,'Tuminiting'),(717103,7171,'Singkil'),(717104,7171,'Wenang'),(717105,7171,'Tikala'),(717106,7171,'Sario'),(717107,7171,'Wanea'),(717108,7172,'Mapanget'),(717109,7172,'Malalayang'),(717110,7172,'Bunaken Kepulauan'),(717111,7172,'Paal Dua'),(717201,7172,'Lembeh Selatan'),(717202,7172,'Madidir'),(717203,7172,'Ranowulu'),(717204,7172,'Aertembaga'),(717205,7173,'Matuari'),(717206,7173,'Girian'),(717207,7173,'Maesa'),(717208,7173,'Lembeh Utara'),(717301,7173,'Tomohon Selatan'),(717302,7174,'Tomohon Tengah'),(717303,7174,'Tomohon Utara'),(717304,7174,'Tomohon Barat'),(717305,7174,'Tomohon Timur'),(717401,7201,'Kotamobagu Utara'),(717402,7201,'Kotamobagu Timur'),(717403,7201,'Kotamobagu Selatan'),(717404,7201,'Kotamobagu Barat'),(720101,7201,'Batui'),(720102,7201,'Bunta'),(720103,7201,'Kintom'),(720104,7201,'Luwuk'),(720105,7201,'Lamala'),(720106,7201,'Balantak'),(720107,7201,'Pagimana'),(720108,7201,'Bualemo'),(720109,7201,'Toili'),(720110,7201,'Masama'),(720111,7201,'Luwuk Timur'),(720112,7201,'Toili Barat'),(720113,7201,'Nuhon'),(720114,7201,'Moilong'),(720115,7201,'Batui Selatan'),(720116,7201,'Lobu'),(720117,7201,'Simpang Raya'),(720118,7201,'Balantak Selatan'),(720119,7201,'Balantak Utara'),(720120,7202,'Luwuk Selatan'),(720121,7202,'Luwuk Utara'),(720122,7202,'Mantoh'),(720123,7202,'Nambo'),(720201,7202,'Poso Kota'),(720202,7202,'Poso Pesisir'),(720203,7202,'Lage'),(720204,7202,'Pamona Puselemba'),(720205,7202,'Pamona Timur'),(720206,7202,'Pamona Selatan'),(720207,7202,'Lore Utara'),(720208,7204,'Lore Tengah'),(720209,7204,'Lore Selatan'),(720330,7204,'Sojol Utara'),(720331,7204,'Balaesang Tanjung'),(720401,7204,'Dampal Selatan'),(720402,7204,'Dampal Utara'),(720403,7204,'Dondo'),(720404,7204,'Basidondo'),(720405,7204,'Ogodeide'),(720406,7204,'Lampasio'),(720407,7205,'Baolan'),(720408,7205,'Galang'),(720409,7205,'Toli-Toli Utara'),(720410,7205,'Dako Pemean'),(720501,7205,'Momunu'),(720502,7205,'Lakea'),(720503,7205,'Bokat'),(720504,7205,'Bunobogu'),(720505,7205,'Paleleh'),(720506,7205,'Biau'),(720507,7205,'Tiloan'),(720508,7206,'Bukal'),(720509,7206,'Gadung'),(720510,7206,'Karamat'),(720511,7206,'Paleleh Barat'),(720601,7206,'Moris Atas'),(720602,7206,'Lembo'),(720603,7206,'Petasia'),(720604,7206,'Bungku Utara'),(720605,7206,'Bungku Tengah'),(720606,7206,'Bungku Selatan'),(720607,7206,'Menui Kepulauan'),(720608,7206,'Bungku Barat'),(720609,7206,'Bumi Raya'),(720610,7206,'Bahodopi'),(720611,7206,'Soyo Jaya'),(720612,7206,'Wita Ponda'),(720613,7206,'Mamosalato'),(720614,7206,'Mori Utara'),(720615,7206,'Bungku Pesisir'),(720616,7207,'Lembo Raya'),(720617,7207,'Petasia Timur'),(720618,7207,'Bungku Timur'),(720619,7207,'Petasia Barat'),(720701,7207,'Labobo'),(720702,7207,'Banggai'),(720703,7207,'Totikum'),(720704,7207,'Tinangkung'),(720705,7207,'Liang'),(720706,7207,'Bulagi'),(720707,7207,'Buko'),(720708,7207,'Bokan Kepulauan'),(720709,7207,'Bulagi Selatan'),(720710,7207,'Banggai Utara'),(720711,7207,'Tinangkung Selatan'),(720712,7207,'Bangkurung'),(720713,7207,'Banggai Tengah'),(720714,7207,'Banggai Selatan'),(720715,7207,'Totikum Selatan'),(720716,7208,'Peling Tengah'),(720717,7208,'Bulagi Utara'),(720718,7208,'Buko Selatan'),(720719,7208,'Tinangkung Utara'),(720801,7208,'Parigi'),(720802,7208,'Ampibabo'),(720803,7208,'Tinombo'),(720804,7208,'Moutong'),(720805,7208,'Tomini'),(720806,7208,'Sausu'),(720807,7208,'Bolano Lambunu'),(720808,7208,'Kasimbar'),(720809,7208,'Torue'),(720810,7208,'Tinombo Selatan'),(720811,7208,'Parigi Selatan'),(720812,7208,'Mepanga'),(720813,7208,'Toribulu'),(720814,7208,'Taopa'),(720815,7208,'Balinggi'),(720816,7208,'Parigi Barat'),(720817,7208,'Siniu'),(720818,7208,'Palasa'),(720819,7209,'Parigi Utara'),(720820,7209,'Parigi Tengah'),(720821,7209,'Bolano'),(720822,7209,'Ongka Malino'),(720901,7209,'Una Una'),(720902,7209,'Togean'),(720903,7209,'Walea Kepulauan'),(720904,7209,'Ampana Tete'),(720905,7209,'Ampana Kota'),(720906,7210,'Ulubongka'),(720907,7210,'Tojo Barat'),(720908,7210,'Tojo'),(720909,7210,'Walea Besar'),(721001,7210,'Sigi Biromaru'),(721002,7210,'Palolo'),(721003,7210,'Nokilalaki'),(721004,7210,'Lindu'),(721005,7210,'Kulawi'),(721006,7210,'Kulawi Selatan'),(721007,7210,'Pipikoro'),(721008,7210,'Gumbasa'),(721009,7210,'Dolo Selatan'),(721010,7210,'Tanambulava'),(721011,7210,'Dolo Barat'),(721012,7271,'Dolo'),(721013,7271,'Kinovaro'),(721014,7271,'Marawola'),(721015,7271,'Marawola Barat'),(727101,7271,'Palu Timur'),(727102,7271,'Palu Barat'),(727103,7271,'Palu Selatan'),(727104,7271,'Palu Utara'),(727105,7301,'Ulujadi'),(727106,7301,'Tatanga'),(727107,7301,'Tawaeli'),(727108,7301,'Mantikulore'),(730101,7301,'Benteng'),(730102,7301,'Bontoharu'),(730103,7301,'Bontomatene'),(730104,7301,'Bontomanai'),(730105,7301,'Bontosikuyu'),(730106,7301,'Pasimasunggu'),(730107,7301,'Pasimarannu'),(730108,7302,'Taka Bonerate'),(730109,7302,'Pasilambena'),(730110,7302,'Pasimasunggu Timur'),(730111,7302,'Buki'),(730201,7302,'Gantorang'),(730202,7302,'Ujung Bulu'),(730203,7302,'Bonto Bahari'),(730204,7302,'Bonto Tiro'),(730205,7302,'Herlang'),(730206,7302,'Kajang'),(730207,7303,'Bulukumpa'),(730208,7303,'Kindang'),(730209,7303,'Ujungloe'),(730210,7303,'Rilauale'),(730301,7303,'Bissappu'),(730302,7303,'Bantaeng'),(730303,7303,'Eremerasa'),(730304,7303,'Tompo Bulu'),(730305,7304,'Pajukukang'),(730306,7304,'Uluere'),(730307,7304,'Gantarang Keke'),(730308,7304,'Sinoa'),(730401,7304,'Bangkala'),(730402,7304,'Tamalatea'),(730403,7304,'Binamu'),(730404,7304,'Batang'),(730405,7304,'Kelara'),(730406,7304,'Bangkala Barat'),(730407,7304,'Bontoramba'),(730408,7305,'Turatea'),(730409,7305,'Arungkeke'),(730410,7305,'Rumbia'),(730411,7305,'Tarowang'),(730501,7305,'Mappakasunggu'),(730502,7305,'Mangarabombang'),(730503,7305,'Polombangkeng Selatan'),(730504,7305,'Polombangkeng Utara'),(730505,7305,'Galesong Selatan'),(730506,7306,'Galesong Utara'),(730507,7306,'Pattallassang'),(730508,7306,'Sanrobone'),(730509,7306,'Galesong'),(730601,7306,'Bontonompo'),(730602,7306,'Bajeng'),(730603,7306,'Tompobullu'),(730604,7306,'Tinggimoncong'),(730605,7306,'Parangloe'),(730606,7306,'Bontomarannu'),(730607,7306,'Palangga'),(730608,7306,'Somba Upu'),(730609,7306,'Bungaya'),(730610,7306,'Tombolopao'),(730611,7306,'Biringbulu'),(730612,7306,'Barombong'),(730613,7306,'Pattalasang'),(730614,7306,'Manuju'),(730615,7307,'Bontolempangang'),(730616,7307,'Bontonompo Selatan'),(730617,7307,'Parigi'),(730618,7307,'Bajeng Barat'),(730701,7307,'Sinjai Barat'),(730702,7307,'Sinjai  Selatan'),(730703,7307,'Sinjai Timur'),(730704,7307,'Sinjai Tengah'),(730705,7307,'Sinjai Utara'),(730706,7308,'Bulupoddo'),(730707,7308,'Sinjai Borong'),(730708,7308,'Tellu Limpoe'),(730709,7308,'Pulau Sembilan'),(730801,7308,'Bontocani'),(730802,7308,'Kahu'),(730803,7308,'Kajuara'),(730804,7308,'Salomekko'),(730805,7308,'Tonra'),(730806,7308,'Libureng'),(730807,7308,'Mare'),(730808,7308,'Sibulue'),(730809,7308,'Barebbo'),(730810,7308,'Cina'),(730811,7308,'Ponre'),(730812,7308,'Lappariaja'),(730813,7308,'Lamuru'),(730814,7308,'Ulaweng'),(730815,7308,'Palakka'),(730816,7308,'Awangpone'),(730817,7308,'Tellu Siattinge'),(730818,7308,'Ajangale'),(730819,7308,'Dua Boccoe'),(730820,7308,'Cenrana'),(730821,7308,'Tanete Riattang'),(730822,7308,'Tanete Riattang Barat'),(730823,7308,'Tanete Riattang Timur'),(730824,7309,'Amali'),(730825,7309,'Tellulimpoe'),(730826,7309,'Bengo'),(730827,7309,'Patimpeng'),(730901,7309,'Mandai'),(730902,7309,'Camba'),(730903,7309,'Bantimurung'),(730904,7309,'Maros Baru'),(730905,7309,'Bontoa'),(730906,7309,'Malllawa'),(730907,7309,'Tanralili'),(730908,7309,'Marusu'),(730909,7309,'Simbang'),(730910,7309,'Cenrana'),(730911,7310,'Tompobulu'),(730912,7310,'Lau'),(730913,7310,'Moncong Loe'),(730914,7310,'Turikale'),(731001,7310,'Liukang Tangaya'),(731002,7310,'Liukang Kalmas'),(731003,7310,'Liukang Tupabbiring'),(731004,7310,'Pangkajene'),(731005,7310,'Balocci'),(731006,7310,'Bungoro'),(731007,7310,'Labakkang'),(731008,7310,'Marang'),(731009,7310,'Segeri'),(731010,7311,'Minasa Tene'),(731011,7311,'Mandalle'),(731012,7311,'Tondong Tallasa'),(731013,7311,'Liukang Tupabbiring Utara'),(731101,7311,'Tanete Riaja'),(731102,7311,'Tanete Rilau'),(731103,7311,'Barru'),(731104,7312,'Soppeng Riaja'),(731105,7312,'Mallusetasi'),(731106,7312,'Pujananting'),(731107,7312,'Balusu'),(731201,7312,'Marioriwawo'),(731202,7312,'Liliraja'),(731203,7312,'Lilirilau'),(731204,7312,'Lalabata'),(731205,7313,'Marioriawa'),(731206,7313,'Donri Donri'),(731207,7313,'Ganra'),(731208,7313,'Citta'),(731301,7313,'Sabangparu'),(731302,7313,'Pammana'),(731303,7313,'Takkalalla'),(731304,7313,'Sajoanging'),(731305,7313,'Majauleng'),(731306,7313,'Tempe'),(731307,7313,'Belawa'),(731308,7313,'Tanasitolo'),(731309,7313,'Maniangpajo'),(731310,7313,'Pitumpanua'),(731311,7314,'Bola'),(731312,7314,'Penrang'),(731313,7314,'Gilireng'),(731314,7314,'Keera'),(731401,7314,'Panca Lautan'),(731402,7314,'Tellu Limpoe'),(731403,7314,'Watang Pulu'),(731404,7314,'Baranti'),(731405,7314,'Panca Rijang'),(731406,7314,'Kulo'),(731407,7314,'Maritengngae'),(731408,7315,'WT. Sidenreng'),(731409,7315,'Dua Pitue'),(731410,7315,'Pitu Riawa'),(731411,7315,'Pitu Raise'),(731501,7315,'Matirro Sompe'),(731502,7315,'Suppa'),(731503,7315,'Mattiro Bulu'),(731504,7315,'Watang Sawito'),(731505,7315,'Patampanua'),(731506,7315,'Duampanua'),(731507,7315,'Lembang'),(731508,7315,'Cempa'),(731509,7316,'Tiroang'),(731510,7316,'Lansirang'),(731511,7316,'Paleteang'),(731512,7316,'Batu Lappa'),(731601,7316,'Maiwa'),(731602,7316,'Enrekang'),(731603,7316,'Baraka'),(731604,7316,'Anggeraja'),(731605,7316,'Alla'),(731606,7316,'Bungin'),(731607,7316,'Cendana'),(731608,7316,'Curio'),(731609,7317,'Malua'),(731610,7317,'Buntu Batu'),(731611,7317,'Masalle'),(731612,7317,'Baroko'),(731701,7317,'Basse Sangtempe'),(731702,7317,'Larompong'),(731703,7317,'Suli'),(731704,7317,'Bajo'),(731705,7317,'Bua Ponrang'),(731706,7317,'Walenrang'),(731707,7317,'Belopa'),(731708,7317,'Bua'),(731709,7317,'Lamasi'),(731710,7317,'Larompong Selatan'),(731711,7317,'Ponrang'),(731712,7317,'Latimojong'),(731713,7317,'Kamanre'),(731714,7317,'Belopa Utara'),(731715,7317,'Walenrang Barat'),(731716,7317,'Walenrang Utara'),(731717,7317,'Walenrang Timur'),(731718,7317,'Lamasi Timur'),(731719,7317,'Suli Barat'),(731720,7317,'Bajo Barat'),(731721,7317,'Ponrang Selatan'),(731722,7317,'Basse Sangtempe Utara'),(731801,7318,'Saluputi'),(731802,7318,'Bittuang'),(731803,7318,'Bonggakaradeng'),(731805,7318,'Makale'),(731809,7318,'Simbuang'),(731811,7318,'Rantetayo'),(731812,7318,'Mengkendek'),(731813,7318,'Sangalla'),(731819,7318,'Gandangbatu Sillanan'),(731820,7318,'Rembon'),(731827,7318,'Makale Utara'),(731828,7318,'Mappak'),(731829,7318,'Makale Selatan'),(731831,7318,'Masanda'),(731833,7318,'Sangalla Selatan'),(731834,7318,'Sangalla Utara'),(731835,7318,'Malimbong Balepe'),(731837,7318,'Rano'),(731838,7318,'Kurra'),(732201,7322,'Malangke'),(732202,7322,'Bone Bone'),(732203,7322,'Masamba'),(732204,7322,'Sabbang'),(732205,7322,'Limbong'),(732206,7322,'Sukamaju'),(732207,7322,'Seko'),(732208,7322,'Malangke Barat'),(732209,7322,'Rampi'),(732210,7322,'Mappedeceng'),(732211,7322,'Baebunta'),(732212,7322,'Tana Lili'),(732401,7324,'Mangkutana'),(732402,7324,'Nuha'),(732403,7324,'Towuti'),(732404,7324,'Malili'),(732405,7324,'Angkona'),(732406,7324,'Wotu'),(732407,7324,'Burau'),(732408,7324,'Tomoni'),(732409,7324,'Tomoni Timur'),(732410,7324,'Kalaena'),(732411,7324,'Wasuponda'),(732601,7326,'Rantepao'),(732602,7326,'Sesean'),(732603,7326,'Nanggala'),(732604,7326,'Rindingallo'),(732605,7326,'Buntao'),(732606,7326,'Sa\'dan'),(732607,7326,'Sanggalangi'),(732608,7326,'Sopai'),(732609,7326,'Tikala'),(732610,7326,'Balusu'),(732611,7326,'Tallunglipu'),(732612,7326,'Dende\' Piongan Napo'),(732613,7326,'Buntu Pepasan'),(732614,7326,'Baruppu'),(732615,7326,'Kesu'),(732616,7326,'Tondon'),(732617,7326,'Bangkelekila'),(732618,7326,'Rantebua'),(732619,7326,'Sesean Suloara'),(732620,7326,'Kapala Pitu'),(732621,7326,'Awan Rante Karua'),(737101,7371,'Mariso'),(737102,7371,'Mamajang'),(737103,7371,'Makasar'),(737104,7371,'Ujung Pandang'),(737105,7371,'Wajo'),(737106,7371,'Bontoala'),(737107,7371,'Tallo'),(737108,7371,'Ujung Tanah'),(737109,7371,'Panakukkang'),(737110,7371,'Tamalate'),(737111,7371,'Biringkanaya'),(737112,7371,'Manggala'),(737113,7371,'Rappocini'),(737114,7371,'Tamalanrea'),(737201,7372,'Bacukiki'),(737202,7372,'Ujung'),(737203,7372,'Soreang'),(737204,7372,'Bacukiki Barat'),(737301,7373,'Wara'),(737302,7373,'Wara Utara'),(737303,7373,'Wara Selatan'),(737304,7373,'Telluwanua'),(737305,7373,'Wara Timur'),(737306,7373,'Wara Barat'),(737307,7373,'Sendana'),(737308,7373,'Mungkajang'),(737309,7373,'Bara'),(740101,7401,'Wundulako'),(740102,7401,'Tirawuta'),(740103,7401,'Mowewe'),(740104,7401,'Kolaka'),(740107,7401,'Pomalaa'),(740108,7401,'Watubangga'),(740109,7401,'Ladongi'),(740110,7401,'Wolo'),(740112,7401,'Baula'),(740113,7401,'Uluiwoi'),(740114,7401,'Latambaga'),(740118,7401,'Tanggetada'),(740119,7401,'Lambandia'),(740120,7401,'Samaturu'),(740121,7401,'Tinondo'),(740122,7401,'Poli-Polia'),(740123,7401,'Lalolae'),(740124,7401,'Toari'),(740125,7401,'Polinggona'),(740126,7401,'Loea'),(740201,7402,'Lambuya'),(740202,7402,'Unaaha'),(740203,7402,'Wawotobi'),(740204,7402,'Pondidaha'),(740205,7402,'Sampara'),(740206,7402,'Wawonii Barat'),(740207,7402,'Wawonii Timur'),(740210,7402,'Abuki'),(740211,7402,'Soropia'),(740213,7402,'Wawonii Selatan'),(740214,7402,'Wawonii Utara'),(740215,7402,'Tongauna'),(740216,7402,'Latoma'),(740217,7402,'Puriala'),(740218,7402,'Uepai'),(740219,7402,'Wonggeduku'),(740220,7402,'Besulutu'),(740221,7402,'Bondoala'),(740223,7402,'Routa'),(740224,7402,'Anggaberi'),(740225,7402,'Meluhu'),(740228,7402,'Amonggedo'),(740230,7402,'Wawonii Tengah'),(740231,7402,'Asinua'),(740232,7402,'Konawe'),(740233,7402,'Kapoiala'),(740234,7402,'Wawonii Tenggara'),(740235,7402,'Wawonii Timur Laut'),(740236,7402,'Lalonggasumeeto'),(740237,7402,'Onembute'),(740301,7403,'Maginti'),(740302,7403,'Tiworo Tengah'),(740303,7403,'Tiworo Kepulauan'),(740304,7403,'Sewergadi'),(740305,7403,'Kusambi'),(740306,7403,'Napabalano'),(740307,7403,'Maligano'),(740313,7403,'Wakorumba Selatan'),(740314,7403,'Lasalepa'),(740315,7403,'Batalaiwaru'),(740316,7403,'Katobu'),(740317,7403,'Duruka'),(740318,7403,'Lohia'),(740319,7403,'Watopute'),(740320,7403,'Kontunaga'),(740321,7403,'Barangka'),(740322,7403,'Lawa'),(740323,7403,'Kabangka'),(740324,7403,'Kabawo'),(740325,7403,'Parigi'),(740326,7403,'Bone'),(740327,7403,'Tongkuno'),(740328,7403,'Pasir Putih'),(740330,7403,'Kontu Kowuna'),(740331,7403,'Marobo'),(740332,7403,'Tongkuno Selatan'),(740333,7403,'Pasi Kolaga'),(740334,7403,'Batukara'),(740335,7403,'Wa Daga'),(740336,7403,'Napano Kusambi'),(740337,7403,'Towea'),(740338,7403,'Tiworo Selatan'),(740339,7403,'Tiworo Utara'),(740405,7404,'Mawasangka'),(740406,7404,'Mawasangka Timur'),(740407,7404,'Lakudo'),(740408,7404,'G u'),(740409,7404,'Batauga'),(740410,7404,'Sampolawa'),(740411,7404,'Pasarwajo'),(740418,7404,'Telaga Raya'),(740419,7404,'Kadatua'),(740420,7404,'Siompu'),(740421,7404,'Batu Atas'),(740422,7404,'Kapontori'),(740423,7404,'Lasalimu'),(740424,7404,'Lasalimu Selatan'),(740425,7404,'Mawasangka Tengah'),(740426,7404,'Sangia Wambulu'),(740427,7404,'Siotapina'),(740428,7404,'Wolowa'),(740429,7404,'Wabula'),(740430,7404,'Lapandewa'),(740431,7404,'Siompu Barat'),(740501,7405,'Tinanggea'),(740502,7405,'Angata'),(740503,7405,'Andoolo'),(740504,7405,'Palangga'),(740505,7405,'Landono'),(740506,7405,'Lainea'),(740507,7405,'Konda'),(740508,7405,'Ranomeeto'),(740509,7405,'Kolono'),(740510,7405,'Moramo'),(740511,7405,'Laonti'),(740512,7405,'Lalembuu'),(740513,7405,'Benua'),(740514,7405,'Palangga Selatan'),(740515,7405,'Mowila'),(740516,7405,'Moramo Utara'),(740517,7405,'Buke'),(740518,7405,'Wolasi'),(740519,7405,'Laeya'),(740520,7405,'Baito'),(740521,7405,'Basala'),(740522,7405,'Ranomeeto Barat'),(740601,7406,'Poleang'),(740602,7406,'Poleang Timur'),(740603,7406,'Rarowatu'),(740604,7406,'Rumbia'),(740605,7406,'Kabaena'),(740606,7406,'Kabaena Timur'),(740607,7406,'Poleang Barat'),(740608,7406,'Mata Oleo'),(740609,7406,'Rarowatu Utara'),(740610,7406,'Poleang Utara'),(740611,7406,'Poleang Selatan'),(740612,7406,'Poleang Tenggara'),(740613,7406,'Kabaena Selatan'),(740614,7406,'Kabaena Barat'),(740615,7406,'Kabaena Utara'),(740616,7406,'Kabaena Tengah'),(740617,7406,'Kep. Masaloka Raya'),(740618,7406,'Rumbia Tengah'),(740619,7406,'Poleang Tengah'),(740620,7406,'Tontonunu'),(740621,7406,'Lantari Jaya'),(740622,7406,'Mata Usu'),(740701,7407,'Wangi-Wangi'),(740702,7407,'Kaledupa'),(740703,7407,'Tomia'),(740704,7407,'Binongko'),(740705,7407,'Wangi Wangi Selatan'),(740706,7407,'Kaledupa Selatan'),(740707,7407,'Tomia Timur'),(740708,7407,'Togo Binongko'),(740801,7408,'Lasusua'),(740802,7408,'Pakue'),(740803,7408,'Batu Putih'),(740804,7408,'Rante Angin'),(740805,7408,'Kodeoha'),(740806,7408,'Ngapa'),(740807,7408,'Wawo'),(740808,7408,'Lambai'),(740809,7408,'Watunohu'),(740810,7408,'Pakue Tengah'),(740811,7408,'Pakue Utara'),(740812,7408,'Porehu'),(740813,7408,'Tolala'),(740814,7408,'Tiwu'),(740815,7408,'Katoi'),(740901,7409,'Asera'),(740902,7409,'Wiwirano'),(740903,7409,'Langgikima'),(740904,7409,'Molawe'),(740905,7409,'Lasolo'),(740906,7409,'Lembo'),(740907,7409,'Sawa'),(740908,7409,'Oheo'),(740909,7409,'Andowia'),(740910,7409,'Motui'),(741001,7410,'Kulisusu'),(741002,7410,'Kambowa'),(741003,7410,'Bonegunu'),(741004,7410,'Kulisusu Barat'),(741005,7410,'Kulisusu Utara'),(741006,7410,'Wakorumba Utara'),(747101,7471,'Mandonga'),(747102,7471,'Kendari'),(747103,7471,'Baruga'),(747104,7471,'Poasia'),(747105,7471,'Kendari Barat'),(747106,7471,'Abeli'),(747107,7471,'Wua-Wua'),(747108,7471,'Kadia'),(747109,7471,'Puuwatu'),(747110,7471,'Kambu'),(747201,7472,'Betoambari'),(747202,7472,'Wolio'),(747203,7472,'Sora Walio'),(747204,7472,'Bungi'),(747205,7472,'Kokalukuna'),(747206,7472,'Murhum'),(747207,7472,'Lea-Lea'),(747208,7472,'Batupoaro'),(750101,7501,'Limboto'),(750102,7501,'Telaga'),(750103,7501,'Batudaa'),(750104,7501,'Tibawa'),(750105,7501,'Batudaa Pantai'),(750109,7501,'Boliyohuto'),(750110,7501,'Telaga Biru'),(750111,7501,'Bongomeme'),(750113,7501,'Tolangohula'),(750114,7501,'Mootilango'),(750116,7501,'Pulubala'),(750117,7501,'Limboto Barat'),(750118,7501,'Tilango'),(750119,7501,'Tabongo'),(750120,7501,'Biluhu'),(750121,7501,'Asparaga'),(750122,7501,'Talaga Jaya'),(750123,7501,'Bilato'),(750124,7501,'Dungaliyo'),(750201,7502,'Paguyaman'),(750202,7502,'Wonosari'),(750203,7502,'Dulupi'),(750204,7502,'Tilamuta'),(750205,7502,'Mananggu'),(750206,7502,'Botumoita'),(750207,7502,'Paguyaman Pantai'),(750301,7503,'Tapa'),(750302,7503,'Kabila'),(750303,7503,'Suwawa'),(750304,7503,'Bonepantai'),(750305,7503,'Bulango Utara'),(750306,7503,'Tilongkabila'),(750307,7503,'Botupingge'),(750308,7503,'Kabila Bone'),(750309,7503,'Bone'),(750310,7503,'Bone Raya'),(750311,7503,'Suwawa Timur'),(750312,7503,'Suwawa Selatan'),(750313,7503,'Suwawa Tengah'),(750314,7503,'Bulango Ulu'),(750315,7503,'Bulango Selatan'),(750316,7503,'Bulango Timur'),(750317,7503,'Bulawa'),(750318,7503,'Pinogu'),(750401,7504,'Popayato'),(750402,7504,'Lemito'),(750403,7504,'Randangan'),(750404,7504,'Marisa'),(750405,7504,'Paguat'),(750406,7504,'Patilanggio'),(750407,7504,'Taluditi'),(750408,7504,'Dengilo'),(750409,7504,'Buntulia'),(750410,7504,'Duhiadaa'),(750411,7504,'Wanggarasi'),(750412,7504,'Popayato Timur'),(750413,7504,'Popayato Barat'),(750501,7505,'Atinggola'),(750502,7505,'Kwandang'),(750503,7505,'Anggrek'),(750504,7505,'Sumalata'),(750505,7505,'Tolinggula'),(750506,7505,'Gentuma Raya'),(750507,7505,'Tomolito'),(750508,7505,'Ponelo Kepulauan'),(750509,7505,'Monano'),(750510,7505,'Biau'),(750511,7505,'Sumalata Timur'),(757101,7571,'Kota Barat'),(757102,7571,'Kota Selatan'),(757103,7571,'Kota Utara'),(757104,7571,'Dungingi'),(757105,7571,'Kota Timur'),(757106,7571,'Kota Tengah'),(757107,7571,'Sipatana'),(757108,7571,'Dumbo Raya'),(757109,7571,'Hulonthalangi'),(760101,7601,'Bambalamotu'),(760102,7601,'Pasangkayu'),(760103,7601,'Baras'),(760104,7601,'Sarudu'),(760105,7601,'Dapurang'),(760106,7601,'Duripoku'),(760107,7601,'Bulu Taba'),(760108,7601,'Tikke Raya'),(760109,7601,'Pedongga'),(760110,7601,'Bambaira'),(760111,7601,'Sarjo'),(760112,7601,'Lariang'),(760201,7602,'Mamuju'),(760202,7602,'Tapalang'),(760203,7602,'Kalukku'),(760204,7602,'Kalumpang'),(760205,7602,'Budong-Budong'),(760206,7602,'Pangale'),(760207,7602,'Papalang'),(760208,7602,'Sampaga'),(760209,7602,'Topoyo'),(760210,7602,'Karossa'),(760211,7602,'Tommo'),(760212,7602,'Simboro dan Kepulauan'),(760213,7602,'Tapalang Barat'),(760214,7602,'Tobadak'),(760215,7602,'Bonehau'),(760216,7602,'Kep. Bala Balakang'),(760301,7603,'Mambi'),(760302,7603,'Aralle'),(760303,7603,'Mamasa'),(760304,7603,'Pana'),(760305,7603,'Tabulahan'),(760306,7603,'Sumarorong'),(760307,7603,'Messawa'),(760308,7603,'Sesenapadang'),(760309,7603,'Tanduk Kalua'),(760310,7603,'Tabang'),(760311,7603,'Bambang'),(760312,7603,'Balla'),(760313,7603,'Nosu'),(760314,7603,'Tawalian'),(760315,7603,'Rantebulahan Timur'),(760316,7603,'Buntumalangka'),(760317,7603,'Mehalaan'),(760401,7604,'Tinambung'),(760402,7604,'Campalagian'),(760403,7604,'Wonomulyo'),(760404,7604,'Polewali'),(760405,7604,'Tutar'),(760406,7604,'Binuang'),(760407,7604,'Tapango'),(760408,7604,'Mapilli'),(760409,7604,'Matangnga'),(760410,7604,'Luyo'),(760411,7604,'Limboro'),(760412,7604,'Balanipa'),(760413,7604,'Anreapi'),(760414,7604,'Matakali'),(760415,7604,'Allu'),(760416,7604,'Bulo'),(760501,7605,'Banggae'),(760502,7605,'Pamboang'),(760503,7605,'Sendana'),(760504,7605,'Malunda'),(760505,7605,'Ulumunda'),(760506,7605,'Tammerodo Sendana'),(760507,7605,'Tubo Sendana'),(760508,7605,'Banggae Timur'),(810101,8101,'Amahai'),(810102,8101,'Teon Nila Serua'),(810106,8101,'Seram Utara'),(810109,8101,'Banda'),(810111,8101,'Tehoru'),(810112,8101,'Saparua'),(810113,8101,'Pulau Haruku'),(810114,8101,'Salahutu'),(810115,8101,'Leihitu'),(810116,8101,'Nusa Laut'),(810117,8101,'Kota Masohi'),(810120,8101,'Seram Utara Barat'),(810121,8101,'Teluk Elpaputih'),(810122,8101,'Leihitu Barat'),(810123,8101,'Telutih'),(810124,8101,'Seram Utara Timur Seti'),(810125,8101,'Seram Utara Timur Kobi'),(810126,8101,'Saparua Timur'),(810201,8102,'Kei Kecil'),(810203,8102,'Kei Besar'),(810204,8102,'Kei Besar Selatan'),(810205,8102,'Kei Besar Utara Timur'),(810213,8102,'Kei Kecil Timur'),(810214,8102,'Kei Kecil Barat'),(810215,8102,'Manyeuw'),(810216,8102,'Hoat Sorbay'),(810217,8102,'Kei Besar Utara Barat'),(810218,8102,'Kei Besar Selatan Barat'),(810219,8102,'Kei Kecil Timur Selatan'),(810301,8103,'Tanimbar Selatan'),(810302,8103,'Selaru'),(810303,8103,'Wer Tamrian'),(810304,8103,'Wer Maktian'),(810305,8103,'Tanimbar Utara'),(810306,8103,'Yaru'),(810307,8103,'Wuar Labobar'),(810308,8103,'Kormomolin'),(810309,8103,'Nirunmas'),(810318,8103,'Molu Maru'),(810401,8104,'Namlea'),(810402,8104,'Air Buaya'),(810403,8104,'Waeapo'),(810406,8104,'Waplau'),(810410,8104,'Batabual'),(810411,8104,'Lolong Guba'),(810412,8104,'Waelata'),(810413,8104,'Fena Leisela'),(810414,8104,'Teluk Kaiely'),(810415,8104,'Lilialy'),(810501,8105,'Bula'),(810502,8105,'Seram Timur'),(810503,8105,'Werinama'),(810504,8105,'Pulau Gorong'),(810505,8105,'Wakate'),(810506,8105,'Tutuk Tolu'),(810507,8105,'Siwalalat'),(810508,8105,'Kilmury'),(810509,8105,'Pulau Panjang'),(810510,8105,'Teor'),(810511,8105,'Gorom Timur'),(810512,8105,'Bula Barat'),(810513,8105,'Kian Darat'),(810514,8105,'Siritaun Wida Timur'),(810515,8105,'Teluk Waru'),(810601,8106,'Kairatu'),(810602,8106,'Seram Barat'),(810603,8106,'Taniwel'),(810604,8106,'Huamual Belakang'),(810605,8106,'Amalatu'),(810606,8106,'Inamosol'),(810607,8106,'Kairatu Barat'),(810608,8106,'Huamual'),(810609,8106,'Kepulauan Manipa'),(810610,8106,'Taniwel Timur'),(810611,8106,'Elpaputih'),(810701,8107,'Pulau-Pulau Aru'),(810702,8107,'Aru Selatan'),(810703,8107,'Aru Tengah'),(810704,8107,'Aru Utara'),(810705,8107,'Aru Utara Timur Batuley'),(810706,8107,'Sir-Sir'),(810707,8107,'Aru Tengah Timur'),(810708,8107,'Aru Tengah Selatan'),(810709,8107,'Aru Selatan Timur'),(810710,8107,'Aru Selatan Utara'),(810801,8108,'Moa Lakor'),(810802,8108,'Damer'),(810803,8108,'Mndona Hiera'),(810804,8108,'Pulau-Pulau Babar'),(810805,8108,'Pulau-pulau Babar Timur'),(810806,8108,'Wetar'),(810807,8108,'Pulau-pulau Terselatan'),(810808,8108,'Pulau Leti'),(810809,8108,'Pulau Masela'),(810810,8108,'Dawelor Dawera'),(810811,8108,'Pulau Wetang'),(810812,8108,'Pulau Lakor'),(810813,8108,'Wetar Utara'),(810814,8108,'Wetar Barat'),(810815,8108,'Wetar Timur'),(810816,8108,'Kepulauan Romang'),(810817,8108,'Kisar Utara'),(810901,8109,'Namrole'),(810902,8109,'Waesama'),(810903,8109,'Ambalau'),(810904,8109,'Kepala Madan'),(810905,8109,'Leksula'),(810906,8109,'Fena Fafan'),(817101,8171,'Nusaniwe'),(817102,8171,'Sirimau'),(817103,8171,'Baguala'),(817104,8171,'Teluk Ambon'),(817105,8171,'Leitimur Selatan'),(817201,8172,'Pulau Dullah Utara'),(817202,8172,'Pulau Dullah Selatan'),(817203,8172,'Tayando Tam'),(817204,8172,'Pulau-Pulau Kur'),(817205,8172,'Kur Selatan'),(820101,8201,'Jailolo'),(820102,8201,'Loloda'),(820103,8201,'Ibu'),(820104,8201,'Sahu'),(820105,8201,'Jailolo Selatan'),(820107,8201,'Ibu Utara'),(820108,8201,'Ibu Selatan'),(820109,8201,'Sahu Timur'),(820201,8202,'Weda'),(820202,8202,'Patani'),(820203,8202,'Pulau Gebe'),(820204,8202,'Weda Utara'),(820205,8202,'Weda Selatan'),(820206,8202,'Patani Utara'),(820207,8202,'Weda Tengah'),(820208,8202,'Patani Barat'),(820304,8203,'Galela'),(820305,8203,'Tobelo'),(820306,8203,'Tobelo Selatan'),(820307,8203,'Kao'),(820308,8203,'Malifut'),(820309,8203,'Loloda Utara'),(820310,8203,'Tobelo Utara'),(820311,8203,'Tobelo Tengah'),(820312,8203,'Tobelo Timur'),(820313,8203,'Tobelo Barat'),(820314,8203,'Galela Barat'),(820315,8203,'Galela Utara'),(820316,8203,'Galela Selatan'),(820319,8203,'Loloda Kepulauan'),(820320,8203,'Kao Utara'),(820321,8203,'Kao Barat'),(820322,8203,'Kao Teluk'),(820401,8204,'Pulau Makian'),(820402,8204,'Kayoa'),(820403,8204,'Gane Timur'),(820404,8204,'Gane Barat'),(820405,8204,'Obi Selatan'),(820406,8204,'Obi'),(820407,8204,'Bacan Timur'),(820408,8204,'Bacan'),(820409,8204,'Bacan Barat'),(820410,8204,'Makian Barat'),(820411,8204,'Kayoa Barat'),(820412,8204,'Kayoa Selatan'),(820413,8204,'Kayoa Utara'),(820414,8204,'Bacan Barat Utara'),(820415,8204,'Kasiruta Barat'),(820416,8204,'Kasiruta Timur'),(820417,8204,'Bacan Selatan'),(820418,8204,'Kepulauan Botanglomang'),(820419,8204,'Mandioli Selatan'),(820420,8204,'Mandioli Utara'),(820421,8204,'Bacan Timur Selatan'),(820422,8204,'Bacan Timur Tengah'),(820423,8204,'Gane Barat Selatan'),(820424,8204,'Gane Barat Utara'),(820425,8204,'Kepulauan Joronga'),(820426,8204,'Gane Timur Selatan'),(820427,8204,'Gane Timur Tengah'),(820428,8204,'Obi Barat'),(820429,8204,'Obi Timur'),(820430,8204,'Obi Utara'),(820501,8205,'Mangoli Timur'),(820502,8205,'Sanana'),(820503,8205,'Sulabesi Barat'),(820504,8205,'Taliabu Barat'),(820505,8205,'Taliabu Timur Selatan'),(820506,8205,'Mangoli Barat'),(820507,8205,'Sulabesi Tengah'),(820508,8205,'Sulabesi Timur'),(820509,8205,'Sulabesi Selatan'),(820510,8205,'Mangoli Utara Timur'),(820511,8205,'Mangoli Tengah'),(820512,8205,'Mangoli Selatan'),(820513,8205,'Mangoli Utara'),(820514,8205,'Taliabu -Timur'),(820515,8205,'Taliabu Utara'),(820516,8205,'Taliabu Barat Laut'),(820517,8205,'Taliabu Selatan'),(820518,8205,'Sanana Utara'),(820519,8205,'Lede'),(820601,8206,'Wasile'),(820602,8206,'Maba'),(820603,8206,'Maba Selatan'),(820604,8206,'Wasile Selatan'),(820605,8206,'Wasile Tengah'),(820606,8206,'Wasile Utara'),(820607,8206,'Wasile Timur'),(820608,8206,'Maba Tengah'),(820609,8206,'Maba Utara'),(820610,8206,'Kota Maba'),(820701,8207,'Morotai Selatan'),(820702,8207,'Morotai Selatan Barat'),(820703,8207,'Morotai Jaya'),(820704,8207,'Morotai Utara'),(820705,8207,'Morotai Timur'),(827101,8271,'Pulau Ternate'),(827102,8271,'Kota Ternate Selatan'),(827103,8271,'Kota Ternate Utara'),(827104,8271,'Pulau Moti'),(827105,8271,'Pulau Batang Dua'),(827106,8271,'Kota Ternate Tengah'),(827107,8271,'Pulau Hiri'),(827201,8272,'Tidore'),(827202,8272,'Oba Utara'),(827203,8272,'Oba'),(827204,8272,'Tidore Selatan'),(827205,8272,'Tidore Utara'),(827206,8272,'Oba Tengah'),(827207,8272,'Oba Selatan'),(827208,8272,'Tidore Timur'),(910101,9101,'Merauke'),(910102,9101,'Muting'),(910103,9101,'Okaba'),(910104,9101,'Kimaam'),(910105,9101,'Semangga'),(910106,9101,'Tanah Miring'),(910107,9101,'Jagebob'),(910108,9101,'Sota'),(910109,9101,'Ulilin'),(910110,9101,'Elikobal'),(910111,9101,'Kurik'),(910112,9101,'Naukenjerai'),(910113,9101,'Animha'),(910114,9101,'Malind'),(910115,9101,'Tubang'),(910116,9101,'Ngguti'),(910117,9101,'Kaptel'),(910118,9101,'Tabonji'),(910119,9101,'Waan'),(910120,9101,'Ilwayab'),(910201,9102,'Wamena'),(910203,9102,'Kurulu'),(910204,9102,'Asologaima'),(910212,9102,'Hubikosi'),(910215,9102,'Bolakme'),(910225,9102,'Walelagama'),(910227,9102,'Musatfak'),(910228,9102,'Wolo'),(910229,9102,'Asolokobal'),(910234,9102,'Pelebaga'),(910235,9102,'Yalengga'),(910240,9102,'Trikora'),(910241,9102,'Napua'),(910242,9102,'Walaik'),(910243,9102,'Wouma'),(910244,9102,'Hubikiak'),(910245,9102,'Ibele'),(910246,9102,'Taelarek'),(910247,9102,'Itlay Hisage'),(910248,9102,'Siepkosi'),(910249,9102,'Usilimo'),(910250,9102,'Wita Waya'),(910251,9102,'Libarek'),(910252,9102,'Wadangku'),(910253,9102,'Pisugi'),(910254,9102,'Koragi'),(910255,9102,'Tagime'),(910256,9102,'Molagalome'),(910257,9102,'Tagineri'),(910258,9102,'Silo Karno Doga'),(910259,9102,'Piramid'),(910260,9102,'Muliama'),(910261,9102,'Bugi'),(910262,9102,'Bpiri'),(910263,9102,'Welesi'),(910264,9102,'Asotipo'),(910265,9102,'Maima'),(910266,9102,'Popugoba'),(910267,9102,'Wame'),(910268,9102,'Wesaput'),(910301,9103,'Sentani'),(910302,9103,'Sentani Timur'),(910303,9103,'Depapre'),(910304,9103,'Sentani Barat'),(910305,9103,'Kemtuk'),(910306,9103,'Kemtuk Gresi'),(910307,9103,'Nimboran'),(910308,9103,'Nimbokrang'),(910309,9103,'Unurum Guay'),(910310,9103,'Demta'),(910311,9103,'Kaureh'),(910312,9103,'Ebungfa'),(910313,9103,'Waibu'),(910314,9103,'Nambluong'),(910315,9103,'Yapsi'),(910316,9103,'Airu'),(910317,9103,'Raveni Rara'),(910318,9103,'Gresi  Selatan'),(910319,9103,'Yokari'),(910401,9104,'Nabire'),(910402,9104,'Napan'),(910403,9104,'Yaur'),(910406,9104,'Uwapa'),(910407,9104,'Wanggar'),(910410,9104,'Siriwo'),(910411,9104,'Makimi'),(910412,9104,'Teluk Umar'),(910416,9104,'Teluk Kimi'),(910417,9104,'Yaro'),(910421,9104,'Wapoga'),(910422,9104,'Nabire Barat'),(910423,9104,'Moora'),(910424,9104,'Dipa'),(910425,9104,'Menou'),(910501,9105,'Yapen Selatan'),(910502,9105,'Yapen Barat'),(910503,9105,'Yapen Timur'),(910504,9105,'Angkaisera'),(910505,9105,'Poom'),(910506,9105,'Kosiwo'),(910507,9105,'Yapen Utara'),(910508,9105,'Raimbawi'),(910509,9105,'Teluk Ampimoi'),(910510,9105,'Kepulauan Ambai'),(910511,9105,'Wonawa'),(910512,9105,'Windesi'),(910513,9105,'Pulau Kurudu'),(910514,9105,'Pulau Yerui'),(910601,9106,'Biak Kota'),(910602,9106,'Biak Utara'),(910603,9106,'Biak Timur'),(910604,9106,'Numfor Barat'),(910605,9106,'Numfor Timur'),(910608,9106,'Biak Barat'),(910609,9106,'Warsa'),(910610,9106,'Padaido'),(910611,9106,'Yendidori'),(910612,9106,'Samofa'),(910613,9106,'Yawosi'),(910614,9106,'Andey'),(910615,9106,'Swandiwe'),(910616,9106,'Bruyadori'),(910617,9106,'Orkeri'),(910618,9106,'Poiru'),(910619,9106,'Aimando Padaido'),(910620,9106,'Oridek'),(910621,9106,'Bondifuar'),(910701,9107,'Mulia'),(910703,9107,'Ilu'),(910706,9107,'Fawi'),(910707,9107,'Mewoluk'),(910708,9107,'Yamo'),(910710,9107,'Jigonikme'),(910711,9107,'Torere'),(910712,9107,'Tingginambut'),(910801,9108,'Paniai Timur'),(910802,9108,'Paniai Barat'),(910804,9108,'Aradide'),(910807,9108,'Bogabaida'),(910809,9108,'Bibida'),(910812,9108,'Dumadama'),(910813,9108,'Siriwo'),(910819,9108,'Kebo'),(910820,9108,'Yatamo'),(910821,9108,'Ekadide'),(910901,9109,'Mimika Baru'),(910902,9109,'Agimuga'),(910903,9109,'Mimika Timur'),(910904,9109,'Mimika Barat'),(910905,9109,'Jita'),(910906,9109,'Jila'),(910907,9109,'Mimika Timur Jauh'),(910908,9109,'Mimika Timur Tengah'),(910909,9109,'Kuala Kencana'),(910910,9109,'Tembagapura'),(910911,9109,'Mimika Barat Jauh'),(910912,9109,'Mimika Barat Tengah'),(911001,9110,'Sarmi'),(911002,9110,'Tor Atas'),(911003,9110,'Pantai Barat'),(911004,9110,'Pantai Timur'),(911005,9110,'Bonggo'),(911009,9110,'Apawer Hulu'),(911012,9110,'Sarmi Selatan'),(911013,9110,'Sarmi Timur'),(911014,9110,'Pantai Timur Bagian Barat'),(911015,9110,'Bonggo Timur'),(911101,9111,'Waris'),(911102,9111,'Arso'),(911103,9111,'Senggi'),(911104,9111,'Web'),(911105,9111,'Skanto'),(911106,9111,'Arso Timur'),(911107,9111,'Towe'),(911201,9112,'Oksibil'),(911202,9112,'Kiwirok'),(911203,9112,'Okbibab'),(911204,9112,'Iwur'),(911205,9112,'Batom'),(911206,9112,'Borme'),(911207,9112,'Kiwirok Timur'),(911208,9112,'Aboy'),(911209,9112,'Pepera'),(911210,9112,'Bime'),(911211,9112,'Alemsom'),(911212,9112,'Okbape'),(911213,9112,'Kalomdol'),(911214,9112,'Oksop'),(911215,9112,'Serambakon'),(911216,9112,'Ok Aom'),(911217,9112,'Kawor'),(911218,9112,'Awinbon'),(911219,9112,'Tarup'),(911220,9112,'Okhika'),(911221,9112,'Oksamol'),(911222,9112,'Oklip'),(911223,9112,'Okbemtau'),(911224,9112,'Oksebang'),(911225,9112,'Okbab'),(911226,9112,'Batani'),(911227,9112,'Weime'),(911228,9112,'Murkim'),(911229,9112,'Mofinop'),(911230,9112,'Jetfa'),(911231,9112,'Teiraplu'),(911232,9112,'Eipumek'),(911233,9112,'Pamek'),(911234,9112,'Nongme'),(911301,9113,'Kurima'),(911302,9113,'Anggruk'),(911303,9113,'Ninia'),(911306,9113,'Silimo'),(911307,9113,'Samenage'),(911308,9113,'Nalca'),(911309,9113,'Dekai'),(911310,9113,'Obio'),(911311,9113,'Suru Suru'),(911312,9113,'Wusama'),(911313,9113,'Amuma'),(911314,9113,'Musaik'),(911315,9113,'Pasema'),(911316,9113,'Hogio'),(911317,9113,'Mugi'),(911318,9113,'Soba'),(911319,9113,'Werima'),(911320,9113,'Tangma'),(911321,9113,'Ukha'),(911322,9113,'Panggema'),(911323,9113,'Kosarek'),(911324,9113,'Nipsan'),(911325,9113,'Ubahak'),(911326,9113,'Pronggoli'),(911327,9113,'Walma'),(911328,9113,'Yahuliambut'),(911329,9113,'Hereapini'),(911330,9113,'Ubalihi'),(911331,9113,'Talambo'),(911332,9113,'Puldama'),(911333,9113,'Endomen'),(911334,9113,'Kona'),(911335,9113,'Dirwemna'),(911336,9113,'Holuon'),(911337,9113,'Lolat'),(911338,9113,'Soloikma'),(911339,9113,'Sela'),(911340,9113,'Korupun'),(911341,9113,'Langda'),(911342,9113,'Bomela'),(911343,9113,'Suntamon'),(911344,9113,'Seredela'),(911345,9113,'Sobaham'),(911346,9113,'Kabianggama'),(911347,9113,'Kwelemdua'),(911348,9113,'Kwikma'),(911349,9113,'Hilipuk'),(911350,9113,'Duram'),(911351,9113,'Yogosem'),(911352,9113,'Kayo'),(911353,9113,'Sumo'),(911401,9114,'Karubaga'),(911402,9114,'Bokondini'),(911403,9114,'Kanggime'),(911404,9114,'Kembu'),(911405,9114,'Goyage'),(911406,9114,'Wunim'),(911407,9114,'Wina'),(911408,9114,'Umagi'),(911409,9114,'Panaga'),(911410,9114,'Woniki'),(911411,9114,'Kubu'),(911412,9114,'Konda/ Kondaga'),(911413,9114,'Nelawi'),(911414,9114,'Kuari'),(911415,9114,'Bokoneri'),(911416,9114,'Bewani'),(911418,9114,'Nabunage'),(911419,9114,'Gilubandu'),(911420,9114,'Nunggawi'),(911421,9114,'Gundagi'),(911422,9114,'Numba'),(911423,9114,'Timori'),(911424,9114,'Dundu'),(911425,9114,'Geya'),(911426,9114,'Egiam'),(911427,9114,'Poganeri'),(911428,9114,'Kamboneri'),(911429,9114,'Airgaram'),(911430,9114,'Wari/Taiyeve II'),(911431,9114,'Dow'),(911432,9114,'Tagineri'),(911433,9114,'Yuneri'),(911434,9114,'Wakuwo'),(911435,9114,'Gika'),(911436,9114,'Telenggeme'),(911437,9114,'Anawi'),(911438,9114,'Wenam'),(911439,9114,'Wugi'),(911440,9114,'Danime'),(911441,9114,'Tagime'),(911442,9114,'Kai'),(911443,9114,'Aweku'),(911444,9114,'Bogonuk'),(911445,9114,'Li Anogomma'),(911446,9114,'Biuk'),(911447,9114,'Yuko'),(911501,9115,'Waropen Bawah'),(911503,9115,'Masirei'),(911507,9115,'Risei Sayati'),(911508,9115,'Urei Faisei'),(911509,9115,'Inggerus'),(911510,9115,'Kirihi'),(911511,9115,'Oudate'),(911512,9115,'Wapoga'),(911513,9115,'Demba'),(911601,9116,'Mandobo'),(911602,9116,'Mindiptana'),(911603,9116,'Waropko'),(911604,9116,'Kouh'),(911605,9116,'Jair'),(911606,9116,'Bomakia'),(911607,9116,'Kombut'),(911608,9116,'Iniyandit'),(911609,9116,'Arimop'),(911610,9116,'Fofi'),(911611,9116,'Ambatkwi'),(911612,9116,'Manggelum'),(911613,9116,'Firiwage'),(911614,9116,'Yaniruma'),(911615,9116,'Subur'),(911616,9116,'Kombay'),(911617,9116,'Ninati'),(911618,9116,'Sesnuk'),(911619,9116,'Ki'),(911620,9116,'Kawagit'),(911701,9117,'Obaa'),(911702,9117,'Mambioman Bapai'),(911703,9117,'Citak-Mitak'),(911704,9117,'Edera'),(911705,9117,'Haju'),(911706,9117,'Assue'),(911707,9117,'Kaibar'),(911708,9117,'Passue'),(911709,9117,'Minyamur'),(911710,9117,'Venaha'),(911711,9117,'Syahcame'),(911712,9117,'Yakomi'),(911713,9117,'Bamgi'),(911714,9117,'Passue Bawah'),(911715,9117,'Ti  Zain'),(911801,9118,'Agats'),(911802,9118,'Atsj'),(911803,9118,'Sawa Erma'),(911804,9118,'Akat'),(911805,9118,'Fayit'),(911806,9118,'Pantai Kasuari'),(911807,9118,'Suator'),(911808,9118,'Suru-suru'),(911809,9118,'Kolf Braza'),(911810,9118,'Unir Sirau'),(911811,9118,'Joerat'),(911812,9118,'Pulau Tiga'),(911813,9118,'Jetsy'),(911814,9118,'Der Koumur'),(911815,9118,'Kopay'),(911816,9118,'Safan'),(911817,9118,'Sirets'),(911818,9118,'Ayip'),(911819,9118,'Betcbamu'),(911901,9119,'Supiori Selatan'),(911902,9119,'Supiori Utara'),(911903,9119,'Supiori Timur'),(911904,9119,'Kepulauan Aruri'),(911905,9119,'Supiori Barat'),(912001,9120,'Mamberamo Tengah'),(912002,9120,'Mamberamo Hulu'),(912003,9120,'Rufaer'),(912004,9120,'Mamberamo Tengah Timur'),(912005,9120,'Mamberamo Hilir'),(912006,9120,'Waropen Atas'),(912007,9120,'Benuki'),(912008,9120,'Sawai'),(912101,9121,'Kobagma'),(912102,9121,'Kelila'),(912103,9121,'Eragayam'),(912104,9121,'Megambilis'),(912105,9121,'Ilugwa'),(912201,9122,'Elelim'),(912202,9122,'Apalapsili'),(912203,9122,'Abenaho'),(912204,9122,'Benawa'),(912205,9122,'Welarek'),(912301,9123,'Tiom'),(912302,9123,'Pirime'),(912303,9123,'Makki'),(912304,9123,'Gamelia'),(912305,9123,'Dimba'),(912306,9123,'Melagineri'),(912307,9123,'Balingga'),(912308,9123,'Tiomneri'),(912309,9123,'Kuyawage'),(912310,9123,'Poga'),(912401,9124,'Kenyam'),(912402,9124,'Mapenduma'),(912403,9124,'Yigi'),(912404,9124,'Wosak'),(912405,9124,'Geselma'),(912406,9124,'Mugi'),(912407,9124,'Mbuwa'),(912408,9124,'Gearek'),(912409,9124,'Koroptak'),(912410,9124,'Kegayem'),(912411,9124,'Paro'),(912412,9124,'Mebarok'),(912413,9124,'Yenggelo'),(912414,9124,'Kilmid'),(912415,9124,'Alama'),(912416,9124,'Yal'),(912417,9124,'Mam'),(912418,9124,'Dal'),(912419,9124,'Nirkuri'),(912420,9124,'Inikgal'),(912421,9124,'Iniye'),(912422,9124,'Mbulmu Yalma'),(912423,9124,'Mbua Tengah'),(912424,9124,'Embetpen'),(912425,9124,'Kora'),(912426,9124,'Wusi'),(912427,9124,'Pija'),(912428,9124,'Moba'),(912429,9124,'Wutpaga'),(912430,9124,'Nenggeagin'),(912431,9124,'Krepkuri'),(912432,9124,'Pasir Putih'),(912501,9125,'Ilaga'),(912502,9125,'Wangbe'),(912503,9125,'Beoga'),(912504,9125,'Doufo'),(912505,9125,'Pogoma'),(912506,9125,'Sinak'),(912507,9125,'Agandugume'),(912508,9125,'Gome'),(912601,9126,'Kamu'),(912602,9126,'Mapia'),(912603,9126,'Piyaiye'),(912604,9126,'Kamu Utara'),(912605,9126,'Sukikai Selatan'),(912606,9126,'Mapia Barat'),(912607,9126,'Kamu Selatan'),(912608,9126,'Kamu Timur'),(912609,9126,'Mapia Tengah'),(912610,9126,'Dogiyai'),(912701,9127,'Sugapa'),(912702,9127,'Homeyo'),(912703,9127,'Wandai'),(912704,9127,'Biandoga'),(912705,9127,'Agisiga'),(912706,9127,'Hitadipa'),(912801,9128,'Tigi'),(912802,9128,'Tigi Timur'),(912803,9128,'Bowobado'),(912804,9128,'Tigi Barat'),(912805,9128,'Kapiraya'),(917101,9171,'Jayapura Utara'),(917102,9171,'Jayapura Selatan'),(917103,9171,'Abepura'),(917104,9171,'Muara Tami'),(917105,9171,'Heram'),(920101,9201,'Makbon'),(920104,9201,'Beraur'),(920105,9201,'Salawati'),(920106,9201,'Seget'),(920107,9201,'Aimas'),(920108,9201,'Klamono'),(920110,9201,'Sayosa'),(920112,9201,'Segun'),(920113,9201,'Mayamuk'),(920114,9201,'Salawati Selatan'),(920117,9201,'Klabot'),(920118,9201,'Klawak'),(920216,9201,'Testega'),(920217,9201,'Tanah Rubuh'),(920218,9201,'Neney'),(920219,9201,'Momi - Waren'),(920220,9201,'Tohota'),(920221,9201,'Sidey'),(920223,9201,'Taige'),(920224,9201,'Membey'),(920225,9201,'Anggi Gida'),(920226,9201,'Didohu'),(920227,9201,'Dataran Isim'),(920229,9201,'Catubouw'),(920230,9201,'Hink'),(920301,9203,'Fak-Fak'),(920302,9203,'Fak-Fak Barat'),(920303,9203,'Fak-Fak Timur'),(920304,9203,'Kokas'),(920305,9203,'Fak-Fak Tengah'),(920306,9203,'Karas'),(920307,9203,'Bomberay'),(920308,9203,'Kramongmongga'),(920309,9203,'Teluk Patipi'),(920401,9204,'Teminabuan'),(920404,9204,'Inanwatan'),(920406,9204,'Sawiat'),(920409,9204,'Kokoda'),(920410,9204,'Moswaren'),(920411,9204,'Seremuk'),(920412,9204,'Wayer'),(920414,9204,'Kais'),(920415,9204,'Konda'),(920420,9204,'Matemani'),(920421,9204,'Kokoda Utara'),(920422,9204,'Saifi'),(920424,9204,'Fokour'),(920501,9205,'Misool (Misool Utara)'),(920502,9205,'Waigeo Utara'),(920503,9205,'Waigeo Selatan'),(920504,9205,'Salawati Utara'),(920505,9205,'Kepulauan Ayau'),(920506,9205,'Misool Timur'),(920507,9205,'Waigeo Barat'),(920508,9205,'Waigeo Timur'),(920509,9205,'Teluk Mayalibit'),(920510,9205,'Kofiau'),(920511,9205,'Meos Mansar'),(920513,9205,'Misool Selatan'),(920514,9205,'Warwarbomi'),(920515,9205,'Waigeo Barat Kepulauan'),(920516,9205,'Misool Barat'),(920517,9205,'Kepulauan Sembilan'),(920518,9205,'Kota Waisai'),(920519,9205,'Tiplol Mayalibit'),(920520,9205,'Batanta Utara'),(920521,9205,'Salawati Barat'),(920522,9205,'Salawati Tengah'),(920523,9205,'Supnin'),(920524,9205,'Ayau'),(920525,9205,'Batanta Selatan'),(920601,9206,'Bintuni'),(920602,9206,'Merdey'),(920603,9206,'Babo'),(920604,9206,'Aranday'),(920605,9206,'Moskona Selatan'),(920606,9206,'Moskona Utara'),(920607,9206,'Wamesa'),(920608,9206,'Fafurwar'),(920609,9206,'Tembuni'),(920610,9206,'Kuri'),(920611,9206,'Manimeri'),(920612,9206,'Tuhiba'),(920613,9206,'Dataran Beimes'),(920614,9206,'Sumuri'),(920615,9206,'Kaitaro'),(920616,9206,'Aroba'),(920617,9206,'Masyeta'),(920618,9206,'Biscoop'),(920619,9206,'Tomu'),(920620,9206,'Kamundan'),(920621,9206,'Weriagar'),(920622,9206,'Moskona Barat'),(920623,9206,'Meyado'),(920624,9206,'Moskona Timur'),(920701,9207,'Wasior'),(920702,9207,'Windesi'),(920703,9207,'Teluk Duairi'),(920704,9207,'Wondiboy'),(920705,9207,'Wamesa'),(920706,9207,'Rumberpon'),(920707,9207,'Naikere'),(920708,9207,'Rasiei'),(920709,9207,'Kuri Wamesa'),(920710,9207,'Roon'),(920711,9207,'Roswar'),(920712,9207,'Nikiwar'),(920713,9207,'Soug Jaya'),(920801,9208,'Kaimana'),(920802,9208,'Buruway'),(920803,9208,'Teluk Arguni Atas'),(920804,9208,'Teluk Etna'),(920805,9208,'Kambrau'),(920806,9208,'Teluk Arguni Bawah'),(920807,9208,'Yamor'),(920901,9209,'Fef'),(920902,9209,'Miyah'),(920903,9209,'Yembun'),(920904,9209,'Kwoor'),(920905,9209,'Sausapor'),(920906,9209,'Abun'),(920907,9209,'Syujak'),(920908,9209,'Moraid'),(920909,9209,'Kebar'),(920910,9209,'Amberbaken'),(920911,9209,'Senopi'),(920912,9209,'Mubrani'),(921001,9210,'Aifat'),(921002,9210,'Aifat Utara'),(921003,9210,'Aifat Timur'),(921004,9210,'Aifat Selatan'),(921005,9210,'Aitinyo Barat'),(921006,9210,'Aitinyo'),(921007,9210,'Aitinyo Utara'),(921008,9210,'Ayamaru'),(921009,9210,'Ayamaru Utara'),(921010,9210,'Ayamaru Timur'),(921011,9210,'Mare'),(921012,9210,'Aifat Timur Tengah'),(921013,9210,'Aifat Timur Jauh'),(921014,9210,'Aifat Timur Selatan'),(921015,9210,'Ayamaru Selatan'),(921016,9210,'Ayamaru Jaya'),(921017,9210,'Ayamaru Selatan Jaya'),(921019,9213,'Tanjung Palas Timur');

/*Table structure for table `komisaris` */

DROP TABLE IF EXISTS `komisaris`;

CREATE TABLE `komisaris` (
  `id_komisaris` int(11) NOT NULL AUTO_INCREMENT,
  `perusahaan_id` int(11) DEFAULT NULL,
  `nama_komisaris` varchar(50) NOT NULL DEFAULT '',
  `jabatan` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_komisaris`),
  KEY `FK_komisaris` (`perusahaan_id`),
  CONSTRAINT `FK_komisaris` FOREIGN KEY (`perusahaan_id`) REFERENCES `perusahaan` (`id_perusahaan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `komisaris` */

/*Table structure for table `kriteria` */

DROP TABLE IF EXISTS `kriteria`;

CREATE TABLE `kriteria` (
  `id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `id_aspek` tinyint(3) NOT NULL DEFAULT '0',
  `nama_kriteria` varchar(50) NOT NULL DEFAULT '',
  `bobot` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_aspek` (`id_aspek`),
  CONSTRAINT `kriteria_ibfk_1` FOREIGN KEY (`id_aspek`) REFERENCES `aspek` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `kriteria` */

insert  into `kriteria`(`id`,`id_aspek`,`nama_kriteria`,`bobot`) values (1,1,'Belum ada proses',0),(2,1,'Pelaksanaan',7),(3,1,'Penetapan',15),(4,2,'Belum ada Proses',0),(5,2,'Dalam Proses',7),(6,2,'Sudah Persetujuan',15),(7,3,'Belum ada Proses',0),(8,3,'Sudah Pengesahan',10),(9,4,'Belum Tersedia',0),(10,4,'Tersedia 1% s/d 50%',7),(11,4,'Tersedia diatas 50%',15),(12,5,'Belum ada Penanaman',0),(13,5,'Realisasi 1% s/d 50%',15),(14,5,'realisasi diatas 50%',25),(15,6,'Belum Pengajuan',0),(16,6,'Sudah SVLK',10),(17,6,'Sudah PHPL',20);

/*Table structure for table `legalitas_perusahaan` */

DROP TABLE IF EXISTS `legalitas_perusahaan`;

CREATE TABLE `legalitas_perusahaan` (
  `id_legalitas` int(11) NOT NULL AUTO_INCREMENT,
  `perusahaan_id` int(11) DEFAULT NULL,
  `jenis_legalitas` enum('Akte Pendirian','Akte Perubahan') NOT NULL DEFAULT 'Akte Pendirian',
  `notaris` varchar(50) NOT NULL DEFAULT '',
  `nomor` varchar(100) NOT NULL DEFAULT '',
  `tanggal` date DEFAULT NULL,
  `perubahan_ke` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_legalitas`),
  KEY `FK_legalitas_perusahaan` (`perusahaan_id`),
  CONSTRAINT `FK_legalitas_perusahaan` FOREIGN KEY (`perusahaan_id`) REFERENCES `perusahaan` (`id_perusahaan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `legalitas_perusahaan` */

/*Table structure for table `m_jenis_hewan` */

DROP TABLE IF EXISTS `m_jenis_hewan`;

CREATE TABLE `m_jenis_hewan` (
  `id_jenis_hewan` tinyint(3) NOT NULL AUTO_INCREMENT,
  `nama_jenis` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_jenis_hewan`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `m_jenis_hewan` */

insert  into `m_jenis_hewan`(`id_jenis_hewan`,`nama_jenis`) values (1,'Mamalia'),(2,'Unggas'),(3,'Lainnya');

/*Table structure for table `master_blok` */

DROP TABLE IF EXISTS `master_blok`;

CREATE TABLE `master_blok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_blok` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Data for the table `master_blok` */

insert  into `master_blok`(`id`,`nama_blok`) values (1,'Blok I'),(2,'Blok II'),(3,'Blok III'),(4,'Blok IV'),(5,'Blok V'),(6,'Blok VI'),(7,'Blok VII'),(8,'Blok VIII'),(9,'Blok IX'),(10,'Blok X'),(11,'Blok XI'),(12,'Blok XII'),(13,'Blok XIII'),(14,'Blok XIV'),(15,'Blok XV'),(16,'Blok XVI'),(17,'Blok XVII'),(18,'Blok XVIII'),(19,'Blok XIX'),(20,'Blok XX');

/*Table structure for table `master_jarak_tanam` */

DROP TABLE IF EXISTS `master_jarak_tanam`;

CREATE TABLE `master_jarak_tanam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jarak_tanam` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `master_jarak_tanam` */

insert  into `master_jarak_tanam`(`id`,`jarak_tanam`) values (1,'3x3'),(2,'3x1');

/*Table structure for table `master_jenis_batas` */

DROP TABLE IF EXISTS `master_jenis_batas`;

CREATE TABLE `master_jenis_batas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_batas` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `master_jenis_batas` */

insert  into `master_jenis_batas`(`id`,`jenis_batas`) values (1,'Batas Alam'),(2,'Batas Sendiri'),(3,'Batas Persekutuan');

/*Table structure for table `master_jenis_dalkar` */

DROP TABLE IF EXISTS `master_jenis_dalkar`;

CREATE TABLE `master_jenis_dalkar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_dalkar` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `master_jenis_dalkar` */

insert  into `master_jenis_dalkar`(`id`,`jenis_dalkar`) values (1,'Menara Pengawas Kebakaran'),(2,'Personil/Satgas Damkarhut'),(3,'Alat Komunikasi/HT'),(4,'Kendaraan Patroli'),(5,'Perlengkapan Pemadam Kebakaran'),(6,'Tenaga Satpam'),(7,'Truck Tanki Air & Embung Air'),(8,'Organisasi');

/*Table structure for table `master_jenis_ganis` */

DROP TABLE IF EXISTS `master_jenis_ganis`;

CREATE TABLE `master_jenis_ganis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jenis` varchar(255) NOT NULL,
  `val1` int(11) DEFAULT NULL,
  `val2` int(11) DEFAULT NULL,
  `val3` int(11) DEFAULT NULL,
  `val4` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `master_jenis_ganis` */

insert  into `master_jenis_ganis`(`id`,`nama_jenis`,`val1`,`val2`,`val3`,`val4`) values (1,'Sarjana Kehutanan',2,3,4,5),(2,'GANISPHPL CANHUT',1,2,4,6),(3,'GANISPHPL NENHUT',1,2,4,5),(4,'GANISPHPL BINHUT',2,5,7,10),(5,'GANISPHPL KPKBR',2,5,9,11),(6,'GANISPHPL KURPET',1,2,4,6),(7,'Non Teknis',1,2,3,4);

/*Table structure for table `master_jenis_infra_mukim` */

DROP TABLE IF EXISTS `master_jenis_infra_mukim`;

CREATE TABLE `master_jenis_infra_mukim` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_sarana` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `master_jenis_infra_mukim` */

insert  into `master_jenis_infra_mukim`(`id`,`nama_sarana`) values (1,'Sarana Peribadatan'),(2,'Sarana Olahraga'),(3,'Sarana Kesehatan');

/*Table structure for table `master_jenis_kawasan_lindung` */

DROP TABLE IF EXISTS `master_jenis_kawasan_lindung`;

CREATE TABLE `master_jenis_kawasan_lindung` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jenis` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `master_jenis_kawasan_lindung` */

insert  into `master_jenis_kawasan_lindung`(`id`,`nama_jenis`) values (1,'Buffer zone Hutan Lindung'),(2,'Sempadan Sungai'),(3,'KPPN'),(4,'DPSL');

/*Table structure for table `master_jenis_kayu` */

DROP TABLE IF EXISTS `master_jenis_kayu`;

CREATE TABLE `master_jenis_kayu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kayu` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `master_jenis_kayu` */

insert  into `master_jenis_kayu`(`id`,`nama_kayu`) values (1,'Kayu Bulat'),(2,'Kayu Bulat Kecil');

/*Table structure for table `master_jenis_kelamin` */

DROP TABLE IF EXISTS `master_jenis_kelamin`;

CREATE TABLE `master_jenis_kelamin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_kelamin` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `master_jenis_kelamin` */

insert  into `master_jenis_kelamin`(`id`,`jenis_kelamin`) values (1,'Laki-laki'),(2,'Perempuan');

/*Table structure for table `master_jenis_kelompok_kayu` */

DROP TABLE IF EXISTS `master_jenis_kelompok_kayu`;

CREATE TABLE `master_jenis_kelompok_kayu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kelompok` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `master_jenis_kelompok_kayu` */

insert  into `master_jenis_kelompok_kayu`(`id`,`nama_kelompok`) values (1,'Kel. Meranti'),(2,'Kel. R. Campuran'),(3,'Kel. Kayu Indah');

/*Table structure for table `master_jenis_kph` */

DROP TABLE IF EXISTS `master_jenis_kph`;

CREATE TABLE `master_jenis_kph` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kph` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=latin1;

/*Data for the table `master_jenis_kph` */

insert  into `master_jenis_kph`(`id`,`nama_kph`,`alamat`) values (1,'KPH Aceh','Lintas Kabupaten'),(2,'KPHP Mandailing Natal','Kab. Mandailing Natal'),(3,'KPHL Toba samosir','Kab. Toba Samosir'),(4,'KPHL Unit XXII','Kab. Toba Samosir'),(5,'KPHL Sijunjung','Kab. Sijunjung'),(7,'KPHL Solok (Unit VI)','Kab. Solok'),(8,'KPHL Lima Puluh Kota (Unit II)','Kab. Lima Puluh Kota'),(9,'KPHP Dharmasraya','Kab. Dharmasraya'),(10,'KPHP Pesisir Selatan','Kab. Pesisir Selatan'),(11,'KPHP Kampar Kiri (Unit XVIII)','Kab. Kampar'),(12,'KPHP Minas Tahura','Kab. Siak & Kampar'),(13,'KPHP Tasik Besar Serkap*','Kab. Pelalawan & Siak'),(14,'KPHP Tebing Tinggi (Unit XXIV)','Kab. Kepulauan Meranti'),(15,'KPHL Karimun (Unit I)','Kab. Karimun'),(16,'KPHP Bukit Lubuk Pekak-Hulu Landai','Kab. Merangin'),(17,'KPHP Limau (Unit VII)','Kab. Sarolangun'),(18,'KPHP Kerinci','Kab. Kerinci'),(19,'KPHL Sungai Beram Hitam','Kab. Tanjung Jabung Barat'),(20,'KPHP Benakat (Revisi)','Kab. Ogan Komering Ulu & Muara Enim'),(21,'KPHP Lakitan VI','Kab. Musi Rawas'),(22,'KPHP Unit III Lalan Mangsang Mendis','Kab. Musi Banyuasin'),(23,'KPHP Meranti','Kab. Musi Banyuasin'),(24,'KPHP Rawas','Kab. Musi Rawas'),(25,'KPHL Banyuasin','Kab. Musi Banyuasin'),(26,'KPHP Gunung Duren','Kab. Belitung Timur'),(27,'KPHP Rambat Menduyung','Kab. Bangka Barat'),(28,'KPHP Sungai Sembulan','Kab. Bangka Tengah'),(29,'KPHP Sigambir-Kotawaringin*','Kab. Bangka'),(30,'KPHP Muko-Muko','Kab. Muko-muko'),(31,'KPHP Bengkulu Utara*','Kab. Bengkulu Utara'),(32,'KPHL Bukit Balai Rejong ','Kab. Rejang Lebong'),(33,'KPHL Kotaagung Utara (Unit X)','Kab. Tanggamus'),(34,'KPHL Batu Tegi','Kab. Tanggamus'),(35,'KPHP Bukit Punggur','Kab. Way Kanan'),(36,'KPHP Gedong Wani (Unit XVI)','Kab. Lampung Selatan & Lampung Timur'),(37,'KPHP Muara Dua ','Kab. Tulang Bawang'),(38,'KPHP Register 47 Way Terusan','Kab. Lampung Tengah'),(39,'KPHP Sungai Buaya','Kab. Mesuji'),(40,'KPHL Pesawaran','Kab. Pesawaran'),(41,'KPHL Rajabasa (Unit XIV)','Kab. Lampung Selatan'),(42,'KPHP YOGYAKARTA','Kab. Kulonprogo'),(43,'KPHL Bali Barat','Kab. Jembarana'),(44,'KPHL Bali Timur (Unit III)','Kab. Buleleng'),(45,'KPHL Bali Tengah (Unit II)','Kab. Buleleng'),(46,'KPHL Ampang','Kab. Sumbawa'),(47,'KPHP Batulanteh (Unit IX)','Kab. Sumbawa'),(48,'KPHP Maria Unit XXIII','Kab. Bima'),(49,'KPHP Tambora Utara','Kab. Bima & Dompu'),(50,'KPHP Sejorong','Kab. Sumbawa Barat'),(51,'KPHL Rinjani Barat','Kab. Lombok Barat & Lombok Utara'),(52,'KPHL Tastura','Kab. Lombok Tengah'),(53,'KPHL Rinjani Timur','Kab. Lombok Timur'),(54,'KPHL Alor  Pantar','Kab. Alor'),(55,'KPHP Rote Ndao','Kab. Rote Ndao'),(56,'KPHP Manggarai Barat','Kab. Manggarai Barat'),(57,'KPHL Flores Timur','Kab. Flores Timur'),(58,'KPHL Mutis Timau (Unit XIX)','Kab. Kupang'),(59,'KPHP Kapuas Hulu (Unit XVIII dan XIX)','Kab. Kapuas Hulu'),(60,'KPHP Sungai Marakai','Kab. Sintang'),(61,'KPHP Ketapang','Kab. Ketapang'),(62,'KPHL Hulu Sungai Selatan','Kab. Hulu Sungai Selatan'),(63,'KPHP Banjar','Kab. Banjar'),(64,'KPHP Pulau Laut dan Sebuku (Unit III)','Kab. Kota Baru'),(65,'KPHP Tanah Laut ','Kab. Tanah Laut'),(66,'KPHP Tabalong','Kab. Tabalong'),(67,'KPHL Gerbang Barito',''),(68,'KPHP Kota Waringin Barat','Kab. Kota Waringin Barat'),(69,'KPHP Lamandau','Kab. Lamandau'),(70,'KPHP Seruyan (Unit XXI)','Kab. Seruyan'),(71,'KPHP Murung Raya*','Kab. Murung Raya'),(72,'KPHP Gunung Mas','Kab. Gunung Mas'),(73,'KPHL Kapuas','Kab. Kapuas'),(74,'KPHP Berau Barat','Kab. Berau'),(75,'KPHP Kayan','kab. Bulungan'),(76,'KPHP Malinau (Unit X)','Kab. Malinau'),(77,'KPHP Meratus','Kab. Kutai Kartanegara'),(78,'KPHP Kendilo','Kab. Paser'),(79,'KPHL Tarakan','Kab. Kota Tarakan'),(80,'KPHP Poigar','Kab. Bolaang Mongondow & Minahasa Selatan'),(81,'KPHL Unit III Pohuwato','Kab. Pohuwatu'),(82,'KPHP Boalemo (UNIT V)','Kab. Boalemo'),(83,'KPHP Gorontalo Utara (Unit IV)','Kab. Gorontalo Utara'),(84,'KPHP Gorontalo*','Kab. Gorontalo'),(85,'KPHP Dampelas Tinombo','Kab. Donggala'),(86,'KPHP Dolago Tanggunung','Kab. Parigi Moutong'),(87,'KPHP Pogogul','Kab. Buol'),(88,'KPHP  Toli Baturube*','Kab. Banggai & Tojo Una-Una'),(89,'KPHP Tojo una-Una*','Kab. Tojo Una-Una'),(90,'KPHP Sintuwu Maroso','Kab. Poso'),(91,'KPHP Balantak','Kab. Banggai'),(92,'KPHL Konawe','Kab. Konawe'),(93,'KPHP Lakompa (Unit III)','Kab. Buton'),(94,'KPHP Gularaya (Unit XXIV)','Kab. Konawe Selatan & Kota Kendari'),(95,'KPHL Peropa ea Gantara','Kab. Buton Utara'),(96,'KPHP Tina Orima Bombana','Kab. Bombana'),(97,'KPHL Larona Malili (Unit I)','Kab. Luwu Timur'),(98,'KPHP Jeneberang (Unit IX)','Kab. Bone'),(99,'KPHP Awota','Kab. Wajo'),(100,'KPHL Mapili','Kab. Polewali Mandar'),(101,'KPHL Unit II Lariang','Kab. Mamuju Utara'),(102,'KPHP Mamasa Barat (Unit VII)','Kab. Mamasa'),(103,'KPHP Buddong-Buddong*','Kab. Mamuju'),(104,'KPHL Malunda','Kab. Majene'),(105,'KPHL Mamasa Tengah (Unit VIII)','Kab. Mamasa'),(106,'KPHL Ganda Dewata','Kab. Mamuju'),(107,'KPHP Wae Apu','Kab. Buru'),(108,'KPHP Wae Sapalewa','Kab. Maluku Tengah'),(109,'KPHP Wae Tina*','Maluku'),(110,'KPHP Wae Bubi*','Kab. Seram Bagian Timur'),(111,'KPHP Gunung Sinopa','Kab. Halmahera Tengah &Kota Tidore Kepulauan'),(112,'KPHP Bacan*','Kab. Halmahera Selatan'),(113,'KPHL Biak Numfor','Kab. Biak Numfor'),(114,'KPHP Keerom (Revisi)','Kab. Keerom'),(115,'KPHP Mamberamo (Revisi)','Kab. Sarmi & Jayapura'),(116,'KPHP Waropen','Kab. Waropen'),(117,'KPHP Yapen','Kepulauan Yapen'),(118,'KPHP Sorong','Kab. Sorong '),(119,'KPHP Sorong Selatan','Kab. Sorong Selatan'),(120,'KPHL Sorong (Remu)','Kab. Kota Sorong');

/*Table structure for table `master_jenis_lahan` */

DROP TABLE IF EXISTS `master_jenis_lahan`;

CREATE TABLE `master_jenis_lahan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_lahan` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `master_jenis_lahan` */

insert  into `master_jenis_lahan`(`id`,`jenis_lahan`) values (1,'Bekas Tebangan (LOA)'),(2,'Bekas Pemanenan (Non LOA)'),(3,'Hutan Tanaman');

/*Table structure for table `master_jenis_pemasaran` */

DROP TABLE IF EXISTS `master_jenis_pemasaran`;

CREATE TABLE `master_jenis_pemasaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pemasaran` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `master_jenis_pemasaran` */

insert  into `master_jenis_pemasaran`(`id`,`nama_pemasaran`) values (1,'Jual Bebas'),(2,'Industri Terkait'),(3,'Dipakai Sendiri');

/*Table structure for table `master_jenis_peningkatan_sdm` */

DROP TABLE IF EXISTS `master_jenis_peningkatan_sdm`;

CREATE TABLE `master_jenis_peningkatan_sdm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_program` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `master_jenis_peningkatan_sdm` */

insert  into `master_jenis_peningkatan_sdm`(`id`,`nama_program`) values (1,'Pelatihan & Penyuluhan'),(2,'Pelatihan Kelompok Tani'),(3,'Penyuluhan');

/*Table structure for table `master_jenis_peralatan` */

DROP TABLE IF EXISTS `master_jenis_peralatan`;

CREATE TABLE `master_jenis_peralatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_perusahaan` int(11) DEFAULT '0',
  `jenis_peralatan` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

/*Data for the table `master_jenis_peralatan` */

insert  into `master_jenis_peralatan`(`id`,`id_perusahaan`,`jenis_peralatan`) values (1,0,'Buldozer'),(2,0,'Excavator Loader'),(3,0,'Motor Grader'),(4,0,'Logging Truck'),(5,0,'Road Compactor'),(6,0,'Back Hoe Loader'),(7,0,'Wheel Loader'),(8,0,'Dump Truck'),(9,0,'Ford Tractor'),(10,0,'Skidder'),(11,0,'Bell Super Loader'),(12,0,'Truck'),(13,0,'Chainsaw'),(14,0,'Fuel Tank Truck'),(15,0,'Colt Diesel'),(16,0,'Sepeda Motor'),(17,0,'Genset'),(18,0,'Pick Up'),(19,0,'GPS'),(20,0,'Ambulance'),(34,2,'Becak'),(35,1,'Coba'),(36,1,'Coba'),(37,214,'Becak');

/*Table structure for table `master_jenis_produksi_lahan` */

DROP TABLE IF EXISTS `master_jenis_produksi_lahan`;

CREATE TABLE `master_jenis_produksi_lahan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_produksi` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `master_jenis_produksi_lahan` */

insert  into `master_jenis_produksi_lahan`(`id`,`jenis_produksi`) values (1,'Tanaman Pokok'),(2,'Tanaman Unggulan'),(3,'Tanaman Kehidupan');

/*Table structure for table `master_jenis_pwh` */

DROP TABLE IF EXISTS `master_jenis_pwh`;

CREATE TABLE `master_jenis_pwh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_pembukaan` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `master_jenis_pwh` */

insert  into `master_jenis_pwh`(`id`,`jenis_pembukaan`) values (1,'Jalan Utama'),(2,'Jalan Cabang'),(3,'TPN/TPK Antara');

/*Table structure for table `master_jenis_sarpras` */

DROP TABLE IF EXISTS `master_jenis_sarpras`;

CREATE TABLE `master_jenis_sarpras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_perusahaan` int(11) DEFAULT '0',
  `jenis_sarpras` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

/*Data for the table `master_jenis_sarpras` */

insert  into `master_jenis_sarpras`(`id`,`id_perusahaan`,`jenis_sarpras`) values (1,0,'Perumahan Pimpinan'),(2,0,'Perumahan Karyawan'),(3,0,'Perumahan Tamu'),(4,0,'Kantor'),(5,0,'Gudang'),(6,0,'Bengkel'),(7,0,'Instalasi Listrik'),(8,0,'Instalasi Air'),(9,0,'Persemaian'),(10,0,'Poliklinik'),(11,0,'Rumah Ibadah'),(12,0,'Sarana Hiburan'),(13,0,'Pos Jaga'),(14,0,'Fasilitas Olahraga'),(16,2,'Museum'),(17,2,'Museum'),(18,1,'Test'),(19,1,'tus'),(20,1,'Tes'),(21,1,'coba'),(22,1,'coba'),(23,1,'Coba'),(24,1,'Coba'),(25,1,'Test');

/*Table structure for table `master_jenis_silvikultur` */

DROP TABLE IF EXISTS `master_jenis_silvikultur`;

CREATE TABLE `master_jenis_silvikultur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_silvikultur` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `master_jenis_silvikultur` */

insert  into `master_jenis_silvikultur`(`id`,`jenis_silvikultur`) values (1,'Tebang Habis Permudaan Buatan ( THPB )'),(2,'Multi Silvikultur Sistem'),(3,'Silin');

/*Table structure for table `master_jenis_tanaman` */

DROP TABLE IF EXISTS `master_jenis_tanaman`;

CREATE TABLE `master_jenis_tanaman` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_tanaman` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

/*Data for the table `master_jenis_tanaman` */

insert  into `master_jenis_tanaman`(`id`,`nama_tanaman`) values (1,'Karet (Havea Brasilliensis)'),(2,'Meranti (Shorea sp)'),(3,'Eucalyptus'),(4,'Akasia Mangium'),(5,'Sengon'),(6,'Jabon'),(7,'Sungkai'),(8,'Kaliandra'),(9,'Kopi'),(10,'Coklat/Kakao'),(11,'Gamal'),(12,'Kelapa'),(13,'Aren'),(14,'Cengkeh'),(15,'Camellina'),(16,'King Grass'),(17,'Rape Seed'),(18,'Ubi kayu'),(19,'Pinang'),(20,'Sorghum'),(21,'Jagung'),(22,'Padi'),(23,'Tebu'),(24,'Jarak Pagar');

/*Table structure for table `master_jenis_tanaman_bibit` */

DROP TABLE IF EXISTS `master_jenis_tanaman_bibit`;

CREATE TABLE `master_jenis_tanaman_bibit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_jenis_produksi_lahan` int(11) NOT NULL,
  `nama_tanaman` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_master_jenis_tanaman_bibit_produksi_lahan` (`id_jenis_produksi_lahan`),
  CONSTRAINT `FK_master_jenis_tanaman_bibit_produksi_lahan` FOREIGN KEY (`id_jenis_produksi_lahan`) REFERENCES `master_jenis_produksi_lahan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `master_jenis_tanaman_bibit` */

insert  into `master_jenis_tanaman_bibit`(`id`,`id_jenis_produksi_lahan`,`nama_tanaman`) values (1,1,'Karet (Havea Brasilliensis)'),(2,2,'Meranti (Shorea sp)'),(3,3,'Karet (Havea Brasilliensis)');

/*Table structure for table `master_jenis_tutup_lahan` */

DROP TABLE IF EXISTS `master_jenis_tutup_lahan`;

CREATE TABLE `master_jenis_tutup_lahan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_penutupan` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `master_jenis_tutup_lahan` */

insert  into `master_jenis_tutup_lahan`(`id`,`jenis_penutupan`) values (1,'Belukar Tua'),(2,'Hutan Bekas Tebangan'),(3,'Hutan Tanaman');

/*Table structure for table `master_kategori_penduduk` */

DROP TABLE IF EXISTS `master_kategori_penduduk`;

CREATE TABLE `master_kategori_penduduk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `master_kategori_penduduk` */

insert  into `master_kategori_penduduk`(`id`,`kategori`) values (1,'Anak-anak (<= 17 Tahun)'),(2,'Angkatan Kerja (> 17 Tahun)'),(3,'Angkatan Tidak Produktif');

/*Table structure for table `master_sektor` */

DROP TABLE IF EXISTS `master_sektor`;

CREATE TABLE `master_sektor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_sektor` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Data for the table `master_sektor` */

insert  into `master_sektor`(`id`,`nama_sektor`) values (1,'Sektor I'),(2,'Sektor II'),(3,'Sektor III'),(4,'Sektor IV'),(5,'Sektor V'),(6,'Sektor VI'),(7,'Sektor VII'),(8,'Sektor VIII'),(9,'Sektor IX'),(10,'Sektor X'),(11,'Sektor XI'),(12,'Sektor XII'),(13,'Sektor XIII'),(14,'Sektor XIV'),(15,'Sektor XV'),(16,'Sektor XVI'),(17,'Sektor XVII'),(18,'Sektor XVIII'),(19,'Sektor XIX'),(20,'Sektor XX');

/*Table structure for table `pengukuran_tata_batas` */

DROP TABLE IF EXISTS `pengukuran_tata_batas`;

CREATE TABLE `pengukuran_tata_batas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_perusahaan` int(11) DEFAULT NULL,
  `realisasi` float(16,2) NOT NULL DEFAULT '0.00',
  `tanggal` date DEFAULT NULL,
  `id_tata_batas` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_perusahaan` (`id_perusahaan`),
  KEY `id_tata_batas` (`id_tata_batas`),
  CONSTRAINT `pengukuran_tata_batas_ibfk_1` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`) ON DELETE CASCADE,
  CONSTRAINT `pengukuran_tata_batas_ibfk_2` FOREIGN KEY (`id_tata_batas`) REFERENCES `rku_tata_batas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pengukuran_tata_batas` */

/*Table structure for table `penilaian_kinerja` */

DROP TABLE IF EXISTS `penilaian_kinerja`;

CREATE TABLE `penilaian_kinerja` (
  `id` bigint(1) NOT NULL AUTO_INCREMENT,
  `id_perusahaan` int(11) DEFAULT NULL,
  `id_rkt` int(11) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `aspek_1` tinyint(2) DEFAULT NULL,
  `aspek_2` tinyint(2) DEFAULT NULL,
  `aspek_3` tinyint(2) DEFAULT NULL,
  `aspek_4` tinyint(2) DEFAULT NULL,
  `aspek_5` tinyint(2) DEFAULT NULL,
  `aspek_6` tinyint(2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_perusahaan` (`id_perusahaan`),
  KEY `id_rkt` (`id_rkt`),
  CONSTRAINT `penilaian_kinerja_ibfk_1` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`) ON DELETE CASCADE,
  CONSTRAINT `penilaian_kinerja_ibfk_3` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `penilaian_kinerja` */

/*Table structure for table `permodalan` */

DROP TABLE IF EXISTS `permodalan`;

CREATE TABLE `permodalan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_perusahaan` int(11) NOT NULL,
  `jenis` enum('PMDN','PMA') NOT NULL DEFAULT 'PMDN',
  PRIMARY KEY (`id`),
  KEY `FK_permodalan_perusahaan` (`id_perusahaan`),
  CONSTRAINT `FK_permodalan_perusahaan` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `permodalan` */

/*Table structure for table `perusahaan` */

DROP TABLE IF EXISTS `perusahaan`;

CREATE TABLE `perusahaan` (
  `id_perusahaan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_perusahaan` varchar(50) NOT NULL DEFAULT '',
  `npwp` varchar(50) DEFAULT NULL,
  `alamat` varchar(100) NOT NULL DEFAULT '',
  `provinsi` int(2) unsigned DEFAULT NULL,
  `kabupaten` int(4) unsigned DEFAULT NULL,
  `telepon` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `kode_pos` int(7) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `kontak` varchar(100) DEFAULT NULL,
  `telepon_kontak` varchar(50) DEFAULT NULL,
  `email_kontak` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_perusahaan`),
  KEY `FK_provinsi` (`provinsi`),
  KEY `FK_kabupaten_kota` (`kabupaten`),
  CONSTRAINT `FK_kabupaten_kota` FOREIGN KEY (`kabupaten`) REFERENCES `kabupaten` (`id_kabupaten`) ON DELETE CASCADE,
  CONSTRAINT `FK_provinsi` FOREIGN KEY (`provinsi`) REFERENCES `provinsi` (`id_provinsi`)
) ENGINE=InnoDB AUTO_INCREMENT=279 DEFAULT CHARSET=latin1;

/*Data for the table `perusahaan` */

insert  into `perusahaan`(`id_perusahaan`,`nama_perusahaan`,`npwp`,`alamat`,`provinsi`,`kabupaten`,`telepon`,`email`,`fax`,`kode_pos`,`website`,`kontak`,`telepon_kontak`,`email_kontak`) values (1,'PT. Rencong Pulp and Paper',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,'PT. Aceh Nusa Indrapuri',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,'PT. Rimba Timur Sentosa',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,'PT. Rimba Wawasan Permai',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,'PT. Tusam Hutani Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,'PT. Rimba Penyangga Utama',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,'PT. Toba Pulp Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,'PT. Putra Lika Perkasa',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,'PT. Sumatera Riang Lestari (Sumut)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(10,'PT. Sumatera Silva Lestari (Sumut)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(11,'PT. Anugerah Rimba Makmur',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(12,'PT. Hutan Barumun Perkasa',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(13,'PT. Sinar Belantara Indah',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(14,'PT. Tanaman Industri Lestari Simalungun',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(15,'PT. Bukit Raya Mudisa',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(16,'PT. Dhara Silva Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(17,'PT. Inkud Agritama',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(18,'PT. Sukses Jaya Wood',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(19,'PT. Jebus Maju',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(20,'PT. Limbah Kayu Utama',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(21,'PT. Rimba Hutani Mas (Jambi)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(22,'PT. Wira Karya Sakti ',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(23,'PT. Tebo Multi Agro',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(24,'PT. Mugitriman Int',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(25,'PT. Alam Lestari Nusantara',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(26,'PT. Malaka Agro Perkasa',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(27,'PT. Lestari Asri Jaya',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(28,'PT. Wanamukti Wisesa',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(29,'PT. Wanakasita Nusantara',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(30,'PT. Wana Perintis',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(31,'PT. Hijau Artha Nusa',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(32,'PT. Agronusa Alam Sejahtera',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(33,'PT. Arangan Hutani Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(34,'PT. Dyera Hutan Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(35,'PT. Samhutani',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(36,'PT. Gading Karya Makmur',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(37,'PT. Bumi Andalas Permai',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(38,'PT. Bumi Mekar Hijau (Sumsel)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(39,'PT. Bumi Persada Permai (2004)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(40,'PT. SBA Wood Industries',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(41,'PT. Sumber Hijau Permai',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(42,'PT. Ciptamas Bumi Subur',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(43,'PT. Rimba Hutani Mas (Sumsel)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(44,'PT. Bumi Persada Permai',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(45,'PT. Sentosa Bahagia Bersama',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(46,'PT. Wahana Agro Mulia',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(47,'PT. Paramitra Mulia Langgeng',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(48,'PT. Sumatera Alam Anugerah',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(49,'PT. Wahana Lestari Makmur Sukses',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(50,'PT. Buana Sriwijaya Sejahtera',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(51,'PT. Tiesico Cahaya Pertiwi',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(52,'PT. Tri Pupajaya',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(53,'PT. Tunas Hutan Pratama',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(54,'PT. Musi Hutan Persada',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(55,'PT. Lantabura Mentari Sejahtera',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(56,'PT. Budi Lampung Sejahtera',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(57,'PT. Allindo Embryo Agro',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(58,'PT. Inhutani V Way Rebang-Muara Dua',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(59,'PT. Silva Inhutani Lampung',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(60,'PT. Bangkanesia',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(61,'PT. Istana Kawi Kencana',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(62,'PT. Agro Pratama Sejahtera',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(63,'PT. Indosukses Lestari Makmur',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(64,'PT. Bangun Rimba Sejahtera',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(65,'PT. Inhutani V',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(66,'PT. Agrindo Persada Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(67,'PT. Industrial Forest Plantation',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(68,'PT. E-Greendo',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(69,'PT. Woyla Raya Abadi',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(70,'PT. Wana Damai (PT. Khatulistiwa Lestari)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(71,'PT. Pundiwana Semesta',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(72,'PT. Meranti Sembada',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(73,'PT. Pola Inti Rimba',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(74,'PT. Rimba Berlian Hijau',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(75,'PT. Ceria Karya Pranawa',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(76,'PT. Bukit Beringin Makmur',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(77,'PT. Korintiga Hutani',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(78,'PT. Kusuma Perkasa Wana',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(79,'PT. Parwata Rimba',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(80,'PT. Perintis Adiwana',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(81,'PT. Purwa Permai',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(82,'PT. Puspa Wana Cemerlang',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(83,'PT. Rimba Argamas',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(84,'PT. Rimba Elok',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(85,'PT. Taiyoung Engreen',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(86,'PT. Grace Putri Perdana',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(87,'PT. Kalanis Sumber Rezeki',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(88,'PT. Baratama Putra Perkasa',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(89,'PT. Trikorindotama Wanakarya (Kalteng)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(90,'PT. Acacia Andalan Utama',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(91,'PT. Acacia Andalan Utama II',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(92,'PT. Adindo Hutani Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(93,'PT. Bakayan Jaya Abadi',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(94,'PT. Multi Kusuma Cemerlang',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(95,'PT. Belantara Persada',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(96,'PT. Belantara Pusaka',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(97,'PT. Belantara Subur',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(98,'PT. Bhinneka Wana',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(99,'PT. Buana Inti Energi',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(100,'PT. Cahaya Mitra Wiratama',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(101,'PT. Fajar Surya Swadaya',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(102,'PT. Hutan Kusuma',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(103,'PT. Hutan Mahligai',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(104,'PT. Inhutani I Batuampar - Mentawir',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(105,'PT. Inhutani I Longnah',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(106,'PT. Inhutani II Tanah Grogot',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(107,'PT. Intraca Hutani Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(108,'PT. ITCI Hutani Manunggal',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(109,'PT. Kayan Makmur Sejahtera',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(110,'PT. Kelawit Hutani Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(111,'PT. Kelawit Wana Lestari I',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(112,'PT. Kelawit Wana Lestari II',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(113,'PT. Mahakam Persada Sakti',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(114,'PT. Oceanis Timber Product',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(115,'PT. Permata Borneo Abadi',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(116,'PT. Rimba Raya Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(117,'PT. Santan Borneo Abadi',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(118,'PT. Sendhawar Adhi Karya',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(119,'PT. Silva Rimba Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(120,'PT. Sumalindo Alam Lestari (Unit II)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(121,'PT. Sumalindo Hutani Jaya I',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(122,'PT. Sumalindo Hutani Jaya II',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(123,'PT. Sumalindo Alam Lestari (Unit I)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(124,'PT. Surya Hutani Jaya',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(125,'PT. Swadaya Perkasa',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(126,'PT. Sylvaduta Corporation',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(127,'PT. Taman Daulat Wananusa',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(128,'PT. Tanjung Redep Hutani',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(129,'PT. Tirta Mahakam resources',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(130,'PT. Wana Kaltim Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(131,'PT. Borneo Kutai Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(132,'PT. Dharma Hutani Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(133,'PT. Diva Perdana Pesona',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(134,'PT. Borneo Utara Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(135,'PT. Indosubur Sukses Makmur',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(136,'PT. Hutan Berau Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(137,'PT. Arara Abadi',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(138,'PT. Bukit Batu Hutani Alam',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(139,'PT. Ekawana Lestari Dharma',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(140,'PT. Nusa Prima Manunggal',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(141,'PT. Perawang Sukses Perkasa Indonesia',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(142,'PT. Riau Andalan Pulp & Paper',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(143,'PT. Rimba Rokan Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(144,'PT. Satria Perkasa Agung (Merawang)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(145,'PT. Sekato Pratama Makmur',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(146,'PT. Selaras Abadi Utama',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(147,'PT. Suntara Gajapati',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(148,'PT. Riau Indo Agropalma',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(149,'PT. Mitra Hutani Jaya',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(150,'PT. Satria Perkasa Agung (Serapung)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(151,'PT. Putra Riau Perkasa',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(152,'PT. Ruas Utama Jaya',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(153,'PT. Bina Duta Laksana',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(154,'PT. Prima Bangun Sukses',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(155,'PT. Rimba Rokan Perkasa',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(156,'PT. Bina Daya Bentala',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(157,'PT. Artellindo Wiratama',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(158,'PT. Rimba Mandau Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(159,'PT. Bukit Batabuh Sei Indah',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(160,'PT. Citra Sumber Sejahtera',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(161,'PT. Mitra Kembang Selaras',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(162,'PT. Bukit Raya Pelalawan',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(163,'PT. Merbau Pelalawan Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(164,'PT. Rimba Mutiara Permai',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(165,'PT. Mitra Tani Nusa Sejati',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(166,'PT. Seraya Sumber Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(167,'PT. Balai Kayang Mandiri',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(168,'PT. Bina Daya Bintara',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(169,'PT. Satria Perkasa Agung',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(170,'PT. Perkasa Baru',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(171,'PT. Nusantara Sentosa Raya',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(172,'PT. Lestari Unggul Makmur',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(173,'PT. Sumatera Silva Lestari (Riau)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(174,'PT. Peranap Timber (PT.Uniseraya)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(175,'PT. Tuah Negeri',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(176,'PT. Wananugraha Bina Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(177,'PT. Sari Hijau Mutiara',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(178,'PT. Sumatera Riang Lestari (Riau)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(179,'KUD Bina Jaya Langgam',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(180,'CV. Alam Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(181,'CV. Harapan Jaya',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(182,'CV. Mutiara Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(183,'CV. Putri Lindung Bulan',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(184,'PT. Madukoro',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(185,'CV. Bhakti Praja Mulia',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(186,'PT. Triomas FDI',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(187,'PT. Nusa Wana Raya',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(188,'PT. Riau Abadi Lestari ',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(189,'PT. Rimba Lazuardi',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(190,'PT. Rimba Peranap Indah ',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(191,'PT. Rimba Seraya Utama',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(192,'PT. Asia Tani Persada',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(193,'PT. Bina Silva Nusa',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(194,'PT. Boma Plantation',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(195,'PT. Buana Megatama Jaya',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(196,'PT. Bumi Mekar Hijau (Kalbar)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(197,'PT. Daya Tani Kalbar',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(198,'PT. Fajar Wana Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(199,'PT. Finnantara Intiga',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(200,'PT. Gapura Persada Khatulistiwa ',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(201,'PT. Garuda Kalimantan Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(202,'PT. Hutan Ketapang Industri (PT KBR)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(203,'PT. Inhutani III Unit Nanga Pinoh',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(204,'PT. Kalimantan Subur Permai',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(205,'PT. Kusuma Puspawana',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(206,'PT. Lahan Cakrawala',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(207,'PT. Lahan Sukses',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(208,'PT. Lembah Jati Mutiara',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(209,'PT. Mahkota Rimba Utama',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(210,'PT. Mayangkara Tanaman Industri (I)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(211,'PT. Mayangkara Tanaman Industri (II)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(212,'PT. Mayawana Persada',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(213,'PT. Menggala Rambu Utama',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(214,'PT. Meranti Laksana',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(215,'PT. Meranti Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(216,'PT. Mitra Jaya Nusaindah',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(217,'PT. Muara Sungai Landak',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(218,'PT. Nityasa Idola',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(219,'PT. Prima Bumi Sentosa',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(220,'PT. Rimba Equator Permai',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(221,'PT. Segah Bangun Persada',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(222,'PT. Sinar Kalbar Raya',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(223,'PT. Unggul Karya Inti Jaya',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(224,'PT. Wana Hijau Pesaguan',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(225,'PT. Sari Bumi Kusuma (Wana Subur Lestari)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(226,'PT. Wanakerta Eka Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(227,'PT. Bhatara Alam Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(228,'PT. Wana Subur Persada',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(229,'PT. Duta Andalan Sukses',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(230,'PT. Gambaru Selaras Alam',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(231,'PT. Alfa Borneo Hutan Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(232,'PT. Duta Bintang Gemilang',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(233,'PT. Citra Mulia Inti',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(234,'PT. Aya Yayang Indonesia',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(235,'PT. Batulicin Bumi Bersujud',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(236,'PT. Dwima Intiga',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(237,'PT. Hutan Rindang Banua',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(238,'PT. Hutan Sembada',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(239,'PT. Inhutani II Unit Pulau Laut (Semaras)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(240,'PT. Inhutani II Unit Senakin',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(241,'PT. Inhutani III (eks PT. IHT III Riam Kiwa)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(242,'PT. Inhutani III Unit Sebuhur - Pelaihari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(243,'PT. Inni Joa',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(244,'PT. Janggala Semesta',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(245,'PT. Kirana Chatulistiwa',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(246,'PT. Kodeco Timber',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(247,'PT. Prima Multi Buana',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(248,'PT. Trikorindotama Wanakarya (Kalsel)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(249,'PT. JohnLin Agro Mandiri',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(250,'PT. Wana Dipa Perkasa',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(251,'PT. Kawanua Kahuripan Pantera',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(252,'PT. Berkat Hutan Pusaka',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(253,'PT. Wana Rindang Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(254,'PT. Amal Nusantara',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(255,'PT. Bio Energy Indoco',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(256,'PT. Bara Indoco',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(257,'PT. Inhutani I Unit Gowa Maros',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(258,'PT. Sele Raya Agri',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(259,'PT. Sinar Ceria Sejati',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(260,'PT. Gorontalo Citra Lestari',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(261,'PT. Gema Nusantara Jaya',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(262,'PT. Koin Nesia',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(263,'PT. Usaha Tani Lestari (NTB)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(264,'PT. Sadhana Arif Nusa',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(265,'PT. Usaha Tani Lestari (NTT)',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(266,'PT. Wono Indotani Niaga',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(267,'PT. Sentosa Pratama',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(268,'PT. Waenibe Wood Industries',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(269,'PT. Kalpika Wanatama Unit I',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(270,'PT. Kalpika Wanatama Unit II',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(271,'PT. Kirana Cakrawala',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(272,'PT. Mangole Timber Producer',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(273,'PT. NNE Plantation',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(274,'PT. Selaras Inti Semesta',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(275,'PT. Plasma Nutfah Marind Papua',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(276,'PT. Wanamulia Sukses Sejati Unit I dan II',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(277,'PT. Wahana Samudra Sentosa',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(278,'PT. Kesatuan Mas Abadi',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `perusahaan_cabang` */

DROP TABLE IF EXISTS `perusahaan_cabang`;

CREATE TABLE `perusahaan_cabang` (
  `id_cabang` bigint(20) NOT NULL AUTO_INCREMENT,
  `perusahaan_id` int(11) NOT NULL DEFAULT '0',
  `nama_cabang` varchar(50) NOT NULL DEFAULT '',
  `alamat` varchar(100) DEFAULT NULL,
  `provinsi` int(2) unsigned DEFAULT NULL,
  `kabupaten` int(4) unsigned DEFAULT NULL,
  `kode_pos` int(7) unsigned DEFAULT NULL,
  `telepon` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `kontak` varchar(50) DEFAULT NULL,
  `telepon_kontak` varchar(50) DEFAULT NULL,
  `email_kontak` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_cabang`),
  KEY `FK_provinsi_branch` (`provinsi`),
  KEY `FK_perusahaan_branch` (`perusahaan_id`),
  KEY `FK_kabupaten_branch` (`kabupaten`),
  CONSTRAINT `FK_kabupaten_branch` FOREIGN KEY (`kabupaten`) REFERENCES `kabupaten` (`id_kabupaten`) ON DELETE CASCADE,
  CONSTRAINT `FK_perusahaan_branch` FOREIGN KEY (`perusahaan_id`) REFERENCES `perusahaan` (`id_perusahaan`) ON DELETE CASCADE,
  CONSTRAINT `FK_provinsi_branch` FOREIGN KEY (`provinsi`) REFERENCES `provinsi` (`id_provinsi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `perusahaan_cabang` */

/*Table structure for table `progres_tata_batas` */

DROP TABLE IF EXISTS `progres_tata_batas`;

CREATE TABLE `progres_tata_batas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=belum ada proses, 2=pelaksaaan, 3=penetapan/temu gelang',
  PRIMARY KEY (`id`),
  KEY `FK_progres_tata_batas_rkt` (`id_rkt`),
  CONSTRAINT `FK_progres_tata_batas_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `progres_tata_batas` */

/*Table structure for table `provinsi` */

DROP TABLE IF EXISTS `provinsi`;

CREATE TABLE `provinsi` (
  `id_provinsi` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL COMMENT 'Nama Provinsi',
  PRIMARY KEY (`id_provinsi`),
  KEY `nama` (`nama`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;

/*Data for the table `provinsi` */

insert  into `provinsi`(`id_provinsi`,`nama`) values (51,'Bali'),(36,'Banten'),(17,'Bengkulu'),(34,'DI Yogyakarta'),(31,'DKI Jakarta'),(75,'Gorontalo'),(15,'Jambi'),(32,'Jawa Barat'),(33,'Jawa Tengah'),(35,'Jawa Timur'),(61,'Kalimantan Barat'),(63,'Kalimantan Selatan'),(62,'Kalimantan Tengah'),(64,'Kalimantan Timur'),(93,'Kalimantan Utara'),(19,'Kep. Bangka Belitung'),(21,'Kepulauan Riau'),(18,'Lampung'),(81,'Maluku'),(82,'Maluku Utara'),(11,'Nangroe Aceh Darussalam'),(52,'Nusa Tenggara Barat'),(53,'Nusa Tenggara Timur'),(91,'Papua'),(92,'Papua Barat'),(14,'Riau'),(76,'Sulawesi Barat'),(73,'Sulawesi Selatan'),(72,'Sulawesi Tengah'),(74,'Sulawesi Tenggara'),(71,'Sulawesi Utara'),(13,'Sumatera Barat'),(16,'Sumatera Selatan'),(12,'Sumatera Utara');

/*Table structure for table `rkt` */

DROP TABLE IF EXISTS `rkt`;

CREATE TABLE `rkt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_perusahaan` int(11) NOT NULL,
  `id_rku` int(11) NOT NULL,
  `nomor_sk` varchar(100) NOT NULL DEFAULT '',
  `tanggal_sk` date NOT NULL,
  `tahun_mulai` year(4) NOT NULL,
  `mulai_berlaku` date NOT NULL,
  `akhir_berlaku` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 rkt aktif, 2 rkt tdk aktif, 3 rkt punya revisi',
  `id_rev` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_perusahaan` (`id_perusahaan`),
  KEY `id_rku` (`id_rku`),
  CONSTRAINT `rkt_ibfk_2` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`) ON DELETE CASCADE,
  CONSTRAINT `rkt_ibfk_3` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt` */

/*Table structure for table `rkt_areal_kerja` */

DROP TABLE IF EXISTS `rkt_areal_kerja`;

CREATE TABLE `rkt_areal_kerja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_blok` int(11) NOT NULL,
  `id_rkt` int(11) NOT NULL,
  `id_jenis_produksi_lahan` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_areal_kerja_rkt` (`id_rkt`),
  KEY `FK_rkt_areal_kerja_blok` (`id_blok`),
  KEY `FK_rkt_areal_kerja_jenis_produksi` (`id_jenis_produksi_lahan`),
  CONSTRAINT `FK_rkt_areal_kerja_blok` FOREIGN KEY (`id_blok`) REFERENCES `blok_sektor` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_areal_kerja_jenis_produksi` FOREIGN KEY (`id_jenis_produksi_lahan`) REFERENCES `master_jenis_produksi_lahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_areal_kerja_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_areal_kerja` */

/*Table structure for table `rkt_areal_non_produktif` */

DROP TABLE IF EXISTS `rkt_areal_non_produktif`;

CREATE TABLE `rkt_areal_non_produktif` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) DEFAULT NULL,
  `id_blok` int(11) DEFAULT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_areal_non_produktif_rkt` (`id_rkt`),
  KEY `FK_rkt_areal_non_produktif_blok` (`id_blok`),
  CONSTRAINT `FK_rkt_areal_non_produktif_blok` FOREIGN KEY (`id_blok`) REFERENCES `blok_sektor` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_areal_non_produktif_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_areal_non_produktif` */

/*Table structure for table `rkt_areal_produktif` */

DROP TABLE IF EXISTS `rkt_areal_produktif`;

CREATE TABLE `rkt_areal_produktif` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_blok` int(11) NOT NULL,
  `id_jenis_produksi_lahan` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_areal_produktif_blok` (`id_blok`),
  KEY `FK_rkt_areal_produktif_rkt` (`id_rkt`),
  KEY `FK_rkt_areal_produktif_jenis` (`id_jenis_produksi_lahan`),
  CONSTRAINT `FK_rkt_areal_produktif_blok` FOREIGN KEY (`id_blok`) REFERENCES `blok_sektor` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_areal_produktif_jenis` FOREIGN KEY (`id_jenis_produksi_lahan`) REFERENCES `master_jenis_produksi_lahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_areal_produktif_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_areal_produktif` */

/*Table structure for table `rkt_bangun_mitra` */

DROP TABLE IF EXISTS `rkt_bangun_mitra`;

CREATE TABLE `rkt_bangun_mitra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_bangun_mitra` (`id_rkt`),
  CONSTRAINT `FK_rkt_bangun_mitra` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_bangun_mitra` */

/*Table structure for table `rkt_bibit` */

DROP TABLE IF EXISTS `rkt_bibit`;

CREATE TABLE `rkt_bibit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_rku_tansil` int(11) NOT NULL,
  `id_produksi_lahan` int(11) NOT NULL,
  `id_jenis_tanaman` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_bibit_rkt` (`id_rkt`),
  KEY `FK_rkt_bibit_tanaman_bibit` (`id_produksi_lahan`),
  KEY `FK_rkt_bibit` (`id_jenis_tanaman`),
  KEY `FK_rkt_bibit_tansil` (`id_rku_tansil`),
  CONSTRAINT `FK_rkt_bibit` FOREIGN KEY (`id_jenis_tanaman`) REFERENCES `master_jenis_tanaman` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_bibit_produksi_lahan` FOREIGN KEY (`id_produksi_lahan`) REFERENCES `master_jenis_produksi_lahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_bibit_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_bibit_tansil` FOREIGN KEY (`id_rku_tansil`) REFERENCES `rku_tanaman_silvikultur` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_bibit` */

/*Table structure for table `rkt_bibit_bak` */

DROP TABLE IF EXISTS `rkt_bibit_bak`;

CREATE TABLE `rkt_bibit_bak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_tanaman_bibit` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_bibit_rkt` (`id_rkt`),
  KEY `FK_rkt_bibit_tanaman_bibit` (`id_tanaman_bibit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_bibit_bak` */

/*Table structure for table `rkt_dangir` */

DROP TABLE IF EXISTS `rkt_dangir`;

CREATE TABLE `rkt_dangir` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_jenis_produksi_lahan` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_dangir_rkt` (`id_rkt`),
  KEY `FK_rkt_dangir` (`id_jenis_produksi_lahan`),
  CONSTRAINT `FK_rkt_dangir` FOREIGN KEY (`id_jenis_produksi_lahan`) REFERENCES `master_jenis_produksi_lahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_dangir_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_dangir` */

/*Table structure for table `rkt_evaluasi_keberhasilan` */

DROP TABLE IF EXISTS `rkt_evaluasi_keberhasilan`;

CREATE TABLE `rkt_evaluasi_keberhasilan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_ganis` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_ganis_rkt` (`id_rkt`),
  KEY `FK_rkt_ganis` (`id_ganis`),
  CONSTRAINT `FK_rkt_evaluasi_keberhasilan` FOREIGN KEY (`id_ganis`) REFERENCES `master_jenis_ganis` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_evaluasi_keberhasilan_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_evaluasi_keberhasilan` */

/*Table structure for table `rkt_evaluasi_pantau_operasional` */

DROP TABLE IF EXISTS `rkt_evaluasi_pantau_operasional`;

CREATE TABLE `rkt_evaluasi_pantau_operasional` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_ganis` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_ganis_rkt` (`id_rkt`),
  KEY `FK_rkt_ganis` (`id_ganis`),
  CONSTRAINT `FK_rkt_evaluasi_pantau_operasional` FOREIGN KEY (`id_ganis`) REFERENCES `master_jenis_ganis` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_evaluasi_pantau_operasional_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_evaluasi_pantau_operasional` */

/*Table structure for table `rkt_ganis` */

DROP TABLE IF EXISTS `rkt_ganis`;

CREATE TABLE `rkt_ganis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_ganis` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_ganis_rkt` (`id_rkt`),
  KEY `FK_rkt_ganis` (`id_ganis`),
  CONSTRAINT `FK_rkt_ganis` FOREIGN KEY (`id_ganis`) REFERENCES `master_jenis_ganis` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_ganis_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_ganis` */

/*Table structure for table `rkt_infra_mukim` */

DROP TABLE IF EXISTS `rkt_infra_mukim`;

CREATE TABLE `rkt_infra_mukim` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_infra_mukim` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_infra_mukim_rkt` (`id_rkt`),
  KEY `FK_rkt_infra_mukim` (`id_infra_mukim`),
  CONSTRAINT `FK_rkt_infra_mukim` FOREIGN KEY (`id_infra_mukim`) REFERENCES `master_jenis_infra_mukim` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_infra_mukim_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_infra_mukim` */

/*Table structure for table `rkt_inventarisasi` */

DROP TABLE IF EXISTS `rkt_inventarisasi`;

CREATE TABLE `rkt_inventarisasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_jenis_produksi` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_inventarisasi_jenis_produksi` (`id_jenis_produksi`),
  KEY `FK_rkt_inventarisasi_rkt` (`id_rkt`),
  CONSTRAINT `FK_rkt_inventarisasi_jenis_produksi` FOREIGN KEY (`id_jenis_produksi`) REFERENCES `master_jenis_produksi_lahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_inventarisasi_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_inventarisasi` */

/*Table structure for table `rkt_jarang` */

DROP TABLE IF EXISTS `rkt_jarang`;

CREATE TABLE `rkt_jarang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_jenis_produksi_lahan` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_jarang_rkt` (`id_rkt`),
  KEY `FK_rkt_jarang_produksi_lahan` (`id_jenis_produksi_lahan`),
  CONSTRAINT `FK_rkt_jarang_produksi_lahan` FOREIGN KEY (`id_jenis_produksi_lahan`) REFERENCES `master_jenis_produksi_lahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_jarang_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_jarang` */

/*Table structure for table `rkt_kawasan_lindung` */

DROP TABLE IF EXISTS `rkt_kawasan_lindung`;

CREATE TABLE `rkt_kawasan_lindung` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL DEFAULT '0',
  `id_blok` int(11) NOT NULL DEFAULT '0',
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_kawasan_lindung_rkt` (`id_rkt`),
  KEY `FK_rkt_kawasan_lindung` (`id_blok`),
  CONSTRAINT `FK_rkt_kawasan_lindung` FOREIGN KEY (`id_blok`) REFERENCES `blok_sektor` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_kawasan_lindung_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_kawasan_lindung` */

/*Table structure for table `rkt_kerjasama_koperasi` */

DROP TABLE IF EXISTS `rkt_kerjasama_koperasi`;

CREATE TABLE `rkt_kerjasama_koperasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `realisasi` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_kerjasama_koperasi` (`id_rkt`),
  CONSTRAINT `FK_rkt_kerjasama_koperasi` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_kerjasama_koperasi` */

/*Table structure for table `rkt_konflik_sosial` */

DROP TABLE IF EXISTS `rkt_konflik_sosial`;

CREATE TABLE `rkt_konflik_sosial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `jenis_konflik` varchar(255) NOT NULL,
  `penanganan` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_konflik_sosial_rkt` (`id_rkt`),
  CONSTRAINT `FK_rkt_konflik_sosial_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_konflik_sosial` */

/*Table structure for table `rkt_lingkungan_dalkar` */

DROP TABLE IF EXISTS `rkt_lingkungan_dalkar`;

CREATE TABLE `rkt_lingkungan_dalkar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_dalkar` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_lingkungan_dalkar_rkt` (`id_rkt`),
  KEY `FK_rkt_lingkungan_dalkar` (`id_dalkar`),
  CONSTRAINT `FK_rkt_lingkungan_dalkar` FOREIGN KEY (`id_dalkar`) REFERENCES `master_jenis_dalkar` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_lingkungan_dalkar_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_lingkungan_dalkar` */

/*Table structure for table `rkt_lingkungan_dalmakit` */

DROP TABLE IF EXISTS `rkt_lingkungan_dalmakit`;

CREATE TABLE `rkt_lingkungan_dalmakit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_lingkungan_dalmakit_rkt` (`id_rkt`),
  CONSTRAINT `FK_rkt_lingkungan_dalmakit_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_lingkungan_dalmakit` */

/*Table structure for table `rkt_lingkungan_dungtan` */

DROP TABLE IF EXISTS `rkt_lingkungan_dungtan`;

CREATE TABLE `rkt_lingkungan_dungtan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_lingkungan_dungtan_rkt` (`id_rkt`),
  CONSTRAINT `FK_rkt_lingkungan_dungtan_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_lingkungan_dungtan` */

/*Table structure for table `rkt_masuk_guna_alat` */

DROP TABLE IF EXISTS `rkt_masuk_guna_alat`;

CREATE TABLE `rkt_masuk_guna_alat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_jenis_peralatan` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_masuk_guna_alat_rkt` (`id_rkt`),
  KEY `FK_rkt_masuk_guna_alat_jenis_alat` (`id_jenis_peralatan`),
  CONSTRAINT `FK_rkt_masuk_guna_alat_jenis_alat` FOREIGN KEY (`id_jenis_peralatan`) REFERENCES `master_jenis_peralatan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_masuk_guna_alat_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_masuk_guna_alat` */

/*Table structure for table `rkt_panen_areal` */

DROP TABLE IF EXISTS `rkt_panen_areal`;

CREATE TABLE `rkt_panen_areal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_rku_tansil` int(11) NOT NULL,
  `id_jenis_lahan` int(11) NOT NULL,
  `id_produksi_lahan` int(11) NOT NULL,
  `id_jenis_tanaman` int(11) NOT NULL,
  `id_blok` int(11) DEFAULT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_tanam_rkt` (`id_rkt`),
  KEY `FK_rkt_tanam_jenis_lahan` (`id_jenis_lahan`),
  KEY `FK_rkt_tanam` (`id_jenis_tanaman`),
  KEY `FK_rkt_tanam_blok` (`id_blok`),
  KEY `FK_rkt_tanam_produksiLahan` (`id_produksi_lahan`),
  KEY `FK_rkt_tanam_tansil` (`id_rku_tansil`),
  CONSTRAINT `FK_rkt_panen_areal` FOREIGN KEY (`id_rku_tansil`) REFERENCES `rku_tanaman_silvikultur` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_panen_areal_bloksektor` FOREIGN KEY (`id_blok`) REFERENCES `blok_sektor` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_panen_areal_jenis_lahan` FOREIGN KEY (`id_jenis_lahan`) REFERENCES `master_jenis_lahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_panen_areal_produksiLahan` FOREIGN KEY (`id_produksi_lahan`) REFERENCES `master_jenis_produksi_lahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_panen_areal_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_panen_areal_tanaman` FOREIGN KEY (`id_jenis_tanaman`) REFERENCES `master_jenis_tanaman` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_panen_areal` */

/*Table structure for table `rkt_panen_areal_bak` */

DROP TABLE IF EXISTS `rkt_panen_areal_bak`;

CREATE TABLE `rkt_panen_areal_bak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_jenis_lahan` int(11) NOT NULL,
  `id_jenis_produksi_lahan` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;

/*Data for the table `rkt_panen_areal_bak` */

insert  into `rkt_panen_areal_bak`(`id`,`id_rkt`,`id_jenis_lahan`,`id_jenis_produksi_lahan`,`jumlah`,`realisasi`,`persentase`) values (1,1,1,1,120.00,50.00,41.67),(2,1,1,2,NULL,NULL,NULL),(3,1,1,3,NULL,NULL,NULL),(4,1,2,1,NULL,NULL,NULL),(5,1,2,2,NULL,NULL,NULL),(6,1,2,3,NULL,NULL,NULL),(7,2,1,1,120.00,50.00,41.67),(8,2,1,2,NULL,NULL,NULL),(9,2,1,3,NULL,NULL,NULL),(10,2,2,1,NULL,NULL,NULL),(11,2,2,2,NULL,NULL,NULL),(12,2,2,3,NULL,NULL,NULL),(13,3,1,1,120.00,50.00,41.67),(14,3,1,2,NULL,NULL,NULL),(15,3,1,3,NULL,NULL,NULL),(16,3,2,1,NULL,NULL,NULL),(17,3,2,2,NULL,NULL,NULL),(18,3,2,3,NULL,NULL,NULL),(19,4,1,1,120.00,50.00,41.67),(20,4,1,2,NULL,NULL,NULL),(21,4,1,3,NULL,NULL,NULL),(22,4,2,1,NULL,NULL,NULL),(23,4,2,2,NULL,NULL,NULL),(24,4,2,3,NULL,NULL,NULL),(25,5,1,1,120.00,50.00,41.67),(26,5,1,2,NULL,NULL,NULL),(27,5,1,3,NULL,NULL,NULL),(28,5,2,1,NULL,NULL,NULL),(29,5,2,2,NULL,NULL,NULL),(30,5,2,3,NULL,NULL,NULL),(31,6,1,1,NULL,NULL,NULL),(32,6,1,2,NULL,NULL,NULL),(33,6,1,3,NULL,NULL,NULL),(34,6,2,1,NULL,NULL,NULL),(35,6,2,2,NULL,NULL,NULL),(36,6,2,3,NULL,NULL,NULL),(37,7,1,1,NULL,NULL,NULL),(38,7,1,2,NULL,NULL,NULL),(39,7,1,3,NULL,NULL,NULL),(40,7,2,1,NULL,NULL,NULL),(41,7,2,2,NULL,NULL,NULL),(42,7,2,3,NULL,NULL,NULL),(43,8,1,1,120.00,50.00,41.67),(44,8,1,2,NULL,NULL,NULL),(45,8,1,3,NULL,NULL,NULL),(46,8,2,1,NULL,NULL,NULL),(47,8,2,2,NULL,NULL,NULL),(48,8,2,3,NULL,NULL,NULL),(49,9,1,1,120.00,50.00,41.67),(50,9,1,2,NULL,NULL,NULL),(51,9,1,3,NULL,NULL,NULL),(52,9,2,1,NULL,NULL,NULL),(53,9,2,2,NULL,NULL,NULL),(54,9,2,3,NULL,NULL,NULL),(55,10,1,1,NULL,NULL,NULL),(56,10,1,2,NULL,NULL,NULL),(57,10,1,3,NULL,NULL,NULL),(58,10,2,1,NULL,NULL,NULL),(59,10,2,2,NULL,NULL,NULL),(60,10,2,3,NULL,NULL,NULL),(61,11,1,1,120.00,50.00,41.67),(62,11,1,2,NULL,NULL,NULL),(63,11,1,3,NULL,NULL,NULL),(64,11,2,1,NULL,NULL,NULL),(65,11,2,2,NULL,NULL,NULL),(66,11,2,3,NULL,NULL,NULL),(67,12,1,1,120.00,50.00,41.67),(68,12,1,2,NULL,NULL,NULL),(69,12,1,3,NULL,NULL,NULL),(70,12,2,1,NULL,NULL,NULL),(71,12,2,2,NULL,NULL,NULL),(72,12,2,3,NULL,NULL,NULL),(73,13,1,1,NULL,NULL,NULL),(74,13,1,2,NULL,NULL,NULL),(75,13,1,3,NULL,NULL,NULL),(76,13,2,1,NULL,NULL,NULL),(77,13,2,2,NULL,NULL,NULL),(78,13,2,3,NULL,NULL,NULL),(79,14,1,1,120.00,50.00,41.67),(80,14,1,2,NULL,NULL,NULL),(81,14,1,3,NULL,NULL,NULL),(82,14,2,1,NULL,NULL,NULL),(83,14,2,2,NULL,NULL,NULL),(84,14,2,3,NULL,NULL,NULL),(85,15,1,1,120.00,50.00,41.67),(86,15,1,2,NULL,NULL,NULL),(87,15,1,3,NULL,NULL,NULL),(88,15,2,1,NULL,NULL,NULL),(89,15,2,2,NULL,NULL,NULL),(90,15,2,3,NULL,NULL,NULL),(91,16,1,1,NULL,NULL,NULL),(92,16,1,2,NULL,NULL,NULL),(93,16,1,3,NULL,NULL,NULL),(94,16,2,1,NULL,NULL,NULL),(95,16,2,2,NULL,NULL,NULL),(96,16,2,3,NULL,NULL,NULL);

/*Table structure for table `rkt_panen_volume_siap_lahan` */

DROP TABLE IF EXISTS `rkt_panen_volume_siap_lahan`;

CREATE TABLE `rkt_panen_volume_siap_lahan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_jenis_kayu` int(11) NOT NULL,
  `id_jenis_kelompok_kayu` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_panen_volume_siap_lahan_rkt` (`id_rkt`),
  KEY `FK_rkt_panen_volume_siap_lahan_jenis_kayu` (`id_jenis_kayu`),
  KEY `FK_rkt_panen_volume_siap_lahan_kelompok_kayu` (`id_jenis_kelompok_kayu`),
  CONSTRAINT `FK_rkt_panen_volume_siap_lahan_jenis_kayu` FOREIGN KEY (`id_jenis_kayu`) REFERENCES `master_jenis_kayu` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_panen_volume_siap_lahan_kelompok_kayu` FOREIGN KEY (`id_jenis_kelompok_kayu`) REFERENCES `master_jenis_kelompok_kayu` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_panen_volume_siap_lahan_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_panen_volume_siap_lahan` */

/*Table structure for table `rkt_panen_volume_tanaman` */

DROP TABLE IF EXISTS `rkt_panen_volume_tanaman`;

CREATE TABLE `rkt_panen_volume_tanaman` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_rku_tansil` int(11) NOT NULL,
  `id_jenis_lahan` int(11) NOT NULL,
  `id_produksi_lahan` int(11) NOT NULL,
  `id_jenis_tanaman` int(11) NOT NULL,
  `id_blok` int(11) DEFAULT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_tanam_rkt` (`id_rkt`),
  KEY `FK_rkt_tanam_jenis_lahan` (`id_jenis_lahan`),
  KEY `FK_rkt_tanam` (`id_jenis_tanaman`),
  KEY `FK_rkt_tanam_blok` (`id_blok`),
  KEY `FK_rkt_tanam_produksiLahan` (`id_produksi_lahan`),
  KEY `FK_rkt_tanam_tansil` (`id_rku_tansil`),
  CONSTRAINT `FK_rkt_panen_volume_tanaman_bloksektor` FOREIGN KEY (`id_blok`) REFERENCES `blok_sektor` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_panen_volume_tanaman_jenislahan` FOREIGN KEY (`id_jenis_lahan`) REFERENCES `master_jenis_lahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_panen_volume_tanaman_jenistanaman` FOREIGN KEY (`id_jenis_tanaman`) REFERENCES `master_jenis_tanaman` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_panen_volume_tanaman_produksilahan` FOREIGN KEY (`id_produksi_lahan`) REFERENCES `master_jenis_produksi_lahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_panen_volume_tanaman_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_panen_volume_tanaman_tansil` FOREIGN KEY (`id_rku_tansil`) REFERENCES `rku_tanaman_silvikultur` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_panen_volume_tanaman` */

/*Table structure for table `rkt_panen_volume_tanaman_bak` */

DROP TABLE IF EXISTS `rkt_panen_volume_tanaman_bak`;

CREATE TABLE `rkt_panen_volume_tanaman_bak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_jenis_produksi_lahan` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_panen_volume_tanaman` (`id_rkt`),
  KEY `FK_rkt_panen_volume_tanaman_produksi_lahan` (`id_jenis_produksi_lahan`),
  CONSTRAINT `FK_rkt_panen_volume_tanaman` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_panen_volume_tanaman_produksi_lahan` FOREIGN KEY (`id_jenis_produksi_lahan`) REFERENCES `master_jenis_produksi_lahan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

/*Data for the table `rkt_panen_volume_tanaman_bak` */

insert  into `rkt_panen_volume_tanaman_bak`(`id`,`id_rkt`,`id_jenis_produksi_lahan`,`jumlah`,`realisasi`,`persentase`) values (1,1,1,100.00,40.00,40.00),(2,1,2,NULL,NULL,NULL),(3,1,3,NULL,NULL,NULL),(13,5,1,100.00,40.00,40.00),(14,5,2,NULL,NULL,NULL),(15,5,3,NULL,NULL,NULL),(16,6,1,NULL,NULL,NULL),(17,6,2,NULL,NULL,NULL),(18,6,3,NULL,NULL,NULL),(19,7,1,NULL,NULL,NULL),(20,7,2,NULL,NULL,NULL),(21,7,3,NULL,NULL,NULL);

/*Table structure for table `rkt_pasar` */

DROP TABLE IF EXISTS `rkt_pasar`;

CREATE TABLE `rkt_pasar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_pemasaran` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_pasar_pemasaran` (`id_pemasaran`),
  KEY `FK_rkt_pasar_rkt` (`id_rkt`),
  CONSTRAINT `FK_rkt_pasar_pemasaran` FOREIGN KEY (`id_pemasaran`) REFERENCES `master_jenis_pemasaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_pasar_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_pasar` */

/*Table structure for table `rkt_pemantauan_lingkungan` */

DROP TABLE IF EXISTS `rkt_pemantauan_lingkungan`;

CREATE TABLE `rkt_pemantauan_lingkungan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `kegiatan` varchar(255) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_pemantauan_lingkungan` (`id_rkt`),
  CONSTRAINT `FK_rkt_pemantauan_lingkungan` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_pemantauan_lingkungan` */

/*Table structure for table `rkt_peningkatan_sdm` */

DROP TABLE IF EXISTS `rkt_peningkatan_sdm`;

CREATE TABLE `rkt_peningkatan_sdm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_peningkatan_sdm` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_peningkatan_sdm_rkt` (`id_rkt`),
  KEY `FK_rkt_peningkatan_sdm` (`id_peningkatan_sdm`),
  CONSTRAINT `FK_rkt_peningkatan_sdm` FOREIGN KEY (`id_peningkatan_sdm`) REFERENCES `master_jenis_peningkatan_sdm` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_peningkatan_sdm_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_peningkatan_sdm` */

/*Table structure for table `rkt_pwh` */

DROP TABLE IF EXISTS `rkt_pwh`;

CREATE TABLE `rkt_pwh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_pwh` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_pwh_rkt` (`id_rkt`),
  KEY `FK_rkt_pwh_jenis_pwh` (`id_pwh`),
  CONSTRAINT `FK_rkt_pwh_jenis_pwh` FOREIGN KEY (`id_pwh`) REFERENCES `master_jenis_pwh` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_pwh_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_pwh` */

/*Table structure for table `rkt_sarpras` */

DROP TABLE IF EXISTS `rkt_sarpras`;

CREATE TABLE `rkt_sarpras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_jenis_sarpras` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_sarpras_rkt` (`id_rkt`),
  KEY `FK_rkt_sarpras_sarpras` (`id_jenis_sarpras`),
  CONSTRAINT `FK_rkt_sarpras_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_sarpras_sarpras` FOREIGN KEY (`id_jenis_sarpras`) REFERENCES `master_jenis_sarpras` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_sarpras` */

/*Table structure for table `rkt_siap_lahan` */

DROP TABLE IF EXISTS `rkt_siap_lahan`;

CREATE TABLE `rkt_siap_lahan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_jenis_lahan` int(11) NOT NULL,
  `id_blok` int(11) DEFAULT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_siap_lahan_rkt` (`id_rkt`),
  KEY `FK_rkt_siap_lahan_blok` (`id_blok`),
  KEY `FK_rkt_siap_lahan_jenis_lahan` (`id_jenis_lahan`),
  CONSTRAINT `FK_rkt_siap_lahan_blok` FOREIGN KEY (`id_blok`) REFERENCES `blok_sektor` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_siap_lahan_jenis_lahan` FOREIGN KEY (`id_jenis_lahan`) REFERENCES `master_jenis_lahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_siap_lahan_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_siap_lahan` */

/*Table structure for table `rkt_sulam` */

DROP TABLE IF EXISTS `rkt_sulam`;

CREATE TABLE `rkt_sulam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_jenis_produksi_lahan` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_sulam_rkt` (`id_rkt`),
  KEY `FK_rkt_sulam` (`id_jenis_produksi_lahan`),
  CONSTRAINT `FK_rkt_sulam` FOREIGN KEY (`id_jenis_produksi_lahan`) REFERENCES `master_jenis_produksi_lahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_sulam_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_sulam` */

/*Table structure for table `rkt_tanam` */

DROP TABLE IF EXISTS `rkt_tanam`;

CREATE TABLE `rkt_tanam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_rku_tansil` int(11) NOT NULL,
  `id_jenis_lahan` int(11) NOT NULL,
  `id_produksi_lahan` int(11) NOT NULL,
  `id_jenis_tanaman` int(11) NOT NULL,
  `id_blok` int(11) DEFAULT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_tanam_rkt` (`id_rkt`),
  KEY `FK_rkt_tanam_jenis_lahan` (`id_jenis_lahan`),
  KEY `FK_rkt_tanam` (`id_jenis_tanaman`),
  KEY `FK_rkt_tanam_blok` (`id_blok`),
  KEY `FK_rkt_tanam_produksiLahan` (`id_produksi_lahan`),
  KEY `FK_rkt_tanam_tansil` (`id_rku_tansil`),
  CONSTRAINT `FK_rkt_tanam` FOREIGN KEY (`id_jenis_tanaman`) REFERENCES `master_jenis_tanaman` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_tanam_blok` FOREIGN KEY (`id_blok`) REFERENCES `blok_sektor` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_tanam_jenis_lahan` FOREIGN KEY (`id_jenis_lahan`) REFERENCES `master_jenis_lahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_tanam_produksiLahan` FOREIGN KEY (`id_produksi_lahan`) REFERENCES `master_jenis_produksi_lahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_tanam_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_tanam_tansil` FOREIGN KEY (`id_rku_tansil`) REFERENCES `rku_tanaman_silvikultur` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_tanam` */

/*Table structure for table `rkt_tanam_bak` */

DROP TABLE IF EXISTS `rkt_tanam_bak`;

CREATE TABLE `rkt_tanam_bak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_jenis_lahan` int(11) NOT NULL,
  `id_jenis_tanaman` int(11) NOT NULL,
  `id_blok` int(11) DEFAULT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  `realisasi` float(16,2) DEFAULT NULL,
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkt_tanam_rkt` (`id_rkt`),
  KEY `FK_rkt_tanam_jenis_lahan` (`id_jenis_lahan`),
  KEY `FK_rkt_tanam` (`id_jenis_tanaman`),
  KEY `FK_rkt_tanam_blok` (`id_blok`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;

/*Data for the table `rkt_tanam_bak` */

insert  into `rkt_tanam_bak`(`id`,`id_rkt`,`id_jenis_lahan`,`id_jenis_tanaman`,`id_blok`,`jumlah`,`realisasi`,`persentase`) values (1,11,1,1,6,20.00,19.00,95.00),(2,11,1,1,7,NULL,NULL,NULL),(3,11,1,2,6,NULL,NULL,NULL),(4,11,1,2,7,NULL,NULL,NULL),(5,11,1,3,6,NULL,NULL,NULL),(6,11,1,3,7,NULL,NULL,NULL),(7,11,2,1,6,NULL,NULL,NULL),(8,11,2,1,7,NULL,NULL,NULL),(9,11,2,2,6,NULL,NULL,NULL),(10,11,2,2,7,NULL,NULL,NULL),(11,11,2,3,6,NULL,NULL,NULL),(12,11,2,3,7,NULL,NULL,NULL),(13,12,1,1,1,NULL,NULL,NULL),(14,12,1,1,2,NULL,NULL,NULL),(15,12,1,1,3,NULL,NULL,NULL),(16,12,1,1,4,NULL,NULL,NULL),(17,12,1,1,5,NULL,NULL,NULL),(18,12,1,2,1,NULL,NULL,NULL),(19,12,1,2,2,NULL,NULL,NULL),(20,12,1,2,3,NULL,NULL,NULL),(21,12,1,2,4,NULL,NULL,NULL),(22,12,1,2,5,NULL,NULL,NULL),(23,12,1,3,1,NULL,NULL,NULL),(24,12,1,3,2,NULL,NULL,NULL),(25,12,1,3,3,NULL,NULL,NULL),(26,12,1,3,4,NULL,NULL,NULL),(27,12,1,3,5,NULL,NULL,NULL),(28,12,2,1,1,NULL,NULL,NULL),(29,12,2,1,2,NULL,NULL,NULL),(30,12,2,1,3,NULL,NULL,NULL),(31,12,2,1,4,NULL,NULL,NULL),(32,12,2,1,5,NULL,NULL,NULL),(33,12,2,2,1,NULL,NULL,NULL),(34,12,2,2,2,NULL,NULL,NULL),(35,12,2,2,3,NULL,NULL,NULL),(36,12,2,2,4,NULL,NULL,NULL),(37,12,2,2,5,NULL,NULL,NULL),(38,12,2,3,1,NULL,NULL,NULL),(39,12,2,3,2,NULL,NULL,NULL),(40,12,2,3,3,NULL,NULL,NULL),(41,12,2,3,4,NULL,NULL,NULL),(42,12,2,3,5,NULL,NULL,NULL),(43,14,1,1,6,100.00,1.00,1.00),(44,14,1,1,7,NULL,NULL,NULL),(45,14,1,2,6,NULL,NULL,NULL),(46,14,1,2,7,NULL,NULL,NULL),(47,14,1,3,6,NULL,NULL,NULL),(48,14,1,3,7,NULL,NULL,NULL),(49,14,2,1,6,NULL,NULL,NULL),(50,14,2,1,7,NULL,NULL,NULL),(51,14,2,2,6,NULL,NULL,NULL),(52,14,2,2,7,NULL,NULL,NULL),(53,14,2,3,6,NULL,NULL,NULL),(54,14,2,3,7,NULL,NULL,NULL),(55,17,1,1,49,1200.00,13.00,1.08),(56,17,1,1,50,1.00,1.00,100.00),(57,17,1,1,51,1.00,1.00,100.00),(58,17,1,1,52,1.00,1.00,100.00),(59,17,1,1,53,1.00,1.00,100.00),(60,17,1,2,49,1.00,1.00,100.00),(61,17,1,2,50,1.00,1.00,100.00),(62,17,1,2,51,1.00,1.00,100.00),(63,17,1,2,52,1.00,1.00,100.00),(64,17,1,2,53,1.00,NULL,NULL),(65,17,1,3,49,1.00,NULL,NULL),(66,17,1,3,50,1.00,NULL,NULL),(67,17,1,3,51,1.00,NULL,NULL),(68,17,1,3,52,1.00,NULL,NULL),(69,17,1,3,53,1.00,NULL,NULL),(70,17,2,1,49,1.00,NULL,NULL),(71,17,2,1,50,1.00,NULL,NULL),(72,17,2,1,51,1.00,NULL,NULL),(73,17,2,1,52,4300.00,NULL,NULL),(74,17,2,1,53,1.00,NULL,NULL),(75,17,2,2,49,1.00,NULL,NULL),(76,17,2,2,50,1.00,NULL,NULL),(77,17,2,2,51,1.00,NULL,NULL),(78,17,2,2,52,1.00,NULL,NULL),(79,17,2,2,53,1.00,NULL,NULL),(80,17,2,3,49,1.00,NULL,NULL),(81,17,2,3,50,1.00,NULL,NULL),(82,17,2,3,51,1.00,NULL,NULL),(83,17,2,3,52,NULL,NULL,NULL),(84,17,2,3,53,NULL,NULL,NULL);

/*Table structure for table `rkt_tata_batas` */

DROP TABLE IF EXISTS `rkt_tata_batas`;

CREATE TABLE `rkt_tata_batas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) DEFAULT NULL,
  `id_jenis_batas` int(11) DEFAULT NULL COMMENT 'Satuan Km',
  `jumlah` float(16,2) DEFAULT NULL COMMENT 'Satuan Km',
  `realisasi` float(16,2) DEFAULT NULL COMMENT 'Satuan Km',
  `persentase` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_perusahaan` (`id_jenis_batas`),
  KEY `id_rku` (`id_rkt`),
  CONSTRAINT `FK_rkt_tata_batas_jenis` FOREIGN KEY (`id_jenis_batas`) REFERENCES `master_jenis_batas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rkt_tata_batas_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rkt_tata_batas` */

/*Table structure for table `rku` */

DROP TABLE IF EXISTS `rku`;

CREATE TABLE `rku` (
  `id_rku` int(11) NOT NULL AUTO_INCREMENT,
  `id_perusahaan` int(11) DEFAULT NULL,
  `nomor_sk` varchar(25) NOT NULL,
  `tgl_sk` date NOT NULL,
  `tahun_mulai` year(4) NOT NULL,
  `tahun_sampai` year(4) NOT NULL,
  `mulai_berlaku` date NOT NULL,
  `akhir_berlaku` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 rku aktif, 2 rku tdk aktif, 3 rku punya revisi',
  `id_rev` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_rku`),
  KEY `id_perusahaan` (`id_perusahaan`),
  CONSTRAINT `rku_ibfk_1` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

/*Data for the table `rku` */

/*Table structure for table `rku_alat_damkar` */

DROP TABLE IF EXISTS `rku_alat_damkar`;

CREATE TABLE `rku_alat_damkar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `id_damkar` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rku_alat_damkar_rku` (`id_rku`),
  KEY `FK_rku_alat_damkar_master_jenis_dalkar` (`id_damkar`),
  CONSTRAINT `FK_rku_alat_damkar_master_jenis_dalkar` FOREIGN KEY (`id_damkar`) REFERENCES `master_jenis_dalkar` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rku_alat_damkar_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_alat_damkar` */

/*Table structure for table `rku_areal_kerja` */

DROP TABLE IF EXISTS `rku_areal_kerja`;

CREATE TABLE `rku_areal_kerja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `daur` int(11) NOT NULL,
  `lokasi_rkt` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `id_jenis_produksi_lahan` int(11) NOT NULL,
  `jumlah` float(16,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rku_areal_kerja_rku` (`id_rku`),
  KEY `FK_jenis_produksi_lahan` (`id_jenis_produksi_lahan`),
  CONSTRAINT `FK_jenis_produksi_lahan` FOREIGN KEY (`id_jenis_produksi_lahan`) REFERENCES `master_jenis_produksi_lahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rku_areal_kerja_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_areal_kerja` */

/*Table structure for table `rku_areal_non_produktif` */

DROP TABLE IF EXISTS `rku_areal_non_produktif`;

CREATE TABLE `rku_areal_non_produktif` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rku_areal_non_produktif_rku` (`id_rku`),
  CONSTRAINT `FK_rku_areal_non_produktif_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_areal_non_produktif` */

/*Table structure for table `rku_areal_produktif` */

DROP TABLE IF EXISTS `rku_areal_produktif`;

CREATE TABLE `rku_areal_produktif` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `id_jenis_produksi_lahan` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rku_produktif_rku` (`id_rku`),
  KEY `FK_areal_produktif_rku_lahan` (`id_jenis_produksi_lahan`),
  CONSTRAINT `FK_areal_produktif_rku_lahan` FOREIGN KEY (`id_jenis_produksi_lahan`) REFERENCES `master_jenis_produksi_lahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rku_produktif_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_areal_produktif` */

/*Table structure for table `rku_bibit` */

DROP TABLE IF EXISTS `rku_bibit`;

CREATE TABLE `rku_bibit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `id_jenis_tanaman_bibit` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rku_bibit_master_jenis_tanaman_bibit` (`id_jenis_tanaman_bibit`),
  KEY `FK_rku_bibit_rku` (`id_rku`),
  CONSTRAINT `FK_rku_bibit_master_jenis_tanaman_bibit` FOREIGN KEY (`id_jenis_tanaman_bibit`) REFERENCES `master_jenis_tanaman_bibit` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rku_bibit_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

/*Data for the table `rku_bibit` */

/*Table structure for table `rku_bibit_new` */

DROP TABLE IF EXISTS `rku_bibit_new`;

CREATE TABLE `rku_bibit_new` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `id_tanaman_silvikultur` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rku_bibit_new_rku` (`id_rku`),
  KEY `FK_rku_bibit_new_rku_tanaman_silvikultur` (`id_tanaman_silvikultur`),
  CONSTRAINT `FK_rku_bibit_new_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE,
  CONSTRAINT `FK_rku_bibit_new_rku_tanaman_silvikultur` FOREIGN KEY (`id_tanaman_silvikultur`) REFERENCES `rku_tanaman_silvikultur` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_bibit_new` */

/*Table structure for table `rku_ganis` */

DROP TABLE IF EXISTS `rku_ganis`;

CREATE TABLE `rku_ganis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `id_ganis` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rku_ganis_rku` (`id_rku`),
  KEY `FK_rku_ganis_jenis_ganis` (`id_ganis`),
  CONSTRAINT `FK_rku_ganis_jenis_ganis` FOREIGN KEY (`id_ganis`) REFERENCES `master_jenis_ganis` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rku_ganis_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_ganis` */

/*Table structure for table `rku_hama_penyakit` */

DROP TABLE IF EXISTS `rku_hama_penyakit`;

CREATE TABLE `rku_hama_penyakit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `hama` varchar(200) NOT NULL,
  `solusi` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rku_hama_penyakit_rku` (`id_rku`),
  CONSTRAINT `FK_rku_hama_penyakit_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_hama_penyakit` */

/*Table structure for table `rku_infra_mukim` */

DROP TABLE IF EXISTS `rku_infra_mukim`;

CREATE TABLE `rku_infra_mukim` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `id_infra_mukim` int(11) NOT NULL,
  `jumlah` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rku_infra_mukim_rku` (`id_rku`),
  KEY `FK_rku_infra_mukim_master_jenis_infra_mukim` (`id_infra_mukim`),
  CONSTRAINT `FK_rku_infra_mukim_master_jenis_infra_mukim` FOREIGN KEY (`id_infra_mukim`) REFERENCES `master_jenis_infra_mukim` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rku_infra_mukim_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_infra_mukim` */

/*Table structure for table `rku_inventarisasi` */

DROP TABLE IF EXISTS `rku_inventarisasi`;

CREATE TABLE `rku_inventarisasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL DEFAULT '0',
  `id_jenis_produksi` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_inventarisasi` */

/*Table structure for table `rku_kawasan_lindung` */

DROP TABLE IF EXISTS `rku_kawasan_lindung`;

CREATE TABLE `rku_kawasan_lindung` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `id_jenis_kawasan_lindung` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rku_kawasan_lindung_rku` (`id_rku`),
  KEY `FK_jenis _kawasan _lindung` (`id_jenis_kawasan_lindung`),
  CONSTRAINT `FK_jenis?_kawasan?_lindung` FOREIGN KEY (`id_jenis_kawasan_lindung`) REFERENCES `master_jenis_kawasan_lindung` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rku_kawasan_lindung_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_kawasan_lindung` */

/*Table structure for table `rku_kelembagaan` */

DROP TABLE IF EXISTS `rku_kelembagaan`;

CREATE TABLE `rku_kelembagaan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `kegiatan` varchar(100) NOT NULL,
  `rencana` int(11) NOT NULL,
  `keterangan` text,
  PRIMARY KEY (`id`),
  KEY `FK_rku_kelembagaan_rku` (`id_rku`),
  CONSTRAINT `FK_rku_kelembagaan_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_kelembagaan` */

/*Table structure for table `rku_panen` */

DROP TABLE IF EXISTS `rku_panen`;

CREATE TABLE `rku_panen` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `id_tanaman_silvikultur` int(11) NOT NULL,
  `luas` float(16,2) DEFAULT NULL,
  `volume` float(16,2) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rku_panen_rku` (`id_rku`),
  KEY `FK_rku_panen_rku_tanaman_silvikultur` (`id_tanaman_silvikultur`),
  CONSTRAINT `FK_rku_panen_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE,
  CONSTRAINT `FK_rku_panen_rku_tanaman_silvikultur` FOREIGN KEY (`id_tanaman_silvikultur`) REFERENCES `rku_tanaman_silvikultur` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_panen` */

/*Table structure for table `rku_pasar` */

DROP TABLE IF EXISTS `rku_pasar`;

CREATE TABLE `rku_pasar` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `id_jenis_tanaman` int(11) NOT NULL,
  `id_jenis_pasar` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rku_pasar_rku` (`id_rku`),
  KEY `FK_rku_pasar_master_jenis_pemasaran` (`id_jenis_pasar`),
  KEY `FK_rku_pasar_master_jenis_tanaman` (`id_jenis_tanaman`),
  CONSTRAINT `FK_rku_pasar_master_jenis_pemasaran` FOREIGN KEY (`id_jenis_pasar`) REFERENCES `master_jenis_pemasaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rku_pasar_master_jenis_tanaman` FOREIGN KEY (`id_jenis_tanaman`) REFERENCES `master_jenis_tanaman` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rku_pasar_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_pasar` */

/*Table structure for table `rku_pelihara` */

DROP TABLE IF EXISTS `rku_pelihara`;

CREATE TABLE `rku_pelihara` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `id_tanaman_silvikultur` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rku_pelihara_rku` (`id_rku`),
  KEY `FK_rku_pelihara_master_jenis_produksi_lahan` (`id_tanaman_silvikultur`),
  CONSTRAINT `FK_rku_pelihara_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE,
  CONSTRAINT `FK_rku_pelihara_rku_tanaman_silvikultur` FOREIGN KEY (`id_tanaman_silvikultur`) REFERENCES `rku_tanaman_silvikultur` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_pelihara` */

/*Table structure for table `rku_pemantauan_lingkungan` */

DROP TABLE IF EXISTS `rku_pemantauan_lingkungan`;

CREATE TABLE `rku_pemantauan_lingkungan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `kegiatan` varchar(255) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rku_pemantauan_lingkungan_rku` (`id_rku`),
  CONSTRAINT `FK_rku_pemantauan_lingkungan_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_pemantauan_lingkungan` */

/*Table structure for table `rku_penyiapan_lahan` */

DROP TABLE IF EXISTS `rku_penyiapan_lahan`;

CREATE TABLE `rku_penyiapan_lahan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `id_tanaman_silvikultur` int(11) NOT NULL,
  `id_jenis_lahan` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rku_penyiapan_lahan_rku` (`id_rku`),
  KEY `FK_rku_penyiapan_lahan_rku_tanaman_silvikultur` (`id_tanaman_silvikultur`),
  KEY `FK_rku_penyiapan_lahan_master_jenis_lahan` (`id_jenis_lahan`),
  CONSTRAINT `FK_rku_penyiapan_lahan_master_jenis_lahan` FOREIGN KEY (`id_jenis_lahan`) REFERENCES `master_jenis_lahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rku_penyiapan_lahan_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE,
  CONSTRAINT `FK_rku_penyiapan_lahan_rku_tanaman_silvikultur` FOREIGN KEY (`id_tanaman_silvikultur`) REFERENCES `rku_tanaman_silvikultur` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_penyiapan_lahan` */

/*Table structure for table `rku_peralatan` */

DROP TABLE IF EXISTS `rku_peralatan`;

CREATE TABLE `rku_peralatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `id_peralatan` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` text,
  PRIMARY KEY (`id`),
  KEY `FK_rku_peralatan_master_jenis_peralatan` (`id_peralatan`),
  KEY `FK_rku_peralatan_rku` (`id_rku`),
  CONSTRAINT `FK_rku_peralatan_master_jenis_peralatan` FOREIGN KEY (`id_peralatan`) REFERENCES `master_jenis_peralatan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rku_peralatan_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_peralatan` */

/*Table structure for table `rku_perambahan_hutan` */

DROP TABLE IF EXISTS `rku_perambahan_hutan`;

CREATE TABLE `rku_perambahan_hutan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `perlindungan` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rku_perambahan_hutan_rku` (`id_rku`),
  CONSTRAINT `FK_rku_perambahan_hutan_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_perambahan_hutan` */

/*Table structure for table `rku_potensi_produksi` */

DROP TABLE IF EXISTS `rku_potensi_produksi`;

CREATE TABLE `rku_potensi_produksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `potensi_produksi` float(16,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_potensi_produksi_rku` (`id_rku`),
  CONSTRAINT `FK_potensi_produksi_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_potensi_produksi` */

/*Table structure for table `rku_pwh` */

DROP TABLE IF EXISTS `rku_pwh`;

CREATE TABLE `rku_pwh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `id_jenis_pwh` int(11) NOT NULL,
  `jumlah` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rku_pwh_rku` (`id_rku`),
  KEY `FK_rku_pwh_master_jenis_pwh` (`id_jenis_pwh`),
  CONSTRAINT `FK_rku_pwh_master_jenis_pwh` FOREIGN KEY (`id_jenis_pwh`) REFERENCES `master_jenis_pwh` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rku_pwh_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_pwh` */

/*Table structure for table `rku_sarpras` */

DROP TABLE IF EXISTS `rku_sarpras`;

CREATE TABLE `rku_sarpras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `id_jenis_sarpras` int(11) NOT NULL,
  `jumlah` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rku_sarpras_rku` (`id_rku`),
  KEY `FK_rku_sarpras_master_jenis_sarpras` (`id_jenis_sarpras`),
  CONSTRAINT `FK_rku_sarpras_master_jenis_sarpras` FOREIGN KEY (`id_jenis_sarpras`) REFERENCES `master_jenis_sarpras` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rku_sarpras_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_sarpras` */

/*Table structure for table `rku_siap_lahan` */

DROP TABLE IF EXISTS `rku_siap_lahan`;

CREATE TABLE `rku_siap_lahan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `id_jenis_produksi_lahan` int(11) NOT NULL,
  `id_jenis_lahan` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rku_siap_lahan_rku` (`id_rku`),
  KEY `FK_rku_siap_lahan_master_jenis_lahan` (`id_jenis_lahan`),
  KEY `FK_rku_siap_lahan_master_jenis_produksi_lahan` (`id_jenis_produksi_lahan`),
  CONSTRAINT `FK_rku_siap_lahan_master_jenis_lahan` FOREIGN KEY (`id_jenis_lahan`) REFERENCES `master_jenis_lahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rku_siap_lahan_master_jenis_produksi_lahan` FOREIGN KEY (`id_jenis_produksi_lahan`) REFERENCES `master_jenis_produksi_lahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rku_siap_lahan_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_siap_lahan` */

/*Table structure for table `rku_sistem_silvikultur` */

DROP TABLE IF EXISTS `rku_sistem_silvikultur`;

CREATE TABLE `rku_sistem_silvikultur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `id_jenis_silvikultur` int(11) NOT NULL,
  `sistem_silvikultur` varchar(100) DEFAULT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rku_silvikultur_system` (`id_rku`),
  KEY `FK_rku_sistem_silvikultur_master_jenis_silvikultur` (`id_jenis_silvikultur`),
  CONSTRAINT `FK_rku_silvikultur_system` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE,
  CONSTRAINT `FK_rku_sistem_silvikultur_master_jenis_silvikultur` FOREIGN KEY (`id_jenis_silvikultur`) REFERENCES `master_jenis_silvikultur` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_sistem_silvikultur` */

/*Table structure for table `rku_tanam` */

DROP TABLE IF EXISTS `rku_tanam`;

CREATE TABLE `rku_tanam` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `id_tanaman_silvikultur` int(11) NOT NULL,
  `id_jenis_lahan` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__rku` (`id_rku`),
  KEY `FK__master_jenis_produksi_lahan` (`id_tanaman_silvikultur`),
  KEY `FK__master_jenis_lahan` (`id_jenis_lahan`),
  CONSTRAINT `FK_rku_tanam_master_jenis_lahan` FOREIGN KEY (`id_jenis_lahan`) REFERENCES `master_jenis_lahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_rku_tanam_rku_tanaman_silvikultur` FOREIGN KEY (`id_tanaman_silvikultur`) REFERENCES `rku_tanaman_silvikultur` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK__rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_tanam` */

/*Table structure for table `rku_tanaman_silvikultur` */

DROP TABLE IF EXISTS `rku_tanaman_silvikultur`;

CREATE TABLE `rku_tanaman_silvikultur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `id_jenis_produksi_lahan` int(11) NOT NULL,
  `id_jenis_tanaman` int(11) NOT NULL,
  `daur` int(11) NOT NULL COMMENT 'tahun',
  `id_jarak_tanam` int(11) DEFAULT NULL,
  `jarak_tanam` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_silvikultur_jenis_produksi_lahan` (`id_jenis_produksi_lahan`),
  KEY `FK_silvikultur_jenis_tanaman` (`id_jenis_tanaman`),
  KEY `FK_silvikultur_jenis_tanaman_rku` (`id_rku`),
  KEY `FK_rku_tanaman_silvikultur_master_jarak_tanam` (`id_jarak_tanam`),
  CONSTRAINT `FK_rku_tanaman_silvikultur_master_jarak_tanam` FOREIGN KEY (`id_jarak_tanam`) REFERENCES `master_jarak_tanam` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_silvikultur_jenis_produksi_lahan` FOREIGN KEY (`id_jenis_produksi_lahan`) REFERENCES `master_jenis_produksi_lahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_silvikultur_jenis_tanaman` FOREIGN KEY (`id_jenis_tanaman`) REFERENCES `master_jenis_tanaman` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_silvikultur_jenis_tanaman_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_tanaman_silvikultur` */

/*Table structure for table `rku_tata_batas` */

DROP TABLE IF EXISTS `rku_tata_batas`;

CREATE TABLE `rku_tata_batas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `id_jenis_batas` int(11) NOT NULL,
  `jumlah` float(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_perusahaan` (`id_jenis_batas`),
  KEY `id_rku` (`id_rku`),
  CONSTRAINT `FK_rku_tata_batas_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE,
  CONSTRAINT `FK_tata_batas_jenis_batas` FOREIGN KEY (`id_jenis_batas`) REFERENCES `master_jenis_batas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_tata_batas` */

/*Table structure for table `rku_teknik_pemadaman` */

DROP TABLE IF EXISTS `rku_teknik_pemadaman`;

CREATE TABLE `rku_teknik_pemadaman` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `metode` varchar(200) NOT NULL,
  `kondisi_kebakaran` varchar(200) DEFAULT NULL,
  `cara` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rku_teknik_pemadaman_rku` (`id_rku`),
  CONSTRAINT `FK_rku_teknik_pemadaman_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rku_teknik_pemadaman` */

/*Table structure for table `saham` */

DROP TABLE IF EXISTS `saham`;

CREATE TABLE `saham` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_perusahaan` int(11) NOT NULL,
  `nama_pemodal` varchar(100) NOT NULL,
  `jumlah` float(6,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_saham_perusahaan` (`id_perusahaan`),
  CONSTRAINT `FK_saham_perusahaan` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `saham` */

/*Table structure for table `sertifikasi_phpl` */

DROP TABLE IF EXISTS `sertifikasi_phpl`;

CREATE TABLE `sertifikasi_phpl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_perusahaan` int(11) NOT NULL,
  `tahun_sertifikasi` year(4) DEFAULT NULL,
  `nilai_kinerja` int(11) DEFAULT NULL,
  `predikat` varchar(255) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_berakhir` date DEFAULT NULL,
  `penerbit` varchar(255) DEFAULT NULL,
  `biaya` enum('Biaya Sendiri','APBN') DEFAULT 'Biaya Sendiri',
  PRIMARY KEY (`id`),
  KEY `FK_sertifikasi_phpl` (`id_perusahaan`),
  CONSTRAINT `FK_sertifikasi_phpl` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `sertifikasi_phpl` */

/*Table structure for table `sertifikasi_vlk` */

DROP TABLE IF EXISTS `sertifikasi_vlk`;

CREATE TABLE `sertifikasi_vlk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_perusahaan` int(11) NOT NULL,
  `nomor` varchar(255) DEFAULT NULL,
  `berlaku` date DEFAULT NULL,
  `berakhir` date DEFAULT NULL,
  `penerbit` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sertifikasi_vlk` (`id_perusahaan`),
  CONSTRAINT `FK_sertifikasi_vlk` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `sertifikasi_vlk` */

/*Table structure for table `spasial_iup` */

DROP TABLE IF EXISTS `spasial_iup`;

CREATE TABLE `spasial_iup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_iup` int(11) NOT NULL,
  `id_perusahaan` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_spasial_rkt` (`id_iup`),
  KEY `FK_spasial_rkt_perusahaan` (`id_perusahaan`),
  CONSTRAINT `FK_spasial_iup` FOREIGN KEY (`id_iup`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE,
  CONSTRAINT `FK_spasial_iup_perusahaan` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `spasial_iup` */

/*Table structure for table `spasial_rkt` */

DROP TABLE IF EXISTS `spasial_rkt`;

CREATE TABLE `spasial_rkt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rkt` int(11) NOT NULL,
  `id_perusahaan` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_spasial_rkt` (`id_rkt`),
  KEY `FK_spasial_rkt_perusahaan` (`id_perusahaan`),
  CONSTRAINT `FK_spasial_rkt` FOREIGN KEY (`id_rkt`) REFERENCES `rkt` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_spasial_rkt_perusahaan` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `spasial_rkt` */

/*Table structure for table `spasial_rku` */

DROP TABLE IF EXISTS `spasial_rku`;

CREATE TABLE `spasial_rku` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rku` int(11) NOT NULL,
  `id_perusahaan` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_spasial_rku` (`id_rku`),
  CONSTRAINT `FK_spasial_rku` FOREIGN KEY (`id_rku`) REFERENCES `rku` (`id_rku`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `spasial_rku` */

/*Table structure for table `spasial_tb` */

DROP TABLE IF EXISTS `spasial_tb`;

CREATE TABLE `spasial_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_iup` int(11) NOT NULL,
  `id_perusahaan` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_spasial_rkt` (`id_iup`),
  KEY `FK_spasial_rkt_perusahaan` (`id_perusahaan`),
  CONSTRAINT `FK_spasial_tb_perusahaan` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`) ON DELETE CASCADE,
  CONSTRAINT `FK_spasial_tb` FOREIGN KEY (`id_iup`) REFERENCES `iuphhk` (`id_iuphhk`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `spasial_tb` */

/*Table structure for table `tenaga_kerja` */

DROP TABLE IF EXISTS `tenaga_kerja`;

CREATE TABLE `tenaga_kerja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `perusahaan_id` int(11) DEFAULT NULL,
  `kategori` enum('Teknis','Non Teknis') NOT NULL DEFAULT 'Teknis',
  `sarjana` int(11) NOT NULL DEFAULT '0',
  `menengah` int(11) NOT NULL DEFAULT '0',
  `asing` int(11) NOT NULL DEFAULT '0',
  `bersertifikat` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_tenaga_kerja` (`perusahaan_id`),
  CONSTRAINT `FK_tenaga_kerja` FOREIGN KEY (`perusahaan_id`) REFERENCES `perusahaan` (`id_perusahaan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tenaga_kerja` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
