-- MySQL dump 10.13  Distrib 5.7.18, for Linux (x86_64)
--
-- Host: localhost    Database: numo
-- ------------------------------------------------------
-- Server version	5.7.18-0ubuntu0.16.04.1

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
-- Table structure for table `page_content`
--

DROP TABLE IF EXISTS `page_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `lastModif` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_content`
--

LOCK TABLES `page_content` WRITE;
/*!40000 ALTER TABLE `page_content` DISABLE KEYS */;
INSERT INTO `page_content` VALUES (1,'Num\'o est une association numérique','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In commodo leo a eleifend imperdiet. Etiam sed orci placerat, convallis nulla eget, viverra nisi. Vivamus imperdiet consectetur tortor, a tincidunt leo efficitur et. Nullam bibendum neque vitae sollicitudin fringilla. Vivamus convallis a magna sit amet blandit. Quisque tellus urna, tempor ac orci id, molestie iaculis neque. Aenean sit amet feugiat lorem. Vivamus consequat libero vehicula, ornare arcu semper, pellentesque turpis. Sed euismod sed nulla at congue. Vivamus elementum rhoncus ex, fermentum facilisis leo finibus rhoncus. Ut lacinia, elit in tincidunt maximus, velit lorem lobortis lorem, in bibendum turpis lorem et ligula. Ut id laoreet ligula, eget accumsan odio.\r\n\r\nVestibulum mattis, libero vitae euismod vulputate, ipsum ligula placerat purus, ullamcorper maximus diam mauris rutrum nisl. Integer vel ipsum eleifend, lobortis diam vel, faucibus est. Morbi fringilla vulputate pulvinar. Cras et arcu ut odio viverra feugiat. Donec scelerisque lacinia metus, vitae sollicitudin nibh laoreet ac. Maecenas lorem neque, cursus vel justo eu, vestibulum molestie ante. Nullam a orci leo. Maecenas ac massa id risus hendrerit interdum. Nam iaculis sagittis ipsum vel blandit. Curabitur non est tempor, dignissim nunc a, ultrices nisi.\r\n\r\nVivamus varius elit ac urna accumsan efficitur. Morbi pulvinar vehicula nisl eget varius. Maecenas et lorem venenatis, commodo orci sit amet, volutpat dolor. Phasellus viverra vel lacus eu facilisis. Aenean et imperdiet eros. Aenean ac feugiat diam. Sed sagittis enim non nunc dapibus, et sagittis neque volutpat.','2012-01-01 00:00:00'),(2,'Adhérez à NUM\'O !','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Velit egestas dui id ornare arcu odio ut sem nulla. Aliquam sem fringilla ut morbi tincidunt augue interdum velit euismod. Ut diam quam nulla porttitor. Elit at imperdiet dui accumsan sit amet. Lobortis scelerisque fermentum dui faucibus in ornare quam viverra. Dolor magna eget est lorem ipsum dolor sit amet consectetur. Amet nulla facilisi morbi tempus iaculis urna. Elit ullamcorper dignissim cras tincidunt. Ultrices mi tempus imperdiet nulla. Pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Tristique et egestas quis ipsum. Senectus et netus et malesuada fames. Volutpat commodo sed egestas egestas fringilla phasellus. Porttitor leo a diam sollicitudin tempor id eu nisl. Pharetra et ultrices neque ornare aenean euismod elementum nisi. Varius quam quisque id diam vel quam elementum. Tellus cras adipiscing enim eu turpis egestas pretium aenean pharetra. Non arcu risus quis varius. Volutpat est velit egestas dui id.\r\n\r\nDignissim convallis aenean et tortor. At augue eget arcu dictum. Sit amet luctus venenatis lectus magna fringilla urna. Aliquam ultrices sagittis orci a scelerisque purus semper. Nunc mi ipsum faucibus vitae aliquet nec ullamcorper sit amet. Pellentesque habitant morbi tristique senectus. Dictum sit amet justo donec enim diam vulputate ut pharetra. Dolor morbi non arcu risus. Aliquam sem et tortor consequat id porta nibh venenatis. Vitae auctor eu augue ut lectus arcu bibendum at varius. Ac odio tempor orci dapibus ultrices. Felis donec et odio pellentesque diam volutpat commodo. Quam elementum pulvinar etiam non. Donec massa sapien faucibus et molestie ac feugiat. Volutpat consequat mauris nunc congue. Arcu ac tortor dignissim convallis aenean et tortor. Ac tortor vitae purus faucibus ornare suspendisse sed nisi lacus. Ante metus dictum at tempor. Facilisi nullam vehicula ipsum a arcu cursus vitae congue. Sit amet porttitor eget dolor morbi non arcu risus.','2017-01-01 00:00:00');
/*!40000 ALTER TABLE `page_content` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-12 16:24:39
