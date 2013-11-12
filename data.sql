/*
SQLyog Community v11.26Test 3 (64 bit)
MySQL - 5.6.14-log : Database - firefox
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`firefox` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci */;

USE `firefox`;

/*Table structure for table `articulos` */

CREATE TABLE `articulos` (
  `articuloID` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) DEFAULT NULL,
  `precio` float NOT NULL DEFAULT '0',
  `articuloTipoID` int(11) NOT NULL,
  `esta` char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`articuloID`),
  KEY `articuloTipoID` (`articuloTipoID`),
  CONSTRAINT `articulos_ibfk_1` FOREIGN KEY (`articuloTipoID`) REFERENCES `articulostipos` (`articuloTipoID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `articulos` */

insert  into `articulos`(`articuloID`,`descripcion`,`precio`,`articuloTipoID`,`esta`) values (1,'BURRITOS',15,1,'A');
insert  into `articulos`(`articuloID`,`descripcion`,`precio`,`articuloTipoID`,`esta`) values (2,'BURRITOS',15,2,'A');
insert  into `articulos`(`articuloID`,`descripcion`,`precio`,`articuloTipoID`,`esta`) values (3,'BURRITOS',15,3,'A');
insert  into `articulos`(`articuloID`,`descripcion`,`precio`,`articuloTipoID`,`esta`) values (4,'MONTADO',30,2,'A');
insert  into `articulos`(`articuloID`,`descripcion`,`precio`,`articuloTipoID`,`esta`) values (5,'TORTA',35,3,'A');

/*Table structure for table `articulostipos` */

CREATE TABLE `articulostipos` (
  `articuloTipoID` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  `esta` char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`articuloTipoID`),
  UNIQUE KEY `descripcion` (`descripcion`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `articulostipos` */

insert  into `articulostipos`(`articuloTipoID`,`descripcion`,`esta`) values (1,'FRIJOLES','A');
insert  into `articulostipos`(`articuloTipoID`,`descripcion`,`esta`) values (2,'DESHEBRADA EN ROJO','A');
insert  into `articulostipos`(`articuloTipoID`,`descripcion`,`esta`) values (3,'DESHEBRADA EN VERDE','A');
insert  into `articulostipos`(`articuloTipoID`,`descripcion`,`esta`) values (4,'CHICHARRON','A');

/*Table structure for table `eventos` */

CREATE TABLE `eventos` (
  `eventoID` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaInicial` datetime NOT NULL,
  `fechaFinal` datetime NOT NULL,
  `esta` char(1) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'A',
  PRIMARY KEY (`eventoID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `eventos` */

/*Table structure for table `menus` */

CREATE TABLE `menus` (
  `menuID` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `esta` char(1) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'A',
  PRIMARY KEY (`menuID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `menus` */

/*Table structure for table `pedidos` */

CREATE TABLE `pedidos` (
  `pedidoID` int(11) NOT NULL AUTO_INCREMENT,
  `usuarioID` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `esta` char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`pedidoID`),
  KEY `usuarioID` (`usuarioID`),
  CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuarioID`) REFERENCES `usuarios` (`usuarioID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pedidos` */

/*Table structure for table `pedidosdetalle` */

CREATE TABLE `pedidosdetalle` (
  `pedidoDetalleID` int(11) NOT NULL AUTO_INCREMENT,
  `pedidoID` int(11) NOT NULL,
  `articuloID` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `esta` char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`pedidoDetalleID`),
  KEY `articuloID` (`articuloID`),
  CONSTRAINT `pedidosdetalle_ibfk_1` FOREIGN KEY (`articuloID`) REFERENCES `articulos` (`articuloID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pedidosdetalle` */

/*Table structure for table `posts` */

CREATE TABLE `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `texto` varchar(4000) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `usuarioId` int(11) NOT NULL,
  `tienefoto` int(11) NOT NULL DEFAULT '0',
  `geo` varchar(1000) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ix_usupost` (`usuarioId`,`fecha`),
  KEY `ix_fecha_post` (`fecha`,`usuarioId`),
  CONSTRAINT `fk_usu_post` FOREIGN KEY (`usuarioId`) REFERENCES `usuarios` (`usuarioID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `posts` */

insert  into `posts`(`id`,`texto`,`fecha`,`usuarioId`,`tienefoto`,`geo`) values (10,'viva mexico','2013-11-12 15:16:41',2,1,'{\"accuracy\":24,\"altitude\":0,\"altitudeAccuracy\":0,\"heading\":null,\"latitude\":28.7122855,\"longitude\":-106.1395119,\"speed\":null,\"timestamp\":1384294580792}');
insert  into `posts`(`id`,`texto`,`fecha`,`usuarioId`,`tienefoto`,`geo`) values (11,'otro post mas','2013-11-12 15:23:12',2,1,'{\"accuracy\":24,\"altitude\":0,\"altitudeAccuracy\":0,\"heading\":null,\"latitude\":28.7122855,\"longitude\":-106.1395119,\"speed\":null,\"timestamp\":1384294985353,\"direccion\":\"Paseo de la Universidad, Campus II Uach, 31125 Chihuahua, CHIH, México\"}');
insert  into `posts`(`id`,`texto`,`fecha`,`usuarioId`,`tienefoto`,`geo`) values (12,'ingue su <b>madre</b>','2013-11-12 15:56:13',2,1,'{\"accuracy\":77,\"altitude\":0,\"altitudeAccuracy\":0,\"heading\":null,\"latitude\":28.6364211,\"longitude\":-106.0844373,\"speed\":null,\"timestamp\":1384296931150,\"direccion\":\"Teófilo Borunda, San Pedro, 31000 Chihuahua, CHIH, México\"}');

/*Table structure for table `usuarios` */

CREATE TABLE `usuarios` (
  `usuarioID` int(11) NOT NULL AUTO_INCREMENT,
  `apaterno` varchar(50) DEFAULT NULL,
  `amaterno` varchar(50) DEFAULT NULL,
  `nombres` varchar(50) DEFAULT NULL,
  `usuario` varchar(35) NOT NULL,
  `clave` varchar(32) NOT NULL,
  `esta` char(1) NOT NULL DEFAULT 'A',
  `email` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`usuarioID`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `usuarios` */

insert  into `usuarios`(`usuarioID`,`apaterno`,`amaterno`,`nombres`,`usuario`,`clave`,`esta`,`email`) values (1,'ponce','v','alejandr0','aponce','5e075c37efb4f81dbfd557a58fc2e58f','A','raulsalitrero@gmail.com');
insert  into `usuarios`(`usuarioID`,`apaterno`,`amaterno`,`nombres`,`usuario`,`clave`,`esta`,`email`) values (2,'salitrero','e','rulo','rsalitrero','5e075c37efb4f81dbfd557a58fc2e58f','A','aponce1979@gmail.com');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
