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
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'AfterWork'),(2,'Atelier'),(3,'Barcamp'),(4,'Conférence'),(5,'Formation'),(6,'Hackathon'),(7,'Meetup'),(8,'NetWorking'),(9,'Startup Weekend');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` VALUES (1,'numo@gmail.com','Orléans','45000','1 avenue du champs de Mars,  Le Lab\'O','0123456789',NULL,'5964d564f2669.pdf','Num\'O est une association numérique','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In commodo leo a eleifend imperdiet. Etiam sed orci placerat, convallis nulla eget, viverra nisi. Vivamus imperdiet consectetur tortor, a tincidunt leo efficitur et. Nullam bibendum neque vitae sollicitudin fringilla. Vivamus convallis a magna sit amet blandit. Quisque tellus urna, tempor ac orci id, molestie iaculis neque. Aenean sit amet feugiat lorem. Vivamus consequat libero vehicula, ornare arcu semper, pellentesque turpis. Sed euismod sed nulla at congue. Vivamus elementum rhoncus ex, fermentum facilisis leo finibus rhoncus. Ut lacinia, elit in tincidunt maximus, velit lorem lobortis lorem, in bibendum turpis lorem et ligula. Ut id laoreet ligula, eget accumsan odio.\r\n\r\nVestibulum mattis, libero vitae euismod vulputate, ipsum ligula placerat purus, ullamcorper maximus diam mauris rutrum nisl. Integer vel ipsum eleifend, lobortis diam vel, faucibus est. Morbi fringilla vulputate pulvinar. Cras et arcu ut odio viverra feugiat. Donec scelerisque lacinia metus, vitae sollicitudin nibh laoreet ac. Maecenas lorem neque, cursus vel justo eu, vestibulum molestie ante. Nullam a orci leo. Maecenas ac massa id risus hendrerit interdum. Nam iaculis sagittis ipsum vel blandit. Curabitur non est tempor, dignissim nunc a, ultrices nisi.\r\n\r\nVivamus varius elit ac urna accumsan efficitur. Morbi pulvinar vehicula nisl eget varius. Maecenas et lorem venenatis, commodo orci sit amet, volutpat dolor. Phasellus viverra vel lacus eu facilisis. Aenean et imperdiet eros. Aenean ac feugiat diam. Sed sagittis enim non nunc dapibus, et sagittis neque volutpat.','Adhérez à Num\'O !','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In commodo leo a eleifend imperdiet. Etiam sed orci placerat, convallis nulla eget, viverra nisi. Vivamus imperdiet consectetur tortor, a tincidunt leo efficitur et. Nullam bibendum neque vitae sollicitudin fringilla. Vivamus convallis a magna sit amet blandit. Quisque tellus urna, tempor ac orci id, molestie iaculis neque. Aenean sit amet feugiat lorem. Vivamus consequat libero vehicula, ornare arcu semper, pellentesque turpis. Sed euismod sed nulla at congue. Vivamus elementum rhoncus ex, fermentum facilisis leo finibus rhoncus. Ut lacinia, elit in tincidunt maximus, velit lorem lobortis lorem, in bibendum turpis lorem et ligula. Ut id laoreet ligula, eget accumsan odio.\r\n\r\nVestibulum mattis, libero vitae euismod vulputate, ipsum ligula placerat purus, ullamcorper maximus diam mauris rutrum nisl. Integer vel ipsum eleifend, lobortis diam vel, faucibus est. Morbi fringilla vulputate pulvinar. Cras et arcu ut odio viverra feugiat. Donec scelerisque lacinia metus, vitae sollicitudin nibh laoreet ac. Maecenas lorem neque, cursus vel justo eu, vestibulum molestie ante. Nullam a orci leo. Maecenas ac massa id risus hendrerit interdum. Nam iaculis sagittis ipsum vel blandit. Curabitur non est tempor, dignissim nunc a, ultrices nisi.\r\n\r\nVivamus varius elit ac urna accumsan efficitur. Morbi pulvinar vehicula nisl eget varius. Maecenas et lorem venenatis, commodo orci sit amet, volutpat dolor. Phasellus viverra vel lacus eu facilisis. Aenean et imperdiet eros. Aenean ac feugiat diam. Sed sagittis enim non nunc dapibus, et sagittis neque volutpat.');
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `fos_user`
--

LOCK TABLES `fos_user` WRITE;
/*!40000 ALTER TABLE `fos_user` DISABLE KEYS */;
INSERT INTO `fos_user` VALUES (12,'duri.teamwild@gmail.com','duri.teamwild@gmail.com','duri.teamwild@gmail.com','duri.teamwild@gmail.com',1,NULL,'$2y$13$YzY.eoUEBa6qK9.mQHmrMeFhO5xB1f/Oy.3n0uzscxzBemJsnjpiu','2017-07-13 09:23:33',NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}','Duri','Wild',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `fos_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `partner`
--

LOCK TABLES `partner` WRITE;
/*!40000 ALTER TABLE `partner` DISABLE KEYS */;
INSERT INTO `partner` VALUES (1,'Wild Code School','https://wildcodeschool.fr/','59649c4da34f0.png',1),(2,'Lab\'O','http://www.le-lab-o.fr/','logolabo.png',1);
/*!40000 ALTER TABLE `partner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `pricing_info`
--

LOCK TABLES `pricing_info` WRITE;
/*!40000 ALTER TABLE `pricing_info` DISABLE KEYS */;
INSERT INTO `pricing_info` VALUES (1,'Plus d\'info sur le site de billeterie'),(2,'Gratuit'),(3,'Gratuit mais necessite inscription (voir billeterie)'),(4,'Payant - Inscription sur place'),(5,'Payant - Necessite inscription (voir billeterie)');
/*!40000 ALTER TABLE `pricing_info` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-17 13:12:06
