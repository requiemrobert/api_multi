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
INSERT INTO `autorizacion` VALUES ('5', '1', '5', '1');
INSERT INTO `autorizacion` VALUES ('6', '1', '6', '1');
INSERT INTO `autorizacion` VALUES ('7', '1', '7', '1');
INSERT INTO `autorizacion` VALUES ('8', '1', '8', '1');
INSERT INTO `autorizacion` VALUES ('9', '1', '9', '1');
INSERT INTO `autorizacion` VALUES ('10', '1', '10', '1');
INSERT INTO `autorizacion` VALUES ('11', '1', '11', '1');
INSERT INTO `autorizacion` VALUES ('12', '1', '12', '1');
INSERT INTO `autorizacion` VALUES ('13', '1', '13', '1');
INSERT INTO `autorizacion` VALUES ('14', '1', '14', '1');
INSERT INTO `autorizacion` VALUES ('15', '1', '15', '1');

-- ----------------------------
-- Table structure for cliente
-- ----------------------------
DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente` (
  `id_cliente` int(10) NOT NULL AUTO_INCREMENT,
  `nombre_cliente` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_cliente` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `pre_doc_cliente` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `doc_cliente` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `rason_social_cliente` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion_cliente` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telf_cliente` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL,
  `otro_telf_cliente` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email_cliente` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipo_cliente` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_cliente`,`tipo_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of cliente
-- ----------------------------

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
INSERT INTO `modulo` VALUES ('5', '1', 'compra', '1');
INSERT INTO `modulo` VALUES ('6', '1', 'ventas', '1');
INSERT INTO `modulo` VALUES ('7', '1', 'movimientos', '1');
INSERT INTO `modulo` VALUES ('8', '4', 'en proceso', '1');
INSERT INTO `modulo` VALUES ('9', '4', 'listos', '1');
INSERT INTO `modulo` VALUES ('10', '2', 'reportes', '1');
INSERT INTO `modulo` VALUES ('11', '3', 'pagos', '1');
INSERT INTO `modulo` VALUES ('12', '0', 'usuarios', '1');
INSERT INTO `modulo` VALUES ('13', '12', 'nuevo', '1');
INSERT INTO `modulo` VALUES ('14', '12', 'historial', '1');
INSERT INTO `modulo` VALUES ('15', '2', 'registro', '1');

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
  `user_name` varchar(20) NOT NULL,
  `f_name` varchar(20) NOT NULL,
  `l_name` varchar(20) NOT NULL,
  `email` varchar(35) NOT NULL,
  `password` varchar(20) NOT NULL,
  `status` tinyint(20) NOT NULL,
  `id_perfil_fk` int(20) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `FK_id_perfil` (`id_perfil_fk`),
  CONSTRAINT `FK_id_perfil` FOREIGN KEY (`id_perfil_fk`) REFERENCES `perfil` (`id_perfil`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of usuario
-- ----------------------------
INSERT INTO `usuario` VALUES ('2', 'dnolasco', 'daniel', 'nolasco', 'dnolasco@gmail.com', '123', '1', '1');
INSERT INTO `usuario` VALUES ('3', 'rpaniagua', 'robert', 'paniagua', 'rpaniagua@gmail.com', '1234', '1', '2');
