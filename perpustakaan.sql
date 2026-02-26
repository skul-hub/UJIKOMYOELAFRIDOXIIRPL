/*
SQLyog Enterprise v12.09 (64 bit)
MySQL - 10.4.27-MariaDB : Database - perpustakaan
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`perpustakaan` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `perpustakaan`;

/*Table structure for table `anggota` */

DROP TABLE IF EXISTS `anggota`;

CREATE TABLE `anggota` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) DEFAULT NULL,
  `nis` varchar(50) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `anggota` */

insert  into `anggota`(`id`,`user_id`,`nis`,`kelas`,`alamat`,`status`) values (20,'24','27392022','XII RPL','CIANGSANA','aktif'),(22,'26','2143432534','XII RPL','BANTAR GEBANG','aktif'),(19,'23','21323124','XII RPL','alok','aktif'),(21,'25','2143432534','XII','GRIYA','aktif'),(18,'22','27392022','xii','griya alam santot','aktif');

/*Table structure for table `buku` */

DROP TABLE IF EXISTS `buku`;

CREATE TABLE `buku` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `kode_buku` varchar(50) DEFAULT NULL,
  `judul` varchar(50) DEFAULT NULL,
  `pengarang` varchar(50) DEFAULT NULL,
  `penerbit` varchar(50) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `buku` */

insert  into `buku`(`id`,`kode_buku`,`judul`,`pengarang`,`penerbit`,`tahun`,`stok`) values (9,'BK-001','LASKAR PELANGI','Andrea Hirata','Bentang Pustaka',2005,9999),(10,'BK-002','Negeri 5 Menara','Ahmad Fuadi','Gramedia Pustaka Utama',2009,9999);

/*Table structure for table `peminjaman` */

DROP TABLE IF EXISTS `peminjaman`;

CREATE TABLE `peminjaman` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `anggota_id` int(20) DEFAULT NULL,
  `tgl_pinjam` date DEFAULT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `status` enum('dipinjam','dikembalikan') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `peminjaman` */

insert  into `peminjaman`(`id`,`anggota_id`,`tgl_pinjam`,`tgl_kembali`,`status`) values (34,19,'2026-02-26','2026-02-27','dikembalikan'),(36,20,'2026-02-26','2026-02-27','dikembalikan'),(35,18,'2026-02-26','2026-03-29','dikembalikan');

/*Table structure for table `peminjaman_detail` */

DROP TABLE IF EXISTS `peminjaman_detail`;

CREATE TABLE `peminjaman_detail` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `peminjaman_id` int(20) DEFAULT NULL,
  `buku_id` int(20) DEFAULT NULL,
  `qty` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `peminjaman_detail` */

insert  into `peminjaman_detail`(`id`,`peminjaman_id`,`buku_id`,`qty`) values (50,36,9,1),(47,34,9,1),(49,36,10,1),(48,35,9,5);

/*Table structure for table `pengembalian` */

DROP TABLE IF EXISTS `pengembalian`;

CREATE TABLE `pengembalian` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `peminjaman_id` int(20) DEFAULT NULL,
  `tgl_pengembalian` date DEFAULT NULL,
  `denda` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `pengembalian` */

insert  into `pengembalian`(`id`,`peminjaman_id`,`tgl_pengembalian`,`denda`) values (31,34,'2026-02-28','5000'),(33,36,'2026-06-30','615000'),(32,35,'2222-12-30','359315000');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `role` enum('admin','siswa') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`nama`,`username`,`password`,`role`,`created_at`) values (26,'FAREL','farel','$2y$10$7VGNQymVewiowjjsog0tl.IUfW0.0hKflK5ol9yuccEkDCkYEq.4m','siswa','2026-02-26 10:20:21'),(23,'susan','susan','$2y$10$Wj3klZTx712uApg/eqb2COa0BxyuYGD6lU/4qzSVKY6SVBNAQN8eu','siswa',NULL),(24,'RIVANO','rivano','$2y$10$AeBxFDsRjp2Dqi69yQgwl.dfAHguzkyZiG1gQpWDyf1qOknYKe1wm','siswa','2026-02-26 09:54:12'),(25,'DANIEL ADI ','daniel','$2y$10$/b4Tnc2nsp2r0myoPhWTNOxOdkz1J9PLRxwP8F8vERSuj8uDf7422','siswa',NULL),(21,'admin','admin','$2y$10$rt6QQQg.J48Xd2IDsuf3TuszrRPQy6mGkwQ4YmbkaYIOvdR5yDSQm','admin',NULL),(22,'asep','asep','$2y$10$lBMdFiNkSnQlBSmHP4t8LOt.6vI2AYUVbP13UATZ6Ye0d57ZRfghu','siswa',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
