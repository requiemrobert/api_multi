/*
Navicat MySQL Data Transfer

Source Server         : global_system
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : global_system

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-11-07 00:20:34
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for autorizacion
-- ----------------------------
DROP TABLE IF EXISTS `autorizacion`;
CREATE TABLE `autorizacion` (
  `id_autorizacion` int(11) NOT NULL AUTO_INCREMENT,
  `id_perfil_fk` int(11) NOT NULL,
  `id_modulo_fk` int(11) NOT NULL,
  `acceso` tinyint(10) NOT NULL,
  PRIMARY KEY (`id_autorizacion`),
  KEY `id_perfil_fk` (`id_perfil_fk`),
  KEY `id_modulo_fk` (`id_modulo_fk`),
  CONSTRAINT `autorizacion_ibfk_1` FOREIGN KEY (`id_perfil_fk`) REFERENCES `perfil` (`id_perfil`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `autorizacion_ibfk_2` FOREIGN KEY (`id_modulo_fk`) REFERENCES `modulo` (`id_modulo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of autorizacion
-- ----------------------------
INSERT INTO `autorizacion` VALUES ('1', '1', '1', '1');
INSERT INTO `autorizacion` VALUES ('2', '1', '2', '1');
INSERT INTO `autorizacion` VALUES ('3', '1', '3', '1');
INSERT INTO `autorizacion` VALUES ('4', '1', '4', '1');

-- ----------------------------
-- Table structure for modulo
-- ----------------------------
DROP TABLE IF EXISTS `modulo`;
CREATE TABLE `modulo` (
  `id_modulo` int(11) NOT NULL AUTO_INCREMENT,
  `id_modulo_fk` int(11) NOT NULL,
  `descripcion` varchar(25) NOT NULL,
  `activo` tinyint(10) NOT NULL,
  PRIMARY KEY (`id_modulo`,`id_modulo_fk`),
  KEY `id_modulo` (`id_modulo`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of modulo
-- ----------------------------
INSERT INTO `modulo` VALUES ('1', '0', 'operaciones', '1');
INSERT INTO `modulo` VALUES ('2', '0', 'clientes', '1');
INSERT INTO `modulo` VALUES ('3', '0', 'proveedores', '1');
INSERT INTO `modulo` VALUES ('4', '0', 'productos', '1');

-- ----------------------------
-- Table structure for perfil
-- ----------------------------
DROP TABLE IF EXISTS `perfil`;
CREATE TABLE `perfil` (
  `id_perfil` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_perfil` varchar(30) NOT NULL,
  `status` tinyint(20) NOT NULL,
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of perfil
-- ----------------------------
INSERT INTO `perfil` VALUES ('1', 'administrador', '1');
INSERT INTO `perfil` VALUES ('2', 'usuario', '1');

-- ----------------------------
-- Table structure for usuario
-- ----------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(20) NOT NULL,
  `f_name` varchar(20) NOT NULL,
  `l_name` varchar(20) NOT NULL,
  `email` varchar(35) NOT NULL,
  `password` varchar(20) NOT NULL,
  `status` tinyint(20) NOT NULL,
  `id_perfil_fk` int(20) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `usuario` (`usuario`),
  KEY `FK_id_perfil` (`id_perfil_fk`),
  CONSTRAINT `FK_id_perfil` FOREIGN KEY (`id_perfil_fk`) REFERENCES `perfil` (`id_perfil`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of usuario
-- ----------------------------
INSERT INTO `usuario` VALUES ('2', 'moya', 'daniel', 'nolasco', 'dnolasco@gmail.com', '123+', '1', '1');
INSERT INTO `usuario` VALUES ('3', 'crojas', 'carlos', 'rojas', 'crojas@gmail.com', '1234', '1', '2');
