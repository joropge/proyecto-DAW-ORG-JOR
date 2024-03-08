CREATE DATABASE  IF NOT EXISTS `ezequiel` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `ezequiel`;
-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: ezequiel
-- ------------------------------------------------------
-- Server version	8.0.36

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo_animal` varchar(45) NOT NULL,
  `procedencia` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'cerdo','andalucia'),(2,'cerdo','extremadura'),(3,'vaca','asturias'),(4,'vaca','galicia'),(5,'pollo','castilla y leon');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idUser` varchar(45) DEFAULT NULL,
  `precioTotal` decimal(8,2) DEFAULT NULL,
  `fechaPedido` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` VALUES (1,'17',11.75,'2024-03-07'),(6,'17',14.00,'2024-03-08');
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `racion` decimal(10,2) NOT NULL,
  `precioKg` decimal(10,2) DEFAULT NULL,
  `fecha_produccion` date NOT NULL,
  `fecha_caducidad` date NOT NULL,
  `categoria_id` int NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_productos_categoria_idx` (`categoria_id`),
  CONSTRAINT `fk_productos_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'Anca de Pollo',1.00,12.00,'2024-03-01','2024-04-01',5,'6ae47d2728bd541ebe07c52d795cfde6.jpg'),(2,'Cabeza de Cerdo',1.00,20.00,'2024-03-01','2024-04-01',2,'5332c2290bee6b5a70175c92d393f149.jpg'),(3,'Filete de Cerdo',1.00,14.00,'2024-03-01','2024-04-01',1,'625319d9c1892293916dda7719def345.jpg'),(4,'Higado de Ternera',1.00,5.00,'2024-03-01','2024-04-01',3,'d870c8ef9b72c5aeae95a3df1efd1546.jpg'),(5,'Paleta de Cerdo',1.00,23.00,'2024-03-01','2024-04-01',1,'7c550372c2ac63af6219dc491154bb13.jpg'),(6,'Pata de Cerdo',1.00,21.00,'2024-03-01','2024-04-01',2,'49fa4fdd805cda7a39ef94d670f65aaa.jpg'),(7,'Pollo Asado',1.00,13.00,'2024-03-01','2024-04-01',5,'13561f78fdb7b66437b6e6547d1b78f5.jpg'),(8,'Pollo Entero',1.00,15.00,'2024-03-01','2024-04-01',5,'a62e48ff59e75b04112c0556ac481fb4.jpg'),(9,'Tacos de Ternera',1.00,10.00,'2024-03-01','2024-04-01',4,'698c77c6fb2390b5ee07d36c0d88fd4b.jpg');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `fecha_registro` timestamp(5) NULL DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `rol` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (17,'usuario','usuario@usuario.es','$2y$10$mJv3/6rFaataTMzif6Ok0OHuv2ioIH1b2PXnwH.qAtgBEG6t1/S5K','2024-03-08 09:38:55.00000','user',2),(18,'admin','admin@admin.es','$2y$10$kcloo3DGDYmVF3H8fMsz/.b0JsSYJb6smkO9LcKJv4B0peC4D0N.6','2024-03-08 09:39:12.00000','admin',1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-03-08 11:54:40
